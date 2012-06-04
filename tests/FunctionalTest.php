<?php

use Silex\WebTestCase;

class FunctionalTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../src/app.php';

        $app['debug'] = true;

        unset($this->app['exception_handler']);

        return $app;
    }

    /**
     * @dataProvider provideApi
     */
    public function testApi($status, $now)
    {
        $client = $this->createClient();

        $client->request('GET', '/api/', array(), array(), array('REQUEST_TIME' => $now));
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertSame('no-cache', $response->headers->get('Cache-Control'));

        $json = json_decode($response->getContent(), true);
        $this->assertNotNull($json);
        $this->assertSame('1.0', $json['version']);
        $this->assertSame($now, $json['current_time']);
        $this->assertSame($status, $json['status']);
    }

    public function provideApi()
    {
        return array(
            array('no', strtotime('2012-06-04 10:46:04')),
            array('no', strtotime('2012-06-04 10:50:00')),
            array('no', strtotime('2012-06-04 10:54:59')),
            array('yes', strtotime('2012-06-04 10:55:00')),
            array('yes', strtotime('2012-06-04 10:56:00')),
            array('yes', strtotime('2012-06-04 10:59:00')),
            array('yes', strtotime('2012-06-04 10:59:59')),
            array('no', strtotime('2012-06-04 11:00:00')),
            array('no', strtotime('2012-06-04 11:04:00')),
            array('no', strtotime('2012-06-04 11:15:00')),
            array('no', strtotime('2012-06-04 11:23:00')),
            array('yes', strtotime('2012-06-04 11:25:00')),
            array('yes', strtotime('2012-06-04 11:25:46')),
            array('yes', strtotime('2012-06-04 11:27:46')),
            array('yes', strtotime('2012-06-04 11:29:37')),
            array('yes', strtotime('2012-06-04 11:29:50')),
            array('no', strtotime('2012-06-04 11:30:00')),
        );
    }
}
