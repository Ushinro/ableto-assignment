<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionChoice;
use App\Questionnaire;
use App\UserAnswer;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the questionnaires.
     *
     * TODO: Reduce the number of DB calls from 3 tables:
     *       questionnaires
     *       questions
     *       question_choices.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questionnaires = Questionnaire::all();
        $questions = Question::all();
        $unsortedQuestionChoices = QuestionChoice::all();

        $questionChoices = [];
        foreach ($questionnaires as $questionnaire) {
            foreach ($unsortedQuestionChoices as $questionChoice) {
                $questionChoices[$questionnaire->id][$questionChoice->question_id][] = $questionChoice;
            }
        }

        return view(
            'home',
            compact(
                'questionnaires',
                'questions',
                'questionChoices'
            )
        );
    }
}
