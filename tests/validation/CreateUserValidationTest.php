<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateUserValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected $userData;

    public function setUp()
    {
        parent::setUp();

        $this->userData = [
            'first_name' => 'Mr',
            'last_name' => 'Robot',
            'email' => 'sam@esmail.com',
            'password' => 'asdfghjkl',
            'password_confirmation' => 'asdfghjkl',
        ];
    }

    /** @test */
    public function a_well_formatted_user_can_be_created()
    {
        $this->post('/register', $this->userData);

        unset($this->userData['password']);
        unset($this->userData['password_confirmation']);

        $this->seeInDatabase('users', $this->userData);
    }

    
}
