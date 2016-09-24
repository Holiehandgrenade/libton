<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LibValidationTest extends TestCase
{
    use DatabaseTransactions;

    protected $user, $libData, $lib;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
        $this->be($this->user);

        $this->libData = [
            'title' => 'The Little Engine that Could',
            'body' => 'One time there was an engine. And oh boy could he.',
        ];
    }

    /** @test */
    public function a_well_formatted_lib_can_be_created()
    {
        $this->post('/libs', $this->libData)
            ->seeInDatabase('libs', $this->libData);
    }

    /** @test */
    public function a_title_is_required()
    {
        unset($this->libData['title']);

        $this->post('/libs', $this->libData)
            ->notSeeInDatabase('libs', $this->libData);
    }

    /** @test */
    public function a_body_is_required()
    {
        unset($this->libData['body']);

        $this->post('/libs', $this->libData)
            ->notSeeInDatabase('libs', $this->libData);
    }



    /******** Updating ********/

    /** @test */
    public function when_updating_a_well_formatted_lib_can_be_created()
    {
        $lib = factory(\App\Lib::class)->make($this->libData);
        $this->user->write($lib);

        $newData = [
            'title' => 'New Title',
            'body' => 'New body mate',
        ];

        $this->patch("libs/$lib->id", $newData)
            ->seeInDatabase('libs', $newData);
    }
}
