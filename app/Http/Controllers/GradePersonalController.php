<?php

namespace App\Http\Controllers;

use App\Events\GradeUpdatedApi;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateGradeRequest;

class GradePersonalController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->can('viewAny', Grade::class)) {
            return \App\Models\Grade::with('user')->get();
        }

        return \App\Models\Grade::with('user')
            ->where('user_id', $user->id)->get();
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Grade $grade)
    {
        //
    }

    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $prevGrade = clone $grade;
        $grade->update($request->validated());

        GradeUpdatedApi::dispatch($prevGrade, $grade, $request->ip());
    }

    public function destroy(Grade $grade)
    {
        //
    }
}
