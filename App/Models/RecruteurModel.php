<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class RecruteurModel extends Model
{
    protected $isPK = 'idREC';
    protected $isAI = true;

    var $idREC, $nom_rec, $prenom_rec, $sexe_rec, $email_rec, $poste_rec;

    public function __construct($data = null)
    {
        parent::__construct();
        if ($data) {
            $this->init($data);
        }
    }

    public function init($data): bool
    {
        $this->parse($data);
        return true;
    }

    public function getFullName(): string
    {
        return $this->civility() . " " . $this->prenom_rec . " " . $this->nom_rec;
    }

    public function civility(): string
    {
        return $this->sexe_rec == 1 ? "Mr" : "Mme";
    }

    public static function findOrCreate($data): RecruteurModel
    {
        $nom_rec = $data["nom_rec"] ?? "";
        $prenom_rec = $data["prenom_rec"] ?? "";
        $sexe_rec = $data["sexe_rec"] ?? "";
        $email_rec = $data["email_rec"] ?? "";
        $poste_rec = $data["poste_rec"] ?? "";

        $result = new RecruteurModel();
        $db = Database::getConnection();
        $sql = "SELECT * FROM recruteur WHERE nom_rec = '{$nom_rec}' LIMIT 1;";
        $statement = $db->prepare($sql);
        $statement->execute();
        $recruteurFromDb = $statement->fetch();
        if ($recruteurFromDb) {
            $result->parse($recruteurFromDb);
        } else {
            $sql = "INSERT INTO recruteur (idREC, nom_rec, prenom_rec, sexe_rec, email_rec, poste_rec) VALUES (
                null, '{$nom_rec}', '{$prenom_rec}', '{$sexe_rec}', '{$email_rec}', '{$poste_rec}'
            );";
            $statement = $db->prepare($sql);
            if ($statement->execute()) {
                $result->parse(["idREC" => $db->lastInsertId(), "$nom_rec" => $nom_rec]);
            }
        }
        return $result;
    }
}
