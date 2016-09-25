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
        $this->post('/register', $this->userData)
            ->unsetPassword();

        $this->seeInDatabase('users', $this->userData);
    }

    /** @test */
    public function first_name_is_required()
    {
        unset($this->userData['first_name']);
        $this->postDontSeeInDatabase();
    }

    /** @test */
    public function first_name_has_a_max_of_255_chars()
    {
        $this->userData['first_name'] = str_repeat('A', 256);
        $this->postDontSeeInDatabase();
    }

    /** @test */
    public function last_name_is_required()
    {
        unset($this->userData['last_name']);
        $this->postDontSeeInDatabase();
    }

    /** @test */
    public function last_name_has_a_max_of_255_chars()
    {
        $this->userData['last_name'] = str_repeat('A', 256);
        $this->postDontSeeInDatabase();
    }

    /** @test */
    public function email_is_required()
    {
        unset($this->userData['email']);
        $this->postDontSeeInDatabase();
    }

    /** @test */
    public function email_has_a_max_of_255_chars()
    {
        $this->userData['email'] = str_repeat('A', 256);
        $this->postDontSeeInDatabase();
    }

    /** @test */
    public function email_must_be_of_type_email()
    {
        $this->userData['email'] = 'asdfsdafadsfasdf';
        $this->postDontSeeInDatabase();
    }

    /** @test */
    public function email_must_be_unique_on_users_table()
    {
        factory(\App\User::class)->create([
            'email' => 'not@unique.com',
        ]);
        $this->userData['email'] = 'not@unique.com';
        $this->postDontSeeInDatabase();
    }

    /** @test */
    public function password_is_required()
    {
        unset($this->userData['password']);
        $this->postDontSeeInDatabase();
    }

    /** @test */
    public function password_must_be_minimum_6_chars()
    {
        $this->userData['password'] = 'AA';
        $this->userData['password_confirmation'] = 'AA';
        $this->postDontSeeInDatabase();
    }

    /** @test */
    public function password_must_be_confirmed()
    {
        $this->userData['password_confirmation'] = 'something_else';
        $this->postDontSeeInDatabase();
    }


    // Helpers

    protected function unsetPassword()
    {
        unset($this->userData['password']);
        unset($this->userData['password_confirmation']);
        return $this;
    }

    protected function postDontSeeInDatabase()
    {
        $this->post('/register', $this->userData)
            ->unsetPassword();

        $this->notSeeInDatabase('users', $this->userData);
    }
}
