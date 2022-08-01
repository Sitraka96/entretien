<?php
use App\Core\Controller;
use App\Core\Database;
use App\Core\Utils;
use App\Core\Alert;
use App\Core\Conf;
use App\Models\UMModel;
use App\Models\UserModel;
use App\Models\Type_userModel;
class AccueilController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $header=[
            'title'=>'ACCUEIL',
            'current_menu'=>'ACCUEIL',
            'css'=>['/src/accueil'],
            'js'=>['/src/accueil'],
            // 'css'=>['aos','/src/accueil'],
            // 'js'=>['aos','/src/accueil'],
        ];
        $this->renderH($header);
        $this->render('index');
        $this->renderF();
    }
   
    

    public function b(){
       $ls=[
           'IRD'=>[1,2,3,4,5,6],
           'TC'=>[1,2,3,4,5,6],
           'MEGP'=>[1,2,3,4,5,6],
           'BANCASS'=>[1,2,3,4,5,6],
       ];
        
    }

    public function getNews(){
        Utils::HeaderJS();
        echo json_encode([
            ['id'=>10,'value'=>'FRS'],
            ['id'=>11,'value'=>'Anglais'],
            ['id'=>12,'value'=>'Malagasy'],
            ['id'=>12,'value'=>'Malaisie'],
        ]);
    }

    function isBetween($d,$f,$lsh){
        foreach ($lsh as $item) {
            $hd=new DateTime($item['hdebut']);
            $hf=new DateTime($item['hfin']);
            if (!(($d<$hd && $f<=$hd) || ($d>=$hf && $f>$hf))) {
                return true;
            } 
        }
        return false;
    }


   




    




}

