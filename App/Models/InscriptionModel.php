<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;
use DateTime;
use PDOException;

class InscriptionModel extends Model
{
    protected $isPK = 'num_matr';
    protected $isAI = true;

    public $num_matr;
    public $ETUDIANT_nie;
    public $AU_id;
    public $NIV_id;
    public $GP_id;
    public $dateInscr;
    public $abandon;
    public $ENTRETIEN_id;

    public function __construct($data = null)
    {
        parent::__construct();
        $this->abandon = 0;
        $this->dateInscr = (new DateTime())->format("c");
        if ($data) {
            $this->init($data);
        }
    }

    public function init($data): bool
    {
        $this->parse($data);

        if ($this->persisted()) {
            if (array_key_exists("list_dossiers", $data)) {
                $dossierList = DossierModel::getListBy($this->NIV_id);

                foreach ($dossierList as $dossier) {
                    $dossierId = $dossier["idDOS"];
                    if (array_key_exists("observation", $data["list_dossiers"])) {
                        $dossierObservation = $data["list_dossiers"]["observation"][$dossierId];
                    } else {
                        $dossierObservation = "";
                    }

                    $status = $this->findOrCreateDossier([
                        "DOSSIER_id" => $dossierId,
                        "isValid" => in_array($dossierId, $data["list_dossiers"]["ids"]) ? 1 : 0,
                        "observation" => $dossierObservation,
                    ]);
                    if (!$status) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    public function getListDossier(): array
    {
        $result = array();

        $db = Database::getConnection();
        $sql = "SELECT DOSSIER_id, observation, isValid, d.nom_dos FROM inscription_has_dossier 
            INNER JOIN inscription i ON INSCRIPTION_id = i.num_matr
            INNER JOIN dossier d ON DOSSIER_id = d.idDOS
            WHERE (INSCRIPTION_id = i.num_matr);
        ";
        $statement = $db->prepare($sql);
        $statement->execute();
        $dossierFromDB = $statement->fetchAll();

        foreach ($dossierFromDB as $dossier) {
            $result[$dossier["DOSSIER_id"]] = [
                "isValid" => $dossier["isValid"],
                "nom_dos" => $dossier["nom_dos"],
                "observation" => $dossier["observation"],
            ];
        }

        return $result;
    }

    private function findOrCreateDossier($data): bool
    {
        $DOSSIER_id = $data["DOSSIER_id"];
        $isValid = $data["isValid"];
        $observation = str_replace("'", "''", $data["observation"]);

        $db = Database::getConnection();

        try {
            $sql = "SELECT * from inscription_has_dossier
                INNER JOIN dossier d ON DOSSIER_id = d.idDOS
                INNER JOIN inscription i ON INSCRIPTION_id = i.num_matr
                WHERE (DOSSIER_id = {$DOSSIER_id} AND INSCRIPTION_id = {$this->num_matr}) LIMIT 1;
            ";
            $statement = $db->prepare($sql);
            $status = $statement->execute();
            if ($status) {
                $ihd = $statement->fetch(); // Inscription has dossier from DB
                if ($ihd) {
                    $sql = "UPDATE inscription_has_dossier SET isValid = {$isValid}, observation = '{$observation}' WHERE DOSSIER_id = {$DOSSIER_id} AND INSCRIPTION_id = {$this->num_matr};";
                } else {
                    $sql = "INSERT INTO inscription_has_dossier (DOSSIER_id, INSCRIPTION_id, isValid, observation) 
                    VALUES ({$DOSSIER_id}, {$this->num_matr}, {$isValid}, '{$observation}');
                ";
                }
                $statement = $db->prepare($sql);

                $status = $statement->execute();
            }
        } catch (\Throwable $err) {
            // throw $err;
            $status = $err;
        }

        return $status;
    }

    public function json(): array
    {
        $result = array();
        $result = [
            "num_matr" => $this->num_matr,
            "ETUDIANT_nie" => $this->ETUDIANT_nie,
            "DateInscr" => $this->getDateInscr(),
            "Niv" => $this->getNiv(),
            "Gp" => $this->getGp(),
            "Au" => $this->getAu(),
            "Au" => $this->getAu(),
            "ListDossier" => $this->getListDossier(),
        ];
        return $result;
    }

    public function getEntretien(): EntretienModel | null
    {
        if (is_null($this->ENTRETIEN_id)) {
            return null;
        }
        $result = new EntretienModel();
        $db = Database::getConnection();
        $sql = "SELECT e.* FROM inscription
            INNER JOIN entretien e ON ENTRETIEN_id = e.idENTR 
            WHERE ENTRETIEN_id = {$this->ENTRETIEN_id} LIMIT 1;
        ";
        $statement = $db->prepare($sql);
        $statement->execute();
        $entretienFromDB = $statement->fetch();
        if ($entretienFromDB) {
            $result->parse($entretienFromDB);
        } else {
            $result = null;
        }
        return $result;
    }

    public function getDateInscr(): DateTime
    {
        $result =  new DateTime($this->dateInscr);
        return $result;
    }

    public static function getCheckEtudiant(): void
    {
    }

    public static function getDossier($NIV_id): array
    {
        return [];
    }

    public static function findBy($ETUDIANT_nie = 0): InscriptionModel | null
    {
        $result = null;

        $db = Database::getConnection();
        $sql = "SELECT * FROM inscription WHERE ETUDIANT_nie = '{$ETUDIANT_nie}' LIMIT 1;";
        $statement = $db->prepare($sql);
        $statement->execute();
        $inscriptionFromDb = $statement->fetch();

        if ($inscriptionFromDb) {
            $result = new InscriptionModel();
            $result->parse($inscriptionFromDb);
        }

        return $result;
    }

    public function isValid(): bool
    {
        $result = true;

        $inscription = InscriptionModel::findBy($this->num_matr, $this->ETUDIANT_nie);

        if ($inscription) {
            $this->errors = [
                "messages" => ["danger" => "Cette fiche d'inscription existe déjà"],
            ];
            return false;
        }

        if (!$this->ETUDIANT_nie) {
            $this->invalidAttributes = [];
            $this->errors = [
                "messages" => ["danger" => "Veuillez remplir les champs obligatoires"],
            ];

            if (!$this->ETUDIANT_nie) {
                $this->invalidAttributes["ETUDIANT_nie"] = "required";
            }

            return false;
        }

        return $result;
    }

    public function persisted(): bool
    {
        return !is_null($this->num_matr);
    }

    public function migrate($data): void
    {
    }
}
