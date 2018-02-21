<?php 

use Orchestra\Testbench\TestCase;
use GuzzleHttp\Client as GuzzleClient;
use Larabay\Support\LarabayService;
use Larabay\LarabayServiceProvider;

class LarabayServiceTest extends TestCase
{
    /**
     * Instantiate our service with a new GuzzleClient.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->service = new LarabayService(new GuzzleClient([
            'base_uri' => 'https://pixabay.com/api/',
        ]));
    }

    /**
     * Test that our search will return some results.
     *
     * @return void
     */
    public function testSearch()
    {
        $response = $this->service->search('flowers');

        $this->assertEquals(20, $response->count());
    }

    /**
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [LarabayServiceProvider::class];
    }
}
