<?php 

namespace Larabay\Exceptions;

use Exception;

class PixabayQueryException extends Exception {

    /**
     * Create a new PixabayQueryException.
     * 
     * @param string $message
     */
    public function __construct($message = null, $code = 400, $previous = null)
    {
        if (! $message) {
            $message = "Invalid query parameters supplied to Pixabay request";
        }

        return parent::__construct($message, $code, $previous);
    }
}
