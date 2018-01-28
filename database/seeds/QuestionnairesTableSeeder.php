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
            'label' => 'What type of car do you own?',
            'type' => 'radio',
        ]);
        $question2 = factory(Question::class)->create([
            'questionnaire_id' => $questionnaire->id,
            'label' => 'How many world languages do you know?',
            'type' => 'radio',
        ]);
        $question3 = factory(Question::class)->create([
            'questionnaire_id' => $questionnaire->id,
            'label' => 'What genres of books do you enjoy reading?',
            'type' => 'checkbox',
        ]);

        // Probably not ideal to also insert choices in the same seeder.
        // However, this does save on a few DB calls,
        // since we will have the question ID to meet the question_id foreign key constraint.
        $question1Choice1 = factory(QuestionChoice::class)->create([
            'question_id' => $question1->id,
            'label' => 'American',
            'value' => 'american',
        ]);
        $question1Choice2 = factory(QuestionChoice::class)->create([
            'question_id' => $question1->id,
            'label' => 'European',
            'value' => 'european',
        ]);
        $question1Choice3 = factory(QuestionChoice::class)->create([
            'question_id' => $question1->id,
            'label' => 'Japanese',
            'value' => 'japanese',
        ]);
        $question1Choice4 = factory(QuestionChoice::class)->create([
            'question_id' => $question1->id,
            'label' => 'I do not own a car',
            'value' => 'none',
        ]);

        $question2Choice1 = factory(QuestionChoice::class)->create([
            'question_id' => $question2->id,
            'label' => '1',
            'value' => '1',
        ]);
        $question2Choice2 = factory(QuestionChoice::class)->create([
            'question_id' => $question2->id,
            'label' => '2',
            'value' => '2',
        ]);
        $question2Choice3 = factory(QuestionChoice::class)->create([
            'question_id' => $question2->id,
            'label' => 'Greater than 2',
            'value' => '>2',
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
        $question3Choice6 = factory(QuestionChoice::class)->create([
            'question_id' => $question3->id,
            'label' => 'I do not read books (often)',
            'value' => 'none',
        ]);
    }
}
