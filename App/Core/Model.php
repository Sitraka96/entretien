<?php

namespace App\Core;

use App\Core\Database;
use App\Models\AbModel;
use App\Models\AuModel;
use App\Models\DoModel;
use App\Models\GpModel;
use App\Models\MbModel;
use App\Models\NatModel;
use App\Models\NivModel;
use App\Models\RecruteurModel;
use App\Models\SbModel;

class Model
{
    var $db;
    var $table;
    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->table = self::get_tablename();
    }


    public function getPPTS()
    {
        $ppts = get_object_vars($this);
        unset($ppts['db'], $ppts['table']);
        return $ppts;
    }


    public static function get_vars()
    {
        $ppts = get_class_vars(get_called_class());
        unset($ppts['db'], $ppts['table']);
        var_dump($ppts);
    }

    private static function get_tablename()
    {
        $mn = strtolower(get_called_class());
        $tab = explode('\\', $mn);
        return str_replace('model', '', $tab[2]);
    }

    public function getModel($modelName): Model | null
    {
        $result = null;
        $tableName = strtolower($modelName);
        $primaryKey = "id" . strtoupper($modelName);
        $foreignKey = strtoupper($modelName) . "_id";
        switch ($modelName) {
            case 'recruteur':
                $primaryKey = "idREC";
                $foreignKey = "REC_id";
                $result = new RecruteurModel();
                break;
            case 'Nat':
                $result = new NatModel();
                break;
            case 'Do':
                $result = new DoModel();
                break;
            case 'Ab':
                $result = new AbModel();
                break;
            case 'Mb':
                $result = new MbModel();
                break;
            case 'Sb':
                $result = new SbModel();
                break;
            case 'Niv':
                $result = new NivModel();
                break;
            case 'Au':
                $result = new AuModel();
                break;
            case 'Gp':
                $result = new GpModel();
                break;

            default:
                return null;
                break;
        }
        $foreignKeyValue = $this->{$foreignKey} ?? 0;
        $db = Database::getConnection();
        $sql = "SELECT * FROM $tableName WHERE $primaryKey = {$foreignKeyValue} LIMIT 1;";
        $dbPreparation = $db->prepare($sql);
        $dbPreparation->execute();
        $resultFromDB = $dbPreparation->fetch();
        $resultFromDB ? $result->parse($resultFromDB) : "";
        return $result;
    }

    public function inspect($attr = null, $msg = "", $position = "left"): void
    {
        $modelName = preg_split("/[\\\\]/", get_called_class())[2];

        echo "<div id='inspection-container' class='inspect' style='z-index:9999;position:fixed;{$position}:0;top:0;height:100vh;line-break:anywhere;overflow-y:auto;background-color:rgba(0 0 0 /75%);color:rgba(250 250 250 /50%);max-width:50%'>";
        echo '<div style="position:sticky;top:0;display:flex;justify-content:space-between;background-color:rgba(250 100 100 /75%);">';
        echo '<h5 style="text-decoration:underline;margin:1rem;">' . $modelName . '</h5>';
        echo '<button type="button" onclick="event.target.parentElement.parentElement.remove();" style="padding:10px 17px;background-color:transparent;border:none;">X</button>';
        echo '</div>';
        if ($msg) {
            echo '<h6 style="color:white;margin:1rem;">';
            var_dump($msg);
            echo '</h6>';
        }
        echo '<ul style="list-style:square;">';
        if ($attr) {
            echo $attr . " => " . $this->{$attr};
        } else {
            foreach ($this->getPPTS() as $key => $value) {
                echo "<li>$key => ";
                var_dump($value);
                echo "<br/></li>";
            }
        }
        echo '</ul></div>';
    }

    public function getDESC()
    {
        $ppts = $this->getPPTS();
        var_dump($ppts);
    }

    public function tryParse($data)
    {
        $str = "KEY ARRAY NOT FOUND\n";
        $str .= "--------------------------------------------\n";
        $nbError = 0;
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            } else {

                $str .= "'" . $key . "' : '" . $value . "'\n";
                $str .= "--------------------------------------------\n";
                $nbError++;
            }
        }
        if ($nbError > 0) {
            echo nl2br($str);
        }
    }

    public function parse($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) { // array_exists does not work with Model
                $this->{$key} = $value;
            }
        }
    }

    public function insert($excludedPPTS = null): string
    {
        $ppts = $this->getPPTS();

        if (!isset($ppts['isPK'])) {
            die('CLE PRIMARY NULL');
        }
        if (!isset($ppts['isAI'])) {
            die('isAI NULL');
        }

        // var_dump($ppts);

        if ($ppts['isAI']) {
            $ik = $ppts['isPK'];
            unset($ppts[$ik]);
        }

        unset($ppts['isPK'], $ppts['isAI']);

        if (isset($excludedPPTS)) {
            if (is_array($excludedPPTS)) {
                foreach ($excludedPPTS as $value) {
                    unset($ppts[$value]);
                }
            } else {
                unset($ppts[$excludedPPTS]);
            }
        }

        $keys = array_keys($ppts);
        $alias = implode(',:', $keys);
        $alias = ':' . $alias;
        $attr = implode(',', $keys);

        $tmp = explode(',', $attr);
        $values = array_values($ppts);
        $list = array_combine($tmp, $values);

        $sql = 'INSERT INTO ' . $this->table . '(' . $attr . ') VALUES (' . $alias . ');';

        try {
            $statement = $this->db->prepare($sql);
            if ($statement->execute($list)) {
                return isset($ik) ? ($this->db)->lastInsertId() : 'ok';
            } else {
                return 'ko';
            }
        } catch (\PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function update($id = null, $excludedPPTS = null)
    {
        $ppts = $this->getPPTS();
        if (!isset($ppts['isPK'])) {
            die('CLE PRIMARY NULL');
        }
        if (!isset($ppts['isAI'])) {
            die('isAI NULL');
        }

        $ik = $ppts['isPK'];
        unset($ppts['isPK'], $ppts['isAI']);

        if (isset($excludedPPTS)) {
            if (is_array($excludedPPTS)) {
                foreach ($excludedPPTS as $value) {
                    unset($ppts[$value]);
                }
            } else {
                unset($ppts[$excludedPPTS]);
            }
        }

        $keys = array_keys($ppts);
        $list = [];
        $ls = [];
        foreach ($ppts as $key => $value) {
            $ls[] = $key . '=:' . $key;
            $list[$key] = $ppts[$key];
        }

        $var1 = implode(',', $ls);
        $sql = 'UPDATE ' . $this->table . ' SET ' . $var1 . ' WHERE ' . $ik . '=:idParam;';
        $list['idParam'] = isset($id) ? $id : $ppts[$ik];
        try {
            $statement = $this->db->prepare($sql);
            if ($statement->execute($list)) {
                return 'ok';
            } else {
                return 'ko';
            }
        } catch (\PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function delete()
    {
        $ppts = $this->getPPTS();
        if (!isset($ppts['isPK'])) {
            die('CLE PRIMARY NULL');
        }
        $ik = $ppts['isPK'];
        $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $ik . '=:' . $ik . ';';
        try {
            $statement = $this->db->prepare($sql);
            $cond = [
                $ik => $ppts[$ik]
            ];
            if ($statement->execute($cond)) {
                return 'ok';
            } else {
                return 'ko';
            }
        } catch (\PDOException $ex) {
            return $ex->getMessage() . "<br/>";
        }
    }

    public static function deleteBy($value)
    {
        $table = self::get_tablename();
        $ppts = get_class_vars(get_called_class());
        $ik = $ppts['isPK'];
        $sql = "DELETE FROM $table WHERE " . $ik . '=:' . $ik . ';';
        $db = Database::getConnection();
        try {
            $stmt = $db->prepare($sql);
            if ($stmt->execute([$ik => $value])) {
                return 'ok';
            } else {
                return 'ko';
            }
        } catch (\PDOException $ex) {
            return $ex->getMessage() . "<br/>";
        }
    }

    public function getAu(): AuModel
    {
        $result = new AuModel();
        $db = Database::getConnection();
        $sql = "SELECT * FROM au WHERE idAU like '{$this->AU_id}' LIMIT 1;";
        $dbPreparation = $db->prepare($sql);
        $dbPreparation->execute();
        $resultFromDB = $dbPreparation->fetch();
        $resultFromDB ? $result->parse($resultFromDB) : "";
        return $result;
    }

    public function getNiv(): NivModel
    {
        $result = new NivModel();
        $db = Database::getConnection();
        $sql = "SELECT * FROM niv WHERE idNIV like '{$this->NIV_id}' LIMIT 1;";
        $dbPreparation = $db->prepare($sql);
        $dbPreparation->execute();
        $resultFromDB = $dbPreparation->fetch();
        $resultFromDB ? $result->parse($resultFromDB) : "";
        return $result;
    }

    public function getGp($attr = "*"): GpModel
    {
        $db = Database::getConnection();
        $sql = "SELECT {$attr} FROM gp WHERE (idGP like '{$this->GP_id}' OR nom_gp = '{$this->GP_id}') LIMIT 1;";
        $dbPreparation = $db->prepare($sql);
        $dbPreparation->execute();
        $gp = new GpModel();
        $fetchedGp = $dbPreparation->fetch();
        $fetchedGp ? $gp->parse($fetchedGp) : "";
        return $gp;
    }

    public function getContacts($contactIndex = null): array | string
    {
        $contact = property_exists($this, "contact") ? $this->contact : $this->contacte;
        $contacts = preg_split("/[,]/", $contact);

        if ($contactIndex >= count($contacts)) {
            $result = "";
        } else {
            if (is_null($contactIndex)) {
                $result = [];
                foreach ($contacts as $contact) {
                    if (!in_array($contact, [' ', ''])) {
                        array_push($result, $contact);
                    }
                }
            } else {
                return  $contacts[$contactIndex];
            }
        }
        return $result;
    }

    public static function getList($value = null, $order = null)
    {
        $table = self::get_tablename();
        $sql = 'SELECT * FROM ' . $table;
        if (isset($value) && isset($order)) {
            $sql .= ' ORDER BY ' . $value . ' ' . $order;
        }
        $db = Database::getConnection();
        try {
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        } catch (\PDOException $ex) {
            return $ex->getMessage() . "<br/>";
        }
    }

    public static function get($value)
    {
        $table = self::get_tablename();
        $ppts = get_class_vars(get_called_class());

        if (!isset($ppts['isPK'])) {
            die('CLE PRIMARY NULL');
        }

        if (!isset($ppts['isAI'])) {
            die('isAI NULL');
        }
        $ik = $ppts['isPK'];

        $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $ik . '=?;';
        $db = Database::getConnection();
        try {
            $stmt = $db->prepare($sql);
            if ($stmt->execute([$value])) {
                return $stmt->fetch();
            } else {
                return false;
            }
        } catch (\PDOException $ex) {
            return false;
        }
    }

    public static function toModel($dataFromDB): array
    {
        $result = [];
        foreach ($dataFromDB as $key => $value) {
            $item = new (get_called_class())(); // ex: new EntretienModel()
            $item->parse($value);
            $result[$key] = $item;
        }
        return $result;
    }
}
