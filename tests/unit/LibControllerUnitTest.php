<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LibControllerUnitTest extends TestCase
{
    use DatabaseTransactions;
    
    /** @test */
    public function it_can_create_a_lib()
    {
        $user = factory(\App\User::class)->create();
        $lib = factory(\App\Lib::class)->make();
        $this->be($user);

        $this->post('libs', $lib['attributes']);

        $this->assertResponseStatus(302);
    }
}