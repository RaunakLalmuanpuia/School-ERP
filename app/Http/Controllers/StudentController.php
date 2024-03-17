<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subjects;
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
        $grade = Grade::with(['subjects.teacher'])->get();
        $student = Student::with(['user','grade'])->paginate();
       
        return Inertia::render('Student/Index',[
            'student' => $student,
            'grade' => $grade
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

        // dd(User::where('email', $vaidated_data['email'])->exists());
        // Check if a user with the provided email already exists
        if (User::where('email', $vaidated_data['email'])->exists()) {
            // Handle the case when the user already exists, perhaps return an error response
            return redirect()->route('student.index')->with('message', 'Email Already Exist!');
        }
        else{
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
            $grade = Grade::where('id', $request->class_id['value'])->first();
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
                'grade_id' =>$grade->id,
            ]);
            info($student->save());
            $student->save();
            return redirect()->route('student.index')->with('message', 'Student Added Successfully!');
        }

       
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
    
        // dd($student);
        
        $student->load('grade', 'user'); // load the relation of student
        // $user_detail = User::where('id', $student->user_id)->first();
        // $student_class = Classes::where('id', $student->class_id)->first();
        $student_subjects = Subjects::where('grade_id', $student->grade_id)->with('teacher.user')->get(); //get teacher of subject also along with the relation of the teacher with user
        // dd($student_subjects[0]->teacher->user->name); // teacher name;
        // dd($student_detail->class->name);
        return Inertia::render('Student/Show',[
            'student_detail' => $student,
            'student_subjects' => $student_subjects
        ]);

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
