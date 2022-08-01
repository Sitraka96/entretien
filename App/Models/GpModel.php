<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class GpModel extends Model
{
    protected $isPK = 'idGP';
    protected $isAI = true;

    var $idGP, $nom_gp;
    public function __construct()
    {
        parent::__construct();
    }

    public static function getListBy($POST): array | string
    {
        $AU_id = $POST['AU_id'] ?? 0;
        $NIV_id = $POST['NIV_id'] ?? 0;

        $sql = "SELECT g.* FROM gp_has_au
            INNER JOIN gp g ON g.idGP = GP_id
            INNER JOIN au a ON a.idAU = AU_id
            INNER JOIN niv n ON n.idNIV = NIV_id
            WHERE (AU_id = {$AU_id} AND NIV_id = {$NIV_id})
            ORDER BY nom_gp ASC;
        ";

        $db = Database::getConnection();
        $stmt = $db->prepare($sql);
        // $stmt->bindParam(1, $nom_gp);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;

        // try {
        // } catch (\PDOException $ex) {
        //     return $ex->getMessage();
        // }
    }

    public function get4AU(): void
    {
    }
}
