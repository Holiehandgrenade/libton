<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LibIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_belong_to_a_user()
    {
        $user = factory(\App\User::class)->create();
        $lib = factory(\App\Lib::class)->make();

        $user->write($lib);

        $this->assertEquals($user->id, $lib->user->id);
    }
}
