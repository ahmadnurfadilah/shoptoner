<?php

namespace App\Filament\App\Pages;

use App\Models\Store\Store;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterStore extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'New store';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
            ]);
    }

    protected function handleRegistration(array $data): Store
    {
        $store = Store::create([
            'user_id' => auth()->id(),
            'name' => $data['name'],
        ]);

        $store->users()->attach(auth()->user());

        return $store;
    }
}
