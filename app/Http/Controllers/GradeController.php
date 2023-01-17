<?php

namespace App\Http\Controllers;

use App\Events\GradeUpdated;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateGradeRequest;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->can('viewAny', Grade::class)) {
            return view('grades.index', [
                'grades' =>
                \App\Models\Grade::with('user')->get()
            ]);
        }

        return view('grades.index', [
            'grades' =>
            \App\Models\Grade::with('user')
                ->where('user_id', $user->id)->get()
        ]);
    }

    public function create()
    {
        return view('grades.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Grade $grade)
    {
        //
    }

    public function edit(Grade $grade)
    {
        $this->authorize('update', $grade);

        return view('grades.edit', ['grade' => $grade]);
    }

    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $this->authorize('update', $grade);

        $prevGrade = clone $grade;
        $grade->update($request->validated());

        GradeUpdated::dispatch($prevGrade, $grade);
    }

    public function destroy(Grade $grade)
    {
        //
    }
}
