<?php

namespace Tests\Feature;

use App\User;
use App\Models\Profession;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Reconoce la prueba si dice test o inicia con test el nombre.
     * La palabra public se puede eliminar
     *
     * @test
     */

    public function it_loads_the_users_list_page()
    {

        factory(User::class)->create([
            'name' => 'Diego'
        ]);

        factory(User::class)->create([
            'name' => 'Chacón',
        ]);

    	$this->get('/usuarios')
    	->assertStatus(200)
    	->assertSee('Listado de usuarios')
    	->assertSee('Diego')
    	->assertSee('Chacón');
    }

	/**
    *
    * @test*/

    public function it_shows_a_default_message_if_there_are_no_users()
    {
    	$this->get('/usuarios')
    	->assertStatus(200)
    	->assertSee('No hay usuarios registrados.');
    }

    /**
    *
    * @test*/

    public function it_loads_the_users_details_page()
    {
        $user = factory(User::class)->create([
            'name' => 'Diego Chacón'
        ]);

    	$this->get('/usuarios/'.$user->id) //Usuarios/5
    	->assertStatus(200)
    	->assertSee('Mostrando detalle del usuario: Diego Chacón');
    }

    /**
    *
    * @test*/

    public function it_loads_the_new_users_page()
    {
    	$this->get('/usuarios/nuevo')
    	->assertStatus(200)
    	->assertSee('Crear usuario');
    }

    /**
    *
    * @test*/

    public function it_displays_a_404_error_if_the_user_is_not_found()
    {
        $this->get('/usuarios/999')
        ->assertStatus(404)
        ->assertSee('Usuario no encontrado');
    }

    /**
    *
    * @test*/

    public function it_creates_a_new_user()
    {
        $this->withoutExceptionHandling();

        $this->post('/usuarios/crear',[
            'name' => 'Alexander',
            'email' => 'alexander@gmail.com',
            'password' => '123456'
        ])->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Alexander',
            'email' => 'alexander@gmail.com',
            'password' => '123456'
        ]);
    }

    /**
    *
    * @test*/

    public function it_name_is_required()
    {
        //Muestra información detallada de errores
        //Manejador de excepciones
        //$this->withoutExceptionHandling();

        $this->from('usuarios/nuevo')->post('/usuarios/crear',[
            'name' => '',
            'email' => 'correo@gmail.com',
            'password' => '123456' 
        ])->assertRedirect('usuarios/nuevo')
          ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);

          // $this->assertDatabaseMissing('users',[
          //   'email' => 'correo@gmail.com',
          // ]);

          $this->assertEquals(0, User::count());
    }

    /**
    *
    * @test*/

    public function it_email_is_required()
    {
        //Muestra información detallada de errores
        //Manejador de excepciones
        //$this->withoutExceptionHandling();

        $this->from('usuarios/nuevo')->post('/usuarios/crear',[
            'name' => 'diegod',
            'email' => '',
            'password' => '123456' 
        ])->assertRedirect('usuarios/nuevo')
          ->assertSessionHasErrors(['email']);

          // $this->assertDatabaseMissing('users',[
          //   'email' => 'correo@gmail.com',
          // ]);

          $this->assertEquals(0, User::count());
    }

    /**
    *
    * @test*/

    public function it_password_is_required()
    {
        //Muestra información detallada de errores
        //Manejador de excepciones
        //$this->withoutExceptionHandling();

        $this->from('usuarios/nuevo')->post('/usuarios/crear',[
            'name' => 'diegod',
            'email' => 'diegod@gmail.com',
            'password' => '' 
        ])->assertRedirect('usuarios/nuevo')
          ->assertSessionHasErrors(['password']);

          // $this->assertDatabaseMissing('users',[
          //   'email' => 'correo@gmail.com',
          // ]);

          $this->assertEquals(0, User::count());
    }

    /**
    *
    * @test*/

    public function it_email_must_be_valid()
    {
        //Muestra información detallada de errores
        //Manejador de excepciones
        //$this->withoutExceptionHandling();

        $this->from('usuarios/nuevo')->post('/usuarios/crear',[
            'name' => 'diegod',
            'email' => 'correo-no-valido',
            'password' => '123' 
        ])->assertRedirect('usuarios/nuevo')
          ->assertSessionHasErrors(['email']);

          // $this->assertDatabaseMissing('users',[
          //   'email' => 'correo@gmail.com',
          // ]);

          $this->assertEquals(0, User::count());
    }

    /**
    *
    * @test*/

    public function the_email_must_be_unique()
    {
        //Muestra información detallada de errores
        //Manejador de excepciones
        //$this->withoutExceptionHandling();

        factory(User::class)->create([
            'email' => 'diegod@gmail.com'
        ]);

        $this->from('usuarios/nuevo')->post('/usuarios/crear',[
            'name' => 'diegod',
            'email' => 'diegod@gmail.com',
            'password' => '123' 
        ])->assertRedirect('usuarios/nuevo')
          ->assertSessionHasErrors(['email']);

          // $this->assertDatabaseMissing('users',[
          //   'email' => 'correo@gmail.com',
          // ]);

          $this->assertEquals(1, User::count());
    }

    /**
    *
    * @test*/

    public function it_password_required_more_six()
    {
        //Muestra información detallada de errores
        //Manejador de excepciones
        //$this->withoutExceptionHandling();

        factory(User::class)->create([
            'email' => 'diegod@gmail.com'
        ]);

        $this->from('usuarios/nuevo')->post('/usuarios/crear',[
            'name' => 'diegod',
            'email' => 'diegod@gmail.com',
            'password' => '123' 
        ])->assertRedirect('usuarios/nuevo')
          ->assertSessionHasErrors(['email']);

          // $this->assertDatabaseMissing('users',[
          //   'email' => 'correo@gmail.com',
          // ]);

          $this->assertEquals(1, User::count());
    }



    /*TEST FOR UPDATE*/



    /**
    *
    * @test*/

    public function it_loads_the_edit_user_page()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->get("/usuarios/{$user->id}/editar") //usuari/5/editar
        ->assertStatus(200)
        ->assertViewIs('users.edit')
        ->assertSee('Editar Usuario')
        ->assertViewHas('user',function($viewUser) use ($user){
            return $viewUser->id == $user->id;
        });
    }

    /**
    *
    * @test*/

    public function it_update_a_new_user()
    {
        $user = factory(User::class)->create();

        $this->withoutExceptionHandling();

        $this->put("/usuarios/{$user->id}", [
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => '123456'
        ])->assertRedirect("/usuarios/{$user->id}");

        $this->assertCredentials([
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => '123456',
        ]);
    }

    /** @test */
    function the_name_is_required_when_updating_the_user()
    {
        $user = factory(User::class)->create();
        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => '',
                'email' => 'duilio@styde.net',
                'password' => '123456'
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['name']);
        $this->assertDatabaseMissing('users', ['email' => 'duilio@styde.net']);
    }
    /** @test */
    function the_email_must_be_valid_when_updating_the_user()
    {
        $user = factory(User::class)->create();
        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Duilio Palacios',
                'email' => 'correo-no-valido',
                'password' => '123456'
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email']);
        $this->assertDatabaseMissing('users', ['name' => 'Duilio Palacios']);
    }
    /** @test */
    function the_email_must_be_unique_when_updating_the_user()
    {
        //$this->withoutExceptionHandling();
        factory(User::class)->create([
            'email' => 'existing-email@example.com',
        ]);

        $user = factory(User::class)->create([
            'email' => 'duilio@styde.net'
        ]);

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Duilio',
                'email' => 'existing-email@example.com',
                'password' => '123456'
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email']);
        //
    }
    /** @test */
    function the_users_email_can_stay_the_same_when_updating_the_user()
    {
        $user = factory(User::class)->create([
            'email' => 'duilio@styde.net'
        ]);

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Duilio Palacios',
                'email' => 'duilio@styde.net',
                'password' => '12345678'
            ])
            ->assertRedirect("usuarios/{$user->id}"); // (users.show)

        $this->assertDatabaseHas('users', [
            'name' => 'Duilio Palacios',
            'email' => 'duilio@styde.net',
        ]);
    }
    /** @test */
    function the_password_is_optional_when_updating_the_user()
    {
        $oldPassword = 'CLAVE_ANTERIOR';

        $user = factory(User::class)->create([
            'password' => bcrypt($oldPassword)
        ]);

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Duilio',
                'email' => 'duilio@styde.net',
                'password' => ''
            ])
            ->assertRedirect("usuarios/{$user->id}"); // (users.show)

        $this->assertCredentials([
            'name' => 'Duilio',
            'email' => 'duilio@styde.net',
            'password' => $oldPassword // VERY IMPORTANT!
        ]);
    }

    function it_deletes_a_user(){

        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->delete("usuarios/{$user->id}")
            ->assertRedirect('usuarios');
            
        $this->assertDatabaseMissing('users', [
           'id' => $user->id
        ]);

        //$this->assertSame(0, User::count());
    }
}
