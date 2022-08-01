<?php

namespace App\Models;

use App\Core\Model;

class DoModel extends Model
{
    // protected $isAI='nie';
    protected $isPK = 'idDO';
    protected $isAI = true;
    //Etudiant

    var $idDO, $diplome;
    public function __construct()
    {
        parent::__construct();
    }
}
