<?php
use App\Core\Controller;
use App\Core\Database;
use App\Core\Utils;
use App\Core\Alert;
use App\Models\AuModel;
use App\Models\GpModel;
class AuController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $header['title']='GROUPE ET PARCOURS';
        $header['current_menu']='AUTRES';
        $header['css']=['/src/inc'];
        $header['js']=['/src/cplugs','/src/au'];
        $data['au']=AuModel::getList('nom_au','DESC');
        $data['niv']=['L1'=>'1','L2'=>'2','L3'=>'3','M1'=>'4','M2'=>'5'];
        $data['L1']= GpModel::getGP(['TC','IRD']);
        $data['L2']= GpModel::getGP(['BANCASS','IRD','MEGP']);
        $data['L3']= GpModel::getGP(['BANCASS','IRD','MEGP']);
        $data['M1']= GpModel::getGP(['IMP','MIAGE','QUADD']);
        $data['M2']= GpModel::getGP(['IMP','MIAGE','QUADD']);
        
        //1 tc2 2
        $this->renderH($header);
        $this->template('confirm_modal');
        $this->render('index',$data);
        $this->renderF();
    }

    public function check(){
        Utils::HeaderJs();
        Utils::Exist(['au','data']);
        GpModel::checkInsert($_POST['au'],$_POST['data']);
    }

    public function a(){
        $ls=[
            GpModel::getGP(['TC','IRD']),
            GpModel::getGP(['BANCASS','IRD','MEGP']),
            GpModel::getGP(['BANCASS','IRD','MEGP']),
            GpModel::getGP(['IMP','MIAGE','QUADD']),
            GpModel::getGP(['IMP','MIAGE','QUADD'])
        ];
        var_dump($ls);
    }






    




}

