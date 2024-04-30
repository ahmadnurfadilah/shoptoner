<?php

namespace App\Filament\App\Pages\Auth;

use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;

class Register extends BaseRegister
{
    protected static string $view = 'filament.app.pages.auth.register';

    protected function handleRegistration(array $data): Model
    {
        return $this->getUserModel()::create([
            'first_name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }
}
