<?php
/**
 * 外观
 */
namespace Psf\Laravel;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Facade extends LaravelFacade
{
    /**
     * 默认为 Server
     *
     * @return string
     */
    static public function getFacadeAccessor()
    {
        return 'psf';
    }
}