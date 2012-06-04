<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/functions.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app['data'] = function () use ($app) {
    $now = $app['request']->server->get('REQUEST_TIME');
    return getStatus($now);
};

$app->get('/', function () use ($app) {
    $data = $app['data'];
    return $app['twig']->render('index.twig', array('status' => $data['status'], 'time' => $data['current_time']));
});

$app->get('/api/', function () use ($app) {
    return $app->json($app['data']);
});

return $app;
