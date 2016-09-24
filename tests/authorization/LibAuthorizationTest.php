<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LibAuthorizationTest extends TestCase
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
    public function a_lib_can_be_updated_by_its_creator()
    {
        $lib = factory(\App\Lib::class)->make();
        $this->user->write($lib);

        $newData = [
            'title' => 'New Title',
            'body' => 'New Body',
        ];

        $this->patch("/libs/$lib->id", $newData)
            ->seeInDatabase('libs', $newData);
    }

    /** @test */
    public function a_lib_cannot_be_updated_by_a_user_other_than_its_creator()
    {
        $lib = factory(\App\Lib::class)->make();
        $this->user->write($lib);

        $newUser = factory(\App\User::class)->create();
        $this->be($newUser);

        $newData = [
            'title' => 'New Title',
            'body' => 'New Body',
        ];

        $this->patch("/libs/$lib->id", $newData)
            ->notSeeInDatabase('libs', $newData);
    }

    /** @test */
    public function a_lib_can_be_deleted_by_its_creator()
    {
        $lib = factory(\App\Lib::class)->make();
        $this->user->write($lib);

        $this->delete("/libs/$lib->id")
            ->notSeeInDatabase('libs', $lib['attributes']);
    }

    /** @test */
    public function a_lib_cannot_be_deleted_by_a_user_other_than_its_creator()
    {
        $lib = factory(\App\Lib::class)->make();
        $this->user->write($lib);

        $newUser = factory(\App\User::class)->create();
        $this->be($newUser);

        $this->delete("/libs/$lib->id")
            ->seeInDatabase('libs', $lib['attributes']);
    }
}

