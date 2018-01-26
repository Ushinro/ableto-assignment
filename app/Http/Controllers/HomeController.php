<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionOption;
use App\UserAnswer;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();

        $unsortedQuestionOptions = QuestionOption::all();
        $questionOptions = [];
        foreach ($unsortedQuestionOptions as $questionOption) {
            $questionOptions[$questionOption->question_id][] = $questionOption;
        }

        return view('home', compact('questions', 'questionOptions'));
    }

    /**
     * Show a list of the questions and answers the user answered today.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reviewToday()
    {
        $userAnswers = UserAnswer::today();

        return view('review', compact('userAnswers'));
    }

    /**
     * Save the answers to the logged-in user's survey.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveSurvey()
    {
        $questionIds = Question::select('id')->get();

        foreach ($questionIds as $questionId) {
            $userAnswer = new UserAnswer();
            $userAnswer->user_id = \Auth::user()->id;
            $userAnswer->question_option_id = request('q' . $questionId->id);
            $userAnswer->save();
        }

        return redirect('/review');
    }
}
