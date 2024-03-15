<?php

namespace App\GeneticAlgorithm;

class Timetable {
    private $periods; // Representation of timetable as an array of periods
    private $fitness; // Fitness score of the timetable

    public function __construct($periods) {
        // dd($periods);
        $this->periods = $periods; // Use the setPeriods method to ensure validity
        $this->fitness = 0;
    }
    
    public function getPeriods() {
        return $this->periods;
    }
    
    public function setPeriods(array $periods)
    {
        $this->periods = $periods;
    }


    public function getFitness() {
        return $this->fitness;
    }

    public function setFitness($fitness) {
        $this->fitness = $fitness;
    }

    public function evaluateFitness() {
        $clashes = 0;
    
        foreach ($this->periods as $period) {
            // Ensure $period is an array
            if (is_array($period)) {
                // Extract the 'teacher' values from each sub-array
                $teachers = array_column($period, 'teacher');
                
                // Count the total number of elements in the period
                $totalElements = count($teachers);
    
                // Count the number of unique elements in the period
                $uniqueTeachers = array_unique($teachers);
                $uniqueElements = count($uniqueTeachers);
    
                // Calculate clashes for this period
                $clashes += $totalElements - $uniqueElements;
            }
        }
    
        $this->fitness = $clashes;
    }

}
