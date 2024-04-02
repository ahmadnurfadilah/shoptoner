<?php

namespace App\Filament\App\Resources\ProductCategoryResource\Pages;

use App\Filament\App\Resources\ProductCategoryResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ManageRecords;

class ManageProductCategories extends ManageRecords
{
    protected static string $resource = ProductCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                // ->mutateFormDataUsing(function (array $data): array {
                //     $data['store_id'] = Filament::getTenant()->id;

                //     return $data;
                // })
        ];
    }
}
