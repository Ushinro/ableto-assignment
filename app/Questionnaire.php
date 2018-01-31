<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Questionnaire
 * @package App
 */
class Questionnaire extends Model
{
    /**
     * Get a list of the questions and the associated question choices for all questionnaires.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function allQuestionsAndChoices()
    {
        return static::join('questions AS q', 'q.questionnaire_id', '=', 'questionnaires.id')
                     ->join('question_choices AS qc', 'qc.question_id', '=', 'q.id')
                     ->select(
                         'questionnaires.id AS questionnaire_id',
                         'questionnaires.name AS questionnaire_name',
                         'q.id AS question_id',
                         'q.label AS question',
                         'qc.id AS choice_value',
                         'qc.label AS choice_label'
                     )
                     ->get();
    }

    /**
     * Get a list of the questions and the associated question choices for the given questionnaire ID.
     *
     * @param int $questionnaireId
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function questions($questionnaireId)
    {
        return static::join('questions AS q', 'q.questionnaire_id', '=', 'questionnaires.id')
                     ->select(
                         'questionnaires.id AS questionnaire_id',
                         'questionnaires.name AS questionnaire_name',
                         'q.id AS question_id',
                         'q.label AS question'
                     )
                     ->where('questionnaires.id', '=', $questionnaireId)
                     ->get();
    }
}
