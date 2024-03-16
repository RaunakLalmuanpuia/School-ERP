<?php

namespace App\Http\Controllers;

use App\Models\Subjects;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher = Teacher::with(['user','subjects'])->paginate();
        return Inertia::render('Teacher/Index',[
            'teacher' => $teacher,
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
        //
        // dd($request);
        $vaidated_data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8',
            'employee_no' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'date_of_birth' => 'nullable|date',
            'date_of_join' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone_no' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming max file size is 2MB
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filepath_photo = $photo->store('public/Teacher');
            $filepath_photo = str_replace('public/', '', $filepath_photo); // Remove 'public/' from the path
           
        }
        // first create a user
        $user = new User([
            'name' => $vaidated_data['name'],
            'email' => $vaidated_data['email'],
            'password' =>Hash::make($vaidated_data['password']),
            
        ]);
        $user->save();
        $user->syncRoles('teacher');
        //get the new created user
        $userId = User::where('email', $vaidated_data['email'])->first();
        // add the teacher details in teacher table
        $teacher = new Teacher([
            'user_id' => $userId->id,
            'employee_no' => $vaidated_data['employee_no'],
            'father_name' => $vaidated_data['father_name'],
            'mother_name' => $vaidated_data['mother_name'],
            'gender' => $vaidated_data['gender'],
            'date_of_birth' => $vaidated_data['date_of_birth'],
            'date_of_join' => $vaidated_data['date_of_join'],
            'address' => $vaidated_data['address'],
            'phone_no' =>$vaidated_data['phone_no'],
            'qualification' => $vaidated_data['qualification'],
            'salary' => $vaidated_data['salary'],
            'photo' => $filepath_photo,
        ]);
        $teacher->save();
        return redirect()->route('teacher.index')->with('message', 'Teacher Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        //
    }
    public function showSubjects(){
        // $user = auth()->user();
        // Retrieve the teacher with its relations where user_id matches the authenticated user's ID
        
        $teacher = Teacher::where('user_id', auth()->id())->with('subjects.class')->first();
     
        $subjects = $teacher->subjects()->with('class')->paginate();
        
        // dd($subjects);
        return Inertia::render('Teacher/Subjects',[
            // 'teacher' => $teacher,
            'subjects' => $subjects
        ]);
    }
    public function viewSubject($id){
        $subject = Subjects::findOrFail($id);
        // dd($subject);
        // Get all the student taking the subject
       
        $teacher = Teacher::where('user_id', auth()->id())->with(['subjects.class', 'user'])->first();
        $subjects = $teacher->subjects()->with('class')->paginate();

        $students = Student::where('class_id', $subject->class_id)->with('user')->paginate();
        // dd($students);
        return Inertia::render('Teacher/Subject/Show',[
            // 'teacher' => $teacher,
            'students' => $students,
            'subjects' => $subjects
        ]);
    }

}
