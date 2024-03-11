<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $classes = Classes::with(['students', 'subjects'])->paginate();
        // $classes = Classes::paginate(); 
        return Inertia::render('Class/Index',[
            'classes' => $classes,
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
        Classes :: create(
            $request->validate([
                'name' => 'required|integer|min:1|max:12',
                'description' => 'required',
                'acadamic_year' => 'required'
            ])
        );
        return redirect()->route('class.index')->with('success', 'Class Sucessfully Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classes $classes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classes $classes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classes $classes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classes $classes)
    {
        //
    }
}
