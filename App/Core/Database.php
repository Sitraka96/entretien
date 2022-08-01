<?php 
namespace App\Core;
use \PDO;
class Database{
    
    private static $pdo;

    /**
     * Permet d'ouvrir une connexion à la base de données
     *
     * @return PDO
     */

    public static function getConnection() : PDO
    {
        if(self::$pdo == null){
            self::$pdo = new PDO('mysql:host='.Conf::$db['hostname'].';dbname='.Conf::$db['dbname'], Conf::$db['username'],Conf::$db['password'],
            [ PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',
              PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC ]
        );
            
        }
        return self::$pdo;
    }

}