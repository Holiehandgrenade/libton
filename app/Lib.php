<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lib extends Model
{
    protected $fillable = ['title', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formatForPlay()
    {
        $matches = $this->findMarkupMatches();

        foreach ($matches as $match) {
            $this->replaceMarkupWithInput($match);
        }

        return $this;
    }

    /**
     * @param $match
     */
    protected function replaceMarkupWithInput($match)
    {
        // makes the matched markup into regex pattern
        $match = $this->turnMatchIntoPattern($match);

        // gets part of speech from the markup between : and }}
        $part_of_speech = $this->getMarkupPartOfSpeech($match);

        // creates input replacement
        $replacement = "<input class='lib-input' placeholder='$part_of_speech'>";

        // replaces matches with replacement input
        $this->body = preg_replace($match, $replacement, $this->body);
    }

    /**
     * @return mixed
     */
    protected function findMarkupMatches()
    {
        // example markup: {{word:part_of_speech}}
        $pattern = "/{{[a-zA-Z]+:[a-zA-Z]+}}/";
        preg_match_all($pattern, $this->body, $matches);

        return $matches[0];
    }

    /**
     * @param $match
     * @return mixed
     */
    protected function getMarkupPartOfSpeech($match)
    {
        // extracts the word between markup : and }}
        preg_match('/(?<=:)(.*)(?=}})/', $match, $part_of_speech);
        return $part_of_speech[0];
    }

    /**
     * @param $match
     * @return string
     */
    protected function turnMatchIntoPattern($match)
    {
        return "/" . $match . "/";
    }
}
