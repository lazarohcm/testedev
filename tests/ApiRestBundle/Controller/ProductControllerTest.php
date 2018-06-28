<?php
/**
 * Created by PhpStorm.
 * User: unasus
 * Date: 6/27/18
 * Time: 10:08 AM
 */

namespace Tests\ApiRestBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testCreate() {
        $client = static::createClient();
        $data = [
            'name' => 'Cellphone',
            'value' => '200.50'
        ];
        $crawler = $client->request('POST', '/api/produto/', ['product' => $data]);
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('product', $response);
        return $response['product'];
    }

    /**
     * @depends testCreate
     */
    public function testFindById($product) {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/produto/find/'.$product['id']);
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('product', $response);
    }


    public function testFindByIdError() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/produto/find/-1');
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($response, 'Product not found');
    }

    /**
     * @depends testCreate
     */
    public function testUpdate($product) {
        $client = static::createClient();
        $product['name'] = 'Bag';
        $crawler = $client->request('PUT', '/api/produto/', ['product' => $product]);
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('product', $response);
        $this->assertContains('Bag', $client->getResponse()->getContent());
    }

    /**
     * @depends testCreate
     */
    public function testDelete($product) {
        $client = static::createClient();
        $crawler = $client->request('DELETE', '/api/produto/'.$product['id']);
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('deleted', $response);
        $this->assertTrue($response['deleted']);
    }

    public function testList() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/produto/list');
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('products', $response);
        $this->assertTrue(count($response['products']) > 0);
    }
}