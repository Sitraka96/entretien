<?php

use App\Core\Controller;
use App\Models\DossierModel;

class DossierController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function list($NIV_id)
    {
        $result = [];

        $result = DossierModel::getListBy($NIV_id);

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
}
