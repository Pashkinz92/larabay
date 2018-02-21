<?php

return [

    /**
     * API key for Pixabay.
     * 
     * @see https://pixabay.com/api/docs/
     */
    'key' => env('PIXABAY_API_KEY', ''),

    /**
     * Set the default language for search results.
     * 
     * Pixabay defaults to 'en'.
     * 
     * @see https://pixabay.com/api/docs/
     * @see https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
     * 
     * Supported: cs, da, de, en, es, fr, id, it, hu, nl, no, pl, pt, ro, sk, fi, sv, tr, vi, th, bg, ru, el, ja, ko, zh 
     */
    'lang' => 'en',

    /**
     * The default response group for the request.
     * 
     * Pixabay by default will only allow searching for details of an image up to 960x720.
     * In order to use 'high_resolution' you must first obtain permission from Pixabay.
     * 
     * Supported: 'image_details', 'high_resolution'
     */
    'response_group' => 'image_details',

    /**
     * Restrict searches to this image type by default.
     * 
     * Supported: 'all', 'photo', 'illustration', 'vector'
     */
    'image_type' => 'all',

    /**
     * Restrict searches to this image orientation by default.
     * 
     * Supported: 'all', 'horizontal', 'vertical'
     */
    'orientation' => 'all',

    /**
     * Restrict searches to images with at least this width.
     */
    'min_width' => '0',

    /**
     * Restrict searches to images with at least this height. 
     */
    'min_height' => '0',

    /**
     * Determine if safesearch should be used by default.
     * 
     * Supported: 'true', 'false'
     */
    'safesearch' => 'true',

    /**
     * Determine how results should be ordered.
     * 
     * Supported: 'popular', 'latest'
     */
    'order' => 'popular',

    /**
     * How many results to display per page.
     * 
     * Supported: 3-200
     */
    'per_page' => '20',

    /**
     * Supply a JSONP callback by name if necessary.
     */
    'callback' => null,

    /**
     * Indent JSON output for pretty printing.
     * 
     * Supported: 'true', 'false'
     */
    'pretty' => 'false',
];
