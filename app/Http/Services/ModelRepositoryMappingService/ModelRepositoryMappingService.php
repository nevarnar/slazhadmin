<?php

namespace App\Http\Services\ModelRepositoryMappingService;

use App\Models\SubProduct;
use App\Http\Repositories\Ads\AdsRepository;
use App\Http\Repositories\Tag\TagRepository;
use App\Http\Repositories\Tax\TaxRepository;
use App\Http\Repositories\Size\SizeRepository;
use App\Http\Repositories\Brand\BrandRepository;
use App\Http\Repositories\Color\ColorRepository;
use App\Http\Repositories\Style\StyleRepository;
use App\Http\Repositories\Coupon\CouponRepository;
use App\Http\Repositories\Gender\GenderRepository;
use App\Http\Repositories\Season\SeasonRepository;
use App\Http\Repositories\Series\SeriesRepository;
use App\Http\Repositories\Country\CountryRepository;
use App\Http\Repositories\Product\ProductRepository;
use App\Http\Repositories\Campaign\CampaignRepository;
use App\Http\Repositories\Category\CategoryRepository;
use App\Http\Repositories\Delivery\DeliveryRepository;
use App\Http\Repositories\Discount\DiscountRepository;
use App\Http\Repositories\Division\DivisionRepository;
use App\Http\Repositories\Occasion\OccasionRepository;
use App\Http\Repositories\Township\TownshipRepository;
use App\Http\Repositories\Supplier\SupplierRepository; 
use App\Http\Repositories\Inventory\InventoryRepository;
use App\Http\Repositories\Variation\VariationRepository;
use App\Http\Repositories\Collection\CollectionRepository;
use App\Http\Repositories\SubProduct\SubProductRepository;
use App\Http\Repositories\SubCategory\SubCategoryRepository;

class ModelRepositoryMappingService implements ModelRepositoryMappingServiceInterface
{
    private $model_repository_map = array(
        "category" => CategoryRepository::class,
        "country" => CountryRepository::class,
        "brand" => BrandRepository::class,
        "color" => ColorRepository::class,
        "occasion" => OccasionRepository::class,
        "supplier" => SupplierRepository::class,
        "sub_category" => SubCategoryRepository::class,
        "variation" => VariationRepository::class,
        "gender"=>GenderRepository::class,
        "season"=>SeasonRepository::class,
        "tax"=>TaxRepository::class,
        "size"=>SizeRepository::class,
        "tag"=>TagRepository::class,
        "style"=>StyleRepository::class,
        "product"=>ProductRepository::class,
        "collection"=>CollectionRepository::class,
        "ads"=>AdsRepository::class,
        "delivery_man"=>DeliveryRepository::class,
        "series"=>SeriesRepository::class,
        "inventory"=>InventoryRepository::class,
        "sub_product"=>SubProductRepository::class,
        "discount"=>DiscountRepository::class,
        "campaign"=>CampaignRepository::class,
        "division"=>DivisionRepository::class,
        "township"=>TownshipRepository::class,
        "coupon"=>CouponRepository::class,
        "order"=>OrderRepository::class,
    );

    public function getRepository(string $model)
    {
        return $this->model_repository_map[$model];
    }
}
