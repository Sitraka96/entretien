<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class DossierModel extends Model
{
    protected $isPK = 'idDOS';
    protected $isAI = true;

    public $idDOS;
    public $nom_dos;
    public $notation;

    public function __construct()
    {
        parent::__construct();
    }

    public static function getListBy($NIV_id): array | string
    {
        $NIV_id ??= 0;

        $sql = "SELECT d.* FROM niv_has_dos
            INNER JOIN dossier d ON d.idDOS = DOS_id
            WHERE (NIV_id = {$NIV_id})
            ORDER BY idDOS ASC;
        ";

        $db = Database::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}
