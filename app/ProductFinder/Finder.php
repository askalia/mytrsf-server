<?php
/**
 * Created by PhpStorm.
 * User: joris
 * Date: 02/09/2015
 * Time: 11:39
 */

namespace App\ProductFinder;

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\ApaiIO;


class Finder
{

    public function find($_keyword, $_category)
    {
        $this->checkCategoryIsValid($_category);

        $conf = new GenericConfiguration();
        $conf
            ->setCountry('fr')
            ->setAccessKey('AKIAIPT5MLUKB3HZ7MOA')
            ->setSecretKey('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')
            ->setAssociateTag('trysurfing-21');

        $apaiIO = new ApaiIO($conf);

        $search = new Search();
        //$search->setCategory('DVD');
        //$search->setActor('Bruce Willis');

        $search->setCategory($_category ? : 'Electronics');
        $search->setKeywords($_keyword);
        $search->setResponseGroup(['Medium']);



        $formattedResponse = $apaiIO->runOperation($search);

        return $this->filterResults($formattedResponse);
    }

    private function filterResults($results)
    {
        $filteredResults = [];
        $xmlDoc = new \SimpleXMLElement($results);
        $xmlDoc->registerXPathNamespace("ns", "http://webservices.amazon.com/AWSECommerceService/2011-08-01");
        $listNodes = $xmlDoc->xpath('/ns:ItemSearchResponse/ns:Items/ns:Item');

        foreach ($listNodes as $node)
        {
            $filteredResults[] = $this->buildItem($node);
        }

        return $filteredResults;
    }
    private function buildItem($node)
    {
        $newItem = new AWSItem();
        $newItem->fullname = (string) $node->ItemAttributes->Title;
        $newItem->pictures = [ 'large' => (string) $node->LargeImage->URL,
                                'small'  => (string) $node->SmallImage->URL,
                                'medium' => (string) $node->MediumImage->URL,
                             ];
        //unset($node['ItemLinks'], $node['SmallImage'], $node['ImageSets']);
        return $newItem;
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