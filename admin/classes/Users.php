<?php
class Users
{
    private $conn;

    public function __construct()
    {
        // Assuming there's a database connection in dbcon.php
        include '../config/dbcon.php';
        $this->conn = $conn;
    }



    // Fetch all students from the tblstudent table
    public function fetchAllStudents()
    {
        $stmt = $this->conn->prepare("SELECT StudentID, MatricNo, Fname, Lname, Address, MobileNo FROM tblstudent");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            throw new Exception("Error fetching students: " . $stmt->error);
        }
    }

    // Edit student details
    public function editStudent($studentID, $data)
    {
        // Prepare the SQL update statement
        $stmt = $this->conn->prepare("UPDATE tblstudent SET MatricNo = ?, Fname = ?, Lname = ?, Address = ?, MobileNo = ? WHERE StudentID = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Bind the parameters
        $stmt->bind_param("sssssi", $data['MatricNo'], $data['Fname'], $data['Lname'], $data['Address'], $data['MobileNo'], $studentID);

        // Execute the statement
        if ($stmt->execute()) {
            return true; // Student successfully updated
        } else {
            throw new Exception("Error updating student: " . $stmt->error);
        }
    }

    // Delete student
    public function deleteStudent($studentID)
    {
        // Prepare the SQL delete statement
        $stmt = $this->conn->prepare("DELETE FROM tblstudent WHERE StudentID = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Bind the studentID parameter
        $stmt->bind_param("i", $studentID);

        // Execute the statement
        if ($stmt->execute()) {
            return true; // Student successfully deleted
        } else {
            throw new Exception("Error deleting student: " . $stmt->error);
        }
    }

    // Login method
    public function login($username, $password)
    {
        // Prepare the SQL statement to select the user by username
        $stmt = $this->conn->prepare("SELECT * FROM tblusers WHERE UEMAIL = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a user with the provided username exists
        if ($result->num_rows === 1) {
            // Fetch the user data
            $user = $result->fetch_assoc();

            // Verify the password (assuming plain text; hash if needed)
            if ($password === $user['PASS']) {
                return $user; // Login successful, return user data
            }
        }
        return false; // Invalid username or password
    }
}
