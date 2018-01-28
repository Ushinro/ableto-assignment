<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserAnswer extends Model
{
    /**
     * Get a list of the question texts and the user's associated answers for today.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function today()
    {
        return static::join('question_choices', 'question_choices.id', '=', 'user_answers.question_choice_id')
                     ->join('questions', 'questions.id', '=', 'question_choices.question_id')
                     ->select(
                         'questions.id AS question_id',
                         'questions.label AS question',
                         'question_choices.label AS answer'
                     )
                     ->where('user_answers.user_id', '=', \Auth::user()->id)
                     ->whereDate('user_answers.created_at', '=', Carbon::today())
                     ->get();
    }
}
