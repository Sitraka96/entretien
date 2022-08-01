<?php

namespace App\Models;

use App\Core\Model;

class DataModel extends Model
{
    protected $isPK = 'idDATA';
    protected $isAI = true;

    var $idDATA, $nom_data;
    public function __construct()
    {
        parent::__construct();
    }

    public static function getData(): mixed
    {
        return [];
    }

    public static function parseContacte(): void
    {
    }

    public static function uploadPhoto_Etudiant(): void
    {
    }

    public static function parseDate(): void
    {
    }
}
