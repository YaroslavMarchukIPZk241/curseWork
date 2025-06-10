<?php
namespace core;

class Cache
{
    public static function load(string $key, int $ttl): string|null
    {
        $file = self::getFilePath($key);
        if (file_exists($file) && (time() - filemtime($file) < $ttl)) {
            return file_get_contents($file);
        }
        return null;
    }

    public static function save(string $key, string $content): void
    {
        file_put_contents(self::getFilePath($key), $content);
    }

    private static function getFilePath(string $key): string
    {
        return __DIR__ . '/../cache/' . md5($key) . '.cache.html';
    }
}

?>