<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LibAcceptanceTest extends TestCase
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
    public function all_libs_can_be_shown()
    {
        factory(\App\Lib::class, 4)->create();

        $this->visit('/libs')
            ->countElements('.lib-links', 4);
    }

    /** @test */
    public function the_show_page_can_be_accessed_via_index()
    {
        $libs = factory(\App\Lib::class, 4)->create();
        $lib = $libs[0];

        $this->visit('libs')
            ->click("#view-lib-$lib->id");

        $this->seePageIs("/libs/$lib->id");
    }

    /** @test */
    public function the_show_page_formats_blanks_as_underlined_words()
    {

        $libBody = "Here is another {%lib:noun%}!";
        $lib = factory(\App\Lib::class)->create(['body' => $libBody]);

        $this->visit("/libs/$lib->id")
            ->countElements('span[style="text-decoration: underline"]', 1);
    }

    // vue component breaks this submission

//    /** @test */
//    public function a_user_can_submit_a_lib()
//    {
//        $this->visit('/libs/create')
//            ->type('My First Lib', 'title')
//            ->type('This is a {%game:noun%}', 'body')
//            ->press('Create Lib');
//
//        $this->seeInDatabase('libs', ['title' => 'My First Lib'])
//            ->seePageIs('/libs');
//    }

    /** @test */
    public function the_update_page_can_be_accessed_from_the_show_page()
    {
        $lib = factory(\App\Lib::class)->make();
        $this->user->write($lib);

        $this->visit("/libs/$lib->id")
            ->click('Edit Lib');

        $this->seePageIs("/libs/$lib->id/edit");
    }

    /** @test */
    public function the_edit_page_is_populated_with_lib_data()
    {
        $lib = factory(\App\Lib::class)->make();
        $this->user->write($lib);

        $this->visit("/libs/$lib->id/edit");

        $this->see($lib->title)
            ->see($lib->body);
    }

    /** @test */
    public function the_edit_button_shows_up_for_the_libs_writer()
    {
        $lib = factory(\App\Lib::class)->make();
        $this->user->write($lib);

        $this->visit("/libs/$lib->id")
            ->see('Edit Lib');
    }

    /** @test */
    public function the_edit_button_only_shows_up_for_the_libs_writer()
    {
        $lib = factory(\App\Lib::class)->make();
        $this->user->write($lib);
        $this->be(factory(\App\User::class)->create());

        $this->visit("/libs/$lib->id")
            ->dontSee('Edit Lib');
    }

    /** @test */
    public function it_can_be_updated()
    {
        $lib = factory(\App\Lib::class)->make();
        $this->user->write($lib);

        $this->visit("/libs/$lib->id/edit")
            ->type('A New Title', 'title')
            ->type('A new paragraph', 'body')
            ->press('Update Lib');

        $this->seeInDatabase('libs', [
            'title' => 'A New Title',
            'body' => 'A new paragraph',
        ])
            ->seePageIs("/libs/$lib->id");
    }

    /** @test */
    public function it_can_be_deleted_from_the_show_page()
    {
        $lib = factory(\App\Lib::class)->make();
        $this->user->write($lib);

        $this->visit("/libs/$lib->id")
            ->press('Delete Lib');

        $this->notSeeInDatabase('libs', ['id' => $lib->id])
            ->seePageIs('/libs');
    }

    /** @test */
    public function the_delete_button_can_be_seen_by_the_libs_writer()
    {
        $lib = factory(\App\Lib::class)->make();
        $this->user->write($lib);

        $this->visit("/libs/$lib->id")
            ->countElements('input[type="submit"]', 1);
    }

    /** @test */
    public function the_delete_button_can_only_be_seen_by_the_libs_writer()
    {
        $lib = factory(\App\Lib::class)->make();
        $this->user->write($lib);
        $this->be(factory(\App\User::class)->create());

        $this->visit("/libs/$lib->id")
            ->countElements('input[type="submit"]', 0);
    }

    /** @test */
    public function it_can_be_played_from_the_show_page()
    {
        $lib = factory(\App\Lib::class)->make();
        $this->user->write($lib);

        $this->visit("/libs/$lib->id")
            ->click('Play this lib!');

        $this->seePageIs("/libs/$lib->id/play");
    }

    /** @test */
    public function the_play_page_has_an_input_for_every_blank_entered_into_the_libs_body()
    {
        $libBody = "This is such a {%fun:adjective%} day! I can't {%believe:verb%} what we are doing!";
        $lib = factory(\App\Lib::class)->make(['body' => $libBody]);
        $this->user->write($lib);

        $this->visit("/libs/$lib->id/play")
            ->countElements('.lib-input', 2);
    }

    /** @test */
    public function the_inputs_have_placeholders_matching_their_parts_of_speech()
    {
        $libBody = "This is such a {%fun:adjective%} day! I can't {%believe:verb%} what we are doing!";
        $lib = factory(\App\Lib::class)->make(['body' => $libBody]);
        $this->user->write($lib);

        $this->visit("/libs/$lib->id/play")
            ->countElements('input[placeholder="adjective"]', 1)
            ->countElements('input[placeholder="verb"]', 1);
    }

    /** @test */
    public function parts_of_speech_can_have_spaces()
    {
        $libBody = "I have many {%things:plural noun%}";
        $lib = factory(\App\Lib::class)->make(['body' => $libBody]);
        $this->user->write($lib);

        $this->visit("/libs/$lib->id/play")
            ->countElements('input[placeholder="plural noun"]', 1);
    }
}
