<?php

use App\Core\Controller;
use App\Models\UserModel;
use App\Core\Database;

class LoginController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $header = array();
        $header['title'] = "se connecter";
        $header['js'] = ['/src/login'];
        $header['css'] = ['/src/login'];
        $this->_renderH($header);
        $this->render('index');
        $this->renderF();
    }

    public function check()
    {

        if (isset($_POST['username']) && isset($_POST['password'])) {
            header("content-type:text/javascript");
            $data = [
                'username' => $_POST['username'],
                'password' => $_POST['password']
            ];
            echo json_encode($data);
        };
    }
}