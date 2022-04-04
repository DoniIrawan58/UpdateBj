<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        DB::table('updates')->insert([
            'tittle' => 'BeJe',
            'version' => '2.5',
        ]);

        DB::table('features')->insert([
            'feature' => 'update',
            'note_id' => '1'
        ]);
    }
}
