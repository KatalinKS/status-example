<?php

namespace Database\Seeders;

use App\Models\Dictionary\ModelName;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ModelNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ModelName $modelName)
    {
        foreach ($this->data() as $data) {
            ModelName::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }

    private function data() {
        return [
            [
                'name' => 'Продукт',
                'link' => Product::class,
                'slug' => 'product',
            ],
        ];
    }
}
