<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,

            CriteriaSeeder::class,
            AlternativeSeeder::class,
            PenilaianSeeder::class,
            RtSeeder::class,
            ActivitySeeder::class,
            UmkmSeeder::class,
            DataKartuKeluargaSeeder::class,
            AnggotaKeluargaSeeder::class,
            SuggestionSeeder::class,
            IuranSeeder::class,
            KriteriaSeeder::class,
            AlternatifSeeder::class,
        ]);

    }
}
