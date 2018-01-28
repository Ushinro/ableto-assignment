<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    /**
     * Get a list of the question texts and the user's associated answers for today.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function questions()
    {
        return static::join('questions', 'questions.questionnaire_id', '=', 'questionnaires.id')
                     ->join('question_choices', 'question_choices.question_id', '=', 'questions.id')
                     ->select(
                         'questionnaires.id AS questionnaire_id',
                         'questionnaires.name AS questionnaire_name',
                         'questions.id AS question_id',
                         'questions.label AS question'
                     )
                     ->get();
    }
}
