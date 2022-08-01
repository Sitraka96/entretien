<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class Type_userModel extends Model
{
    protected $isPK = 'idTU';
    protected $isAI = true;

    var $idTU, $type_tu;
    public function __construct()
    {
        parent::__construct();
    }

    public static function All(): array
    {
        $result = array();
        $db = Database::getConnection();
        $sql = "SELECT * from type_user;";
        $statement = $db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }
}
