<?php

namespace Tests\Feature;

use App\Question;
use App\QuestionChoice;
use App\Questionnaire;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class WebRouteTest
 * @package Tests\Feature
 */
class WebRouteTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that an unauthenticated visitor is redirected (HTTP 302) to the login page.
     *
     * @return void
     */
    public function testUnauthenticatedHomePageTest()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test that an authenticated user accessing the home page has an HTTP 200 response code.
     *
     * @return void
     */
    public function testAuthenticatedHomePageTest()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($user);

        $response = $this->get('/');
        $response->assertStatus(302);
    }

    /**
     * Given two questions, save a user's choices to the questions to the database.
     *
     * Test that the submitted form is processed as valid.
     */
    public function testSaveValidAnswersTest()
    {
        $questionnaire = factory(Questionnaire::class)->create();

        $question1 = factory(Question::class)->create(['questionnaire_id' => $questionnaire->id]);
        $question1Option1 = factory(QuestionChoice::class)->create(['question_id' => $question1->id]);
        $question1Option2 = factory(QuestionChoice::class)->create(['question_id' => $question1->id]);

        $question2 = factory(Question::class)->create(['questionnaire_id' => $questionnaire->id]);
        $question2Option1 = factory(QuestionChoice::class)->create(['question_id' => $question2->id]);
        $question2Option2 = factory(QuestionChoice::class)->create(['question_id' => $question2->id]);
        $question2Option3 = factory(QuestionChoice::class)->create(['question_id' => $question2->id]);

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $data = [
            'questionnaire' => $questionnaire->id,
            'q' . $question1->id => $question1Option1->id,
            'q' . $question2->id => $question2Option3->id,
        ];

        $response = $this->post('/answers', $data);

        $response->assertStatus(302);
    }
}
