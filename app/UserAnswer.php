<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class UserAnswer
 * @package App
 */
class UserAnswer extends Model
{
    /**
     * Get a list of the question texts and the user's associated answers for today.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function today()
    {
        return static::join('question_choices AS qc', 'qc.id', '=', 'user_answers.question_choice_id')
                     ->join('questions AS q', 'q.id', '=', 'qc.question_id')
                     ->select(
                         'q.id AS question_id',
                         'q.label AS question',
                         'qc.id AS input_value',
                         'qc.label AS answer',
                         'user_answers.id AS user_answer_id',
                         'user_answers.created_at'
                     )
                     ->where('user_answers.user_id', '=', \Auth::user()->id)
                     ->whereDate('user_answers.created_at', '=', Carbon::today())
                     ->orderBy('user_answers.created_at', 'DESC')
                     ->get();
    }
}
