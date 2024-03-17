<?php

namespace App\Http\Controllers;

use App\GeneticAlgorithm\TimetableGenerator;
use App\GeneticAlgorithm\GeneticAlgorithm;

use App\Models\Classes;
use App\Models\Grade;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

          $grades= Grade::with(['students', 'subjects'])->paginate();
        //   $classes = Classes::paginate();
          return Inertia::render('Grade/Index',[
            'grades' => $grades,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        Grade :: create(
            $request->validate([
                'name' => 'required|min:1|max:12',
                'description' => 'required',
                'acadamic_year' => 'required'
            ])
        );
        return redirect()->route('grade.index')->with('success', 'Class Sucessfully Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        //
    }
    
  public function generate()
    {
        // Initialize classes and use them as needed
        $classes = ['Class 1A', 'Class 1B', 'Class 2A', 'Class 2B'];
        $teachers = ['Teacher A', 'Teacher B', 'Teacher C', 'Teacher D'];
        $subjects = [
            'Math' => 3, // Subject priority is 3
            'Science' => 2, // Subject priority is 2
            'History' => 1, // Subject priority is 1
            // Add more subjects and corresponding priorities as needed
        ];
        $rooms = ['Room 101', 'Room 102', 'Room 103', 'Room 104'];

        // Create an instance of TimetableGenerator
        $timetableGenerator = new TimetableGenerator($classes, $teachers, $subjects, $rooms);

        // Create an instance of GeneticAlgorithm with injected TimetableGenerator instance
        $geneticAlgorithm = new GeneticAlgorithm(100, 5, $timetableGenerator); // Population size: 100, Mutation rate: 5%

        // Evolve the population for 100 generations
        $bestTimetable = $geneticAlgorithm->evolve(100);
        
        // Initialize the periods array with class names as keys
        $periods = [];
        foreach ($classes as $className) {
            $periods[$className] = [];
        }

        // Extract periods for each class
        foreach ($bestTimetable->getPeriods() as $classIndex => $classPeriods) {
            $className = $classes[$classIndex];
            $periods[$className] = $classPeriods;
        }

        // Return the view with the timetable data
        return Inertia::render('Timetable', ['periods' => $periods]);
    }



}
