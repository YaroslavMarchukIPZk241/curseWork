<?php

namespace controllers;

use core\Controller;
use models\Period;
use core\Core;
use models\InformationPeriod;
class PeriodController extends Controller
{
   public function actionIndex(array $params = [])
    {   
        $page = isset($params[0]) ? (int)$params[0] : 1;
        $page = max(1, $page);

        $itemsPerPage = 8;
        $offset = ($page - 1) * $itemsPerPage;

        $periods = Period::findPaginatedSortedByTime($itemsPerPage, $offset);
        $totalPeriods = Period::countAll();
        $totalPages = ceil($totalPeriods / $itemsPerPage);

        return $this->render('views/period/index.php', [
            'periods' => $periods,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }


public function actionShow(array $params)
{
    $id = intval($params[0] ?? 0);
    $periods = Core::get()->db->select('periods', '*', ['id' => $id]);
    $period = !empty($periods) ? $periods[0] : null;

    if (!$period) {
        $this->Error(404);
    }

    $categories = Core::get()->db->select('categories');


    $where = ['period_id' => $id];
    if (!empty($_GET['category_id'])) {
        $where['category_id'] = intval($_GET['category_id']);
    }
    if (!empty($_GET['search'])) {
        $where['title'] = ['LIKE', '%' . $_GET['search'] . '%'];
    }

    $perPage = 8;
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($page - 1) * $perPage;

    $sqlCount = "SELECT COUNT(*) as cnt FROM exhibits WHERE period_id = :period_id";
    $paramsCount = ['period_id' => $id];
    if (!empty($_GET['category_id'])) {
        $sqlCount .= " AND category_id = :category_id";
        $paramsCount['category_id'] = intval($_GET['category_id']);
    }
    if (!empty($_GET['search'])) {
        $sqlCount .= " AND title LIKE :search";
        $paramsCount['search'] = '%' . $_GET['search'] . '%';
    }

    $stmt = Core::get()->db->pdo->prepare($sqlCount);
    foreach ($paramsCount as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    $stmt->execute();
    $total = $stmt->fetch()['cnt'];
    $totalPages = ceil($total / $perPage);

    $sql = "SELECT * FROM exhibits WHERE period_id = :period_id";
    $paramsSelect = ['period_id' => $id];

    if (!empty($_GET['category_id'])) {
        $sql .= " AND category_id = :category_id";
        $paramsSelect['category_id'] = intval($_GET['category_id']);
    }
    if (!empty($_GET['search'])) {
        $sql .= " AND title LIKE :search";
        $paramsSelect['search'] = '%' . $_GET['search'] . '%';
    }

    $sql .= " LIMIT $offset, $perPage";
    $stmt = Core::get()->db->pdo->prepare($sql);
    foreach ($paramsSelect as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    $stmt->execute();
    $exhibits = $stmt->fetchAll();

  $exhibitIds = array_column($exhibits, 'id');
    $avgRatings = [];

    if (!empty($exhibitIds)) {
        $placeholders = implode(',', array_fill(0, count($exhibitIds), '?'));

        $sqlRatings = "SELECT exhibit_id, AVG(rating) as avg_rating FROM exhibit_reviews WHERE exhibit_id IN ($placeholders) GROUP BY exhibit_id";
        $stmtRatings = Core::get()->db->pdo->prepare($sqlRatings);
        $stmtRatings->execute($exhibitIds);

        $ratingsData = $stmtRatings->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($ratingsData as $row) {
            $avgRatings[$row['exhibit_id']] = round(floatval($row['avg_rating']), 2);
        }
    }
    // --- Кінець доданого коду ---

    return $this->render('views/period/show.php', [
        'period' => $period,
        'exhibits' => $exhibits,
        'categories' => $categories,
        'page' => $page,
        'totalPages' => $totalPages,
        'avgRatings' => $avgRatings
    ]);

}
 public function actionDetail($params)
    {
        $id = $params[0] ?? null;
        if (!$id) return $this->redirect('/MuseumShowcase');

        $period = Period::findById($id);
        if (!$period) return $this->redirect('/MuseumShowcase');

        $events = InformationPeriod::findByPeriodId($id);

        return $this->render('period/detail.php', [
            'period' => $period,
            'events' => $events
        ]);
    }

}
