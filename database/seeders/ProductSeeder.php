<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $keys = [
            'category_id', 'name', 'description', 'price', 'quantity', 'created_at', 'updated_at'
        ];
        // Mobile Phones
        $mobile = Category::where('name', 'Mobile Phones')->first();
        if ($mobile) {
            $values = [
                [$mobile->id, 'Apple iPhone 12', '', 50000, 10, Carbon::now(), Carbon::now()],
                [$mobile->id, 'Apple iPhone 12 Pro', '', 70000, 5, Carbon::now(), Carbon::now()],
                [$mobile->id, 'Apple iPhone 12 Pro Max', '', 90000, 5, Carbon::now(), Carbon::now()],
                [$mobile->id, 'Apple iPhone 11', '', 36000, 3, Carbon::now(), Carbon::now()],
                [$mobile->id, 'Apple iPhone 11 Pro', '', 48000, 6, Carbon::now(), Carbon::now()],
                [$mobile->id, 'Samsung Galaxy S21 Ultra', '', 98800, 5, Carbon::now(), Carbon::now()],
            ];
            $this->insertProducts($keys, $values);
        }

        // Mobile Accessories
        $mobileAccessories = Category::where('name', 'Mobile Accessories')->first();
        if ($mobileAccessories) {
            $values = [
                [$mobileAccessories->id, 'Portable Charger', '', 3000, 4, Carbon::now(), Carbon::now()],
                [$mobileAccessories->id, 'Car Mounts', '', 1500, 5, Carbon::now(), Carbon::now()],
                [$mobileAccessories->id, 'Selfie Sticks', '', 2000, 5, Carbon::now(), Carbon::now()],
                [$mobileAccessories->id, 'Headphones', '', 1000, 20, Carbon::now(), Carbon::now()],
            ];
            $this->insertProducts($keys, $values);
        }

        // Monitors
        $monitors = Category::where('name', 'Monitors')->first();
        if ($monitors) {
            $values = [
                [$monitors->id, 'Razer Raptor 27', '', 11500, 4, Carbon::now(), Carbon::now()],
                [$monitors->id, 'Asus ROG Swift PG35VQ', '', 30000, 40, Carbon::now(), Carbon::now()],
                [$monitors->id, 'Philips Brilliance 279P1', '', 15000, 5, Carbon::now(), Carbon::now()],
                [$monitors->id, 'Apple Pro Display XDR', '', 29000, 18, Carbon::now(), Carbon::now()],
                [$monitors->id, 'BenQ ASDF', '', 13000, 6, Carbon::now(), Carbon::now()],
            ];
            $this->insertProducts($keys, $values);
        }

        // Laptops

        // Speakers

        // Printers

    }

    private function insertProducts($keys, $values)
    {
        $insert_array = [];
        foreach ($values as $value)
        {
            if (!Product::where('name', $value[1])->where('category_id', $value[0])->first()) {
                $insert_array[] = array_combine($keys, $value);
            }
        }

        if (count($insert_array) > 0) {
            DB::table('products')->insert($insert_array);
        }
    }
}
