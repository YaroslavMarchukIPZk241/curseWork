<?php

namespace controllers;
use core\Cache;
use core\Controller;

class AboutController extends Controller
{
    public function actionIndex()
{
    $cacheKey = 'about_page';
    $cacheTTL = 3600;

    $cachedContent = Cache::load($cacheKey, $cacheTTL);

    if ($cachedContent !== null) {
        return [
            'Content' => $cachedContent,
            'Title' => 'Про нас - Музей'
        ];
    }

    $result = $this->render('about/index', [
        'Title' => 'Про нас - Музей'
    ]);

    Cache::save($cacheKey, $result['Content']);

    return $result;
}
}
