<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

function getStatus($now) {
    $minute = date("i", $now);

    $status = 'no';
    if (($minute >= 25 && $minute <= 29) || ($minute >= 55  && $minute <= 59)) {
        $status = 'yes';
    }

    $data = array(
        'version'       => '1.0',
        'current_time'  => $now,
        'status'        => $status
    );

    return $data;
}

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

$app->run();
