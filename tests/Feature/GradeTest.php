<?php

namespace Tests\Feature;

use App\Events\GradeUpdated;
use App\Events\GradeUpdatedApi;
use App\Services\FetchTokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GradeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function event_web_will_be_dispatched_on_grade_update()
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

    /** @test */
    public function M2M_can_update_the_grades_with_the_valid_scope()
    {
        $token = (new FetchTokenService())
            ->withScopes(['update-grades'])
            ->getToken();
        $grade1 = \App\Models\Grade::factory()->create([
            'user_id' => 123
        ]);

        $response = Http::acceptJson()
            ->withToken($token)
            ->post(
                'http://localhost/api/m2m/grades/update/' . $grade1->id,
                [
                    'value' => 123123
                ]
            );

        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function M2M_cannot_update_the_grades_with_the_invalid_scope()
    {
        $token = (new FetchTokenService())
            ->withScopes(['scope-1'])
            ->getToken();
        $grade1 = \App\Models\Grade::factory()->create([
            'user_id' => 123
        ]);

        $response = Http::acceptJson()
            ->withToken($token)
            ->post(
                'http://localhost/api/m2m/grades/update/' . $grade1->id,
                [
                    'value' => 123123
                ]
            );

        $this->assertEquals(403, $response->status());
    }

    public function event_api_will_be_dispatched_on_grade_update()
    {
        Event::fake();
        $token = (new FetchTokenService())
            ->withScopes(['update-grades'])
            ->getToken();
        $grade1 = \App\Models\Grade::factory()->create([
            'user_id' => 123
        ]);

        $response = Http::acceptJson()
            ->withToken($token)
            ->post(
                'http://localhost/api/m2m/grades/update/' . $grade1->id,
                [
                    'value' => 123123
                ]
            );

        $this->assertEquals(200, $response->status());
        Event::assertDispatched(GradeUpdatedApi::class);
    }
}
