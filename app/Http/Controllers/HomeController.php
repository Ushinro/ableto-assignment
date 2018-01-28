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
     * Show the questionnaire.
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

    /**
     * Show a list of the questions and answers the user answered today.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reviewToday()
    {
        $unfilteredUserAnswers = UserAnswer::today();
        $userAnswers = [];
        foreach ($unfilteredUserAnswers as $userAnswer) {
            $userAnswers[$userAnswer->question_id][] = $userAnswer;
        }

        return view('review', compact('userAnswers'));
    }

    /**
     * Save the answers to the logged-in user's survey.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveSurvey()
    {
        $questions = Question::where('questionnaire_id', '=', request('questionnaire'))
                             ->get();

        foreach ($questions as $question) {
            $formAnswer = request('q' . $question->id);

            if ($question->type == 'checkbox') {
                foreach ($formAnswer as $answer) {
                    $userAnswer = new UserAnswer();
                    $userAnswer->user_id = \Auth::user()->id;
                    $userAnswer->question_choice_id = $answer;
                    $userAnswer->save();
                }
            } else {
                $userAnswer = new UserAnswer();
                $userAnswer->user_id = \Auth::user()->id;
                $userAnswer->question_choice_id = $formAnswer;
                $userAnswer->save();
            }
        }

        return redirect('answers');
    }
}
