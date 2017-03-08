<?php
namespace Tests\Functional;

class DurationTest extends BaseTestCase
{
    public function testGetMetadata()
    {
        $response = $this->runApp('GET', '/api/MapboxDirection');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
    }
}