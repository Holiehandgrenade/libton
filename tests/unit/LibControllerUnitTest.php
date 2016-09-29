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

    /** @test */
    public function a_lib_can_be_tagged_with_one_tag()
    {
        $lib = factory(\App\Lib::class)->create();
        $tag = factory(\App\Tag::class)->create();

        $lib->tag($tag);

        $this->assertCount(1, $lib->tags);
        $this->assertEquals($tag->id, $lib->tags->first()->id);
    }

    /** @test */
    public function a_lib_can_be_tagged_with_many_tags()
    {
        $lib = factory(\App\Lib::class)->create();
        $tags = factory(\App\Tag::class, 4)->create();

        $lib->tag($tags);

        $this->assertCount(4, $lib->tags);
    }
}