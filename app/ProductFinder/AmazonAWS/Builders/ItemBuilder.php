<?php
/**
 * Created by PhpStorm.
 * User: joris
 * Date: 02/09/2015
 * Time: 14:49
 */

namespace App\ProductFinder\AmazonAWS\Builders;


class ItemBuilder
{
    public $fullname = '';
    public $pictures = [];
    public $asin = '';

    /**
     * @param \SimpleXMLElement $node
     */
    public static function buildFromXML($_itemClass, \SimpleXMLElement $xmlNode)
    {
        $newItem = $_itemClass::buildFromAmazonAWS($xmlNode);
        return $newItem;
    }


} 