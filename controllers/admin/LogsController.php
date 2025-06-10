<?php

namespace controllers\admin;

use core\Controller;
use core\Core;
use models\Log;

class LogsController extends Controller
{
 public function actionIndex($params = [])
{
    $page = isset($params[0]) ? (int)$params[0] : 1;
    $page = max(1, $page);
    $itemsPerPage = 300;
    $offset = ($page - 1) * $itemsPerPage;

    $db = Core::get()->db;

    // Підрахунок загальної кількості записів
    $totalCountData = $db->query("SELECT COUNT(*) AS total FROM logs");
    $totalLogs = $totalCountData[0]['total'] ?? 0;

    // Отримуємо логи з пагінацією
    $logsData = $db->query("SELECT * FROM logs ORDER BY created_at DESC LIMIT $itemsPerPage OFFSET $offset");

    $logs = [];
    foreach ($logsData as $data) {
        $log = new Log();
        $log->id = $data['id'];
        $log->user_id = $data['user_id'];
        $log->action = $data['action'];
        $log->message = $data['message'];
        $log->ip_address = $data['ip_address'];
        $log->created_at = $data['created_at'];
        $log->method = $data['method'];
        $log->uri = $data['uri'];
        $log->params = $data['params'];
        $logs[] = $log;
    }

    $totalPages = ceil($totalLogs / $itemsPerPage);

    return $this->render('admin/logs/index', [
        'logs' => $logs,
        'page' => $page,
        'totalPages' => $totalPages
    ]);
}
    public function actionStatistics()
{
    return $this->render('admin/logs/statistics');
}

   public function actionSearch()
{
    $q = $_GET['q'] ?? '';

    try {
        $results = Log::search($q);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;   
}
public function actionStats()
{
    $db = \core\Core::get()->db;

 
    $sql = "SELECT DATE(created_at) as log_date, COUNT(*) as count
            FROM logs
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 14 DAY)
            GROUP BY log_date
            ORDER BY log_date ASC";

    $sth = $db->pdo->prepare($sql);
    $sth->execute();

    $result = $sth->fetchAll();

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
public function actionStatusStats()
{
    $sql = "SELECT 
                CASE
                    WHEN action LIKE '404%' THEN '404'
                    WHEN action LIKE '403%' THEN '403'
                    WHEN action LIKE '500%' THEN '500'
                    WHEN action LIKE '401%' THEN '401'
                    WHEN action LIKE '400%' THEN '400'
                    ELSE 'Інше'
                END as status_code,
                COUNT(*) as total
            FROM logs
            GROUP BY status_code
            ORDER BY total DESC";

    $sth = \core\Core::get()->db->pdo->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
public function actionTopUris()
{
        $sql = "SELECT uri, COUNT(*) as total
            FROM logs
            WHERE uri IS NOT NULL AND uri != ''
            GROUP BY uri
            ORDER BY total DESC
            LIMIT 10";

    $sth = \core\Core::get()->db->pdo->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;

}
public function actionUserActivityStats()
{
    $sql = "SELECT user_id, COUNT(*) as total
            FROM logs
            WHERE user_id IS NOT NULL
            GROUP BY user_id
            ORDER BY total DESC
            LIMIT 10";

    $sth = \core\Core::get()->db->pdo->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

public function actionActionsStats()
{
    $sql = "SELECT action, COUNT(*) as total
            FROM logs
            WHERE action IS NOT NULL
            GROUP BY action
            ORDER BY total DESC
            LIMIT 10";

    $sth = \core\Core::get()->db->pdo->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
public function actionIpStats()
{
    $sql = "SELECT ip_address, COUNT(*) as total
            FROM logs
            WHERE ip_address IS NOT NULL
            GROUP BY ip_address
            ORDER BY total DESC
            LIMIT 10";

    $sth = \core\Core::get()->db->pdo->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
public function actionMethodStats()
{
    $sql = "SELECT method, COUNT(*) as total
            FROM logs
            WHERE method IS NOT NULL
            GROUP BY method
            ORDER BY total DESC";

    $sth = \core\Core::get()->db->pdo->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

}