<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Product extends Model {

	protected $table = 'product';
    public $incrementing = true;
	public $timestamps = true;
	protected $fillable = array('model', 'brand', 'category_id', 'small_picture', 'medium_picture', 'large_picture', 'ASIN', 'EAN', 'ISBN', 'webpage', 'created_at', 'updated_at');
	protected $visible = array('model', 'brand', 'category_id', 'small_picture', 'medium_picture', 'large_picture', 'ASIN', 'EAN', 'ISBN');

    public static function buildFromAmazonAWS(\SimpleXMLElement $awsXMLNode)
    {
        $newItem = null;

        try {
            //$newItem = Product::firstOrNew([]);
            return Product::firstOrNew([
                'model' => (string) $awsXMLNode->ItemAttributes->Title,

            'brand' => (string) $awsXMLNode->ItemAttributes->Brand,
            'category_id' => Category::where('keyname', (string) $awsXMLNode->ItemAttributes->Binding)->first()->id,

            'large_picture' => (string) $awsXMLNode->LargeImage->URL,
            'small_picture' => (string) $awsXMLNode->SmallImage->URL,
            'medium_picture' => (string) $awsXMLNode->MediumImage->URL,

            'ASIN' => (string) $awsXMLNode->ASIN,
            'EAN' => (string) $awsXMLNode->ItemAttributes->EAN,
            'webpage' => (string) $awsXMLNode->DetailPageURL
        ]);

        }
        catch (\ErrorException $e){
           app('log')->error($e->getMessage());
        }
        return $newItem;
    }

}