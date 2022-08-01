<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Utils;
use App\Core\Alert;
use App\Core\Database;
use DateTime;

class EtudiantModel extends Model
{
    protected $isPK = 'nie';
    protected $isAI = false;

    public $nie;
    public $abandon;
    public $photo;
    public $nom;
    public $prenom;
    public $sexe;
    public $datenaiss;
    public $lieunaiss;
    public $email;
    public $fb;
    public $contacte;
    public $adresse;

    public $nom_p;
    public $prenom_p;
    public $adresse_p;
    public $profession_p;
    public $email_p;
    public $contacte_p;

    public $nom_m;
    public $prenom_m;
    public $adresse_m;
    public $profession_m;
    public $email_m;
    public $contacte_m;

    public $nom_t;
    public $prenom_t;
    public $adresse_t;
    public $profession_t;
    public $email_t;
    public $contacte_t;

    public $NAT_id;
    public $AB_id;
    public $SB_id;
    public $MB_id;
    public $REC_id;
    public $dateRec;

    public function __construct($data = null)
    {
        parent::__construct();
        $this->abandon = 0;
        if ($data) {
            $this->init($data);
        }
    }

    public function init($data): bool | array
    {
        $this->parse($data);

        if ($data["session"] && is_null($this->nie)) {
            $this->generateNewNie($data["session"]);
        }

        if ($data["NAT_id"] == "*" && array_key_exists("NAT_other", $data)) {
            $this->NAT_id = NatModel::findOrCreate($data["NAT_other"])->idNAT;
        }

        if ($data["SB_id"] == "*" && array_key_exists("SB_other", $data)) {
            $this->SB_id = SbModel::findOrCreate($data["SB_other"])->idSB;
        }
        if ($data["REC_id"] == "*" && array_key_exists("nom_rec", $data)) {
            $this->REC_id = RecruteurModel::findOrCreate($data)->idREC;
        }

        if (gettype($data['contacte']) == "array") {
            $contacts = array_map("trim", $data["contacte"]);
            $this->contacte = join(", ", $contacts);
        }

        if (array_key_exists("photo", $_FILES) && array_key_exists("name", $_FILES['photo'])) {
            return $this->upload();
        }

        return true;
    }

    public static function photosDirectory(): string
    {
        return "assets/images/students/";
    }

    public function photo(): string
    {
        return "/" . $this->getAvatar();
    }

    public function upload(): bool | array
    {
        if (!array_key_exists("name", $_FILES["photo"]) || $_FILES["photo"]["name"] == "") {
            $this->errors = [
                "messages" => [
                    "warning" => "Photo is empty"
                ]
            ];
            return ["empty" => true];
        }

        $target_dir = "assets/images/students/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOk = 1;
        $this->invalidAttributes = [
            "photo" => "required"
        ];
        $this->errors = [
            "messages" => ["danger" => "Upload impossible"],
        ];

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["photo"]["tmp_name"]);
            if ($check == false) {
                $this->errors["message"] = "Veuillez choisir une image";
                return 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $this->errors["message"] = "Cette image existe déjà";
            return 0;
        }

