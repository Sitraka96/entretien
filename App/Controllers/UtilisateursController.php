<?php
use App\Core\Controller;
use App\Core\Utils;
use App\Core\Alert;
use App\Models\UserModel;
use App\Models\Type_userModel;
use App\Core\Database;
class UtilisateursController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $header['title']="Gestion des utilisateurs";
        $header['current_menu']='AUTRES';
        $header['js']=['/src/cplugs','/src/register'];
        $header['css']=['/src/inc'];
        $data['types']=Type_userModel::All();
        $data['list']=UserModel::getUsersTypes();
       
        $this->renderH($header);
        $this->render('index',$data);
        $this->renderF();
    }


    public function check(){
        Utils::PAuth();
        Utils::Exist(['username','password','cpassword','form_type','email']);
        Utils::UCP('nom');
        Utils::UCWP('prenom');
        Utils::int_post('TU_id');
        $user=new UserModel();
        $user->parse($_POST);
        if($_POST['form_type']=='insert'){
            $user->create_time=date('Y-m-d');
            $res=$user->insert();
            if ($res=='ok') {
                \addFlash('success','Bien Ajouté !');
            } else {
                \addFlash('danger','Erreur d\'insertion !');
            }
           
        }

        if($_POST['form_type']=='edit'){
            $res=$user->update($id=$_POST['opk'],$excludedPPTS='photo');
            if ($res=='ok') {
                \addFlash('success','Bien à jour !');
            } else {
                \addFlash('danger','Erreur de mise à jour !');
            }
        }
        header('Location: /Utilisateurs');
        

    }
    
    public function delete(){
        Utils::PAuth();
        UserModel::removeUser();
        header('Location: /Utilisateurs');
    }


    function showUptOPT($fk_id,$ls,$key,$value){
        foreach ($ls as $item) {
          $s=($item[$key]==$fk_id)?'selected':'';
          echo '<option value="'.$item[$key].'"'.$s.'>'.$item[$value].'</option>';
        }
        
    }

    function showOPT($ls,$key,$value){
        foreach ($ls as $item) {
          echo '<option value="'.$item[$key].'">'.$item[$value].'</option>';
        }
    }





}

