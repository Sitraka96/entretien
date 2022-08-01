<?php

use App\Core\Controller;
use App\Core\Database;
use App\Core\Alert;
use App\Core\Utils;
use App\Models\DataModel;
use App\Models\AuModel;
use App\Models\NivModel;
use App\Models\GpModel;
use App\Models\NatModel;
use App\Models\RecruteurModel;
use App\Models\AbModel;
use App\Models\SbModel;
use App\Models\MbModel;
use App\Models\DoModel;
use App\Models\DossierModel;
use App\Models\EtudiantModel;
use App\Models\TrancheFsModel;
use App\Models\InscriptionModel;
use App\Models\FsModel;
use App\Models\HistoryModel;
use App\Models\OptModel;

class EtudiantController extends Controller
{
    const PHOTO_DIR = 'assets/images/students/',
        EXTS = ['jpg', 'jpeg', 'png'];

    public function __construct()
    {
        parent::__construct();
    }


    private function getRIData()
    {
        $data['au'] = AuModel::getList('nom_au', 'DESC');
        $data['niv'] = NivModel::getList('nom_niv', 'ASC');
        $data['tranchefs'] = TrancheFsModel::getList('nbT', 'ASC');
        return $data;
    }


    //post get gp
    public function check_niv()
    {
        // Utils::HeaderJS();
        // $res=GpModel::getAllNivGP($_POST['id']);
        // echo json_encode($res);
        GpModel::get4AU($_POST['id']);
    }

    //post
    public function getfs()
    {
        Utils::HeaderJS();
        $id = intval($_POST['id']);
        echo json_encode(FsModel::getListBy($id));
    }

