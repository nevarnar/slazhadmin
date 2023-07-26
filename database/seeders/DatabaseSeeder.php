<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\DeliveryMan;
use App\Models\Division;
use Database\Factories\BrandFactory;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\ColorSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\SubCategorySeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            PermissionSeeder::class,
            AdminTypeSeeder::class,
            DepartmentSeeder::class,
            InventorySeeder::class,
            AdminSeeder::class,
            CountrySeeder::class,
            ProductMeasurementSeeder::class,
            GenderSeeder::class,
            SeasonSeeder::class,
            TaxSeeder::class,
            SizeSeeder::class,
            #seed
                //  BrandSeeder::class,
                //  CategorySeeder::class,
                //  ColorSeeder::class,
                //  SubCategorySeeder::class,
                //  OccasionSeeder::class,
                //  VariationSeeder::class,
                //  DeliverySeeder::class,
                //  DeliveryManSeeder::class,
                //  SeriesSeeder::class,
                 SupplierSeeder::class,
                //  ProductSeeder::class,
                //  StockSeeder::class,
         #endseed
            AdsTypeSeeder::class,
            DiscountTypeSeeder::class,
            DivisionSeeder::class,
            TownshipSeeder::class,
            StyleNameSeeder::class,
            PaymentSeeder::class,
            CouponTypeSeeder::class,
            CouponDiscountTypeSeeder::class,
            SizeChartRegionSeeder::class,
            ReasonSeeder::class,
        ]);
    }
}
