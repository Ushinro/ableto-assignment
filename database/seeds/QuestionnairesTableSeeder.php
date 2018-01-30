<?php

use Illuminate\Database\Seeder;
use App\Question;
use App\QuestionChoice;
use App\Questionnaire;

/**
 * Class QuestionnairesTableSeeder
 */
class QuestionnairesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questionnaire = factory(Questionnaire::class)->create([
            'name' => 'AbleTo Behavioral Questionnaire'
        ]);

        $question1 = factory(Question::class)->create([
            'questionnaire_id' => $questionnaire->id,
            'label' => 'How are you feeling today?',
            'type' => 'radio',
        ]);
        $question2 = factory(Question::class)->create([
            'questionnaire_id' => $questionnaire->id,
            'label' => 'How many hours of sleep did you have last night?',
            'type' => 'radio',
        ]);
        $question3 = factory(Question::class)->create([
            'questionnaire_id' => $questionnaire->id,
            'label' => 'What genres of books do you enjoy reading?',
            'type' => 'checkbox',
            'required' => false,
        ]);
        $question4 = factory(Question::class)->create([
            'questionnaire_id' => $questionnaire->id,
            'label' => 'What will you do today?',
            'type' => 'checkbox',
            'required' => false,
        ]);

        // Probably not ideal to also insert choices in the same seeder.
        // However, this does save on a few DB calls,
        // since we will have the question ID to meet the question_id foreign key constraint.
        $question1Choice1 = factory(QuestionChoice::class)->create([
            'question_id' => $question1->id,
            'label' => 'Terrible',
            'value' => '-2',
        ]);
        $question1Choice2 = factory(QuestionChoice::class)->create([
            'question_id' => $question1->id,
            'label' => 'Not so good',
            'value' => '-1',
        ]);
        $question1Choice3 = factory(QuestionChoice::class)->create([
            'question_id' => $question1->id,
            'label' => 'Okay — not good, not bad',
            'value' => '0',
        ]);
        $question1Choice4 = factory(QuestionChoice::class)->create([
            'question_id' => $question1->id,
            'label' => 'Pretty good',
            'value' => '1',
        ]);
        $question1Choice5 = factory(QuestionChoice::class)->create([
            'question_id' => $question1->id,
            'label' => 'Excellent',
            'value' => '2',
        ]);

        $question2Choice1 = factory(QuestionChoice::class)->create([
            'question_id' => $question2->id,
            'label' => 'Less than 6',
            'value' => '5',
        ]);
        $question2Choice2 = factory(QuestionChoice::class)->create([
            'question_id' => $question2->id,
            'label' => '6',
            'value' => '6',
        ]);
        $question2Choice3 = factory(QuestionChoice::class)->create([
            'question_id' => $question2->id,
            'label' => '7',
            'value' => '7',
        ]);
        $question2Choice3 = factory(QuestionChoice::class)->create([
            'question_id' => $question2->id,
            'label' => '8',
            'value' => '8',
        ]);
        $question2Choice3 = factory(QuestionChoice::class)->create([
            'question_id' => $question2->id,
            'label' => 'Greater than 8',
            'value' => '9',
        ]);

        $question3Choice1 = factory(QuestionChoice::class)->create([
            'question_id' => $question3->id,
            'label' => 'Fiction',
            'value' => 'fiction',
        ]);
        $question3Choice2 = factory(QuestionChoice::class)->create([
            'question_id' => $question3->id,
            'label' => 'Non-fiction',
            'value' => 'nonfiction',
        ]);
        $question3Choice3 = factory(QuestionChoice::class)->create([
            'question_id' => $question3->id,
            'label' => 'Sci-Fi',
            'value' => 'scifi',
        ]);
        $question3Choice4 = factory(QuestionChoice::class)->create([
            'question_id' => $question3->id,
            'label' => 'Mystery',
            'value' => 'mystery',
        ]);
        $question3Choice5 = factory(QuestionChoice::class)->create([
            'question_id' => $question3->id,
            'label' => 'Romance',
            'value' => 'romance',
        ]);

        $question4Choice1 = factory(QuestionChoice::class)->create([
            'question_id' => $question4->id,
            'label' => 'Work',
            'value' => 'work',
        ]);
        $question4Choice2 = factory(QuestionChoice::class)->create([
            'question_id' => $question4->id,
            'label' => 'Exercise',
            'value' => 'exercise',
        ]);
        $question4Choice3 = factory(QuestionChoice::class)->create([
            'question_id' => $question4->id,
            'label' => 'Play games',
            'value' => 'games',
        ]);
        $question4Choice4 = factory(QuestionChoice::class)->create([
            'question_id' => $question4->id,
            'label' => 'Learn something new',
            'value' => 'learn',
        ]);
        $question4Choice5 = factory(QuestionChoice::class)->create([
            'question_id' => $question4->id,
            'label' => 'Hang out with other people',
            'value' => 'socialize',
        ]);
    }
}
