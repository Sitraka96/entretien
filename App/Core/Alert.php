<?php
namespace App\Core;
class Alert{
    const TYPES=[
        'info'=>'info',
        'success'=>'success',
        'error'=>'danger',
        'warning'=>'warning'
    ];
    static $liste=['a','u','d'];
    static $aok='Ajout éffectué !',
    $ako='Erreur d\'ajout !',
    $uok='Mise à jour éffectuée !',
    $uko='Erreur de mise à jour !',
    $dok='Suppréssion éffectuée !',
    $dko='Erreur de suppréssion !';
    
    
    
    public static function get($color,$message,$data=null){
        if ($data!=null) {
            echo json_encode(['message'=>$message,'color'=>$color,'data'=>$data]);
        } else {
            echo json_encode(['message'=>$message,'color'=>$color]);
        }
        die();
    }
   

    private static function get_ko($index,$value){
        if (in_array($value,self::$liste)) {
            $value.='ko';
            self::get(self::TYPES[$index],self::$$value);
        } else {
            self::get(self::TYPES[$index],$value);
        }
    }

    //success('a',$data) ou success('a') ou success('okdqfqsdf')
    private static function get_ok($index,$value,$data=null){
        if (in_array($value,self::$liste) && $data!=null) {
            $value.='ok';
            self::get(self::TYPES[$index],self::$$value,$data);
        }elseif (in_array($value,self::$liste) && $data==null) {
            $value.='ok';
            self::get(self::TYPES[$index],self::$$value);
        }else{
            self::get(self::TYPES[$index],$value);
        }
        
       
    }
    
    public static function success($value,$data=null){
       self::get_ok('success',$value,$data);

    }
    public static function info($value,$data=null){
       self::get_ok('info',$value,$data);

    }
  

    public static function warning($value){
        self::get_ko('warning',$value);
    }

    public static function error($value){
        self::get_ko('error',$value);
    }


    public static function debug($message){
        if(Conf::debug==1){
            self::error($message);
        }else{
            self::error(Conf::DEFAULT_MESSAGE);
        }
        
    }

    public static function check($res,$opt='a'){

        switch ($res) {
            case 'ok':
                $opt.=$res;
                self::info(self::$$opt);
                break;
            case 'ko':
                $opt.=$res;
                self::warning(self::$$opt);
                break;
            default:
                self::debug($res);
                break;
        }
    }
    

    public static function vp($value){      
        ob_start();
        var_dump($value);
        $c = ob_get_clean();
        echo json_encode(['color'=>self::TYPES['info'],'message'=>$c]);
    }
    


    

}