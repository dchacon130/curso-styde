<?php

use App\Models\Profession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('professions')->insert([
        // 	'title' => 'Desarrollador back-end',
        // ]);

        // DB::table('professions')->insert([
        // 	'title' => 'Desarrollador frond-end',
        // ]);

        // DB::table('professions')->insert([
        // 	'title' => 'Desarrollador web',
        // ]);

        Profession::create(['title' => 'Desarrollador back-end']);

		Profession::create(['title' => 'Desarrollador frond-end']);

		Profession::create(['title' => 'Desarrollador web']);        
    }
}
