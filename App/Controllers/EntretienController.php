<?php

use App\Core\Controller;
use App\Core\Database;
use App\Models\AbModel;
use App\Models\AuModel;
use App\Models\DoModel;
use App\Models\EntretienModel;
use App\Models\GpModel;
use App\Models\HistoryModel;
use App\Models\MbModel;
use App\Models\NivModel;
use App\Models\RecruteurModel;
use App\Models\SbModel;

class EntretienController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['au'] = AuModel::getList('nom_au', 'DESC');
        $data['niv'] = NivModel::getList('nom_niv', 'ASC');
        $data['recruteurs'] = RecruteurModel::getList('nom_rec', 'ASC');
        $data['orders'] = [
            "idENTR:ASC",
            "idENTR:DESC",
            "nom:ASC",
            "nom:DESC",
            "AU_id:ASC",
            "AU_id:DESC",
            "NIV_id:ASC",
            "NIV_id:DESC",
            "date_entretien:DESC",
            "date_entretien:DESC",
        ];

        $filterData = count($_POST) > 0 ? $_POST : $this->GET();

        $search = EntretienModel::where($filterData);

        $data['entretiens'] = $search['result'];
        $data['filterData'] = $search['filter'];

        $header['title'] = 'Liste de tous les RDV';
        $header['current_menu'] = 'RDV';
        $header['css'] = ['/src/entretien/list'];
        $header['js'] = ['/src/entretien/list'];

        $this->renderH($header);
        $this->render('list', $data);
        $this->renderF();
    }

    public function new()
    {
        $data['au'] = AuModel::getList('nom_au', 'DESC');

        $entretien = new EntretienModel();
        $entretien->invalidAttributes = [];
        $data['entretien'] = $entretien;

        $data['AU_id'] = array_filter($data['au'], function ($year) {
            // $year => ["idAU" => 1, "nom_au" => "2019-2020"];
            $startYear = preg_split("/[-]/", $year["nom_au"])[0]; // => "2019"
            $todaysYear = (new DateTime())->format("Y"); // => "2022"

            return $startYear == $todaysYear;
        })[3]['idAU']; // Why 3 ? I don't know O_o

        $this->_renderForm($data);
    }

    public function create()
    {
        /**
         * Afficher le form quand la requette est GET
         */
        if (count($_POST) > 0) {
        } else {
            return $this->_renderForm();
        }

        $db = Database::getConnection();
        $db->beginTransaction();

        $data = $_POST;

        $entretien = new EntretienModel($data);
        $response = $entretien->save();

        if ($response["success"]) {
            $data = array();
            $data["alert"] = [
                'messages' => [
                    "success" => "Rendez-vous enregistré"
                ],
                'success' => true,
            ];
            $entretienId = $response['idENTR'];
            HistoryModel::create([
                "subject_type" => "Entretien",
                "subject_id" => $entretien->idENTR,
                "newValues" => $entretien,
            ]);
            $db->commit();
            header("location:/Entretien/Print/{$entretienId}");
        } else {
            $data['entretien'] = $entretien;
            $data["alert"] = [
                'messages' => $response["messages"] ?? [
                    "danger" => "Une erreur s'est produite, veuillez réessayer"
                ],
            ];
            $data['invalidAttributes'] = $entretien->invalidAttributes ?? [];
            switch ($response['code']) {
                case "taken":
                    $data["dateIsNotFree"] =  true;
                    break;
                case "user_already_exists":
                    break;

                default:
                    break;
            }
            $db->rollback();
            $this->_renderForm($data);
        }
    }

    public function print($entretienId)
    {
        $entretien = EntretienModel::find($entretienId);

        $header['title'] = "Rendez-vous confirmé";
        $header['current_menu'] = 'Print';
        $header['css'] = ['/src/entretien/view'];
        $header['js'] = ['/src/entretien/print'];

        $data = [
            "entretienId" => $entretienId,
            "entretien" => $entretien
        ];

        $this->renderH($header);
        $this->render('view', $data);
        $this->renderF();
    }

    public function Show($entretienId)
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM entretien WHERE idENTR like '$entretienId' LIMIT 1;";
        $dbPreparation = $db->prepare($sql);
        $dbPreparation->execute();
        $e = $dbPreparation->fetch();
        if ($e) {
            $entretien = new EntretienModel();
            $entretien->parse($e);
        }

        $header['title'] = "Aperçu de l'entretien";
        $header['current_menu'] = 'Entretien';
        $header['css'] = ['/src/entretien/show'];
        $header['js'] = ['/src/entretien/show'];

        $data = [
            "entretienId" => $entretienId,
            "entretien" => $entretien
        ];

        $this->renderH($header);
        $this->render('show', $data);
        $this->renderF();
    }

    public function edit($entretienId)
    {
        $data['entretienId'] = $entretienId;
        $this->_renderEditForm($data);
    }

    public function update()
    {
        $entretienId = $_POST["entretienId"];
        $entretien = EntretienModel::find($entretienId);
        $data['entretienId'] = $entretienId;

        $history  = HistoryModel::put([
            "subject_type" => "Entretien",
            "subject_id" => $entretien->idENTR,
            "oldValues" => $entretien,
        ]);

        if (!$entretien) {
            $data["alert"] = [
                'message' => "Rendez-vous introuvable",
                'success' => false,
                'color' => 'danger',
            ];
        } else {
            $db = Database::getConnection();
            $db->beginTransaction();

            $reqData = $_POST;

            $entretien->parse($reqData);
            $entretien->contact = join(", ", $entretien->contact);
            if ($reqData["SB_id"] == "*" && $reqData["SB_other"]) {
                $entretien->SB_id = SbModel::findOrCreate($reqData["SB_other"])->idSB;
            }

            $response = $entretien->patch($reqData);

            if ($response["success"]) {
                $data["alert"] = [
                    'message' => "Mise à jour effectuée",
                    'success' => true,
                    'color' => 'success',
                ];
                $history->setNewValues($entretien);
                $history->save();
            } else {
                $data["alert"] = [
                    'message' => $response["message"] ?? "Une erreur s'est produite, veuillez réessayer",
                    'success' => false,
                    'color' => 'danger',
                ];
                switch ($response['code']) {
                    case "taken":
                        $data["dateIsNotFree"] =  true;
                        break;
                    case "user_already_exists":
                        break;

                    default:
                        break;
                }
                $db->rollBack();
            }
        }

        if ($data["alert"]["success"]) {
            $db->commit();
            header("location:/Entretien/View/{$entretienId}");
        } else {
            $this->_renderEditForm($data);
        }
    }

    public function delete($entretienId)
    {
        $entretienId = $_POST["entretienId"];
        $entretien = EntretienModel::find($entretienId);
        $data['entretienId'] = $entretienId;

        if (!$entretien) {
            $data["alert"] = [
                'message' => "Rendez-vous introuvable",
                'success' => false,
                'color' => 'danger',
            ];
        } else {
            $reqData = $_POST;

            $db = Database::getConnection();
            $db->beginTransaction();

            $history = HistoryModel::remove([
                "subject_type" => "Entretien",
                "subject_id" => $entretien->idENTR,
                "oldValues" => $entretien,
            ]);

            if ($entretien->delete()) {
                $db->commit();
                $history->save();
                header('location:/Entretien');
            } else {
                $db->rollBack();
            }
        }
    }

    /**
     * PROTECTED SECTION
     */

    private function _renderEditForm($data)
    {
        $header['title'] = "Edition d' un entretien";
        $header['current_menu'] = 'Entretien';
        $header['css'] = ['/alert', '/src/form-ui', '/src/entretien/edit'];
        $header['js'] = ['/alert', '/src/bs-stepper.min', '/src/form', '/src/entretien/edit', '/src/field-formatter'];
        $data += [
            'au' => AuModel::getList('nom_au', 'DESC'),
            'niv' => NivModel::getList('nom_niv', 'ASC'),
            'do' => DoModel::getList(),
            'abs' => AbModel::getList(),
            'mb' => MbModel::getList(),
            'series' => SbModel::getList(),
            'recruteurs' => RecruteurModel::toModel(RecruteurModel::getList('nom_rec', 'ASC')),
            'fields' => GpModel::getList(),
            'connaissances_esmia' => [
                "Pub TV",
                "FB",
                "B à O",
                "Smatch'In",
                "Autres",
            ]
        ];

        $entretienId = $data['entretienId'];

        $db = Database::getConnection();
        $sql = "SELECT * FROM entretien WHERE idENTR like '{$entretienId}' LIMIT 1;";
        $dbPreparation = $db->prepare($sql);
        $dbPreparation->execute();
        $e = $dbPreparation->fetch();
        if ($e) {
            $entretien = new EntretienModel();
            $entretien->parse($e);
            $data["entretien"] = $entretien;
            $data["contacts"] = $entretien->getContacts();

            $data['contact0'] ??= $data["contacts"][0] ?? "";
            $data['contact1'] ??= $data["contacts"][1] ?? "";
            $data['contact2'] ??= $data["contacts"][2] ?? "";

            $view = ('edit');
        } else {
            $view = ('404');
        }

        $data["nom"] ??= $entretien->getNom();
        $data["prenom"] ??= $entretien->getPrenom();
        $data["sexe"] ??= $entretien->getSexe();
        $data["contact"] ??= $entretien->getContact();
        $data["now"] ??= new DateTime();
        $data["todayDate"] ??= $data["now"]->format("Y-m-d\TH:i");
        $data["maxRDVDate"] ??= (new DateTime("now + 3weeks"))->format("Y-m-d\TH:i");
        $data["oldestDate"] ??= "1900-11-01";
        $data["date_entretien"] ??= ($entretien->getDateEntretien() ?? new DateTime(""))->format("Y-m-d\TH:i");
        $data["NIV_id"] ??= $entretien->getNiv()->idNIV;
        $data["AU_id"] ??= $entretien->getAu()->idAU;
        $data["REC_id"] ??= $entretien->getRecruteur()->idREC;
        $data["entretienId"] ??= $entretien->getId();

        $data["datenaiss"] ??= $entretien->getDatenaiss()->format("Y-m-d");
        $data["lieunaiss"] ??= $entretien->getLieunaiss();
        $data["adresse"] ??= $entretien->getAdresse();
        $data["religion"] ??= $entretien->getReligion();
        $data["etablissement"] ??= $entretien->getEtablissement();
        $data["DO_id"] ??= $entretien->getModel("Do")->idDO;
        $data["MB_id"] ??= $entretien->getModel("Mb")->idMB;
        $data["SB_id"] ??= $entretien->getModel("Sb")->idSB;
        $data["AB_id"] ??= $entretien->getModel("Ab")->idAB;
        $data["GP_id"] ??= $entretien->getModel("Gp")->idGP;
        $data["presentation_soi"] ??= $entretien->getPresentation();
        $data["comportement"] ??= $entretien->getComportement();

        $data["fume"] ??= $entretien->getFume();
        $data["boit"] ??= $entretien->getBoit();
        $data["autodidacte"] ??= $entretien->getAutodidacte();

        $data["ecole"] ??= $entretien->getEcole();
        $data["college"] ??= $entretien->getCollege();
        $data["lycee"] ??= $entretien->getLycee();

        $data["experience"] ??= $entretien->getExperience();
        $data["autre"] ??= $entretien->getAutre();

        $data["pere"] ??= $entretien->getPere();
        $data["mere"] ??= $entretien->getMere();
        $data["freres"] ??= $entretien->getFreres()["string"];
        $data["soeurs"] ??= $entretien->getSoeurs()["string"];

        $data["domaine_souhaite"] ??= $entretien->getDomaineSouhaite();
        $data["connaissance_esmia"] ??= $entretien->getConnaissanceEsmia();

        $data["motivation"] ??= $entretien->getMotivation();
        $data["attentes"] ??= $entretien->getAttentes();
        $data["problemes"] ??= $entretien->getProblem();
        $data["vision"] ??= $entretien->getVision();
        $data["projets"] ??= $entretien->getProjets();
        $data["loisirs"] ??= $entretien->getLoisirs();
        $data["qualites"] ??= $entretien->getQualites();
        $data["defauts"] ??= $entretien->getDefauts();

        $data["frs"] ??= $entretien->getFrs();
        $data["agl"] ??= $entretien->getAgl();
        $data["info"] ??= $entretien->getInfo();
        $data["react"] ??= $entretien->getReact();

        $data["favorable"] ??= $entretien->getFavorable();

        $this->_renderH($header);
        $this->render($view, $data);
        $this->renderF();
    }

    private function _renderForm($data = [])
    {
        $header['title'] = 'ENTRETIEN';
        $header['current_menu'] = 'NEW';
        $header['css'] = ['/alert', '/src/form-ui', '/src/entretien/new'];
        $header['js'] = ['/alert', '/src/form', '/src/entretien/new', '/src/field-formatter'];
        // $header['css']=['toggle-btn','/src/ei','/context.standalone'];

        $data['au'] = AuModel::getList('nom_au', 'DESC');
        $data['niv'] = NivModel::getList('nom_niv', 'ASC');
        $data['recruteurs'] = RecruteurModel::toModel(RecruteurModel::getList('nom_rec', 'ASC'));

        $data['nom'] ??= '';
        $data['prenom'] ??= '';
        $data['sexe'] ??= 0;
        $data['contact'] ??= '';
        $data['todayDateTime'] ??= (new DateTime())->format("Y-m-d\TH:i");
        $data['date_entretien'] ??= (new DateTime(""))->format("Y-m-d\TH:i");
        $data['datenaiss'] ??= (new DateTime(""))->format("Y-m-d");
        $data['oldestDate'] = "1900-11-01";
        $data['newestDate'] = (new DateTime("now - 5years"))->format("Y-m-d");
        $data['NIV_id'] ??= '';
        $data['AU_id'] ??= '';
        $data['REC_id'] ??= '';
        $data['nom_rec'] ??= '';
        $data['prenom_rec'] ??= '';
        $data['sexe_rec'] ??= 0;
        $data['contact_rec'] ??= '';
        $data['allow_same_date'] ??= false;
        $data['allow_same_person'] ??= false;
        $data['alert'] ??= [];

        $this->_renderH($header);
        $this->render('new', $data);
        $this->renderF();
    }
}
