<?php

namespace Database\Seeders;

use App\Models\Common\Status\Status;
use App\Models\Common\Status\StatusType;
use App\Sorurce\Statuses\Constants\ProductStatusConstant;
use App\Source\Statuses\Constants\StatusTypeConstant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ProductStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusType = StatusType::updateOrCreate(
        [
            'slug' => StatusTypeConstant::PRODUCT_TYPE
        ],
        [
            'name' => 'Общие статусы',
            'slug' => StatusTypeConstant::PRODUCT_TYPE
        ]);

        $this->storeStatus($this->commonStatuses(), $statusType);
    }

    protected function storeStatus(Collection $dataStatusesArray, StatusType $statusType):self
    {
        $dataStatusesArray->each(function ($value) use ($statusType) {

            Status::updateOrCreate(
            [
                'slug' => $value['slug']
            ],
            [
                'name' => $value['name'],
                'slug' => $value['slug'],
                'status_type_id' => $statusType->getId(),
            ]);
        });

        return $this;
    }

    public function commonStatuses(): Collection
    {

        return collect([
            [
                'slug' => ProductStatusConstant::NEW,
                'name' => 'Новинка',
            ],
        ]);
    }
}
