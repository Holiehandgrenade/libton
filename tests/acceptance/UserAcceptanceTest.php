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
}
