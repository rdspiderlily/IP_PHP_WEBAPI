<?php
require_once "services/StudentServices.php";
require_once "repositories/StudentRepository.php";
require_once "config/Database.php"; // Ensure Database class is included

class StudentController {
    private StudentService $studentService;
    private StudentRepository $studentRepository;
    private $databaseConnection;

    public function __construct() {
        $database = new Database();
        $this->databaseConnection = $database->getConnection();
        $this->studentRepository = new StudentRepository($this->databaseConnection, "Student");
        $this->studentService = new StudentService($this->studentRepository);
    }

    public function GetAllStudent(): void {
        echo json_encode($this->studentRepository->GetAllList());
    }

    public function GetStudentById(int $id): void {
        echo json_encode($this->studentRepository->GetById($id));
    }

    public function AddStudent($studentData): void {
        $this->studentService->addStudent($studentData);
        echo "Data Added Successfully"; 
    }

    public function UpdateStudent($studentData): void {
        $id = $studentData['id'];
        $this->studentService->updateStudent($studentData, $id);
        echo "Data Updated Successfully";
    }

    public function DeleteStudent(int $id): void {
        $this->studentRepository->Delete($id);
        echo "Data Deleted Successfully";
    }
}
