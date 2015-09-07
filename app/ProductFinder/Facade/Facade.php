<?php
/**
 * Created by PhpStorm.
 * User: joris
 * Date: 02/09/2015
 * Time: 12:36
 */

namespace App\ProductFinder\Facade;

use Illuminate\Support\Facades\Facade;

class Finder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ProductFinder';
    }

} 