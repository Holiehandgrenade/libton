<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAuthorizationTest extends TestCase
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
        ];
    }

    /** @test */
    public function a_user_may_update_itself()
    {
        $this->patch('/users/' . $this->user->id, $this->userData);

        $this->seeInDatabase('users', $this->userData);
    }

    /** @test */
    public function a_user_may_not_update_another_user()
    {
        $otherUser = factory(\App\User::class)->create();

        $this->patch('/users/' . $otherUser->id, $this->userData);

        $this->notSeeInDatabase('users', $this->userData);
    }

    /** @test */
    public function a_user_may_destroy_itself()
    {
        $this->delete('/users/' . $this->user->id);

        $this->notSeeInDatabase('users', $this->user['attributes']);
    }

    /** @test */
    public function a_user_may_not_destroy_another_user()
    {
        $otherUser = factory(\App\User::class)->create();

        $this->delete('/users/' . $otherUser->id);

        $this->seeInDatabase('users', $otherUser['attributes']);
    }
}
