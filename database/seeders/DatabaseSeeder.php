<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $this->call([
            BranchRelationSeeder::class,
            StarSeeder::class,
            LucThapHoaGiapSeeder::class,
            StarEnergyLevelSeeder::class,
            GlossarySeeder::class,
            SampleHoroscopeSeeder::class,
            FullRuleSeeder::class,
        ]);
    }
}
