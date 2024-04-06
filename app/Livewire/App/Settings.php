<?php

namespace App\Livewire\App;

use App\Models\Store\Store;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Support\Str;

class Settings extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $store = Filament::getTenant();
        $this->form->fill([
            'name' => $store->name,
            'slug' => $store->slug,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required()
                    ->alphaNum()
                    ->unique('stores', 'slug', Filament::getTenant()),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $store = Store::firstOrNew(['id' => Filament::getTenant()->id]);
        $store->name = $this->form->getState()['name'];
        $store->slug = Str::slug($this->form->getState()['slug']);
        $store->save();

        Notification::make()->title('Saved')->success()->send();
    }

    public function render()
    {
        return view('livewire.app.settings');
    }
}
