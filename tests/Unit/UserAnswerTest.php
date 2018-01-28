<?php

namespace Tests\Unit;

use App\User;
use App\UserAnswer;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class UserAnswerTest
 * @package Tests\Unit
 */
class UserAnswerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Assert that a user's submitted answers over multiple days
     * will only return today's submitted answers.
     *
     * @return void
     */
    public function testTodayWithMultipleDaySubmissions()
    {
        // Given I have four user answers and only one was created on the same day.
        $first = factory(UserAnswer::class)->create();
        $second = factory(UserAnswer::class)->create([
            'user_id' => $first->user_id,
            'created_at' => Carbon::now()->subDay(),
        ]);
        $third = factory(UserAnswer::class)->create([
            'user_id' => $first->user_id,
            'created_at' => Carbon::now()->subDays(2),
        ]);
        $fourth = factory(UserAnswer::class)->create([
            'user_id' => $first->user_id,
            'created_at' => Carbon::now()->subDays(2),
        ]);

        $user = User::find($first->user_id);
        $this->actingAs($user);

        // When the history of answers is fetched.
        $answers = UserAnswer::today();

        $this->assertCount(1, $answers);
    }

    public function testMultipleSubmissionsWithMultipleUsers()
    {
        // 4 user answers from the same user with 1 from a previous day.
        $user1FirstAnswer = factory(UserAnswer::class)->create();
        $user1SecondAnswer = factory(UserAnswer::class)->create([
            'user_id' => $user1FirstAnswer->user_id,
        ]);
        $user1ThirdAnswer = factory(UserAnswer::class)->create([
            'user_id' => $user1FirstAnswer->user_id,
        ]);
        $user1FourthAnswer = factory(UserAnswer::class)->create([
            'user_id' => $user1FirstAnswer->user_id,
            'created_at' => Carbon::now()->subDay(),
        ]);

        // 2 user answers from a different user but from today.
        $user2FirstAnswer = factory(UserAnswer::class)->create();
        $user2SecondAnswer = factory(UserAnswer::class)->create([
            'user_id' => $user2FirstAnswer->user_id,
        ]);
        $user2SecondAnswer = factory(UserAnswer::class)->create([
            'user_id' => $user2FirstAnswer->user_id,
            'created_at' => Carbon::now()->subDays(2),
        ]);

        $user = User::find($user1FirstAnswer->user_id);
        $this->actingAs($user);

        // When the history of answers is fetched.
        $user1Answers = UserAnswer::today();

        // There are 7 entries from today but only 3 are from user1.
        $this->assertCount(3, $user1Answers);
    }
}
