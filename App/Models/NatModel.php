<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class NatModel extends Model
{
    protected $isPK = 'idNAT';
    protected $isAI = true;

    var $idNAT, $nationalite;
    public function __construct()
    {
        parent::__construct();
    }

    public static function findOrCreate($nationalite): NatModel
    {
        $result = new NatModel();
        $db = Database::getConnection();
        $sql = "SELECT * FROM nat WHERE nationalite = '{$nationalite}' LIMIT 1;";
        $statement = $db->prepare($sql);
        $statement->execute();
        $natFromDb = $statement->fetch();
        if ($natFromDb) {
            $result->parse($natFromDb);
        } else {
            $sql = "INSERT INTO nat (idNAT, nationalite) VALUES (null, '{$nationalite}');";
            $statement = $db->prepare($sql);
            if ($statement->execute()) {
                $result->parse(["idNAT" => $db->lastInsertId(), "$nationalite" => $nationalite]);
            }
        }
        return $result;
    }
}