    public function newNie(): void
    {
        $req = $_SERVER["REQUEST_URI"];
        $req = preg_split("/[?=&]/", $_SERVER["REQUEST_URI"]);
        $parsedReq = array();
        foreach ($req as $key => $value) {
            if ($key % 2 && $key < sizeof($req) - 1) {
                $parsedReq[$value] = $req[$key + 1];
            }
        }

        $session = $parsedReq['session'];
        $AU_id = $parsedReq['AU_id'];

        $etudiant = new EtudiantModel();
        $etudiant->generateNewNie($session, $AU_id);
        $result = [
            "nie" => $etudiant->nie,
            "success" => true
        ];

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function Created($nie): void
    {
        $etudiant = EtudiantModel::find($nie);
        $header['title'] = 'Inscription réussie #' . $etudiant->nie;
        $header['current_menu'] = 'Fiche étudiant';
        $header['css'] = ['jquery-datetime', 'toggle-btn', '/src/form', '/src/etudiant/created'];
        $header['js'] = ['jquery-datetime', 'toggle-btn', 'moment-with-locales', '/src/cplugs', '/src/inscr_form'];
        $data = array();

        if (property_exists($etudiant, "notFound") && $etudiant->notFound) {
            $view = "Errors.404";
        } else {
            $inscription = $etudiant->getInscription();
            $data['etudiant'] = $etudiant->json();
            $data['inscription'] = $inscription->json();
            $data['dossiers'] = DossierModel::getListBy($inscription->NIV_id);
            $view = "Etudiant.created";
        }

        $this->_renderH($header);
        $this->render($view, $data);
        $this->renderF();
    }

    private function find($nie): EtudiantModel | null
    {
        $etudiant = EtudiantModel::find($nie);

        if (property_exists($etudiant, "notFound") && $etudiant->notFound) {
            $header['title'] = 'Page not found';
            $header['current_menu'] = 'PAGE_NOT_FOUND';
            $header['css'] = ['jquery-datetime', 'toggle-btn'];
            $header['js'] = ['jquery-datetime', 'toggle-btn'];
            $data = array();
            $this->_renderH($header);
            $this->render("Errors.404", $data);
            $this->renderF();
            die("");
            return null;
        } else {
            return $etudiant;
        }
    }

    public function Show($nie): void
    {
        $etudiant = $this->find($nie);

        $header['title'] = 'Résumé #' . $etudiant->nie;
        $header['current_menu'] = 'Fiche étudiant';
        $header['css'] = ['jquery-datetime', 'toggle-btn', '/src/form', '/src/form-ui', '/src/etudiant/show'];
        $header['js'] = ['jquery-datetime', 'toggle-btn', 'moment-with-locales', '/src/cplugs', '/src/inscr_form', '/src/form'];
        $data = array();

        $inscription = $etudiant->getInscription();
        $data['etudiant'] = $etudiant->json();
        $data['inscription'] = $inscription->json();
        $entretien = $inscription->getEntretien();
        $data['entretien'] = $entretien;
        $data['dossiers'] = DossierModel::getListBy($inscription->NIV_id);

        $this->_renderH($header);
        $this->render("Etudiant.show", $data);
        $this->renderF();
    }

    private function _renderForm($data): void
    {
        $etudiant = $this->find($data["nie"]);
        $etudiant->invalidAttributes ??= [];

        $header['title'] = 'Edition #' . $etudiant->nie;
        $header['current_menu'] = 'Edition fiche étudiant';
        $header['css'] = ['jquery-datetime', 'toggle-btn', '/src/form', '/src/form-ui', '/src/etudiant/edit', "/alert"];
        $header['js'] = ['jquery-datetime', 'toggle-btn', 'moment-with-locales', '/src/cplugs', '/src/form', '/src/field-formatter', '/src/etudiant/edit', '/src/etudiant/photo', '/src/inscription/new', '/alert'];

        $data ??= array();

        $inscription = $etudiant->getInscription();
        $entretien = $inscription->getEntretien();

        $data['etudiant'] = $etudiant;
        $data['inscription'] = $inscription->json();
        $data['entretien'] = $entretien;
        $data['dossiers'] = DossierModel::toModel(DossierModel::getListBy($inscription->NIV_id));

        $data['photo'] = $etudiant->getAvatar();
        $data['nom'] = $etudiant->nom;
        $data['prenom'] = $etudiant->prenom;
        $data['sexe'] = $etudiant->sexe;
        $data['datenaiss'] = $etudiant->datenaiss;
        $data['lieunaiss'] = $etudiant->lieunaiss;
        $data['contacte0'] = $etudiant->getContacts(0);
        $data['contacte1'] = $etudiant->getContacts(1);
        $data['contacte2'] = $etudiant->getContacts(2);
        $data['adresse'] = $etudiant->adresse;
        $data['email'] = $etudiant->email;
        $data['fb'] = $etudiant->fb;

        $data["NAT_id"] ??= $etudiant->NAT_id;
        $data["NAT_other"] ??= "";
        $data["AB_id"] ??= $etudiant->AB_id ?? "";
        $data["SB_id"] ??= $etudiant->SB_id ?? "";
        $data["SB_other"] ??= "";

        $data["MB_id"] ??= $inscription->getModel("Mb")->idMB ?? "";
        $data["AU_id"] ??= $inscription->getModel("Au")->idAU ?? "";
        $data["NIV_id"] ??= $inscription->getNiv()->idNIV ?? "";
        $data["GP_id"] ??= $inscription->getGp("idGP")->idGP;
        $data["REC_id"] ??= $etudiant->getRecruteur()->idREC ?? "";
        $data["sexe_rec"] ??= "";
        $data["nom_rec"] ??= "";
        $data["prenom_rec"] ??= "";

        $parents = $etudiant->getParent();

        $data["nom_p"] ??= $parents['pere']['nom'];
        $data["prenom_p"] ??= $parents['pere']['prenom'];
        $data["contacte_p"] ??= $parents['pere']['contacte'];
        $data["email_p"] ??= $parents['pere']['email'];
        $data["adresse_p"] ??= $parents['pere']['adresse'];
        $data["profession_p"] ??= $parents['pere']['profession'];

        $data["nom_m"] ??= $parents['mere']['nom'];
        $data["prenom_m"] ??= $parents['mere']['prenom'];
        $data["contacte_m"] ??= $parents['mere']['contacte'];
        $data["email_m"] ??= $parents['mere']['email'];
        $data["adresse_m"] ??= $parents['mere']['adresse'];
        $data["profession_m"] ??= $parents['mere']['profession'];

        $data["nom_t"] ??= "";
        $data["prenom_t"] ??= "";
        $data["contacte_t"] ??= "";
        $data["email_t"] ??= "";
        $data["adresse_t"] ??= "";
        $data["profession_t"] ??= "";

        $data["list_dossiers"] = $data["inscription"]["ListDossier"];

        $data["session"] ??= "";
        $data["nie"] ??= $etudiant->nie;

        $data["dateRec"] ??= $etudiant->getDateEntretien()->format("Y-m-d");
        $data["dateInscr"] ??= (new DateTime())->format("Y-m-d");

        $data['au'] = AuModel::getList('nom_au', 'DESC');
        $data['niv'] = NivModel::getList('nom_niv', 'ASC');
        $data['gps'] = GpModel::toModel((GpModel::getListBy([
            "AU_id" => $inscription->AU_id,
            "NIV_id" => $inscription->NIV_id,
        ])));

        $data['nats'] = NatModel::toModel((NatModel::getList()));
        $data['abs'] = AbModel::toModel((AbModel::getList()));
        $data['sbs'] = SbModel::toModel((SbModel::getList()));
        $data['mbs'] = MbModel::toModel((MbModel::getList()));
        $data['recs'] = RecruteurModel::toModel((RecruteurModel::getList()));
        $data['sessions'] = [
            "SE", "SI"
        ];

        $this->_renderH($header);
        $this->render("Etudiant.form", $data);
        $this->renderF();
    }

    public function Edit($nie): void
    {
        $data["nie"] = $nie;
        $this->_renderForm($data);
    }

    public function Update($nie): void
    {
        $header['title'] = 'Mise à jour en cours';
        $header['current_menu'] = 'UPDATE_STUDENT';

        $etudiant = $this->find($nie);

        $data = $_POST;

        $studentHistory  = HistoryModel::put([
            "subject_type" => "Etudiant",
            "subject_id" => $etudiant->nie,
            "oldValues" => $etudiant,
        ]);

        $db = Database::getConnection();
        $db->beginTransaction();

        if ($etudiant->init($data)) {
            if (property_exists($etudiant, "errors")) {
                // $errors = $etudiant->errors;
                unset($etudiant->errors);
            }
            $status = $etudiant->update();
            if ($status == "ok") {
                $inscription = $etudiant->getInscription();

                $registrationHistory  = HistoryModel::put([
                    "subject_type" => "Inscription",
                    "subject_id" => $inscription->num_matr,
                    "oldValues" => $inscription,
                ]);

                $inscription->init($data);
                $status = $inscription->update();
                if ($status == "ok") {
                    $registrationHistory->setNewValues($inscription);
                    $registrationHistory->save();
                    $studentHistory->setNewValues($etudiant);
                    $studentHistory->save();
                } else {
                    $errors = [
                        "messages" => [
                            "danger" => "Impossible de mettre à jour la fiche d'inscription"
                        ]
                    ];
                }
            } else {
                $errors = [
                    "messages" => [
                        "danger" => "Impossible de mettre à jour la fiche étudiante"
                    ]
                ];
            }
        } else {
            $errors = $etudiant->errors;
        }

        $data["alert"] = $errors ?? [
            "messages" => [
                "success" => "Mise à jour effectuée",
            ]
        ];

        $data["nie"] = $nie;

        if ($status == "ok") {
            $db->commit();
            header("location:/Etudiant/Show/" . $nie);
        } else {
            $db->rollBack();
            $this->_renderForm($data);
        }
    }

    //get
    public function view($num_matr)
    {
        $db = Database::getConnection();
        $sql = "select i.*,e.*,
        DATE_FORMAT(i.dateInscr,'%d/%m/%Y') as dateInscr,DATE_FORMAT(e.dateRec,'%d/%m/%Y') as dateRec,
        DATE_FORMAT(e.datenaiss,'%d/%m/%Y') as datenaiss 
        from inscription i
        inner join etudiant e on i.etudiant_nie=e.nie
        where i.num_matr=?;";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $num_matr);
        $stmt->execute();
        $data = DataModel::getData();
        $fetchedEtudiant = $stmt->fetch();
        $etudiant = new EtudiantModel();
        if ($fetchedEtudiant) {
            $etudiant->parse($fetchedEtudiant);
        } else {
            # code...
        }
        $data['etudiant'] = $etudiant;
        $fk_niv = intval($data['etudiant']->getModel("Niv")->idNIV);
        $fk_au = intval($data['etudiant']->getModel("Au")->idAU);
        $nstmt = $db->prepare('select nom_niv from niv where idNIV=?;');
        $nstmt->execute([$fk_niv]);
        $response = $nstmt->fetch();
        $data['dossier'] = InscriptionModel::getDossier($fk_niv);
        $data['gp'] = GpModel::getListBy($fk_au, $fk_niv);
        $data['fs'] = FsModel::getListBy($num_matr);
        $header['title'] = 'Détail ' . $data['etudiant']->nie;
        $header['current_menu'] = 'LISTE DES ÉTUDIANTS';
        $header['css'] = ['jquery-datetime', 'toggle-btn', '/src/form'];
        $header['js'] = ['jquery-datetime', 'toggle-btn', 'moment-with-locales', '/src/cplugs', '/src/inscr_form'];
        $this->renderH($header);
        $this->render('Etudiant.view', $data);
        $this->renderF();
    }


    //post:: get list student by au,niv,gp,abd
    public function getLsE()
    {
        header('content-type:text/javascript');
        $data['list'] = EtudiantModel::getLsByNivGP($_POST['au'], $_POST['niv'], $_POST['gp'], $_POST['abd']);
        // $edit = ($_SESSION['type']=='job_etudiant' || $_SESSION['type']=='guest') ? 'false' : 'true' ;
        $edit = ($_SESSION['type'] == 'guest') ? 'false' : 'true';
        $data['edit'] = $edit;
        $data['type'] = $_SESSION['type'];
        echo json_encode($data);
    }


    //post:: get list student by search
    public function getLs4E()
    {
        header('content-type:text/javascript');
        $data['list'] = EtudiantModel::getLsBySearch($_POST['au'], $_POST['txt'], $_POST['abd'], $_POST['by']);
        // $edit = ($_SESSION['type']=='job_etudiant' || $_SESSION['type']=='guest') ? 'false' : 'true' ;
        $edit = ($_SESSION['type'] == 'guest') ? 'false' : 'true';
        $data['edit'] = $edit;
        $data['type'] = $_SESSION['type'];
        echo json_encode($data);
    }


    //get:: listes etudiants
    public function listes()
    {
        $db = Database::getConnection();
        $data['au'] = AuModel::getList('nom_au', 'DESC');
        $header['title'] = 'Liste des étudiants';
        $header['current_menu'] = 'LISTE DES ÉTUDIANTS';
        $header['js'] = ['/src/cplugs', 'toggle-btn', '/context', '/src/sgetLs'];
        $header['css'] = ['toggle-btn', '/src/ei', '/context.standalone'];
        $this->renderH($header);
        $this->template('confirm_modal');
        $this->render('listes', $data);
        $this->renderF();
    }

    public function setABD()
    {
        Utils::HeaderJS();
        Utils::PAuth();
        Utils::Exist('ne');
        $res = EtudiantModel::setABD($_POST['ne']);
        if ($res) {
            Alert::get('success', 'Opération éfféctuée avec succès !');
        } else {
            Alert::get('danger', 'Erreur du réseau !');
        }
    }

    public function Delete()
    {
        Utils::HeaderJS();
        Utils::PAuth();
        Utils::Exist(['ni', 'ne']);
        $res = EtudiantModel::deleteInscr($_POST['ni'], $_POST['ne']);
        if ($res) {
            Alert::get('success', 'Opération éfféctuée avec succès !');
        } else {
            Alert::get('danger', 'Cet étudiant possède encore des présences !');
        }
    }

    public function migrate()
    {
        InscriptionModel::migrate($_POST['au'], $_POST['niv'], $_POST['gp'], $_POST['list']);
    }

    public function compte()
    {
        $header['title'] = "Compte des étudiants";
        $header['current_menu'] = 'AUTRES';
        $header['js'] = ['/src/cplugs', '/src/cmps'];
        $header['css'] = ['/src/cmps'];
        $data['au'] = AuModel::getList('nom_au', 'DESC');

        $this->renderH($header);
        $this->template('confirm_modal');
        $this->render('cmps', $data);
        $this->renderF();
    }

    public function getLsCmps()
    {
        header('content-type:text/javascript');
        $data = EtudiantModel::getLsCmps($_POST['au'], $_POST['niv'], $_POST['gp']);
        echo json_encode($data);
    }

    //update student pwd
    public function uptcmp()
    {
        header('content-type:text/javascript');
        EtudiantModel::uptcmp();
    }
    public function gererateCmps()
    {
        header('content-type:text/javascript');
        EtudiantModel::gererateCmps();
    }

    public function printCmps()
    {
        $filename = $_POST['nom_au'] . '_' . $_POST['nom_niv'];
        header('content-type:text/csv');
        header('Content-Disposition: attachement; filename="' . $filename . '.csv"');
        $data = EtudiantModel::getLsCmps($_POST['au'], $_POST['niv'], $_POST['gp']);
        echo utf8_decode('Num;NIE;Nom;prénom(s);sexe;Mot de passe');
        foreach ($data as $key => $item) {
            $sexe = ($item['sexe']) ? 'M' : 'F';
            echo "\n" . ($key + 1) . ';' . $item['nie'] . ';' . utf8_decode($item['nom']) . ';' . utf8_decode($item['prenom']) . ';' . $sexe . ';' . $item['pwd'];
        }
    }
}
