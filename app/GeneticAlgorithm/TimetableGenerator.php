<?php

namespace App\GeneticAlgorithm;


class TimetableGenerator {
    private $classes;
    private $teachers;
    private $subjects;
    private $rooms;
    private $teachersForSubjects;

    public function __construct($classes, $teachers, $subjects, $rooms) {
        $this->classes = $classes;
        $this->teachers = $teachers;
        $this->subjects = $subjects;
        $this->rooms = $rooms;
        $this->teachersForSubjects = [
            'Math' => ['Teacher A', 'Teacher B'],
            'Science' => ['Teacher C', 'Teacher D'],
            'History' => ['Teacher A', 'Teacher D'],
            // Add more subjects and corresponding teachers as needed
        ];
        
    }
    
   
    // public function generateRandomTimetable($numPeriodsPerDay, $numDaysPerWeek) {
    //     $timetable = array();
    
    //     // Add logging for $this->classes
    //     info("Classes: " . print_r($this->classes, true));
        
    //     foreach ($this->classes as $class) {
    //         $classTimetable = array();
            
    //         for ($day = 1; $day <= $numDaysPerWeek; $day++) {
    //             $dailyPeriods = array();
                
    //             for ($period = 1; $period <= $numPeriodsPerDay; $period++) {
    //                 // Randomly select a subject based on priority
    //                 $subject = $this->getRandomSubjectWithPriority();
                    
    //                 // Ensure the subject has a teacher assigned to it
    //                 $teacher = $this->getTeacherForSubject($subject);
    
    //                 // Add logging for selected subject and teacher
    //                 info("Selected subject for $class - Day $day, Period $period: $subject");
    //                 info("Selected teacher for $class - Day $day, Period $period: $teacher");
                    
    //                 // Randomly select a room for the period
    //                 $room = $this->getRandomRoom();
                    
    //                 $dailyPeriods[] = array(
    //                     'subject' => $subject,
    //                     'teacher' => $teacher,
    //                     'room' => $room,
    //                 );
    //             }
                
    //             $classTimetable[] = $dailyPeriods;
    //         }
            
    //         $timetable[$class] = $classTimetable;
    //     }
    
    //     // Add logging statement to print the generated timetable
    //     info("Generated timetable: " . print_r($timetable, true));
        
    //     return $timetable;
    // }
    public function generateRandomTimetable($numPeriodsPerDay, $numDaysPerWeek) {
        $timetable = array();
    
        foreach ($this->classes as $class) {
            $classTimetable = array();
    
            for ($day = 1; $day <= $numDaysPerWeek; $day++) {
                $dailyPeriods = array();
    
                for ($period = 1; $period <= $numPeriodsPerDay; $period++) {
                    // Try generating a valid period, throwing an exception if unsuccessful
                    $validPeriod = $this->generateValidPeriod();
                    
                    // Add the valid period to the daily periods
                    $dailyPeriods[] = $validPeriod;
                }
    
                // Add the daily periods to the class timetable
                $classTimetable[] = $dailyPeriods;
            }
    
            // Add the class timetable to the overall timetable
            $timetable[$class] = $classTimetable;
        }
    
        // Log the generated timetable
        info("Generated timetable successfully.");
    
        return $timetable;
    }
    
    private function generateValidPeriod() {
        do {
            // Randomly select a subject based on priority
            $subject = $this->getRandomSubjectWithPriority();
            
            // Ensure the subject has a teacher assigned to it
            $teacher = $this->getTeacherForSubject($subject);
    
            // Randomly select a room for the period
            $room = $this->getRandomRoom();
        } while (empty($subject) || empty($teacher) || empty($room));
    
        return array(
            'subject' => $subject,
            'teacher' => $teacher,
            'room' => $room,
        );
    }

    private function getRandomSubjectWithPriority() {
        // Generate a weighted list of subjects based on priority
        $weightedSubjects = array();
        foreach ($this->subjects as $subject => $priority) {
            for ($i = 0; $i < $priority; $i++) {
                $weightedSubjects[] = $subject;
            }
        }
        
        // Randomly select a subject from the weighted list
        return $weightedSubjects[rand(0, count($weightedSubjects) - 1)];
    }
    
    // private function getTeacherForSubject($subject) {
    //     // Implement logic to randomly select a teacher for the given subject
    //     $teachersForSubject = $this->subjects[$subject];
    //     return $teachersForSubject[rand(0, count($teachersForSubject) - 1)];
    // }
    private function getTeacherForSubject($subject) {
        // Check if the subject exists in the subjects array
        if (isset($this->teachersForSubjects[$subject])) {
            // Retrieve the list of teachers available for that subject
            $teachersForSubject = $this->teachersForSubjects[$subject];

            // Ensure that $teachersForSubject is an array and not empty
            if (is_array($teachersForSubject) && !empty($teachersForSubject)) {
                // Randomly select a teacher from the list
                return $teachersForSubject[array_rand($teachersForSubject)];
            } else {
                // If $teachersForSubject is empty or not an array, throw an exception or handle it as needed
                throw new Exception("No teacher assigned for subject: $subject");
            }
        } else {
            // If the subject does not exist, throw an exception or handle it as needed
            throw new Exception("Subject not found: $subject");
        }
    }

    private function getRandomRoom() {
        // Implement logic to randomly select a room
        return $this->rooms[rand(0, count($this->rooms) - 1)];
    }
    public function getAvailableRooms() {
        // Return all rooms as available
        return $this->rooms;
    }

    public function getAvailableTeachers() {
        // Return all teachers as available
        return array_values($this->teachers);
    }
}