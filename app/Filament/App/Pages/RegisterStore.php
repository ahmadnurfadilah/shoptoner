<?php

namespace App\Filament\App\Pages;

use App\Models\Store\Store;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Support\HtmlString;

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
                Placeholder::make('')
                    ->content(new HtmlString('<h2 class="text-center text-lg text-gray-500 font-medium">Let\'s create your first store</h2>')),
                TextInput::make('name')
                    ->label('Store name')
                    ->required(),
                TextInput::make('wallet_address')
                    ->label('Wallet address (TON)')
                    ->hint('to receive payment')
                    ->required(),
            ]);
    }

    protected function handleRegistration(array $data): Store
    {
        $store = Store::create([
            'user_id' => auth()->id(),
            'name' => $data['name'],
            'wallet_address' => $data['wallet_address'],
        ]);

        $store->users()->attach(auth()->user());

        return $store;
    }
}
