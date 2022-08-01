<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class HistoriqueModel extends Model
{
    protected $isPK = 'id';
    protected $isAI = true;

    public $id;
    public $information;
    public $created_at;
    public $username;
    public $action_type;
    public $etudiant;

    public function __construct()
    {
        parent::__construct();
    }

    public static function insertData(): void
    {
    }
}
