<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LibTagControllerUnitTest extends TestCase
{
    use DatabaseTransactions;

    // actually, make this into a vue component
//    /** @test */
//    public function a_tag_can_be_associated_with_a_lib()
//    {
//        $user = factory(\App\User::class)->create();
//        $lib = factory(\App\Lib::class)->make();
//        $user->write($lib);
//        $this->be($user);
//
//        factory(\App\Tag::class, 3)->create();
//
//        $this->post("libs/$lib->id/tags", [1, 2, 3]);
//
//        $this->assertCount(3, $lib->tags);
    }
}
