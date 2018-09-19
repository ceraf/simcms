<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        //$client->followRedirect(true);
        $crawler = $client->request('GET', '/');
        
        $link = $crawler->filter('a:contains("Blog")')->eq(0)->link();
        $crawler = $client->click($link);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Блог', $crawler->filter('.page-header h1')->text());
    }
}
