<?php

namespace App\Http\Controllers;
use App\Question;
use App\Questionnaire;
use App\UserAnswer;
use Carbon\Carbon;

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
            $userAnswers[$userAnswer->question_id][] = $userAnswer;
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

        $todaysAnswers = UserAnswer::today();
        $today = Carbon::today();
        if (count($todaysAnswers) > 0) {
            $today = $todaysAnswers[0]->created_at;
        }

        // HACK: Purge the records to "update" the existing submission.
        // This hack is here because the database relationships between tables was not well-thought-out
        // and it has become difficult to fetch existing submissions.
        foreach ($todaysAnswers as $answer) {
            try {
                $answer->destroy($answer->user_answer_id);
            } catch (\Exception $e) {
                continue;
            }
        }

        foreach ($questions as $question) {
            $formAnswer = request('q' . $question->id);

            if (!is_null($formAnswer)) {
                if ($question->type == 'checkbox') {
                    foreach ($formAnswer as $answer) {
                        $userAnswer = new UserAnswer();
                        $userAnswer->user_id = \Auth::user()->id;
                        $userAnswer->question_choice_id = $answer;
                        $userAnswer->created_at = $today;
                        $userAnswer->save();
                    }
                } else {
                    $userAnswer = new UserAnswer();
                    $userAnswer->user_id = \Auth::user()->id;
                    $userAnswer->question_choice_id = $formAnswer;
                    $userAnswer->created_at = $today;
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
