<?php

namespace App\Http\Controllers;

use App\Events\GradeUpdatedApi;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateGradeRequest;

class GradeM2MController extends Controller
{
    public function index(Request $request)
    {
        return \App\Models\Grade::with('user')->get();
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
