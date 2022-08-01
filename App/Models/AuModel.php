<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class AuModel extends Model
{
    protected $isPK = 'idAU';
    protected $isAI = true;

    var $idAU, $nom_au;
    public function __construct()
    {
        parent::__construct();
    }

    public static function find($AU_id): AuModel
    {
        $result = new AuModel();
        $db = Database::getConnection();
        $sql = "SELECT * FROM au WHERE idAU like '$AU_id' LIMIT 1;";
        $dbPreparation = $db->prepare($sql);
        $dbPreparation->execute();
        $e = $dbPreparation->fetch();
        if ($e) {
            $result->parse($e);
        }
        return $result;
    }
}