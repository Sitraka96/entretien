<?php
use App\Core\Controller;
use App\Core\Conf;
use App\Models\UMModel;
use App\Models\UserModel;
use App\Models\Type_userModel;
use App\Core\Database;
class UserController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $header=array();
        $header['title']="s'inscrire";
        $header['js']=['/src/register'];
        $header['css']=['/src/form'];

       
        $this->_renderH($header);
        $this->render('register');
        $this->renderF();
        
    }

    public function check(){
        if (isset($_POST['username']) && isset($_POST['password'])) {
            UserModel::checkUM();
        }else{
            echo 'error';
        }
    }

    public function logout(){
        if (isset($_SESSION['username'])) {
            session_destroy();
            header("Location:/login");
        }
        
    }

    public function micr(){
        $pwd='dsd!';
        $file=fopen('conf.txt','a');
        for ($i=0; $i < 20; $i++) { 
            // $hash=password_hash($pwd,PASSWORD_DEFAULT);
            fputs($file,$i);
        }
        fclose($file);
        echo 'fichier oks!';
        // $hash= password_hash($pwd,PASSWORD_DEFAULT);
        // var_dump($hash,password_verify($pwd,$hash));
    }




}

