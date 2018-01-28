<?php

namespace Tests\Unit;

use App\Question;
use App\QuestionChoice;
use App\Questionnaire;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class QuestionnaireTest
 * @package Tests\Unit
 */
class QuestionnaireTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Create a questionnaire and assert that one is created in the database.
     *
     * @return void
     */
    public function testCreateQuestionnaireTest()
    {
        $questionnaire = factory(Questionnaire::class)->create();

        $this->assertDatabaseHas('questionnaires', [
            'id' => $questionnaire->id,
        ]);
    }

    /**
     * Create a questionnaire and assert that one is created in the database.
     *
     * @return void
     */
    public function testCreateMultipleQuestionnairesWithQuestionsTest()
    {
        $questionnaire1 = factory(Questionnaire::class)->create(['name' => 'Questionnaire 1']);
        $questionnaire1Question1 = factory(Question::class)->create(['questionnaire_id' => $questionnaire1->id]);
        $questionnaire1Question2 = factory(Question::class)->create(['questionnaire_id' => $questionnaire1->id]);
        $questionnaire1Question3 = factory(Question::class)->create(['questionnaire_id' => $questionnaire1->id]);

        $questionnaire2 = factory(Questionnaire::class)->create(['name' => 'Questionnaire 2']);
        $questionnaire2Question1 = factory(Question::class)->create(['questionnaire_id' => $questionnaire2->id]);
        $questionnaire2Question2 = factory(Question::class)->create(['questionnaire_id' => $questionnaire2->id]);
        $questionnaire2Question3 = factory(Question::class)->create(['questionnaire_id' => $questionnaire2->id]);
        $questionnaire2Question4 = factory(Question::class)->create(['questionnaire_id' => $questionnaire2->id]);

        $allTestQuestionnaires = Questionnaire::whereIn('id', [$questionnaire1->id, $questionnaire2->id])->get();
        $actualQuestionnaire1 = Questionnaire::questions($questionnaire1->id);
        $actualQuestionnaire2 = Questionnaire::questions($questionnaire2->id);

        $this->assertCount(2, $allTestQuestionnaires);
        $this->assertCount(3, $actualQuestionnaire1);
        $this->assertCount(4, $actualQuestionnaire2);
    }
}
