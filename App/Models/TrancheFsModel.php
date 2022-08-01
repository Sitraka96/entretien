<?php

namespace App\Models;

use App\Core\Model;

class TrancheFsModel extends Model
{
    protected $isPK = 'idTFS';
    protected $isAI = true;

    var $idTFS;
    public function __construct()
    {
        parent::__construct();
    }
}
