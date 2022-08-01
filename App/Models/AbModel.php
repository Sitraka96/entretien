<?php

namespace App\Models;

use App\Core\Model;

class AbModel extends Model
{
    protected $isPK = 'idAB';
    protected $isAI = true;

    var $idAB, $annee;
    public function __construct()
    {
        parent::__construct();
    }
}