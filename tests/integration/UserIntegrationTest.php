<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_have_many_libs()
    {
        $user = factory(\App\User::class)->create();
        $libOne = factory(\App\Lib::class)->make();
        $libTwo = factory(\App\Lib::class)->make();

        $user->write($libOne);
        $user->write($libTwo);

        $this->assertCount(2, $user->libs);
    }

    /** @test */
    public function it_can_play_a_lib()
    {
        $user = factory(\App\User::class)->create();
        $lib = factory(\App\Lib::class)->create();

        $user->play($lib);

        $this->assertEquals($user->id, \App\Play::first()->user_id);
        $this->assertEquals($lib->id, \App\Play::first()->lib_id);
    }
}
