<?php

namespace Umg\VotacionBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RcatedraticoControllerTest extends WebTestCase
{
    public function testLista()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/lista');
    }

    public function testVer()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ver');
    }

    public function testObservacion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/observacion');
    }

}
