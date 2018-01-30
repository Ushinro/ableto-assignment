<?php

namespace App\Http\Controllers;
use App\Question;
use App\Questionnaire;
use App\UserAnswer;

/**
 * Class QuestionnaireController
 * @package App\Http\Controllers
 */
class QuestionnaireController extends Controller
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
     * Show a list of the questions and answers the user answered today.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reviewToday()
    {
        $unfilteredUserAnswers = UserAnswer::today();
        $userAnswers = [];
        foreach ($unfilteredUserAnswers as $userAnswer) {
            $userAnswers[$userAnswer->created_at->format('F j, Y, g:i:s a')][$userAnswer->question_id][] = $userAnswer;
        }

        return view('review', compact('userAnswers'));
    }

    /**
     * Save the answers to the questionnaire.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save()
    {
        $questionnaire = Questionnaire::find(request('questionnaire'));
        $questions = Question::where('questionnaire_id', '=', $questionnaire->id)
                             ->get();

        $requiredQuestionsToValidate = [];
        foreach ($questions as $question) {
            if ($question->required) {
                $requiredQuestionsToValidate['q' . $question->id] = 'required';
            }
        }
        $this->validate(request(), $requiredQuestionsToValidate);

        foreach ($questions as $question) {
            $formAnswer = request('q' . $question->id);

            if (!is_null($formAnswer)) {
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
        }

        session()->flash(
            'status',
            'Questionnaire "' . $questionnaire->name . '" has been successfully saved'
        );

        return redirect('answers');
    }
}
