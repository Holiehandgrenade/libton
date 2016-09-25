<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected $user, $userData;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
        $this->be($this->user);

        $this->userData = [
            'first_name' => 'Mr',
            'last_name' => 'Robot',
            'email' => 'sam@esmail.com',
            'password' => 'asdfghjkl',
            'confirm_password' => 'asdfghjkl',
        ];
    }

    /** @test */
    public function a_welL_formatted_user_can_be_updated()
    {
        $this->patch('/users/' . $this->user->id, $this->userData);

        unset($this->userData['password']);
        unset($this->userData['confirm_password']);

        $this->seeInDatabase('users', $this->userData);
    }
}
