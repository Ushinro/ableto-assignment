<?php

namespace Tests\Unit;

use App\Question;
use App\QuestionChoice;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class QuestionTest
 * @package Tests\Unit
 */
class QuestionTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Assert that question choices are stored in the database, are saved, and retrieved properly.
     *
     * @return void
     */
    public function testCreateQuestionChoicesForSingleQuestion()
    {
        $question = factory(Question::class)->create(['type' => 'radio']);
        $choice1 = factory(QuestionChoice::class)->create(['question_id' => $question->id]);
        $choice2 = factory(QuestionChoice::class)->create(['question_id' => $question->id]);
        $choice3 = factory(QuestionChoice::class)->create(['question_id' => $question->id]);

        $questionChoices = QuestionChoice::where('question_id', '=', $question->id)->get();

        $this->assertCount(3, $questionChoices);
    }

    /**
     * Assert that question choices are stored in the database, are saved, and retrieved properly.
     *
     * @return void
     */
    public function testCreateQuestionChoicesForMultipleQuestion()
    {
        $question1 = factory(Question::class)->create(['type' => 'radio']);
        $question1Choice1 = factory(QuestionChoice::class)->create(['question_id' => $question1->id]);
        $question1Choice2 = factory(QuestionChoice::class)->create(['question_id' => $question1->id]);
        $question1Choice3 = factory(QuestionChoice::class)->create(['question_id' => $question1->id]);

        $question2 = factory(Question::class)->create(['type' => 'checkbox']);
        $question2Choice1 = factory(QuestionChoice::class)->create(['question_id' => $question2->id]);
        $question2Choice2 = factory(QuestionChoice::class)->create(['question_id' => $question2->id]);
        $question2Choice3 = factory(QuestionChoice::class)->create(['question_id' => $question2->id]);
        $question2Choice4 = factory(QuestionChoice::class)->create(['question_id' => $question2->id]);

        $question1Choices = QuestionChoice::where('question_id', '=', $question1->id)->get();
        $question2Choices = QuestionChoice::where('question_id', '=', $question2->id)->get();

        $this->assertCount(3, $question1Choices);
        $this->assertCount(4, $question2Choices);
    }
}
