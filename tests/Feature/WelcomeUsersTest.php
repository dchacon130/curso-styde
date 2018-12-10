<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeUsersTest extends TestCase
{
    /**
    *
    * @test*/

    public function it_welcomes_users_with_nickname()
    {
    	$this->get('/saludo/Diego/DieGod')
    	->assertStatus(200)
    	->assertSee('Bienvenido Diego, tu apodo es: DieGod');
    }

    /**
    *
    * @test*/

    public function it_welcomes_users_without_nickname()
    {
    	$this->get('/saludo/Diego/')
    	->assertStatus(200)
    	->assertSee('Bienvenido Diego');
    }
}
