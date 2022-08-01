<?php

use App\Core\Controller;
use App\Core\Database;
use App\Models\HistoryModel;

class HistoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $date = "today";
        $history = HistoryModel::index($date);

        $header = [
            'title' => 'Historique',
            'current_menu' => 'HISTORY',
            'css' => ['/src/history/index'],
            'js' => ['/src/history/index'],
        ];
        $data = [
            "history" => $history
        ];

        $this->_renderH($header);
        $this->render('index', $data);
        $this->renderF();
    }

    public function Restore($id): void
    {
        $history = $this->_find($id);

        $db = Database::getConnection();
        $db->beginTransaction();

        if ($history) {
            $history->restore();
            $db->commit();
        } else {
            $db->rollBack();
        }

        header('Content-Type: application/json');
        echo json_encode($history);
        exit;
    }

    /**
     * @param int $id
     * @return HistoryModel|null
     */
    private function _find($id): HistoryModel | null
    {
        return HistoryModel::find($id);
    }
}
