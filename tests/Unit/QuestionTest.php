<?php

namespace Tests\Unit;

use App\Question;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class QuestionChoiceTest
 * @package Tests\Unit
 */
class QuestionChoiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Assert that questions stored in the database are saved and retrieved properly.
     *
     * @return void
     */
    public function testCreateQuestionsWithSingleTypeTest()
    {
        $first = factory(Question::class)->create(['type' => 'radio']);
        $second = factory(Question::class)->create(['type' => 'radio']);
        $third = factory(Question::class)->create(['type' => 'radio']);
        $fourth = factory(Question::class)->create(['type' => 'radio']);

        $savedQuestions = Question::where('type', '=', 'radio')
                                  ->whereIn(
                                      'id',
                                      [
                                          $first->id,
                                          $second->id,
                                          $third->id,
                                          $fourth->id,
                                      ]
                                  )
                                  ->get();

        $this->assertCount(4, $savedQuestions);
    }
}
