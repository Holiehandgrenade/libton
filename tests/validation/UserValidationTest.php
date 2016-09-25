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

    /** @test */
    public function a_welL_formatted_user_can_be_updated()
    {
        $this->patch('/users/' . $this->user->id, $this->userData)
            ->unsetPasswords();

        $this->seeInDatabase('users', $this->userData);
    }

    /** @test */
    public function first_name_is_required()
    {
        unset($this->userData['first_name']);

        $this->patch('/users/' . $this->user->id, $this->userData)
            ->unsetPasswords();

        $this->notSeeInDatabase('users', $this->userData);
    }

    /** @test */
    public function first_name_has_max_of_255_chars()
    {
        $this->userData['first_name'] = str_repeat('A', 256);

        $this->patch('/users/' . $this->user->id, $this->userData)
            ->unsetPasswords();

        $this->notSeeInDatabase('users', $this->userData);
    }

    /** @test */
    public function last_name_is_required()
    {
        unset($this->userData['last_name']);

        $this->patch('/users/' . $this->user->id, $this->userData)
            ->unsetPasswords();

        $this->notSeeInDatabase('users', $this->userData);
    }

    /** @test */
    public function last_name_has_max_of_255_chars()
    {
        $this->userData['last_name'] = str_repeat('A', 256);

        $this->patch('/users/' . $this->user->id, $this->userData)
            ->unsetPasswords();

        $this->notSeeInDatabase('users', $this->userData);
    }

    /** @test */
    public function email_is_required()
    {
        unset($this->userData['email']);

        $this->patch('/users/' . $this->user->id, $this->userData)
            ->unsetPasswords();

        $this->notSeeInDatabase('users', $this->userData);
    }

    /** @test */
    public function email_must_be_email()
    {
        $this->userData['email'] = 'asfdsafasdf';

        $this->patch('/users/' . $this->user->id, $this->userData)
            ->unsetPasswords();

        $this->notSeeInDatabase('users', $this->userData);
    }

    /** @test */
    public function email_has_max_of_255_chars()
    {
        $this->userData['email'] = str_repeat('A', 256);

        $this->patch('/users/' . $this->user->id, $this->userData)
            ->unsetPasswords();

        $this->notSeeInDatabase('users', $this->userData);
    }

    /** @test */
    public function email_must_be_unique_on_users_table()
    {
        factory(\App\User::class)->create([
            'email' => 'not@unique.com',
        ]);

        $this->userData['email'] = 'not@unique.com';

        $this->patch('/users/' . $this->user->id, $this->userData)
            ->unsetPasswords();

        $this->notSeeInDatabase('users', $this->userData);
    }

    /** @test */
    public function password_and_confirmation_are_not_required()
    {

        $this->unsetPasswords()
            ->patch('/users/' . $this->user->id, $this->userData);

        $this->seeInDatabase('users', $this->userData);
    }
    
    /** @test */
    public function password_must_be_confirmed()
    {
        $this->userData['password_confirmation'] = 'wronggggg';
        $this->patch('/users/' . $this->user->id, $this->userData)
            ->unsetPasswords();

        $this->notSeeInDatabase('users', $this->userData);
    }

    protected function unsetPasswords()
    {
        unset($this->userData['password']);
        unset($this->userData['password_confirmation']);
        return $this;
    }
}
