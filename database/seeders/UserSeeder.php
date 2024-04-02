<?php

namespace Database\Seeders;

use App\Models\Store\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'Ahmad',
            'last_name' => 'Nurfadilah',
            'username' => 'ahmad',
            'email' => 'ahmad@shopshake.co',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);

        $this->createTeam($user);
    }

    protected function createTeam(User $user): void
    {
        $team = Store::forceCreate([
            'user_id' => $user->id,
            'name' => $user->first_name . "'s Store",
        ]);

        $user->stores()->attach($team, ['role' => 'owner']);
    }
}
