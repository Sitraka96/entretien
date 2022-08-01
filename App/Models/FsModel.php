<?php

namespace App\Models;

use App\Core\Model;

class FsModel extends Model
{
    protected $isPK = 'idFS';
    protected $isAI = true;

    var $idFS, $nom_fs;
    public function __construct()
    {
        parent::__construct();
    }

    public static function getListBy(): array
    {
        $result = [];
        return $result;
    }
}
