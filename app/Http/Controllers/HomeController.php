<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionOption;

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
}
