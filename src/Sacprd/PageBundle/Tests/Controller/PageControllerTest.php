<?php

namespace Sacprd\PageBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/app_dev.php/admin/pages');

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }
}
