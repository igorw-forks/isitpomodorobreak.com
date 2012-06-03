<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));


function getStatus() {
    $now    = time();
    $minute = date("i", $now);

    $status = 'no';
    if(($minute >= 25 && $minute <= 29) || ($minute >= 55  && $minute <= 59)) {
        $status = 'yes';
    }

    $data = array(
        'version'       => '1.0',
        'current_time'  => $now,
        'status'        => $status
    );

    return $data;
}

$data = getStatus();

$app->get('/', function() use ($app, $data) {
    return $app['twig']->render('index.twig', array('status' => $data['status'], 'time' => $data['current_time']));
});

$app->get('/api/', function() use ($app, $data) {
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');

    return json_encode($data);

});

$app->run();