<?php
namespace core;

class Logger
{
    public static function log($action, $message = '', $userId = null, $method = null, $uri = null, $params = null)
    {
        try {
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

            Core::get()->db->insert('logs', [
                'user_id'    => $userId,
                'action'     => $action,
                'message'    => $message,
                'ip_address' => $ip,
                'method'     => $method,
                'uri'        => $uri,
                'params'     => $params,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Throwable $e) {
            error_log("Logger error: " . $e->getMessage());
        }
    }
}
