<?php

namespace App\GeneticAlgorithm;

class GeneticAlgorithm {
    private $populationSize;
    private $mutationRate;
    private $timetables;
    private $timetableGenerator; // Instance of TimetableGenerator


    public function __construct($populationSize, $mutationRate, TimetableGenerator $timetableGenerator) {
        $this->populationSize = $populationSize;
        $this->mutationRate = $mutationRate;
        $this->timetables = array();
        $this->timetableGenerator = $timetableGenerator; // Assign the injected instance
    }

    
    // public function evolve($limit) {
    //     $numberOfGenerations = 0;
    //     $perfectIndividual = false;
    
    //     while ($numberOfGenerations < $limit && !$perfectIndividual) {
    //         // Create new population
    //         $newPopulation = $this->createNewPopulation();
            
    //         // Parallel mating process
    //         $newPopulation = $this->parallelMating($newPopulation);
            
    //         // Repair lost & duplicated labels
    //         $newPopulation = $this->labelReplacement($newPopulation);
            
    //         // Fitness scaling
    //         $this->scaleFitness($newPopulation);
            
    //         // Update population
    //         $this->timetables = $newPopulation;
            
    //         $numberOfGenerations++;
    
    //         $bestTimetable = $this->findBestTimetable();
            
    //         // Add logging statement to print the best timetable
    //         info("Best timetable after generation $numberOfGenerations: " . print_r($bestTimetable, true));
    
    //         return $bestTimetable;
    //     }
    // }
    public function evolve($limit) {
        $numberOfGenerations = 0;
        $perfectIndividual = false;
        $bestTimetable = null;
    
        while ($numberOfGenerations < $limit && !$perfectIndividual) {
            // Create new population
            $newPopulation = $this->createNewPopulation();
            
            // Parallel mating process
            $newPopulation = $this->parallelMating($newPopulation);
            
            // Repair lost & duplicated labels
            $newPopulation = $this->labelReplacement($newPopulation);
            
            // Fitness scaling
            $this->scaleFitness($newPopulation);
            
            // Update population
            $this->timetables = $newPopulation;
            
            $numberOfGenerations++;
    
            $bestTimetable = $this->findBestTimetable();
        }
    
        // Add logging statement to print the best timetable
        info("Best timetable after generation $numberOfGenerations: " . print_r($bestTimetable, true));
    
        return $bestTimetable;
    }
    
    

    public function findBestTimetable() {
        $bestTimetable = null;
        $bestFitness = PHP_INT_MAX;

        foreach ($this->timetables as $timetable) {
            if ($timetable->getFitness() < $bestFitness) {
                $bestTimetable = $timetable;
                $bestFitness = $timetable->getFitness();
            }
        }
        return $bestTimetable;
    }

    // private function createNewPopulation() {
    //     $newPopulation = array();
    //     for ($i = 0; $i < $this->populationSize; $i++) {
    //         // Generate random timetable
    //         $periods = $this->generateRandomTimetable();
    //         $timetable = new Timetable($periods);
    //         $timetable->evaluateFitness(); // Evaluate fitness for the new timetable
    //         $newPopulation[] = $timetable;
    //     }
    //     return $newPopulation;
    // }
    private function createNewPopulation() {
        $newPopulation = array();
        for ($i = 0; $i < $this->populationSize; $i++) {
            // Generate random timetable
            $periods = $this->generateRandomTimetable();
            $timetable = new Timetable($periods);
            $timetable->evaluateFitness(); // Evaluate fitness for the new timetable
            $newPopulation[] = $timetable;
        }
        return $newPopulation;
    }
    
    
   
    private function generateRandomTimetable() {
                // Implement code to generate a random timetable using TimetableGenerator class
                // This could involve randomly assigning classes, teachers, and rooms to periods
                // return $timetableGenerator->generateRandomTimetable(6, 5); // 6 periods per day, 5 days per week
                // return $this->timetableGenerator->generateRandomTimetable(6, 5); // Example parameters
                return $this->timetableGenerator->generateRandomTimetable(6, 5); // 6 periods per day, 5 days per week
    }

    private function parallelMating($population) {
        // Implement parallel mating process
        // Split the population into multiple chunks
        $chunks = array_chunk($population, count($population) / 4);
        // Process each chunk in parallel to create new children
        $newPopulation = array();
        foreach ($chunks as $chunk) {
            $newPopulation = array_merge($newPopulation, $this->mateChunk($chunk));
        }
        // Return the combined new population
        return $newPopulation;
    }

    private function mateChunk($chunk) {
        $newChildren = array();
        foreach ($chunk as $parent1) {
            $parent2 = $this->selectRandomParent($chunk);
            $child = $this->createChild($parent1, $parent2);
            $this->applyMutation($child);
            $child->evaluateFitness(); // Evaluate fitness for the new child
            $newChildren[] = $child;
        }
        return $newChildren;
    }

    private function selectRandomParent($population) {
        return $population[rand(0, count($population) - 1)];
    }

