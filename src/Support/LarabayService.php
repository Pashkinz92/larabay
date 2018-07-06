<?php 

namespace Larabay\Support;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use Larabay\Contracts\QueriesPixabay;
use Larabay\Exceptions\PixabayQueryException;

final class LarabayService implements QueriesPixabay
{
    /**
     * Guzzle client to use for perusing the Pixabay API.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Options merged from defaults and overridden options.
     *
     * @var array
     */
    protected $options = [];

    protected $totalItems = 0;
    protected $items = [];

    /**
     * Create a new Larabay service.
     *
     * @param GuzzleClient $client
     */
    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;

        $this->options = collect(config('larabay'));
    }

    /**
     * Query the Pixabay API for either images or videos with the specified options.
     * Better for a few situations where perhaps user input is required and there
     * is a boolean flag indicating whether videos or images are to be queried.
     *
     * @param mixed $terms
     * @param boolean $image
     * @param mixed $options
     * @return void
     */
    public function search($terms, $image = true, $options = [])
    {
        $url = $image ? '' : 'videos';

        $response = $this->client->send($this->buildRequest($url, $terms, $options));

        $body = collect(json_decode($response->getBody()->getContents()));
        $this->totalItems = $body->get('total');
        $this->items = collect($body->get('hits'));
        return $this->items;
    }

    /**
     * Query the Pixabay API for images using the specified options.
     *
     * @param mixed $terms
     * @param mixed $options
     * @return GuzzleHttp\Psr7\Response
     */
    public function searchImages($terms, $options = [])
    {
        return $this->search($terms, true, $options);
    }

    /**
     * Query the Pixabay API for videos using the specified options.
     *
     * @param mixed $terms
     * @param mixed $options
     * @return GuzzleHttp\Psr7\Response
     */
    public function searchVideos($terms, $options = [])
    {
        return $this->search($terms, false, $options);
    }

    /**
     * Pixabay requires our searches to be 'GET' requests to specific endpoints.
     * We build the request by taking all of our request options and building
     * a URL-encoded query string and then passing our request back.
     *
     * @param mixed $terms
     * @param mixed $options
     * @return GuzzleHttp\Psr7\Request
     * 
     * @todo Needs to be moved to a custom request class
     */
    protected function buildRequest($url, $terms, $options = [])
    {
        $requestOptions = collect($this->options)->merge($options);

        $requestOptions->put('q', $this->buildQuery($terms));

        $queryString = $requestOptions
            ->filter(function ($value, $key) {
                if (function_exists('filled')) {
                    return filled($value);
                } else {
                    return !empty($value) && trim($value) !='';
                }
            })
            ->map(function ($option, $key) {
                return "$key=$option";
            })->implode('&');

        $url .= '?' . $queryString;

        return new Request('GET', $url);
    }

    /**
     * We build the query params by checking whether we've
     * received an array or a string separated by spaces.
     * 
     * We then build the query by url-encoding the array
     * and gluing the pieces together with a '+' char.
     *
     * @param mixed $terms
     * @return void
     * 
     * @todo Needs to be moved to a custom request class
     */
    protected function buildQuery($terms)
    {
        $collection = collect($this->buildQueryArrayFromTerms($terms))
            ->map(function ($term) {
                return urlencode((string) $term);
            })
            ;

        return $collection->implode('+');
    }

    /**
     * Build an array from the supplied terms.
     * 
     * Must be either an array or a string with words separated by spaces.
     *
     * @param mixed $terms
     * @return void
     * 
     * @throws Larabay\Exceptions\PixabayQueryException
     *         If the parameters are malformed; either not an array or string
     */
    protected function buildQueryArrayFromTerms($terms)
    {
        if (is_array($terms)) {
            return $terms;
        }

        if (is_string($terms)) {
            return explode(' ', $terms);
        }

        throw new PixabayQueryException;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getTotalItems()
    {
        return $this->totalItems;
    }
}
