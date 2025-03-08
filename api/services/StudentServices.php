<?php
require_once "repositories/StudentRepository.php";

class StudentService {
    private StudentRepository $studentRepository;

    public function __construct(StudentRepository $studentRepository) {
        $this->studentRepository = $studentRepository;
    }

    public function calculateGrade($midterm_score, $final_score) {
        return round(($midterm_score * 0.4) + ($final_score * 0.6));
    }

    public function calculateStatus($finalGrade) {
        return $finalGrade >= 75 ? 'Pass' : 'Fail';
    }

    public function addStudent($studentData): Student {
        $finalGrade = $this->calculateGrade($studentData['midterm_score'], $studentData['final_score']);
        $status = $this->calculateStatus($finalGrade);

        $student = new Student();
        $student->name = $studentData['name'];
        $student->midterm_score = $studentData['midterm_score'];
        $student->final_score = $studentData['final_score'];
        $student->final_grade = $finalGrade;
        $student->status = $status;

        return $this->studentRepository->Add($student);
    }

    public function updateStudent($studentData, $id): void {
        $studentFromDb = $this->studentRepository->GetById($id);
        $finalGrade = $this->calculateGrade($studentData['midterm_score'], $studentData['final_score']);
        $status = $this->calculateStatus($finalGrade);
    
        $student = new Student();
        $student->id = $id;
        $student->name = $studentFromDb->name;
        $student->midterm_score = $studentData['midterm_score'];
        $student->final_score = $studentData['final_score'];
        $student->final_grade = $finalGrade;
        $student->status = $status;
    
        $this->studentRepository->Update($student);
    }
    
}
