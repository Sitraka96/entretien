<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;
use DateTime;
use PDO;

class EntretienModel extends Model
{
    private $tableName = 'entretien';
    protected $isPK = 'idENTR';
    protected $isAI = true;

    public $idENTR;
    public $AU_id;
    public $NIV_id;
    public $DO_id;
    public $REC_id;
    public $GP_id;
    public $AB_id;
    public $SB_id;
    public $MB_id;
    public $nom;
    public $prenom;
    public $sexe;
    public $contact;
    public $date_entretien;
    public $datenaiss;
    public $lieunaiss;
    public $adresse;
    public $religion;
    public $etablissement;
    public $presentation_soi;

    public $ignoreOldInterview = false;
    public $allow_same_date = false;
    public $allow_same_person = false;
    public $ecole;
    public $college;
    public $lycee;
    public $comportement;
    public $fume;
    public $boit;
    public $autodidacte;
    public $experience;
    public $autre;

    public $pere;
    public $nom_pere;
    public $prenom_pere;
    public $contact_pere;
    public $email_pere;
    public $adresse_pere;
    public $profession_pere;
    public $mere;
    public $nom_mere;
    public $prenom_mere;
    public $contact_mere;
    public $email_mere;
    public $adresse_mere;
    public $profession_mere;
    public $freres;
    public $soeurs;

    public $domaine_souhaite;
    public $connaissance_esmia;
    public $motivation;
    public $attentes;
    public $problemes;
    public $vision;
    public $projets;
    public $loisirs;
    public $qualites;
    public $defauts;
    public $frs;
    public $agl;
    public $info;
    public $react;
    public $favorable;
    public $responsable;
    public $closed;
    public $creationDate;
    public $updateDate;

    private $hiddenAttrs = ["hiddenAttrs", "db", "table", "tableName", "isPK", "isAI", "idENTR"];

    public function __construct($data = null)
    {
        parent::__construct();
        $this->fume = 0;
        $this->boit = 0;
        $this->boit = 0;
        $this->favorable = 0;
        $this->closed = 0;

        if ($data) {
            $this->init($data);
        }
    }

    public function init($data): bool
    {
        $this->parse($data);
        if (array_key_exists("REC_id", $data) && $data["REC_id"] == "*") {
            $this->REC_id = $this->_findOrCreateRecruteur($data)->idREC;
        }
        return true;
    }

    public static function where($options): array
    {
        $result = [];
        $filter = array_merge([
            "AU_id" => "*",
            "NIV_id" => "*",
            "REC_id" => "*",
            "orderBy" => "date_entretien:ASC",
            "q" => "",
            "date_entretien" => "",
            "favorable" => null,
            "closed" => null,
        ], $options);

        $AU_id = $filter['AU_id'];
        $NIV_id = $filter['NIV_id'];
        $REC_id = $filter['REC_id'];
        $order = preg_split("/[:]/", $filter['orderBy']); // => ["date_entretien", "ASC"]
        $orderBy = join(" ", $order);
        $favorable = $filter['favorable'];
        $closed = $filter['closed'];
        $q = $filter['q'];
        $date_entretien = $filter['date_entretien'];

        $db = Database::getConnection();

        if ($favorable == "*") {
            $searchFilter = "(favorable = 0 OR favorable = 1 OR favorable IS NULL)";
        } else if ($favorable == null) {
            $searchFilter = "(favorable IS NULL)";
        } else if ($favorable == 0) {
            $searchFilter = "(favorable = 0)";
        } else if ($favorable) {
            $searchFilter = "(favorable = 1)";
        }

        if ($closed) {
            $searchFilter = $searchFilter . " AND closed = 1";
        } else {
            $searchFilter = $searchFilter . " AND (closed = 0 OR closed IS NULL)";
        }

        if ($AU_id != "*") {
            $searchFilter = $searchFilter . " AND AU_id = $AU_id";
        }

        if ($NIV_id != "*") {
            $searchFilter = $searchFilter . " AND NIV_id = $NIV_id";
        }

        if ($REC_id != "*") {
            $searchFilter = $searchFilter . " AND REC_id = $REC_id";
        }

        if ($q != "") {
            $searchFilter = $searchFilter . " AND (idENTR LIKE '$q' OR nom LIKE '%$q%' OR prenom LIKE '%$q%')";
        }

        if ($date_entretien != "") {
            $date_entretien = (new DateTime($date_entretien))->format("d/m/Y");
            $searchFilter = $searchFilter . " AND DATE_FORMAT(date_entretien, '%d/%m/%Y') = '$date_entretien'";
        }

        $sql = "SELECT * FROM entretien WHERE ($searchFilter) ORDER BY $orderBy;";

        $dbPreparation = $db->prepare($sql);
        $dbPreparation->execute();
        $e = $dbPreparation->fetchAll();
        $e = $e ? $e : [];

        $result = EntretienModel::toModel($e);

        return [
            "result" => $result,
            "filter" => $filter
        ];
    }

