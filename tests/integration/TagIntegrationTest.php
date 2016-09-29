<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TagIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_have_many_libs()
    {
        $libs = factory(\App\Lib::class, 4)->create();
        $tag = factory(\App\Tag::class)->create();

        $libs->each(function ($lib) use ($tag){
            $lib->tag($tag);
        });

        $this->assertCount(4, $tag->libs);
    }
}
