<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $keys = [
            'name',
            'sort',
            'created_at',
            'updated_at'
        ];

        $values = [
            ['Mobile Phones', 0, Carbon::now(), Carbon::now()],
            ['Mobile Accessories', 1, Carbon::now(), Carbon::now()],
            ['Monitors', 2, Carbon::now(), Carbon::now()],
            ['Laptops', 3, Carbon::now(), Carbon::now()],
            ['Speakers', 4, Carbon::now(), Carbon::now()],
            ['Printers', 5, Carbon::now(), Carbon::now()],
        ];

        $insert_array = [];
        foreach ($values as $value)
        {
            if (!Category::where('name', $value[0])->first()) {
                $insert_array[] = array_combine($keys, $value);
            }
        }

        if (count($insert_array) > 0) {
            DB::table('categories')->insert($insert_array);
        }
    }
}
