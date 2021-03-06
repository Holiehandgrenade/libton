<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAcceptanceTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
        $this->be($this->user);
    }

    /** @test */
    public function a_user_can_see_their_info_on_edit_page()
    {
        $this->visit('/my/account')
            ->see($this->user->first_name)
            ->see($this->user->last_name)
            ->see($this->user->email);
    }

    /** @test */
    public function a_user_can_update_their_info()
    {
        $this->visit('/my/account')
            ->type('New', 'first_name')
            ->type('Name', 'last_name')
            ->type('a@b.com', 'email')
            ->type('asdfghjkl', 'password')
            ->type('asdfghjkl', 'password_confirmation')
            ->press('Save Changes');

        $this->seeInDatabase('users', [
            'first_name' => 'New',
            'last_name' => 'Name',
            'email' => 'a@b.com',
        ]);
    }

    /** @test */
    public function a_user_can_see_all_of_the_libs_they_created()
    {
        $libOne = factory(\App\Lib::class)->make();
        $libTwo = factory(\App\Lib::class)->make();

        $this->user->write($libOne);
        $this->user->write($libTwo);

        $this->visit('/my/libs');

        $this->see($libOne->title);
        $this->see($libTwo->title);
    }

    /** @test */
    public function a_user_can_only_see_their_libs_on_the_my_libs_route()
    {
        $otherUser = factory(\App\User::class)->create();

        $libOne = factory(\App\Lib::class)->make();
        $libTwo = factory(\App\Lib::class)->make();

        $this->user->write($libOne);
        $otherUser->write($libTwo);

        $this->visit('/my/libs');

        $this->see($libOne->title);
        $this->dontSee($libTwo->title);
    }
}
