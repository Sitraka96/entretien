<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class SbModel extends Model
{
    protected $isPK = 'idSB';
    protected $isAI = true;

    var $idSB, $serie;
    public function __construct()
    {
        parent::__construct();
    }

    public static function findOrCreate($serie): SbModel
    {
        $result = new SbModel();
        $db = Database::getConnection();
        $sql = "SELECT * FROM sb WHERE serie = '{$serie}' LIMIT 1;";
        $statement = $db->prepare($sql);
        $statement->execute();
        $sbFromDb = $statement->fetch();
        if ($sbFromDb) {
            $result->parse($sbFromDb);
        } else {
            $sql = "INSERT INTO sb (idSB, serie) VALUES (null, '{$serie}');";
            $statement = $db->prepare($sql);
            if ($statement->execute()) {
                $result->parse(["idSB" => $db->lastInsertId(), "serie" => $serie]);
            }
        }
        return $result;
    }
}
