<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;
use DateTime;
use InvalidArgumentException;

class HistoryModel extends Model
{
    public static $tableName = "history";

    protected $isPK = 'id';
    protected $isAI = true;

    public $id;
    public $actor_type;
    public $actor_id;
    public $action; // INDEX / NEW / CREATE / SHOW / EDIT / UPDATE / DELETE
    public $subject_type;
    public $subject_id;
    public $oldValues;
    public $newValues;
    public $changes;
    public $created_at;

    public function __construct($data = null)
    {
        parent::__construct();
        $this->_init($data);
    }

    public static function toJson($data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $history = HistoryModel::new(array_merge($value, [
                "keepChanges" => true
            ]));
            array_push($result, $history->json());
        }
        return $result;
    }

    public function json(): array
    {
        return array_merge((array) $this, [
            "title" => $this->getTitle(),
            "changes" => $this->getChanges(),
            "created_at" => $this->getCreatedAt()
        ]);
    }

    public function restore(): bool
    {
        $db = Database::getConnection();
        $subject = $this->getSubject();
        $tableName = $subject->tableName;
        $attributes = [];
        $values = [];
        foreach ($this->oldValues as $attr => $value) {
            array_push($attributes, $attr);
            array_push($values, $value);
        }
        $attributes = join(", ", $attributes);
        $values = join(", ", $values);
        $sql = "INSERT INTO {$tableName} {$attributes} VALUES '{$values}';";
        $statement = $db->prepare($sql);
        $status = $statement->execute();
        $this->inspect(null, $sql);
        die();
        return $status;
    }

    /**
     * Get history list
     *
     * @param DateTime|string $date
     * @return array
     */
    public static function index($date): array
    {
        $date = new DateTime($date);
        $result = [];
        $db = Database::getConnection();
        $sql = "SELECT * FROM history ORDER BY created_at DESC LIMIT 10;";
        $statement = $db->prepare($sql);
        $statement->execute();
        $dbHistory = $statement->fetchAll();
        if ($dbHistory) {
            $result = HistoryModel::toJson($dbHistory);
        }
        return $result;
    }

    /**
     * Create an history with 'CREATE' action
     *w
     * @param array $data
     * @return void
     */
    public static function create($data): void
    {
        $data["action"] = "'CREATE'";
        $history = HistoryModel::new($data);
        $history->save();
    }

    /**
     * Initiate an history with 'UPDATE' action
     *
     * @param array $data
     * @return HistoryModel
     */
    public static function put($data): HistoryModel
    {
        $data["action"] = "'UPDATE'";
        $history = HistoryModel::new($data);
        return $history;
    }

    /**
     * Create an history with 'DELETE' action
     *w
     * @param array $data
     * @return HistoryModel
     */
    public static function remove($data): HistoryModel
    {
        $data["action"] = "'DELETE'";
        $history = HistoryModel::new($data);
        return $history;
    }

    public static function find($id): HistoryModel | null
    {
        $result = new HistoryModel();
        $db = Database::getConnection();
        $sql = "SELECT * FROM history WHERE id = $id LIMIT 1;";
        $statement = $db->prepare($sql);
        $status = $statement->execute();
        if ($status) {
            $result->parse($statement->fetch());
        } else {
            $result = null;
        }
        return $result;
    }

    /**
     * Persist in Database
     *
     * @return boolean
     */
    public function save(): bool
    {
        try {
            $this->encode("oldValues");
            $this->encode("newValues");
            $this->encode("changes");

            $status = true;
            $db = Database::getConnection();
            $sql = "INSERT INTO history (
                    `id`, 
                    `actor_type`, 
                    `actor_id`, 
                    `action`, 
                    `subject_type`, 
                    `subject_id`, 
                    `oldValues`, 
                    `newValues`, 
                    `changes`, 
                    `created_at`
                ) VALUES (
                    {$this->id},
                    '{$this->actor_type}',
                    '{$this->actor_id}',
                    {$this->action},
                    '{$this->subject_type}',
                    '{$this->subject_id}',
                    '{$this->oldValues}',
                    '{$this->newValues}',
                    '{$this->changes}',
                    '{$this->created_at}'
                );";
            $statement = $db->prepare($sql);
            $status = $statement->execute();
        } catch (\PDOException $err) {
            throw $err;
        }
        return $status;
    }

    private static function new($data): HistoryModel
    {
        return new HistoryModel($data);
    }

    private function _init($data): HistoryModel
    {
        $data ??= [];
        $data["action"] ??= null;
        $data["actor_type"] ??= null;
        $data["actor_id"] ??= null;
        $data["subject_type"] ??= null;
        $data["subject_id"] ??= null;
        $data["oldValues"] ??= null;
        $data["newValues"] ??= null;
        $data["keepChanges"] ??= null;

        $this->setAction($data["action"]);
        $this->setSubjectType($data["subject_type"]);
        $this->setSubjectId($data["subject_id"]);
        $this->setOldValues($data["oldValues"]);
        $this->setNewValues($data["newValues"]);
        $this->_setChanges($data);
        $this->setActorType($data["actor_type"]);
        $this->setActorId($data["actor_id"]);
        $this->_setId();

        return $this;
    }

    private function _setId($id = null): void
    {
        $this->id = $id ?? "NULL";
    }

    public function getActorType(): string
    {
        return $this->actor_type;
    }

    public function setActorType($actor_type): void
    {
        $ALLOWED_ACTORS = ["USER", "ADMIN"];
        if (!in_array($actor_type, $ALLOWED_ACTORS)) {
            $actor_type = "USER";
        }
        $this->actor_type = (string) $actor_type;
    }

    public function getActorId(): string | int | null
    {
        return $this->actor_id;
    }

    public function setActorId($actor_id): void
    {
        $this->actor_id = (string) $actor_id;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction($action): void
    {
        $ALLOWED_ACTIONS = ["'CREATE'", "'UPDATE'", "'DELETE'", "INDEX", "RESTORE"];
        if (isset($action) && !in_array($action, $ALLOWED_ACTIONS)) {
            throw new InvalidArgumentException($action);
        }
        $this->action = (string) ($action);
    }

    public function getSubjectType(): string
    {
        return $this->subject_type;
    }

    /**
     * @param string $subject_type
     * @return void
     */
    public function setSubjectType($subject_type): void
    {
        $this->subject_type = (string) $subject_type;
    }

    public function getSubjectId(): int | string | null
    {
        return $this->subject_id;
    }

    /**
     * @param string|int $subject_id
     * @return void
     */
    public function setSubjectId($subject_id): void
    {
        $this->subject_id = (int) $subject_id;
    }

    public function getSubject(): mixed
    {
        $subject = null;
        $SUBJECT_NAME = strtoupper($this->getSubjectType());
        switch ($SUBJECT_NAME) {
            case 'ENTRETIEN':
                $subject = new EntretienModel();
                $tableName = "entretien";
                $pk = "idENTR";
                break;

            default:
                die("'{$SUBJECT_NAME}' n'existe pas encore. Veuillez l'ajouter dans App/Models/HistoryModel.php");
                break;
        }
        if (isset($tableName)) {
            $pkID = (int)$this->getSubjectId();
            $db = Database::getConnection();
            $sql = "SELECT * from {$tableName} WHERE {$pk} = {$pkID} LIMIT 1;";
            $statement = $db->prepare($sql);
            $statement->execute();
            $result  = $statement->fetch();
            if ($result) {
                $subject->parse($result);
            } else {
                $subject->pk = $pk;
                $subject->pkID = $pkID;
                $subject->tableName = $tableName;
                return $subject;
            }
        }
        return $subject;
    }

    public function getOldValues(): array
    {
        return $this->oldValues;
    }

    public function setOldValues($values): void
    {
        $this->oldValues = (array) $values;
    }

    public function getNewValues(): array
    {
        return $this->newValues;
    }

    public function setNewValues($values): void
    {
        $this->newValues = (array) $values;
    }

    public function getChanges(): array
    {
        $result = (json_decode((string)$this->changes) ?? []);
        foreach ($result as $change) {
            foreach ($change as $changeKey => $changeValue) {
                $change->{$changeKey}->name = HistoryModel::translate($changeKey);
            }
        }
        return $result;
    }

    private function _setChanges($data = null): void
    {
        if (!isset($data["keepChanges"]) || !$data["keepChanges"]) {
            $oldValues = $this->getOldValues();
            $newValues = $this->getNewValues();
            $changes = [];
            foreach ($oldValues as $key => $value) {
                if (array_key_exists($key, $oldValues) && array_key_exists($key, $newValues) && $oldValues[$key] != $newValues[$key]) {
                    array_push($changes, [
                        $key => [
                            "old" => $value,
                            "new" => $newValues[$key],
                        ]
                    ]);
                }
            }
            $this->changes = $changes;
        }
        $this->changes = (array) $this->changes;
    }

    public function getCreatedAt(): DateTime
    {
        return new DateTime((string) $this->created_at);
    }

    public function encode($value): void
    {
        $this->{$value} = json_encode($this->{$value});
    }

    public function decode($value): void
    {
        $this->{$value} = json_decode($this->{$value});
    }

    private function translate($key): string
    {
        $result = "UNKNOWN ATTRIBUTE";
        switch ($key) {
            case 'DO_id':
                $result = "Diplome";
                break;
            case 'GP_id':
                $result = "Parcours";
                break;
            case 'AB_id':
                $result = "Bacc";
                break;
            case 'SB_id':
                $result = "Série";
                break;
            case 'MB_id':
                $result = "Mention";
                break;
            case 'contact':
                $result = "Contacte";
                break;
            case 'lieunaiss':
                $result = "Lieu de naissance";
                break;
            case 'religion':
                $result = "Religion";
                break;
            case 'etablissement':
                $result = "établissement";
                break;
            case 'presentation_soi':
                $result = "Présentation";
                break;
            case 'ecole':
                $result = "école";
                break;
            case 'college':
                $result = "Collège";
                break;
            case 'lycee':
                $result = "Lycée";
                break;
            case 'comportement':
                $result = "Comportement";
                break;
            case 'boit':
                $result = "Buveur";
                break;
            case 'autodidacte':
                $result = "Autodidacte";
                break;
            case 'experience':
                $result = "Expérience";
                break;
            case 'autre':
                $result = "Autre";
                break;
            case 'nom_pere':
                $result = "Nom du père";
                break;
            case 'prenom_pere':
                $result = "Prénoms du père";
                break;
            case 'contact_pere':
                $result = "Contacte du père";
                break;
            case 'nom_mere':
                $result = "Nom de la mère";
                break;
            case 'prenom_mere':
                $result = "Prénoms de la mère";
                break;
            case 'contact_mere':
                $result = "Contacte de la mère";
                break;
            case 'connaissance_esmia':
                $result = "Connaissance ESMIA";
                break;
            case 'motivation':
                $result = "Motivation";
                break;
            case 'attentes':
                $result = "Attentes";
                break;
            case 'problemes':
                $result = "Problèmes";
                break;
            case 'vision':
                $result = "Vision";
                break;
            case 'projets':
                $result = "Projets";
                break;
            case 'loisirs':
                $result = "Loisirs";
                break;
            case 'qualites':
                $result = "Qualités";
                break;
            case 'defauts':
                $result = "Défauts";
                break;
            case 'frs':
                $result = "Français";
                break;
            case 'agl':
                $result = "Anglais";
                break;
            case 'info':
                $result = "Info";
                break;
            case 'react':
                $result = "Réactivité";
                break;
            case 'favorable':
                $result = "Favorable";
                break;
            default:
                $result = $result . " $key";
                break;
        }
        return $result;
    }

    private function getTitle(): string
    {
        switch ($this->action) {
            case 'CREATE':
                $result = "Ajout ";
                break;
            case 'UPDATE':
                $result = "Mise à jour ";
                break;
            case 'DELETE':
                $result = "Suppression ";
                break;

            default:
                $result = "NO TITLE";
                break;
        }
        switch (strtoupper($this->subject_type)) {
            case 'ENTRETIEN':
                $result .= " de l'entretien";
                break;
            case 'ETUDIANT':
                $result .= " du profil étudiant";
                break;
            case 'INSCRIPTION':
                $result .= " de la fiche d'inscription";
                break;
            default:
                $result .= " {$this->getSubjectType()}";
        }
        $result .= " #{$this->getSubjectId()}";
        return $result;
    }
}
