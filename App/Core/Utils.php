<?php
namespace App\Core;
use  App\Models\OptModel;
class Utils{

    public static function getToken(){
        return md5(substr(str_shuffle(Conf::$alphabet), rand(0,20),rand(40,60)));
    }

    public static function str_random($l){
        return substr(str_shuffle(Conf::$alphabet), 0,$l);
    }

    public static function HeaderJS(){
        header("content-type:text/javascript");
    }
    
    public static function GAuth($token){
        if(isset($token) && $token!=$_SESSION['token']){
            Alert::error('Jeton de sécurité périmé !');
            die();
        }
    }

    public static function convertToLetter($number){
        $convert = explode('.', $number);    
        $num[17] = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit',
            'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize');
                
        $num[100] = array(20 => 'vingt', 30 => 'trente', 40 => 'quarante', 50 => 'cinquante',
                60 => 'soixante', 70 => 'soixante-dix', 80 => 'quatre-vingt', 90 => 'quatre-vingt-dix');
                    
        if (isset($convert[1]) && $convert[1] != '') {
            
            if($convert[1][0] == 0 || strlen($convert[1]) > 1){
            $convert[1] = (int) $convert[1];    
            }else{
            $convert[1] = (int) ($convert[1].'0');   
            }
        
            return self::convertToLetter($convert[0]).'$$$'.self::convertToLetter( $convert[1]);
        }
        if ($number < 0) return 'moins '.self::convertToLetter(-$number);
        if ($number < 17) {
            return $num[17][$number];
        }
        elseif ($number < 20) {
            return 'dix-'.self::convertToLetter($number-10);
        }
        elseif ($number < 100) {
            if ($number%10 == 0) {
            return $num[100][$number];
            }
            elseif (substr($number, -1) == 1) {
            if( ((int)($number/10)*10)<70 ){
            return self::convertToLetter((int)($number/10)*10).'-et-un';
            }
            elseif ($number == 71) {
            return 'soixante-et-onze';
            }
            elseif ($number == 81) {
            return 'quatre-vingt-un';
            }
            elseif ($number == 91) {
            return 'quatre-vingt-onze';
            }
            }
            elseif ($number < 70) {
            return self::convertToLetter($number-$number%10).'-'.self::convertToLetter($number%10);
            }
            elseif ($number < 80) {
            return self::convertToLetter(60).'-'.self::convertToLetter($number%20);
            }
            else {
            return self::convertToLetter(80).'-'.self::convertToLetter($number%20);
            }
        }
        elseif ($number == 100) {
            return 'cent';
        }
        elseif ($number < 200) {
            return self::convertToLetter(100).' '.self::convertToLetter($number%100);
        }
        elseif ($number < 1000) {
            return self::convertToLetter((int)($number/100)).' '.self::convertToLetter(100).($number%100 > 0 ? ' '.self::convertToLetter($number%100): '');
        }
        elseif ($number == 1000){
            return 'mille';
        }
        elseif ($number < 2000) {
            return self::convertToLetter(1000).' '.self::convertToLetter($number%1000).' ';
        }
        elseif ($number < 1000000) {
            return self::convertToLetter((int)($number/1000)).' '.self::convertToLetter(1000).($number%1000 > 0 ? ' '.self::convertToLetter($number%1000): '');
        }
        elseif ($number == 1000000) {
            return 'millions';
        }
        elseif ($number < 2000000) {
            return self::convertToLetter(1000000).' '.self::convertToLetter($number%1000000);
        }
        elseif ($number < 1000000000) {
            return self::convertToLetter((int)($number/1000000)).' '.self::convertToLetter(1000000).($number%1000000 > 0 ? ' '.self::convertToLetter($number%1000000): '');
        }
    }


    public static function PAuth(){
        if(isset($_POST) && isset($_POST['token']) && $_POST['token']!=$_SESSION['token']){
            Alert::error('Jeton de sécurité périmé !');
            die();
        }
    }
    public static function PEqual($a,$b){
        if($_POST[$a]!=$_POST[$b]){
            Alert::error('Votre mot de passe n\'est pas identique !');
            die();
        }
    }
    

    public static function Exist($params){
        $a=1;
        if (is_array($params)) {
            foreach ($params as $value) {
                $a&=!empty($_POST[$value]);
            }
        } else {
            $a&=!empty($_POST[$params]);
        }
        if($a==0){
            Alert::error('Veuillez-remplir les champs obligatoires !');
            die();
        }
        
       
         
    }

    public static function VD($params){
        call_user_func_array('var_dump',$params);
    }

    
    public static function tofloat($num) {
        $dotPos = strrpos($num, '.');
        $commaPos = strrpos($num, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
            ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
      
        if (!$sep) {
            return floatval(preg_replace("/[^0-9]/", "", $num));
        }
    
        return floatval(
            preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
            preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
        );
    }

    public static function datetime_now(){
        $d=new \DateTime('now');
        $d->modify('+3 hours');
        return $d;
    }
    
    //28/02/2019
    public static function date2db($value){
        $t=str_replace('/','-',$value);
        return date('Y-m-d',strtotime($t));
    }
    public static function parseDate($date){
        if (is_array($date)) {
            foreach ($date as $value) {
                $t=str_replace('/','-',$_POST[$value]);
                $_POST[$value]=date('Y-m-d',strtotime($t));
            }
        } else {
            $t=str_replace('/','-',$_POST[$date]);
            $_POST[$date]=date('Y-m-d',strtotime($t));
        }
        
    }

    public static function int_post($value){
        if(is_array($value)){
            foreach ($value as $item) {
                $_POST[$item]=intval($_POST[$item]);
            }
        }else{
            $_POST[$value]=intval($_POST[$value]);
        }
    }

    public static function int_session($value){
        if(is_array($value)){
            foreach ($value as $item) {
                $_SESSION[$item]=intval($_SESSION[$item]);
            }
        }else{
            $_SESSION[$value]=intval($_SESSION[$value]);
        }
    }

    public static function check_post($value){
        if(is_array($value)){
            foreach ($value as $item) {
                $_POST[$item]=isset($_POST[$item])?1:0;
            }
        }else{
            $_POST[$value]=isset($_POST[$value])?1:0;
        }
    }

    //set_session(['nom'=>tata])
    public static function set_session($values){
        if (is_array($values)) {
            foreach ($values as $key=> $value) {
                $_SESSION[$key]=$value;
            }
        }
    }

    public static function crypt($str){
        //abcd

    }

    //to upper case
    public static function UCP($values){
        if (is_array($values)) {
            foreach ($values as $value) {
                $_POST[$value]=strtoupper(trim($_POST[$value]));
            }
        } else {
            $_POST[$values]=strtoupper(trim($_POST[$values]));
        }
        
    }

    //to upper case word 
    public static function UCWP($values){
        if (is_array($values)) {
            foreach ($values as $value) {
                $_POST[$value]=ucwords(trim($_POST[$value]));
            }
        } else {
            $_POST[$values]=ucwords(trim($_POST[$values]));
        }
        
    }
}