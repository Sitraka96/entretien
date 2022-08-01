<?php
define('APP',str_replace('\\','/',dirname(__DIR__)));
define ('RWEB',dirname(__DIR__));
define('WEB',dirname(APP).'/public');
define('LS_CSS',[
    'typeahead'=>[
        'online'=>'https://cdnjs.cloudflare.com/ajax/libs/jquery-typeahead/2.11.0/jquery.typeahead.min.css',
        'offline'=>'/assets/css/th.min.css'],
    'toggle-btn'=>[
        'online'=>'https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css',
        'offline'=>'/assets/css/bt4-tg.min.css'],
    'td'=>[
        'online'=>'https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css',
        'offline'=>'/assets/css/td.min.css'],
    'animate'=>[
        'online'=>'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css',
        'offline'=>'/assets/css/animate.min.css'],
    'fontawesome'=>[
        'online'=>'https://use.fontawesome.com/releases/v5.0.6/css/all.css',
        'offline'=>'/assets/css/all.min.css'],
    'jquery-datetime'=>[
        'online'=>'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css',
        'offline'=>'/assets/css/jdt.min.css'],
    'select2'=>[
        'online'=>'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css',
        'offline'=>'/assets/css/select2.min.css'],
    'aos'=>[
        'online'=>'https://unpkg.com/aos@2.3.1/dist/aos.css',
        'offline'=>'/assets/css/aos.css'],
]);
        
define('LS_JS',[
    'typeahead'=>[
        'online'=>'https://cdnjs.cloudflare.com/ajax/libs/jquery-typeahead/2.11.0/jquery.typeahead.min.js',
        'offline'=>'/assets/js/th.min.js'],
    'toggle-btn'=>[
        'online'=>'https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js',
        'offline'=>'/assets/js/bt4-tg.min.js'],
    'moment'=>[
        'online'=>'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js',
        'offline'=>'/assets/js/moment.min.js'],
    'moment-fr'=>[
        'online'=>'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.0/locale/fr.js',
        'offline'=>'/assets/js/moment-fr.min.js'],
    
    'moment-with-locales'=>[
        'online'=>'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js',
        'offline'=>'/assets/js/moment-with-locales.min.js'],
    'jquery-datetime'=>[
        'online'=>'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js',
        'offline'=>'/assets/js/jdt.min.js'],
    
    'td'=>[
        'online'=>'https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js',
        'offline'=>'/assets/js/td.min.js'],
    'select2'=>[
        'online'=>'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js',
        'offline'=>'/assets/js/select2.min.js'],
    'aos'=>[
        'online'=>'https://unpkg.com/aos@2.3.1/dist/aos.js',
        'offline'=>'/assets/js/aos.js'],
    'chart'=>[
        'online'=>'https://cdn.jsdelivr.net/npm/chart.js@2.8.0',
        'offline'=>'/assets/js/chart.js'],
]);

function addFlash($color,$msg)
{
    $_SESSION['flash']=[
        'color'=>$color,
        'message'=>$msg
    ];
}

function showFlash()
{
    if (isset($_SESSION['flash'])) {
        $color=$_SESSION['flash']['color'];
        $msg=$_SESSION['flash']['message'];
        unset($_SESSION['flash']);
        echo '<div class="mx-4 alert alert-'.$color.'" role="alert">'.$msg.
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }
}

function getImg($img_name){
    return WEB.'/assets/images/'.$img_name;
}

function userImg($img_name){
    echo '/assets/images/users/'.$img_name;
}

function getImageUrl($img_name){
    return '/assets/images/'.$img_name;
}
function getIcon($ico_name){
    echo '/assets/icons/'.$ico_name;
}
function ckCss($value,$status){
    if ($value[0]=='/') {
        $s='/assets/css'.$value.'.css';
        if(!file_exists(WEB.$s)){die('<div style="font-family:arial;color:#559;font-size:1.2rem;margin:50px 20px;padding:20px">Fichier '.WEB.$value.' introuvable</div>');}
    } else {
        $s=LS_CSS[$value][$status];}
    echo '<link rel="stylesheet" href="'.$s.'"/>';
    
}
function CSS($item){
    $status=(App\Core\Conf::online==1)?'online':'offline';
    if (is_array($item)) {
        foreach ($item as $value) {
            ckCss($value,$status);
        }
    }else{
        ckCss($item,$status);
    }
}
function ckJs($value,$status){
    if ($value[0]=='/') {
        $s='/assets/js'.$value.'.js';
        if(!file_exists(WEB.$s)){
            die('<div style="font-family:arial;color:#559;font-size:1.2rem;margin:20px;padding:20px">Fichier '.WEB.$value.' introuvable</div>');}
    } else {$s=LS_JS[$value][$status];}
    echo '<script src="'.$s.'"></script>';
}
function JS($item){
    $status=(App\Core\Conf::online==1)?'online':'offline';
    if (is_array($item)) {
        foreach ($item as $value) {
            ckJs($value,$status);
        }
    }else{
        ckJs($item,$status);
    }
}

function FONT($item){
    $status=(App\Core\Conf::online==1)?'online':'offline';
    $value=($item[0]=='/')?'/assets/css'.$item.'.css':LS_FONT[$item][$status];
    echo '<link rel="stylesheet" href="'.$value.'"/>';
    
}


function getDD($title,$active,$data){
    echo '<li class="nav-item dropdown '.$active.'" style="cursor: pointer;"><a class="nav-link dropdown-toggle"  id="'.$data['id'].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$title.'</a>
    <ul class="dropdown-menu" aria-labelledby="'.$data['id'].'">';
    for ($i=0; $i < count($data)-1; $i++) { 
        echo '<li><a class="dropdown-item" href="'.$data[$i]['link'].'">'.$data[$i]['name'].'</a></li>';
    }
    echo '</ul></li>';
    
}
function getMenu($data,$cm){
    //key name, $value link
    foreach ($data as $name => $value) { 
        $active=($name==$cm)?'active':'';
        if (is_array($value)) {
            getDD($name,$active,$value);
        } else {
            echo '<li class="nav-item '.$active.'"><a class="nav-link" href="'.$value.'" >'.$name.'</a></li>';
        }
        
    }
}


function getToken(){
    if(isset($_SESSION) && isset($_SESSION['token'])){
        echo '<input type="hidden" id="token" name="token" value="'.$_SESSION['token'].'">';
    }
}















