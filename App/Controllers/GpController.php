<?php

use App\Core\Controller;
use App\Models\GpModel;

class GpController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $result = [];

        extract($_POST);

        if (isset($AU_id) && isset($NIV_id)) {
        } else {
            $req = $_SERVER["REQUEST_URI"];
            $req = preg_split("/[?=&]/", $_SERVER["REQUEST_URI"]);
            $parsedReq = array();
            foreach ($req as $key => $value) {
                if ($key % 2 && $key < sizeof($req) - 1) {
                    $parsedReq[$value] = $req[$key + 1];
                }
            }
            $AU_id = $parsedReq['AU_id'];
            $NIV_id = $parsedReq['NIV_id'];
        }

        $POST = [
            "AU_id" => intval($AU_id),
            "NIV_id" => intval($NIV_id),
        ];

        $result = GpModel::getListBy($POST);

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
}