    private function _findOrCreateRecruteur($data): RecruteurModel
    {
        $result = RecruteurModel::findOrCreate($data);
        return $result;
    }

    public static function find($entretienId): EntretienModel
    {
        $result = new EntretienModel();
        $db = Database::getConnection();
        $sql = "SELECT * FROM entretien WHERE idENTR like '$entretienId' LIMIT 1;";
        $dbPreparation = $db->prepare($sql);
        $dbPreparation->execute();
        $e = $dbPreparation->fetch();
        if ($e) {
            $result->parse($e);
        }
        return $result;
    }

    public function getResponsable(): string
    {
        return $this->responsable ?? "-";
    }

    public function getFavorable(): bool | null
    {
        return $this->favorable;
    }

    public function getTotal(): int
    {
        return ($this->frs + $this->agl + $this->info + $this->react);
    }

    public function getReact(): int
    {
        return $this->react ?? 0;
    }

    public function getInfo(): int
    {
        return $this->info ?? 0;
    }

    public function getAgl(): int
    {
        return $this->agl ?? 0;
    }

    public function getFrs(): int
    {
        return $this->frs ?? 0;
    }

    public function getDefauts(): string
    {
        return $this->defauts ?? "-";
    }

    public function getQualites(): string
    {
        return $this->qualites ?? "-";
    }

    public function getLoisirs(): string
    {
        return $this->loisirs ?? "-";
    }

    public function getProjets(): string
    {
        return $this->projets ?? "-";
    }

    public function getVision(): string
    {
        return $this->vision ?? "-";
    }

    public function getProblem(): string
    {
        return $this->problemes ?? "-";
    }

    public function getAttentes(): string
    {
        return $this->attentes ?? "Vide";
    }

    public function getMotivation(): string
    {
        return $this->motivation ?? "-";
    }

    public function getConnaissanceEsmia(): string
    {
        return $this->connaissance_esmia ?? "-";
    }

    public function getDomaineSouhaite(): string
    {
        return $this->getGp()->nom_gp ?? "-";
    }

    public function getParent(): mixed
    {
        return [
            "pere" => $this->getPere(),
            "mere" => $this->getMere(),
            "freres" => $this->getFreres(),
            "soeurs" => $this->getSoeurs()
        ];
    }

    public function getSoeurs(): array
    {
        $soeurs = preg_split("/[\n,]+/", $this->soeurs);
        return [
            "array" => $soeurs,
            "string" => $this->soeurs
        ];
    }

    public function getFreres(): array
    {
        $freres = preg_split("/[\n,]+/", $this->freres);
        return [
            "array" => $freres,
            "string" => $this->freres
        ];
    }

    public function getMere(): array
    {
        // $mere = preg_split("/[,]+/", $this->mere);
        // return [
        //     "full" => $this->mere,
        //     "nom" => $mere[0],
        //     "profession" => array_key_exists(1, $mere) ? $mere[1] : null,
        //     "contact" => array_key_exists(2, $mere) ? $mere[2] : null,
        // ];
        return [
            "nom" => $this->nom_mere,
            "prenom" => $this->prenom_mere,
            "contact" => $this->contact_mere,
            "email" => $this->email_mere,
            "adresse" => $this->adresse_mere,
            "profession" => $this->profession_mere,
        ];
    }

    public function getPere(): array
    {
        // $pere = preg_split("/[,]+/", $this->pere);
        // return [
        //     "full" => $this->pere,
        //     "nom" => $pere[0],
        //     "profession" => array_key_exists(1, $pere) ? $pere[1] : null,
        //     "contact" => array_key_exists(2, $pere) ? $pere[2] : null,
        // ];
        return [
            "nom" => $this->nom_pere,
            "prenom" => $this->prenom_pere,
            "contact" => $this->contact_pere,
            "email" => $this->email_pere,
            "adresse" => $this->adresse_pere,
            "profession" => $this->profession_pere,
        ];
    }

