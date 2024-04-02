<?php

namespace App\Filament\App\Resources\ProductAttributeResource\Pages;

use App\Filament\App\Resources\ProductAttributeResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ManageRecords;

class ManageProductAttributes extends ManageRecords
{
    protected static string $resource = ProductAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('xl')
                ->mutateFormDataUsing(function (array $data): array {
                    $data['store_id'] = Filament::getTenant()->id;

                    return $data;
                })
        ];
    }
}
