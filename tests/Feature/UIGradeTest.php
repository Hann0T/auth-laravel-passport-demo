<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UIGradeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function student_can_only_see_its_own_grades()
    {
        $user = \App\Models\User::factory()->create();
        $grade1 = \App\Models\Grade::factory()->create([
            'user_id' => $user->id
        ]);
        $grade2 = \App\Models\Grade::factory()->create([
            'user_id' => 1231231
        ]);

        $response = $this->actingAs($user)->get('/grades');

        $response->assertSeeText(e($grade1->id), false);
        $response->assertSeeText(e($grade1->value), false);
        $response->assertDontSeeText(e($grade2->id), false);
        $response->assertDontSeeText(e($grade2->value), false);
    }

    /** @test */
    public function student_cannot_edit_its_own_grades()
    {
        $user = \App\Models\User::factory()->create(['role' => 'xdf']);
        $grade1 = \App\Models\Grade::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->get('/grades/edit/' . $grade1->id);

        $response->assertForbidden();

        $response = $this->actingAs($user)->post(
            '/grades/update/' . $grade1->id,
            [
                'value' => 123123
            ]
        );
        $response->assertForbidden();
    }

    /** @test */
    public function teacher_can_edit_grades()
    {
        $teacher = \App\Models\User::factory()->create([
            'role' => 'teacher',
        ]);

        $grade1 = \App\Models\Grade::factory()->create([
            'user_id' => 123
        ]);

        $response = $this->actingAs($teacher)->get('/grades/edit/' . $grade1->id);
        $response->assertOk();

        $response = $this->actingAs($teacher)->post(
            '/grades/update/' . $grade1->id,
            [
                'value' => 123123
            ]
        );
        $response->assertOk();
    }
}