    public function getRecruteur(): RecruteurModel
    {
        $result = new RecruteurModel();
        $db = Database::getConnection();

        $sql = "SELECT * FROM recruteur WHERE idREC = '{$this->REC_id}' LIMIT 1;";
        $statement = $db->prepare($sql);
        $statement->execute();
        $resultFromDB = $statement->fetch();

        if ($resultFromDB) {
            $result->parse($resultFromDB);
        }

        return $result;
    }

    public function getAutre(): string
    {
        return $this->autre ?? "-";
    }

    public function getExperience(): string
    {
        return $this->experience ?? "-";
    }

    public function getLycee(): string
    {
        return $this->lycee ?? "Non renseigné";
    }

    public function getCollege(): string
    {
        return $this->college ?? "Non renseigné";
    }

    public function getEcole(): string
    {
        return $this->ecole ?? "Non renseigné";
    }

    public function getAutodidacte(): bool | null
    {
        return $this->autodidacte;
    }

    public function getBoit(): bool | null
    {
        return $this->boit;
    }

    public function getFume(): bool | null
    {
        return $this->fume;
    }

    public function autodidacte(): string
    {
        return $this->autodidacte ? "Autodidacte" : "Non autodidacte";
    }

    public function buveur(): string
    {
        return $this->boit ? "Buveur" : "Non buveur";
    }

    public function fumeur(): string
    {
        return $this->fume ? "Fumeur" : "Non fumeur";
    }

    public function getComportement(): string
    {
        return $this->comportement ?? "Inconnu";
    }

    public function getPresentation(): string | null
    {
        return $this->presentation_soi ?? "-";
    }

    public function getEtablissement(): string
    {
        return $this->etablissement ?? "Inconnu";
    }

    public function getMention(): string
    {
        return $this->getModel("Mb")?->mention ?? "";
    }

    public function getSerie(): string
    {
        return $this->getModel("Sb")?->serie ?? "";
    }

    public function getDiplome(): mixed
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM do WHERE idDO like '{$this->DO_id}' LIMIT 1;";
        $dbPreparation = $db->prepare($sql);
        $dbPreparation->execute();
        $do = new DoModel();
        $doFromDB = $dbPreparation->fetch();
        if ($doFromDB) {
            $do->parse($doFromDB);
        } else {
            $do->diplome = "Aucun";
        }

