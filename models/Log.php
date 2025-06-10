<?php

namespace models;

use core\Core;

class Log
{
    public $id;
    public $user_id;
    public $action;
    public $message;
    public $ip_address;
    public $created_at;
    public $method;
    public $uri;
    public $params;

public static function search(string $q): array
{
    $db = Core::get()->db;

    $sql = "SELECT * FROM logs 
            WHERE CAST(id AS CHAR) LIKE :q
               OR CAST(user_id AS CHAR) LIKE :q 
               OR action LIKE :q 
               OR ip_address LIKE :q 
               OR message LIKE :q
               OR method LIKE :q
            ORDER BY created_at DESC";

    $sth = $db->pdo->prepare($sql);

    $like = "%$q%";
    $sth->bindValue(':q', $like);

    $sth->execute();

    $logsData = $sth->fetchAll();

    $logs = [];
    foreach ($logsData as $data) {
        $log = new self();
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

    return $logs;
}

}
