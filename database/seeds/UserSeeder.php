<?php

use App\User;
use App\Models\Profession;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//$professions = DB::select('SELECT id FROM professions WHERE title = ?', ['Desarrollador back-end']);

    	// $professionId = DB::table('professions')
    	// ->where(['title' => 'Desarrollador back-end'])
    	// ->value('id');

    	//Eloquent
    	$professionId = Profession::where('title', 'Desarrollador back-end')->value('id');

        // DB::table('users')->insert([
        // 	'name' => 'Diego Chacon',
        // 	'email' => 'dchacon@gmail.com',
        // 	'password' => bcrypt('laravel'),
        // 	'profession_id' => $professionId
        // ]);

        //Le indica a tinker que debe tomar este id para crear usuarios aletorios
        factory(User::class, 20)->create([
            'profession_id' => $professionId
        ]);
    }
}
