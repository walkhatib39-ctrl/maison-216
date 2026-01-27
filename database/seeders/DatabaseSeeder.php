<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Base settings + catégories
        $this->call([
            SettingSeeder::class,
            CategorySeeder::class,
            OrderSeeder::class,
        ]);

        // Admin par défaut (modifiable ensuite via l'admin)
        $adminEmail = 'admin@maison216.tn';
        User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        $this->command?->warn("Admin créé/présent: {$adminEmail} / password");

        // Admin demandé par le client
        $clientEmail = 'walkhatib39@gmail.com';
        User::firstOrCreate(
            ['email' => $clientEmail],
            [
                'name' => 'Admin',
                'password' => Hash::make('Aa09600710'),
                'is_admin' => true,
            ]
        );

        $this->command?->warn("Admin créé/présent: {$clientEmail} / Aa09600710");
    }
}