    private function createChild($parent1, $parent2) {
        // Implement crossover between parent1 and parent2 to create a child
        $childPeriods = array();
        foreach ($parent1->getPeriods() as $index => $period) {
            $childPeriods[$index] = rand(0, 1) ? $period : $parent2->getPeriods()[$index];
        }
        return new Timetable($childPeriods);
    }

    private function applyMutation($child) {
        // Implement mutation on the child
        foreach ($child->getPeriods() as &$period) {
            if (rand(0, 100) / 100 < $this->mutationRate) {
                // Perform mutation on this period
                $period[rand(0, count($period) - 1)] = rand(0, 100); // Example mutation
            }
        }
    }

    
    // private function labelReplacement($population) {
    //     foreach ($population as &$timetable) {
    //         $periods = $timetable->getPeriods();
    //         // Flatten the periods array and extract the values
    //         $flattenedPeriods = [];
    //         foreach ($periods as $period) {
    //             $flattenedPeriods = array_merge($flattenedPeriods, array_column($period, 'teacher'));
    //         }
    
    //         // Remove duplicate values
    //         $flattenedPeriods = array_unique($flattenedPeriods);
    
    //         // Shuffle the array
    //         shuffle($flattenedPeriods);
    
    //         // Calculate chunk size
    //         $chunkSize = max(1, ceil(count($flattenedPeriods) / max(count($periods), 1)));
    
    //         // Check if chunk size is greater than zero
    //         if ($chunkSize > 0) {
    //             // Split the array into chunks
    //             $shuffledPeriods = array_chunk($flattenedPeriods, $chunkSize);
    
    //             // Construct new periods array
    //             $newPeriods = [];
    //             foreach ($periods as $period) {
    //                 $newPeriod = [];
    //                 foreach ($period as $index => $data) {
    //                     // Replace teacher label with shuffled label
    //                     if (!empty($shuffledPeriods)) {
    //                         $data['teacher'] = $shuffledPeriods[$index % count($shuffledPeriods)];
    //                     }
    //                     $newPeriod[] = $data;
    //                 }
    //                 $newPeriods[] = $newPeriod;
    //             }
    //             // dd($newPeriod);                
    
    //             // Set the new periods for the timetable
    //             // $timetable->$newPeriods;
    //             $timetable->setPeriods($newPeriods);

    //             // dd($timetable);
    //         }
    //     }
    //     // dd($population);
    //     return $population;
    // }
    private function labelReplacement($population) {
        foreach ($population as &$timetable) {
            $periods = $timetable->getPeriods();
            $roomsOccupied = []; // Track occupied rooms
            $teachersOccupied = []; // Track occupied teachers
    
            foreach ($periods as &$period) {
                foreach ($period as &$slot) {
                    // Assign a room that is not already occupied
                    do {
                        $occupiedRooms = []; // You need to populate this array with occupied rooms
                        $randomRoom = $this->getRandomRoom($occupiedRooms); // Implement this method to get a random available room
                    } while (in_array($randomRoom, $roomsOccupied));
                    $slot['room'] = $randomRoom;
                    $roomsOccupied[] = $randomRoom;
    
                    // Assign a teacher that is not already occupied
                    do {
                        $occupiedTeachers = [];
                        $randomTeacher = $this->getRandomTeacher($occupiedTeachers); // Implement this method to get a random available teacher
                    } while (in_array($randomTeacher, $teachersOccupied));
                    $slot['teacher'] = $randomTeacher;
                    $teachersOccupied[] = $randomTeacher;
                }
            }
    
            // Set the updated periods for the timetable
            $timetable->setPeriods($periods);
        }
    
        return $population;
    }
    
    

    private function scaleFitness($population) {
        // Implement fitness scaling
    
        // Scale fitness values of individuals so that individuals with higher fitness have a greater chance of surviving
    
        $fitnessSum = array_sum(array_map(function ($timetable) {
            return $timetable->getFitness();
        }, $population));
    
        // Check if $fitnessSum is greater than zero to avoid DivisionByZeroError
        if ($fitnessSum > 0) {
            foreach ($population as &$timetable) {
                $timetable->setFitness($timetable->getFitness() / $fitnessSum);
            }
        } else {
            // If $fitnessSum is zero, set fitness values to a uniform value
            $uniformFitness = 1 / count($population);
            foreach ($population as &$timetable) {
                $timetable->setFitness($uniformFitness);
            }
        }
    }
    private function getRandomRoom($occupiedRooms) {
        // Get all available rooms from your timetable generator or database
        
        $availableRooms = $this->timetableGenerator->getAvailableRooms();
    
        // Filter out rooms that are already occupied in the current period
        $availableRooms = array_diff($availableRooms, $occupiedRooms);
    
        // Return a random available room
        return $availableRooms[array_rand($availableRooms)];
    }
    
    private function getRandomTeacher($occupiedTeachers) {
        // Get all available teachers from your timetable generator or database
        $availableTeachers = $this->timetableGenerator->getAvailableTeachers();
    
        // Filter out teachers that are already occupied in the current period
        $availableTeachers = array_diff($availableTeachers, $occupiedTeachers);
    
        // Return a random available teacher
        return $availableTeachers[array_rand($availableTeachers)];
    }
    // Other helper methods for selection, crossover, mutation, etc.
    
}
