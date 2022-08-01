<?php
namespace App\Core;
class Application 
{
    private $controller;
    private $method;
    private $params;
    private $url;
    const URLS=['login','user/check'],
        LOGIN='location:/login';

    public function start(){
        session_start();
        $this->url=trim($_GET['url']);
        if ((!empty($_SESSION) && $this->url!='login') ||(empty($_SESSION) && in_array($this->url,self::URLS))) {
            $this->check();
        }elseif (!empty($_SESSION) && $this->url=='login') {
            header("Location:/Accueil");
        }else {
            header(self::LOGIN);
        } 

       
        
    }
    
    private function check(){
        $this->parseUrl();
        $this->getController();
    }

    private function parseUrl()
    {
        $url=explode('/',$this->url);
        $this->controller=!empty($url[0])?ucwords($url[0]).'Controller':null;
        $this->method=!empty($url[1])?$url[1]:'index';
        unset($url[0],$url[1]);
        $this->params=array_values($url);
    }
    
    private function getController()
    {
        $controller_file=APP.'/Controllers/'.$this->controller.'.php';
        if (file_exists($controller_file)) {
            require $controller_file;
            if(!class_exists($this->controller)){
                 die('CLASS NOT EXIST');
            }
            $this->controller=new $this->controller();
            if (method_exists($this->controller,$this->method)) {
                if (isset($this->params)) {
                    call_user_func_array(array($this->controller,$this->method),$this->params);
                } else {
                    $this->controller->{$this->method}();
                }
            }else{
                // die("Cette page n'existe pas");
                header(self::LOGIN);
            }
            
        } else {
            // die("REDIRECTION VERS HOME!");
            header(self::LOGIN);
        }
    }
}
