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

    public function register($formData, $fileData)
    {
        // Extract form data
        $matricno = $formData['matricno'];
        $fname = $formData['fname'];
        $lname = $formData['lname'];
        $department = $formData['department'];
        $level = $formData['level'];
        $address = $formData['address'];
        $mobile = $formData['mobile'];
        $studusername = $formData['studusername'];
        $studpass = $formData['studpass'];

        // Hash password
        $hashed_pass = password_hash($studpass, PASSWORD_BCRYPT);

        // Insert data into the database
        $query = "INSERT INTO tblstudent (MatricNo, Fname, Lname, department, level, Address, MobileNo, STUDUSERNAME, STUDPASS) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Check if prepare() failed
        if ($stmt === false) {
            error_log("SQL error: " . $this->conn->error);
            return "Database error: Unable to prepare statement.";
        }

        // Bind parameters
        $stmt->bind_param('sssssssss', $matricno, $fname, $lname, $department, $level, $address, $mobile, $studusername, $hashed_pass);

        // Execute and check if it was successful
        if ($stmt->execute()) {
            // Registration successful, now handle the file upload
            $photo = $fileData['photo']['name'];
            $photo_tmp = $fileData['photo']['tmp_name'];
            $upload_dir = '../img/profile/';
            $photo_new_name = time() . "_" . $photo;
            $upload_file = $upload_dir . $photo_new_name;

            // If file upload is successful, update the ProfilePic column
            if (move_uploaded_file($photo_tmp, $upload_file)) {
                $update_query = "UPDATE tblstudent SET photo = ? WHERE MatricNo = ?";
                $update_stmt = $this->conn->prepare($update_query);

                if ($update_stmt === false) {
                    error_log("SQL update error: " . $this->conn->error);
                    return "Database error: Unable to prepare profile picture update.";
                }

                $update_stmt->bind_param('ss', $photo_new_name, $matricno);

                if ($update_stmt->execute()) {
                    return true; // All operations successful
                } else {
                    error_log("Profile pic update error: " . $update_stmt->error);
                    return "Profile picture update failed.";
                }
            } else {
                return "File upload failed.";
            }
        } else {
            // Log the error if execute() failed
            error_log("Execute error: " . $stmt->error);
            return "Registration failed. Unable to execute statement.";
        }
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

    public function login($username, $password)
    {
        // Prepare the SQL statement to select the user by username
        $stmt = $this->conn->prepare("SELECT * FROM tblstudent WHERE STUDUSERNAME = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a user with the provided username exists
        if ($result->num_rows === 1) {
            // Fetch the user data
            $user = $result->fetch_assoc();

            // Verify the password (assuming plain text; hash if needed)
            if (password_verify($password, $user['STUDPASS'])) {
                return $user; // Login successful, return user data
            }
        }
        return false; // Invalid username or password
    }
}