        return $do;
    }

    public function getReligion(): string
    {
        return $this->religion ? $this->religion : "Non communiquée";
    }

    public function getAdresse(): string
    {
        return $this->adresse ? $this->adresse : "";
    }

    public function getLieunaiss(): string
    {
        return $this->lieunaiss ? $this->lieunaiss : "";
    }

    public function getDatenaiss(): DateTime
    {
        $datenaiss = (new DateTime($this->datenaiss ? $this->datenaiss : "01-11-1998"));
        return $datenaiss;
    }

    public function getSexe(): int | null
    {
        return $this->sexe;
    }

    public function getFullName(): string
    {
        return $this->getCivility() . " " . $this->nom . " " . $this->prenom;
    }

    public function getName(): string
    {
        return $this->nom . " " . $this->prenom;
    }

    public function getCivility(): string
    {
        return $this->sexe == 0 ? "Mme" : "Mr";
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getContact(): string
    {
        return $this->contact;
    }

    public function getDo(): DoModel
    {
        $result = new DoModel();
        $db = Database::getConnection();
        $sql = "SELECT * FROM do WHERE idDO like '{$this->DO_id}' LIMIT 1;";
        $dbPreparation = $db->prepare($sql);
        $dbPreparation->execute();
        $resultFromDB = $dbPreparation->fetch();
        $resultFromDB ? $result->parse($resultFromDB) : "";
        return $result;
    }

    public function getDateEntretien(): DateTime
    {
        $date_entretien = new DateTime($this->date_entretien);
        return $date_entretien;
    }

    public function getSecureId(): string
    {
        $result = "";
        $now = ""; // (new DateTime())->format("\AY\Mm\Jd\HH\Mi\I");
        $result = $now . $this->idENTR;
        return $result;
    }

    public function getId(): int
    {
        return $this->idENTR;
    }

    public function isNew(): bool
    {
        return $this->unfinished();
    }

    public function signedUp(): bool
    {
        $result = false;
        $result = $this->closed() && $this->favorable();
        return $result;
    }

    public function closed(): bool
    {
        return $this->finished() && $this->closed;
    }

    public function defavorable(): bool
    {
        return $this->finished() && !$this->favorable;
    }

    public function favorable(): bool
    {
        return $this->finished() && $this->favorable;
    }

    public function finished(): bool
    {
        return !$this->unfinished();
    }

    public function unfinished(): bool
    {
        return is_null($this->favorable);
    }

    public function patch($reqData): array | bool
    {
        $db = Database::getConnection();
        $sql = "SELECT (idENTR) FROM {$this->tableName} WHERE idENTR LIKE '{$this->idENTR}' ORDER BY idENTR DESC LIMIT 1;";
        $dbPreparation = $db->prepare($sql);
        $dbPreparation->execute();
        $ancienEntretien = $dbPreparation->fetch();

        $result = [
            "success" => false,
            "messages" => [
                "danger" => "Unkonwn error"
            ],
            "code" => "500"
        ];

        if (!$ancienEntretien) {
            $result["message"] = "Entretien introuvable";
        } else {

            $date_entretien = $reqData['date_entretien'] ?? $this->date_entretien;
            $fume = array_key_exists('fume', $reqData) ? $reqData['fume'] : $this->fume;
            $boit = array_key_exists('boit', $reqData) ? $reqData['boit'] : $this->boit;
            $autodidacte = array_key_exists('autodidacte', $reqData) ? $reqData['autodidacte'] : $this->autodidacte;
            $favorable = array_key_exists('favorable', $reqData) ? $reqData['favorable'] : $this->favorable;
            $closed = array_key_exists('closed', $reqData) ? $reqData['closed'] : $this->closed;
            $NIV_id = $req['NIV_id'] ?? $this->NIV_id;
            $AU_id = $req['AU_id'] ?? $this->AU_id;
            $nom = $req['nom'] ?? $this->nom;
            $prenom = $req['prenom'] ?? $this->prenom;
            $sexe = $req['sexe'] ?? $this->sexe;
            $contact = $req['contact'] ?? $this->contact;
            $datenaiss = $req['datenaiss'] ?? $this->datenaiss;
            $lieunaiss = $req['lieunaiss'] ?? $this->lieunaiss;
            $adresse = $req['adresse'] ?? $this->adresse;
            $religion = $req['religion'] ?? $this->religion;
            $etablissement = $req['etablissement'] ?? $this->etablissement;
            $DO_id = $req['DO_id'] ?? $this->DO_id;
            $MB_id = $req['MB_id'] ?? $this->MB_id;
            $SB_id = $req['SB_id'] ?? $this->SB_id;
            $AB_id = $req['AB_id'] ?? $this->AB_id;
            $REC_id = $req['REC_id'] ?? $this->REC_id;
            $GP_id = $req['GP_id'] ?? $this->GP_id;
            $presentation_soi = $req['presentation_soi'] ?? $this->presentation_soi;
            $comportement = $req['comportement'] ?? $this->comportement;
            $ecole = $req['ecole'] ?? $this->ecole;
            $college = $req['college'] ?? $this->college;
            $lycee = $req['lycee'] ?? $this->lycee;
            $experience = $req['experience'] ?? $this->experience;
            $autre = $req['autre'] ?? $this->autre;
            $pere = $req['pere'] ?? $this->pere;
            $nom_pere = $req['nom_pere'] ?? $this->nom_pere;
            $prenom_pere = $req['prenom_pere'] ?? $this->prenom_pere;
            $contact_pere = $req['contact_pere'] ?? $this->contact_pere;
            $profession_pere = $req['profession_pere'] ?? $this->profession_pere;
            $mere = $req['mere'] ?? $this->mere;
            $nom_mere = $req['nom_mere'] ?? $this->nom_mere;
            $prenom_mere = $req['prenom_mere'] ?? $this->prenom_mere;
            $contact_mere = $req['contact_mere'] ?? $this->contact_mere;
            $profession_mere = $req['profession_mere'] ?? $this->profession_mere;
            $freres = $req['freres'] ?? $this->freres;
            $soeurs = $req['soeurs'] ?? $this->soeurs;
            $domaine_souhaite = $req['domaine_souhaite'] ?? $this->domaine_souhaite;
            $connaissance_esmia = $req['connaissance_esmia'] ?? $this->connaissance_esmia;
            $motivation = $req['motivation'] ?? $this->motivation;
            $attentes = $req['attentes'] ?? $this->attentes;
            $problemes = $req['problemes'] ?? $this->problemes;
            $vision = $req['vision'] ?? $this->vision;
            $projets = $req['projets'] ?? $this->projets;
            $loisirs = $req['loisirs'] ?? $this->loisirs;
            $qualites = $req['qualites'] ?? $this->qualites;
            $defauts = $req['defauts'] ?? $this->defauts;
            $frs = $req['frs'] ?? $this->frs;
            $agl = $req['agl'] ?? $this->agl;
            $info = $req['info'] ?? $this->info;
            $react = $req['react'] ?? $this->react;
            // $date = new DateTime();
            // $updateDate = NULL; // $date->format("c");

            // die();

            $sql = "UPDATE {$this->tableName} SET 
                    date_entretien = \"{$date_entretien}\", 
                    fume = \"{$fume}\",
                    boit = \"{$boit}\",
                    autodidacte = \"{$autodidacte}\",
                    NIV_id = \"{$NIV_id}\", 
                    AU_id = \"{$AU_id}\", 
                    nom = \"{$nom}\", 
                    prenom = \"{$prenom}\",
                    sexe = \"{$sexe}\",
                    contact = \"{$contact}\",
                    datenaiss = \"{$datenaiss}\",
                    lieunaiss = \"{$lieunaiss}\",
                    adresse = \"{$adresse}\",
                    religion = \"{$religion}\",
                    etablissement = \"{$etablissement}\",
                    DO_id = \"{$DO_id}\",
                    MB_id = \"{$MB_id}\",
                    SB_id = \"{$SB_id}\",
                    AB_id = \"{$AB_id}\",
                    REC_id = \"{$REC_id}\",
                    GP_id = \"{$GP_id}\",
                    presentation_soi = \"{$presentation_soi}\",
                    comportement = \"{$comportement}\",
                    ecole = \"{$ecole}\",
                    college = \"{$college}\",
                    lycee = \"{$lycee}\",
                    experience = \"{$experience}\",
                    autre = \"{$autre}\",
                    pere = \"{$pere}\",
                    nom_pere = \"{$nom_pere}\",
                    prenom_pere = \"{$prenom_pere}\",
                    contact_pere = \"{$contact_pere}\",
                    profession_pere = \"{$profession_pere}\",
                    mere = \"{$mere}\",
                    nom_mere = \"{$nom_mere}\",
                    prenom_mere = \"{$prenom_mere}\",
                    contact_mere = \"{$contact_mere}\",
                    profession_mere = \"{$profession_mere}\",
                    freres = \"{$freres}\",
                    soeurs = \"{$soeurs}\",
                    domaine_souhaite = \"{$domaine_souhaite}\",
                    connaissance_esmia = \"{$connaissance_esmia}\",
                    motivation = \"{$motivation}\",
                    attentes = \"{$attentes}\",
                    problemes = \"{$problemes}\",
                    vision = \"{$vision}\",
                    projets = \"{$projets}\",
                    loisirs = \"{$loisirs}\",
                    qualites = \"{$qualites}\",
                    defauts = \"{$defauts}\",
                    frs = \"{$frs}\",
                    agl = \"{$agl}\",
                    info = \"{$info}\",
                    react = \"{$react}\",
                    favorable = \"{$favorable}\",
                    closed = \"{$closed}\"
                WHERE idENTR = {$this->idENTR};
            ";
            $dbPreparation = $db->prepare($sql);
            if ($dbPreparation->execute()) {
                $result["success"] = true;
            } else {
                $result["message"] = "Entretien ne peut pas être mis à jour";
            }
        }

        return $result;
    }

    public function save(): array
    {
        $db = Database::getConnection();

        $result = [
            "success" => false,
            "code" => "unknown_error"
        ];

        if ($this->isValid()) {
            /**
             * Vérifier si cette date est déjà prise
             * A moins qu'on accepte les RDV à la même date
             */
            if ($this->allow_same_date) {
            } else {
                // Formater comme la date enregistrée en BDD
                $date_entretien = (new DateTime($this->date_entretien))->format('Y-m-d H:i:s');
                $sql = "SELECT (nom) FROM {$this->tableName} WHERE date_entretien LIKE '{$date_entretien}' LIMIT 10;";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $ancienEntretien = $stmt->fetchAll();

                if ($ancienEntretien) {
                    $nbrAncienRdv = sizeof($ancienEntretien);
                    $this->invalidAttributes = [
                        "date_entretien" => "required"
                    ];
                    return [
                        "messages" => [
                            "danger" => "Cette date est déjà prise <br> par {$nbrAncienRdv} candidat(s)"
                        ],
                        "success" => false,
                        "code" => "taken"
                    ];
                }
            }

            /**
             * Vérifier si un étudiant avec ce nom, prénom et ce numéro existe déjà
             * Sauf si on ignore cette vérification
             */

            if ($this->allow_same_person || $this->ignoreOldInterview) {
                $ancienEntretien = false;
            } else {
                $datenaiss = (new DateTime($this->datenaiss))->format("Y-m-d");
                $sql = "SELECT * FROM {$this->tableName} WHERE nom like '{$this->nom}' AND prenom LIKE '{$this->prenom}' AND (contact LIKE '{$this->contact}' OR DATE_FORMAT(datenaiss, '%Y-%m-%d') LIKE '{$datenaiss}') LIMIT 1;";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $ancienEntretien = $stmt->fetch();
            }

            if ($ancienEntretien) {
                return [
                    "messages" => [
                        "danger" => "Cette personne a déjà candidaté"
                    ],
                    "success" => false,
                    "code" => "user_already_exists"
                ];
            } else {

                $values = [$this->AU_id, $this->NIV_id, $this->REC_id];

                $nom = $this->nom ? "'$this->nom'" : 'NULL';
                $prenom = $this->prenom ? "'$this->prenom'" : 'NULL';
                $sexe = $this->sexe ? "$this->sexe" : 0;
                $contact = $this->contact ? "'$this->contact'" : 'NULL';
                $datenaiss = $this->datenaiss ? "'$this->datenaiss'" : 'NULL';
                $date_entretien = $this->date_entretien ? "'$this->date_entretien'" : 'NULL';

                array_push($values, $nom);
                array_push($values, $prenom);
                array_push($values, $sexe);
                array_push($values, $contact);
                array_push($values, $datenaiss);
                array_push($values, $date_entretien);

                $values = join(", ", $values);

                $sql = "INSERT INTO {$this->tableName} (AU_id, NIV_id, REC_id, nom, prenom, sexe, contact, datenaiss, date_entretien) VALUES ($values);";

                try {
                    $statement = $db->prepare($sql);
                    $status = $statement->execute();
                    $idENTR = $db->lastInsertId();
                    $this->idENTR = $idENTR;
                    $result = [
                        "success" => $status,
                        "idENTR" => $idENTR
                    ];
                } catch (\PDOException $err) {
                    $result = [
                        "messages" => [
                            "danger" => $err->errorInfo[2]
                        ],
                        "success" => false,
                        "code" => "unkown_error"
                    ];
                }
                return $result;
            }
        } else {
            return [
                "success" => false,
                "code" => "unknown_error",
            ];
        }
    }

    private function attributes(): array
    {
        $result = [];
        foreach ($this as $key => $value) {
            if (str_contains(join(", ", $this->hiddenAttrs), $key)) {
            } else {
                array_push($result, $key);
            }
        }
        return $result;
    }

    private function isValid(): bool
    {
        $result = true;
        foreach ($this->attributes() as $attr) {
            if (!$this->validate($attr)) {
                $result = false;
                break;
            }
        }
        return $result;
    }

    private function validate($attr): bool
    {
        $result = false;
        $this->invalidAttributes = array();
        $value = $this->{$attr};

        switch ($attr) {
                // case 'AU_id':
                //     if ($this->AU_id == "" || $this->AU_id == "NULL") {
                //         array_push($this->invalidAttributes, "AU_id");
                //     }
                //     break;
                // case 'NIV_id':
                //     if (!$this->NIV_id) {
                //         array_push($this->invalidAttributes, "NIV_id");
                //     }
                //     break;
                // case 'DO_id':
                //     if (!$this->DO_id) {
                //         array_push($this->invalidAttributes, "DO_id");
                //     }
                //     break;
                // case 'nom':
                //     if (!$this->nom) {
                //         array_push($this->invalidAttributes, "nom");
                //     }
                //     break;
                // case 'prenom':
                //     if (!$this->prenom) {
                //         array_push($this->invalidAttributes, "prenom");
                //     }
                //     break;

            default:
                $result = true;
                break;
        }

        // echo "is $attr : $value valid ? $result<br/>";

        return $result;
    }
}
