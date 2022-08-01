<?php

namespace App\Core;

class Controller
{
    var $layout = 'default';
    var $dir_view;
    var $dir_template = APP . '/Views/Templates/';
    var $content;
    public function __construct()
    {
        $tmp = str_replace('Controller', 'View', get_class($this));
        $this->dir_view = APP . '/Views/' . $tmp . '/';
    }

    public function render($filename, $data = null)
    {
        if ($data) {
            extract($data);
        }
        $v = str_replace('.', '/', $filename);
        $ls = explode('/', $v);
        if (count($ls) > 1) {
            $nv = ucfirst($ls[0]) . 'View/';
            unset($ls[0]);
            $nf = implode('/', $ls);
            require APP . '/Views/' . $nv . $nf . '.php';
        } else {
            require $this->dir_view . $filename . '.php';
        }
    }

    public function template($filename, $data = null)
    {
        if ($data) {
            extract($data);
        }
        require $this->dir_template . $filename . '.php';
    }

    public function _renderH($data = null)
    {
        if ($data) {
            extract($data);
        }
        require APP . '/Views/Layout/header.php';
    }

    public function renderH($data = null)
    {
        if ($data) {
            extract($data);
        }
        require APP . '/Views/Layout/header.php';
        require APP . '/Views/Layout/menu.php';
    }
    public function renderF($data = null)
    {
        if ($data) {
            extract($data);
        }
        require APP . '/Views/Layout/footer.php';
    }

    public function renderOB($filename, $data = null)
    {
        if ($data) {
            extract($data);
        }
        ob_start();
        require $this->dir_view . $filename . '.php';
        return ob_get_clean();
    }

    public function GET($query = null)
    {
        $req = $_SERVER["REQUEST_URI"];
        $req = preg_split("/[?=&]/", $_SERVER["REQUEST_URI"]);
        $parsedReq = array();
        foreach ($req as $key => $value) {
            if ($key % 2 && $key < sizeof($req) - 1) {
                $parsedReq[$value] = $req[$key + 1];
            }
        }
        return $query ? $parsedReq[$query] : $parsedReq;
    }
}
