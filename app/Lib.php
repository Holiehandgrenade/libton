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

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function tag(Tag $tag)
    {
        return $this->tags()->save($tag);
    }

    public function format($method)
    {
        $matches = $this->findMarkupMatches();

        foreach ($matches as $match) {
            // makes the matched markup into regex pattern
            $match = $this->turnMatchIntoPattern($match);

            // gets part of speech from the markup between : and }}
            $part_of_speech = $this->getMarkupPartOfSpeech($match);

            if($method == 'show') {
                $this->replaceMarkupWithUnderlinedWords($match, $part_of_speech);
                continue;
            }

            $this->replaceMarkupWithInput($match, $part_of_speech);
        }
    }

    /**
     * @param $match
     */
    protected function replaceMarkupWithUnderlinedWords($match, $part_of_speech)
    {
        // creates input replacement
        $replacement = "<span style='text-decoration: underline'>$part_of_speech</span>";

        // replaces matches with replacement input
        $this->body = preg_replace($match, $replacement, $this->body);
    }

    /**
     * @param $match
     */
    protected function replaceMarkupWithInput($match, $part_of_speech)
    {
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

        $pattern = "/{%[\w]+:[A-z\s]+%}/";
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
        preg_match('/(?<=:)(.*)(?=%})/', $match, $part_of_speech);
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
