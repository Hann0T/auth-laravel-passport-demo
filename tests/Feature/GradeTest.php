<?php

namespace Tests\Feature;

use App\Events\GradeUpdated;
use App\Services\FetchTokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GradeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function event_will_be_dispatched_on_grade_update()
    {
        Event::fake();
        $teacher = \App\Models\User::factory()->create([
            'role' => 'teacher',
        ]);
        $grade1 = \App\Models\Grade::factory()->create([
            'user_id' => 123
        ]);

        $response = $this->actingAs($teacher)->post(
            '/grades/update/' . $grade1->id,
            [
                'value' => 0
            ]
        );

        $response->assertOk();
        Event::assertDispatched(GradeUpdated::class);
    }

    // public function can_get_the_token()
    // {
    //     $token = (new FetchTokenService())
    //         ->getToken();
    //     $this->assertNotNull($token);
    // }

    //public function can_get_all_the_grades_with_the_rigth_scope()

    /** @test */
    public function can_update_the_grades_with_the_rigth_scope()
    {
        $token = (new FetchTokenService())
            ->withScopes(['update-grades'])
            ->getToken();
        $grade1 = \App\Models\Grade::factory()->create([
            'user_id' => 123
        ]);
        dd($token);

        $response = Http::acceptJson()
            ->withToken($token)
            ->post(
                'http://localhost/api/grades/update/' . $grade1->id,
                [
                    'value' => 123123
                ]
            );

        dd($response->status());
    }
}
