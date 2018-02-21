<?php 

namespace Larabay\Contracts;

interface QueriesPixabay
{
    /**
     * Returns the search response.
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    public function search($terms, $image = true, $options = []);

    /**
     * Returns a search for images.
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    public function searchImages($terms, $options = []);

    /**
     * Returns a search for videos.
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    public function searchVideos($terms, $options = []);
}
