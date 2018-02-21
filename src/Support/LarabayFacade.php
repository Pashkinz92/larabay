<?php 

namespace Larabay\Support;

use Illuminate\Support\Facades\Facade;

final class LarabayFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'larabay';
    }
}
