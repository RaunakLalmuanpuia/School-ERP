<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = Classes::with(['subjects.teacher'])->get();
        $student = Student::with(['user','class'])->paginate();
        return Inertia::render('Student/Index',[
            'student' => $student,
            'classes' => $classes
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
        
        $vaidated_data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8',
            'admission_no' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'date_of_birth' => 'nullable|date',
            'acadamic_year' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone_no' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming max file size is 2MB
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filepath_photo = $photo->store('public/Student');
            $filepath_photo = str_replace('public/', '', $filepath_photo); // Remove 'public/' from the path
           
        }
        // first create a user
        $user = new User([
            'name' => $vaidated_data['name'],
            'email' => $vaidated_data['email'],
            'password' =>Hash::make($vaidated_data['password']),
            
        ]);
        $user->save();
        $user->syncRoles('student');
        //get the new created user
        $userId = User::where('email', $vaidated_data['email'])->first();
        $class = Classes::where('id', $request->class_id['value'])->first();
        // add the teacher details in teacher table
        $student = new Student([
            'user_id' => $userId->id,
            'admission_no' => $vaidated_data['admission_no'],
            'father_name' => $vaidated_data['father_name'],
            'mother_name' => $vaidated_data['mother_name'],
            'gender' => $vaidated_data['gender'],
            'date_of_birth' => $vaidated_data['date_of_birth'],
            'acadamic_year' => $vaidated_data['acadamic_year'],
            'address' => $vaidated_data['address'],
            'phone_no' =>$vaidated_data['phone_no'],
            'photo' => $filepath_photo,
            'class_id' =>$class->id,
        ]);
        $student->save();
        return redirect()->route('student.index')->with('message', 'Student Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
