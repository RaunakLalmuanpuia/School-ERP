<?php

namespace App\Http\Controllers;


use App\Models\Grade;
use App\Models\Subjects;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Inertia\Inertia;
class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // $classes = Classes::with(['students', 'subjects'])->paginate();
         $subjects = Subjects::with(['grade', 'teacher.user'])->paginate();
         $grades = Grade::all();
         $teacher = Teacher::with(['user'])->get();
         // Load the class and teacher associated with the subject
        // $subject = Subjects::load(['class', 'teacher']);
         return Inertia::render('Subjects/Index',[
             'subjects' => $subjects,
             'classes' => $grades,
             'teacher' => $teacher
         ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        // dd($request->class_id['value']);

        $grade = Grade::where('id', $request->class_id['value'])->first();
        // dd($grade->id);
        $teacher = Teacher::where('id', $request->teacher_id['value'])->first();
        $subject = new Subjects([
            'grade_id' => $grade->id,
            'teacher_id' => $teacher->id,
            'name' => $request->name,
            'subject_code' => $request->subject_code,
            'acadamic_year' =>$request->acadamic_year
            
        ]);
        $subject->save();
        return redirect()->route('subject.index')->with('message', 'Subject Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subjects $subjects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subjects $subjects)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subjects $subjects)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subjects $subjects)
    {
        //
    }
}