        // Check file size
        if ($_FILES["photo"]["size"] > 500000) {
            $this->errors["message"] = "Votre fichier est trop volumineux";
            return 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $this->errors["message"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            return 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            // if everything is ok, try to upload file
        } else {
            $newFileName = $this->nie . ".jpg";
            $target_file_to_overwrite = $target_dir . $newFileName;
            $newFile = fopen($target_file_to_overwrite, "w");
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file_to_overwrite)) {
                unset($this->invalidAttributes);
                unset($this->errors);
                $this->photo = $newFileName;
            } else {
                $this->errors = [
                    "success" => true,
                    "messages" => [
                        "danger" => "Sorry, there was an error uploading your file."
                    ]
                ];
            }
        }
        return $uploadOk;
    }

    public function json(): array
    {
        return [
            "Nie" => $this->getNie(),
            "Avatar" => $this->getAvatar(),
            "FullName" => $this->getFullName(),
            "FullDatenaiss" => $this->getFullDatenaiss(),
            "Contacte" => $this->getContacte(),
            "Contacts" => $this->getContacts(),
            "Adresse" => $this->getAdresse(),
            "Email" => $this->getEmail(),
            "Fb" => $this->getFb(),
            "Age" => $this->getAge(),
            "Nat" => $this->getNat(),
            "Pere" => $this->getPere(),
            "Mere" => $this->getMere(),
            "Ab" => $this->getAb(),
            "Sb" => $this->getSb(),
            "Mb" => $this->getMb(),
            "Rec" => $this->getRec(),
            "DateRec" => $this->getDateRec(),
            "Inscription" => $this->getInscription(),
        ];
    }

    public function getRec(): array
    {
        $rec = new RecruteurModel();
        $rec->parse($this->getModel("recruteur"));
        return [
            "FullName" => $rec->getFullName(),
        ];
    }

    public function getRecruteur(): RecruteurModel
    {
        $rec = new RecruteurModel();
        $rec->parse($this->getModel("recruteur"));
        return $rec;
    }

    public function getMb(): array
    {
        $nat = $this->getModel("Mb");
        return [
            "mention" => $nat->mention,
        ];
    }

    public function getSb(): array
    {
        $nat = $this->getModel("Sb");
        return [
            "serie" => $nat->serie,
        ];
    }

    public function getAb(): array
    {
        $nat = $this->getModel("Ab");
        return [
            "annee" => $nat->annee,
        ];
    }

    public function getNat(): array
    {
        $nat = $this->getModel("Nat");
        return [
            "nationalite" => $nat->nationalite,
        ];
    }

    public function getMere(): array
    {
        return [
            "fullName" => "Mr $this->prenom_m $this->nom_m",
            "nom" => $this->nom_m,
            "prenom" => $this->prenom_m,
            "contacte" => $this->contacte_m,
            "email" => $this->email_m,
            "profession" => $this->profession_m,
            "adresse" => $this->adresse_m,
        ];
    }

    public function getPere(): array
    {
        return [
            "fullName" => "Mr $this->prenom_p $this->nom_p",
            "nom" => $this->nom_p,
            "prenom" => $this->prenom_p,
            "contacte" => $this->contacte_p,
            "email" => $this->email_p,
            "profession" => $this->profession_p,
            "adresse" => $this->adresse_p,
        ];
    }

    public function getFb(): string
    {
        return $this->fb ?? "-";
    }

    public function getEmail(): string
    {
        return $this->email ?? "Vide";
    }

    public function getAdresse(): string
    {
        return $this->adresse ?? "Aucune adresse";
    }

    public function getStrContact(): string
    {
        return join(", ", $this->getContacts());
    }

    public function getParent(): mixed
    {
        return [
            "pere" => $this->getPere(),
            "mere" => $this->getMere(),
        ];
    }

    public function getContacte(): string
    {
        return $this->contacte ?? "Aucun contact";
    }

    public function getFullDatenaiss(): string
    {
        return ("Né" . ($this->isABoy() ? "" : "e")) . " le " . (new DateTime($this->datenaiss))->format("d M Y à ") . $this->lieunaiss;
    }

    public function getAge(): string
    {
        $now = new DateTime();
        $birthday = new DateTime($this->datenaiss);
        return (strval($now->format("Y") - $birthday->format("Y"))) . " ans";
    }

    public function getFullName(): string
    {
        return ($this->isABoy() ? "Mr " : "Mme ") . $this->prenom . " " . $this->nom;
    }

    public function AU_id(): int | null
    {
        $inscription = $this->getInscription();
        return $inscription->AU_id;
    }

    public function NIV_id(): int | null
    {
        $inscription = $this->getInscription();
        return $inscription->NIV_id;
    }

    public function getAvatar(): string
    {
        $file = EtudiantModel::photosDirectory() . $this->photo;
        if ($this->photo != null && file_exists($file)) {
        } else {
            $file = $this->defaultAvatar();
        }
        $file = "/" . $file;
        return $file;
    }

    public function defaultAvatar(): string
    {
        return EtudiantModel::photosDirectory() . ($this->isABoy() ? "boys.png" : "girls.png");
    }

    public function getNie(): string | null
    {
        return $this->nie;
    }

    public function isABoy(): bool
    {
        return $this->sexe == 1;
    }

    public function getDescription()
    {
        $sexe = ($this->sexe) ? 'H' : 'F';
        return $this->nie . '(' . $sexe . ') - ' . $this->prenom . ' ' . $this->nom;
    }

    public static function getNewNie($str): string
    {
        $db = Database::getConnection();
        $sql = "select nie from etudiant where nie like '" . $str . "%' order by nie desc limit 1;";
        $stmt = $db->query($sql);
        $res = $stmt->fetch();
        if ($res) {
            $s = substr($res['nie'], -4);
            $s = intval($s) + 1;
            return sprintf('%04d', $s);
        } else return '0001';
    }

    public function generateNewNie($str, $AU_id = null): string
    {
        $AU_id ??= $this->AU_id();
        if ($AU_id) {
            $au = AuModel::find($AU_id);
            $year = preg_split("/[-]/", $au->nom_au)[0];
        } else {
            $year = $this->getDateRec()->format("Y");
        }
        return $this->nie = $str . "" . $year . EtudiantModel::getNewNie($str);
    }

    public function getDateRec(): DateTime
    {
        return new DateTime($this->dateRec);
    }

    public static function setABD($nie)
    {
        $db = Database::getConnection();
        $sql = "update etudiant set abandon=1 where nie=?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$nie]);
    }

    public static function deleteInscr($num_matr, $nie)
    {
        $db = Database::getConnection();
        $sql = "SELECT count(*) FROM inscription WHERE etudiant_nie=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$nie]);
        $nb = $stmt->fetchColumn();
        $sql = "SELECT count(*) FROM presence WHERE inscr_num_matr=? and etudiant_nie=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$num_matr, $nie]);
        if ($stmt->fetchColumn() > 0) {
            return false;
        }
        try {
            $sql = "DELETE FROM absence WHERE insc_num_matr=:nm;
            DELETE FROM retard WHERE insc_num_matr=:nm;
            DELETE FROM moyenne WHERE insc_num_matr=:nm;
            DELETE FROM moyenneue WHERE insc_num_matr=:nm;
            DELETE FROM note WHERE insc_num_matr=:nm;
            DELETE FROM fs WHERE inscr_num_matr=:nm;
            DELETE FROM inscription WHERE num_matr=:nm;
            ";
            if ($nb == 1) {
                $sql .= "DELETE FROM etudiant WHERE nie=:nie;";
                $stmt = $db->prepare($sql);
                $stmt->bindParam('nm', $num_matr);
                $stmt->bindParam('nie', $nie);
                return $stmt->execute();
            } else {
                $stmt = $db->prepare($sql);
                $stmt->bindParam('nm', $num_matr);
                return $stmt->execute();
            }
        } catch (\PDOException $ex) {
            return false;
        }
    }


    public function isValid(): bool
    {
        $result = true;
        $etudiant = EtudiantModel::isExist($this->nie, $this->nom, $this->prenom, $this->datenaiss);

        if ($etudiant) {
            $result = false;
            $this->errors = [
                "messages" => ["danger" => "Cet étudiant(e) est déjà inscrit(e)"],
            ];
        }

        if (!$this->REC_id || !$this->NAT_id || !$this->AB_id || !$this->SB_id || !$this->MB_id || !$this->nom || !$this->prenom || !$this->datenaiss || !$this->lieunaiss || !$this->contacte || !$this->nom_p || !$this->prenom_p || !$this->contacte_p || !$this->nom_m || !$this->prenom_m || !$this->contacte_m) {
            $result = false;
            $this->invalidAttributes = [];
            $this->errors = [
                "messages" => ["danger" => "Veuillez remplir les champs obligatoires"],
            ];
        }

        /**
         * Don't check this because there may be REC_other
         */
        // if (!$this->REC_id) {
        //     $this->invalidAttributes["REC_id"] = "required";
        // }

        /**
         * Don't check this because there may be NAT_other
         */
        // if (!$this->NAT_id) {
        //     $this->invalidAttributes["NAT_id"] = "required";
        // }

        if (!$this->AB_id) {
            $this->invalidAttributes["AB_id"] = "required";
        }

        /**
         * Don't check this because there may be SB_other
         */
        // if (!$this->SB_id) {
        //     $this->invalidAttributes["SB_id"] = "required";
        // }

        if (!$this->MB_id) {
            $this->invalidAttributes["MB_id"] = "required";
        }

        if (!$this->nom) {
            $this->invalidAttributes["nom"] = "required";
        }

        if (!$this->prenom) {
            $this->invalidAttributes["prenom"] = "required";
        }

        if (!$this->datenaiss) {
            $this->invalidAttributes["datenaiss"] = "required";
        }

        if (!$this->lieunaiss) {
            $this->invalidAttributes["lieunaiss"] = "required";
        }

        if (!$this->contacte) {
            $this->invalidAttributes["contacte"] = "required";
        }

        if (!$this->nom_p) {
            $this->invalidAttributes["nom_p"] = "required";
        }

        if (!$this->prenom_p) {
            $this->invalidAttributes["prenom_p"] = "required";
        }

        if (!$this->contacte_p) {
            $this->invalidAttributes["contacte_p"] = "required";
        }

        if (!$this->nom_m) {
            $this->invalidAttributes["nom_m"] = "required";
        }

        if (!$this->prenom_m) {
            $this->invalidAttributes["prenom_m"] = "required";
        }

        if (!$this->contacte_m) {
            $this->invalidAttributes["contacte_m"] = "required";
        }

        return $result;
    }

    public static function isExist($nie, $nom, $prenom, $datenaiss)
    {
        $db = Database::getConnection();
        $sql = "select nie,nom,prenom,datenaiss from etudiant where nie=? or (nom=? and prenom=? and datenaiss=?);";
        $stmt = $db->prepare($sql);
        $stmt->execute([$nie, $nom, $prenom, $datenaiss]);
        return $stmt->fetch();
    }

    public static function getNum_matr($nie, $nom, $prenom, $datenaiss, $au_id, $niv_id, $gp_id)
    {
        $db = Database::getConnection();
        $sql = "select i.num_matr from inscription i 
        inner join etudiant e on i.etudiant_nie=e.nie 
        where (e.nie=? or (e.nom=? and e.prenom=? and e.datenaiss=?)) and i.au_id=? and i.niv_id=? and i.gp_id=?;";
        $stmt = $db->prepare($sql);
        $stmt->execute([$nie, $nom, $prenom, $datenaiss, intval($au_id), intval($niv_id), intval($gp_id)]);
        return $stmt->fetch();
    }

    public static function getLsByNivGP($au, $niv, $gp, $is_abd)
    {
        $abd = ($is_abd === 'false') ? 0 : 1;
        $db = Database::getConnection();
        $sql = "SELECT i.num_matr,e.nie,e.photo,e.nom,e.prenom,e.sexe,IF(e.sexe=1,'boys','girls') as color,e.fb,e.email,
        YEAR(CURDATE())-YEAR(e.datenaiss) as age,DATE_FORMAT(i.dateInscr,'%d.%m.%Y') as dateInscr,DATE_FORMAT(e.dateRec,'%d.%m.%Y') as dateRec,
        (select r.poste_rec from recruteur r where r.idREC=e.REC_id) as posteRec, n.nom_niv, g.nom_gp 
        from inscription i
        inner join etudiant e on i.etudiant_nie=e.nie
        inner join niv n on i.NIV_id=n.idNIV 
        inner join gp g on i.GP_id=g.idGP 
        where i.AU_id= ? and i.NIV_id=? and i.GP_id=? and i.abandon=? order by e.nie asc";
        $stmt = $db->prepare($sql);
        $stmt->execute([intval($au), intval($niv), intval($gp), $abd]);
        return $stmt->fetchAll();
    }

    public static function getLsCmps($au, $niv, $gp)
    {
        $db = Database::getConnection();
        $sql = "SELECT i.num_matr,i.pwd,e.nie,e.nom,e.prenom,e.sexe 
        from inscription i
        inner join etudiant e on i.etudiant_nie=e.nie
        where i.AU_id= ? and i.NIV_id=? and i.GP_id=? and i.abandon=0 order by e.nom,e.prenom asc";
        $stmt = $db->prepare($sql);
        $stmt->execute([intval($au), intval($niv), intval($gp)]);
        return $stmt->fetchAll();
    }

    public static function uptcmp()
    {
        $db = Database::getConnection();
        try {
            Utils::PEqual('pwd', 'cpwd');
            $sql = "UPDATE inscription SET pwd=? WHERE num_matr=? AND ETUDIANT_nie=?;";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_POST['pwd'], $_POST['nm'], $_POST['ne']]);
            echo json_encode(['color' => 'success', 'message' => 'Mise à jour OK!']);
        } catch (\PDOException $ex) {
            echo json_encode(['color' => 'danger', 'message' => 'Erreur: ' . $ex->getMessage()]);
        }
    }

    public static function gererateCmps()
    {
        $db = Database::getConnection();
        try {
            $sql = "UPDATE inscription SET pwd=? WHERE num_matr=? AND ETUDIANT_nie=?;";
            $stmt = $db->prepare($sql);
            foreach ($_POST['list'] as $item) {
                $pwd = Utils::str_random(6);
                $stmt->execute([$pwd, $item['nm'], $item['ne']]);
            }
            $au = intval($_POST['au']);
            $niv = intval($_POST['niv']);
            $gp = intval($_POST['gp']);
            $res = self::getLsCmps($au, $niv, $gp);
            echo json_encode($res);
        } catch (\PDOException $ex) {
            echo json_encode(['color' => 'danger', 'message' => 'Erreur: ' . $ex->getMessage()]);
        }
    }


    public static function getLsEByNivGP($au, $niv, $gp)
    {
        $db = Database::getConnection();
        $sql = "select i.num_matr,e.nie,e.photo,e.nom,e.prenom,IF(e.sexe=1,'M','F') as sexe 
        from inscription i 
        inner join etudiant e on i.etudiant_nie=e.nie 
        where i.AU_id= ? and i.NIV_id=? and i.GP_id=? and i.abandon=0 order by e.nom,e.prenom asc";
        $stmt = $db->prepare($sql);
        $stmt->execute([intval($au), intval($niv), intval($gp)]);
        return $stmt->fetchAll();
    }

    public static function getLsBySearch($au, $value, $is_abd, $by)
    {
        $abd = ($is_abd === 'false') ? 0 : 1;
        $db = Database::getConnection();
        $adv = ($_SESSION['type'] == 'devmaster') ? ' || e.adresse like :adresse || YEAR(e.datenaiss) like :adn ' : '';
        $cond = '';
        switch ($by) {
            case 'e':
                $cond = 'e.nie like :nie || e.nom like :nom || e.prenom like :prenom';
                break;
            case 'p':
                $cond = 'e.nom_p like :nom_p || e.prenom_p like :prenom_p';
                break;
            case 'm':
                $cond = 'e.nom_m like :nom_m || e.prenom_m like :prenom_m';
                break;
            case 't':
                $cond = 'e.nom_t like :nom_t || e.prenom_t like :prenom_t';
                break;

            default:
                $cond = 'e.nie like :nie || e.nom like :nom || e.prenom like :prenom';
                break;
        }
        $sql = "select i.num_matr,e.nie,e.photo,e.nom,e.prenom,e.sexe,IF(e.sexe=1,'boys','girls') as color,e.fb,e.email,
        YEAR(CURDATE())-YEAR(e.datenaiss) as age,DATE_FORMAT(i.dateInscr,'%d.%m.%Y') as dateInscr,DATE_FORMAT(e.dateRec,'%d.%m.%Y') as dateRec,
        (select r.poste_rec from recruteur r where r.idREC=e.REC_id) as posteRec, n.nom_niv, g.nom_gp 
        from inscription i
        inner join etudiant e on i.etudiant_nie=e.nie
        inner join niv n on i.NIV_id=n.idNIV 
        inner join gp g on i.GP_id=g.idGP 
        where i.AU_id= :au and i.abandon=:abd and (" . $cond . $adv . ") 
        order by e.nie asc";
        $au = intval($au);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':au', $au);
        $stmt->bindParam(':abd', $abd);
        $txt = '%' . $value . '%';
        switch ($by) {
            case 'e':
                $stmt->bindParam(':nie', $txt);
                $stmt->bindParam(':nom', $txt);
                $stmt->bindParam(':prenom', $txt);
                break;
            case 'p':
                $stmt->bindParam(':nom_p', $txt);
                $stmt->bindParam(':prenom_p', $txt);
                break;
            case 'm':
                $stmt->bindParam(':nom_m', $txt);
                $stmt->bindParam(':prenom_m', $txt);
                break;
            case 't':
                $stmt->bindParam(':nom_t', $txt);
                $stmt->bindParam(':prenom_t', $txt);
                break;

            default:
                $stmt->bindParam(':nie', $txt);
                $stmt->bindParam(':nom', $txt);
                $stmt->bindParam(':prenom', $txt);
                break;
        }

        if ($_SESSION['type'] == 'devmaster') {
            $stmt->bindParam(':adresse', $txt);
            $stmt->bindParam(':adn', $txt);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public static function exportBy($txt, $au, $niv, $gp, $is_abd = 'false')
    {
        header('Content-Type: text/csv;');
        header("Content-Disposition: attachement; filename=$txt.csv;");
        $ls_filter = [
            'dn' => 'datenaiss', 'ln' => 'lieunaiss', 'ce' => 'contact', 'cp' => 'contact_p',
            'npp' => 'pere', 'npm' => 'mere', 'npt' => 'tuteur'
        ];
        $lsTitle = [
            'dn' => 'Date de naissance', 'ln' => 'Lieu de naissance',
            'ce' => 'Contacts étudiants', 'cp' => 'Contacts parents',
            'npp' => 'PÈRE', 'npm' => 'MÈRE', 'npt' => 'TUTEUR'
        ];
        $cp = ($_SESSION['type'] == 'devmaster') ? 'CONCAT(e.contacte_p,"|",e.contacte_m,"|",e.contacte_t)' : 'CONCAT(e.contacte_p,",",e.contacte_m)';
        $abd = ($is_abd === 'false') ? 0 : 1;

        $lsSql = [
            'dn' => "DATE_FORMAT(e.datenaiss,'%d/%m/%Y') as datenaiss",
            'ln' => 'e.lieunaiss',
            'ce' => 'e.contacte as contact',
            'cp' => $cp . ' as contact_p',
            'npp' => 'CONCAT(e.nom_p," ",e.prenom_p) as pere',
            'npm' => 'CONCAT(e.nom_m," ",e.prenom_m) as mere',
            'npt' => 'CONCAT(e.nom_t," ",e.prenom_t) as tuteur'
        ];
        $s = '';
        $stitle = '';
        $ls_alias = [];
        if (isset($_POST['fm'])) {
            $filter = $_POST['fm'];
            foreach ($filter as $value) {
                $ls_alias[] = $ls_filter[$value];
                $s .= ',' . $lsSql[$value];
                $stitle .= ';' . $lsTitle[$value];
            }
        }
        $db = Database::getConnection();
        $sql = "SELECT e.nie,e.nom,e.prenom,IF(e.sexe=1,'H','F') AS sexe" . $s .
            " FROM inscription i 
        INNER JOIN etudiant e on i.etudiant_nie=e.nie 
        WHERE i.AU_id= ? AND i.NIV_id=? AND i.GP_id=? AND i.abandon=? ORDER BY e.nom,e.prenom ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute([intval($au), intval($niv), intval($gp), $abd]);
        $res = $stmt->fetchAll();
        echo utf8_decode('NIE;Nom;Prenoms;Sexe' . $stitle);
        foreach ($res as $item) {
            $s = '';
            foreach ($ls_alias as $value) {
                $s .= ';' . $item[$value];
            }
            echo "\n" . $item['nie'] . ';' . utf8_decode($item['nom']) . ';' . utf8_decode($item['prenom']) . ';' . $item['sexe'] . utf8_decode($s);
        }
    }

    public static function exportAll($txt, $au, $niv = -1, $is_abd = 'false')
    {
        header('Content-Type: text/csv;');
        header("Content-Disposition: attachement; filename=$txt.csv;");
        $ls_filter = [
            'em' => 'email', 'dn' => 'datenaiss', 'ln' => 'lieunaiss', 'ce' => 'contact', 'cp' => 'contact_p',
            'npp' => 'pere', 'npm' => 'mere', 'npt' => 'tuteur'
        ];
        $lsTitle = [
            'em' => 'Email',
            'dn' => 'Date de naissance', 'ln' => 'Lieu de naissance',
            'ce' => 'Contacts étudiants', 'cp' => 'Contacts parents',
            'npp' => 'PÈRE', 'npm' => 'MÈRE', 'npt' => 'TUTEUR'
        ];
        $cp = ($_SESSION['type'] == 'devmaster') ? 'CONCAT(e.contacte_p,"|",e.contacte_m,"|",e.contacte_t)' : 'CONCAT(e.contacte_p,",",e.contacte_m)';
        $abd = ($is_abd === 'false') ? 0 : 1;

        $lsSql = [
            'em' => 'e.email',
            'dn' => "DATE_FORMAT(e.datenaiss,'%d/%m/%Y') as datenaiss",
            'ln' => 'e.lieunaiss',
            'ce' => 'e.contacte as contact',
            'cp' => $cp . ' as contact_p',
            'npp' => 'CONCAT(e.nom_p," ",e.prenom_p) as pere',
            'npm' => 'CONCAT(e.nom_m," ",e.prenom_m) as mere',
            'npt' => 'CONCAT(e.nom_t," ",e.prenom_t) as tuteur'
        ];
        $s = '';
        $stitle = '';
        $ls_alias = [];
        if (isset($_POST['fm'])) {
            $filter = $_POST['fm'];
            foreach ($filter as $value) {
                $ls_alias[] = $ls_filter[$value];
                $s .= ',' . $lsSql[$value];
                $stitle .= ';' . $lsTitle[$value];
            }
        }
        $db = Database::getConnection();
        $niv = intval($niv);
        $cniv = ($niv != -1) ? ' AND i.NIV_id=?' : '';
        $sql = "SELECT n.nom_niv,p.nom_gp,e.nie,e.nom,e.prenom,IF(e.sexe=1,'H','F') AS sexe" . $s .
            " FROM inscription i 
        INNER JOIN etudiant e on i.etudiant_nie=e.nie 
        INNER JOIN niv n on i.niv_id=n.idniv 
        INNER JOIN gp p on i.gp_id=p.idgp 
        WHERE i.AU_id= ?" . $cniv . " AND i.abandon=? ORDER BY n.nom_niv,p.nom_gp,e.nom,e.prenom ASC";
        $stmt = $db->prepare($sql);
        $params = ($niv != -1) ? [intval($au), intval($niv), $abd] : [intval($au), $abd];
        $stmt->execute($params);
        $res = $stmt->fetchAll();
        echo utf8_decode('Niveau;Groupes|Parcours;NIE;Nom;Prenoms;Sexe' . $stitle);
        foreach ($res as $item) {
            $s = '';
            foreach ($ls_alias as $value) {
                $s .= ';' . $item[$value];
            }
            echo "\n" . $item['nom_niv'] . ';' . $item['nom_gp'] . ';' . $item['nie'] . ';' . utf8_decode($item['nom']) . ';' . utf8_decode($item['prenom']) . ';' . $item['sexe'] . utf8_decode($s);
        }
    }

    public static function find($nie): EtudiantModel
    {
        $result = new EtudiantModel();
        $db = Database::getConnection();
        $sql = "SELECT * FROM etudiant WHERE nie like '$nie' LIMIT 1;";
        $dbPreparation = $db->prepare($sql);
        $dbPreparation->execute();
        $e = $dbPreparation->fetch();
        if ($e) {
            $result->parse($e);
        } else {
            $result->notFound = true;
        }
        return $result;
    }

    public function getDateEntretien(): DateTime
    {
        $date_entretien = new DateTime($this->dateRec);
        return $date_entretien;
    }

    public function getInscription(): InscriptionModel
    {
        $result = new InscriptionModel();
        $sql = "SELECT i.* from etudiant INNER JOIN inscription i ON i.ETUDIANT_nie = nie WHERE ETUDIANT_nie = '{$this->nie}' ORDER BY i.dateInscr DESC LIMIT 1;";
        $db = Database::getConnection();
        $statement = $db->prepare($sql);
        $status = $statement->execute();
        $inscription = $status ? $statement->fetch() : null;
        $inscription ? $result->parse($inscription) : null;
        return $result;
    }

    public function unsaved(): bool
    {
        return $this->nie == null;
    }
}
