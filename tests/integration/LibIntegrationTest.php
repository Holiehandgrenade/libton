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

    /** @test */
    public function it_can_have_many_tags()
    {
        $lib = factory(\App\Lib::class)->create();
        $tags = factory(\App\Tag::class, 4)->create();

        $tags->each(function ($tag) use($lib) {
            $lib->tag($tag);
        });

        $this->assertCount(4, $lib->tags);
    }
}
