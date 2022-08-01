<?php

namespace App\Models;

use App\Core\Model;

class MbModel extends Model
{
    protected $isPK = 'idMB';
    protected $isAI = true;

    var $idMB, $mention;
    public function __construct()
    {
        parent::__construct();
    }
}