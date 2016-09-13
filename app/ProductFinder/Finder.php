<?php
/**
 * Created by PhpStorm.
 * User: joris
 * Date: 02/09/2015
 * Time: 11:39
 */

namespace App\ProductFinder;

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
use ApaiIO\Operations\Search;
use ApaiIO\ApaiIO;

use App\Entities\Category;
use App\Entities\Product;
use App\ProductFinder\AmazonAWS\Builders\ItemBuilder;
use Doctrine\Tests\Common\Persistence\Mapping\SimpleAnnotationDriver;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DependencyInjection\SimpleXMLElement;


class Finder
{
    public function find($_keyword, $_category, $_lang)
    {
        $useCache = false;

        //if (!$useCache || ! Storage::exists(env('AWS_PRODUCT_API_CACHE_FILE')))
        //{
            $this->checkCategoryIsValid($_category);

            $conf = new GenericConfiguration();
            $conf
                ->setCountry($_lang ?: env('AWS_PRODUCT_API_DEFAULT_LANG'))
                ->setAccessKey(env('AWS_PRODUCT_API_ACCESS_KEY'))
                ->setSecretKey(env('AWS_PRODUCT_API_SECRET_KEY'))
                ->setAssociateTag(env('AWS_PRODUCT_API_ASSOCIATE_TAG'));

            $apaiIO = new ApaiIO($conf);

            $search = new Search();
            $search->setCategory($_category ? : env('AWS_PRODUCT_API_DEFAULT_CATEGORY'));
            $search->setKeywords($_keyword);
            $search->setResponseGroup([env('AWS_PRODUCT_API_DEFAULT_RESPONSEGROUP')]);

            $formattedResponse = $apaiIO->runOperation($search);

            /*if (!Storage::exists(static::AWS_CACHE_XML))
            {
                $dom = new \DOMDocument("1.0");
                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;
                $dom->loadXML($formattedResponse);
                Storage::disk('local')->put(env('AWS_PRODUCT_API_CACHE_FILE'), $dom->saveXML());
            }*/
        //}
        //else {
        //    $formattedResponse = Storage::get(env('AWS_PRODUCT_API_CACHE_FILE'));
        //}

        /*
        $xml = new \SimpleXMLElement($formattedResponse);
        $xml->formatOutput = true;
        */


        return $this->buildDisplayableItems($formattedResponse);
    }

    /**
     * @param $_productRef ASIN reference
     */
    public function lookupItem($_productRef, $_lang, $_userId)
    {
        $conf = new GenericConfiguration();
        $conf
            ->setCountry($_lang ?: env('AWS_PRODUCT_API_DEFAULT_LANG'))
            ->setAccessKey(env('AWS_PRODUCT_API_ACCESS_KEY'))
            ->setSecretKey(env('AWS_PRODUCT_API_SECRET_KEY'))
            ->setAssociateTag(env('AWS_PRODUCT_API_ASSOCIATE_TAG'));
        $apaiIO = new ApaiIO($conf);
        $itemLookup = new Lookup();
        $itemLookup->setIdType('ASIN');
        $itemLookup->setItemId($_productRef);
        $itemLookup->setResponseGroup([env('AWS_PRODUCT_API_DEFAULT_RESPONSEGROUP')]);
        $formattedResults = $apaiIO->runOperation($itemLookup);
        return $this->buildFullfilledItem($formattedResults);
    }

    private function buildDisplayableItems($results)
    {
        $filteredResults = [];
        $xmlDoc = new \SimpleXMLElement($results);
        $xmlDoc->registerXPathNamespace("ns", env('AWS_PRODUCT_API_XMLNS'));
        $listNodes = $xmlDoc->xpath('/ns:ItemSearchResponse/ns:Items/ns:Item');

        foreach ($listNodes as $node)
        {
            $filteredResults[] = ItemBuilder::buildFromXML(Product::class, $node);
        }

        return $filteredResults;
    }
    private function buildFullfilledItem($results)
    {
        $filteredResults = [];
        $xmlDoc = new \SimpleXMLElement($results);
        $xmlDoc->registerXPathNamespace("ns", env('AWS_PRODUCT_API_XMLNS'));
        $itemNode = $xmlDoc->xpath('/ns:ItemLookupResponse/ns:Items/ns:Item[1]')[0];

        return ItemBuilder::buildFromXML(Product::class, $itemNode);

    }

    private function checkCategoryIsValid($_category)
    {
        if (! $_category)
        {
            throw new \InvalidArgumentException('category_argument_missing');
        }
        if (! $this->isCategoryValid($_category)){
            throw new \InvalidArgumentException('category_not_allowed');
        }
    }


    private function isCategoryValid($_category)
    {
        return (in_array($_category, $this->allowedCategories()));
    }

    public function allowedCategories()
    {
        return [
            'All','Wine','Wireless','ArtsAndCrafts','Miscellaneous','Electronics','Jewelry','MobileApps','Photo','Shoes','KindleStore','Automotive','MusicalInstruments','DigitalMusic','GiftCards','FashionBaby','FashionGirls','GourmetFood','HomeGarden','MusicTracks','UnboxVideo','FashionWomen','VideoGames','FashionMen','Kitchen','Video','Software','Beauty','Grocery','FashionBoys','Industrial','PetSupplies','OfficeProducts','Magazines','Watches','Luggage','OutdoorLiving','Toys','SportingGoods','PCHardware','Movies','Books','Collectibles','VHS','MP3Downloads','Fashion','Tools','Baby','Apparel','Marketplace','DVD','Appliances','Music','LawnAndGarden','WirelessAccessories','Blended','HealthPersonalCare','Classical'
        ];
    }
    //private function filterResults()
} 