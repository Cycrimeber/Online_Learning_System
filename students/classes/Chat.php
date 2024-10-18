<?php
class Chat
{
    private $conn;

    public function __construct()
    {
        // Include database connection
        include '../config/dbcon.php';
        $this->conn = $conn; // Assuming $conn is a MySQLi connection instance
    }

    // Method to send a message
    public function sendMessage($exerciseID, $userID, $message)
    {
        // Prepare SQL statement
        $stmt = $this->conn->prepare("INSERT INTO tblchat (exerciseID, userID, message) VALUES (?, ?, ?)");

        // Check for preparation error
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Bind parameters (i: integer, s: string)
        $stmt->bind_param('iis', $exerciseID, $userID, $message);

        // Execute the statement
        if ($stmt->execute()) {
            return "Message sent successfully!";
        } else {
            throw new Exception("Error sending message: " . $stmt->error);
        }
    }

    // Method to fetch messages for a specific exercise
    public function fetchMessages($exerciseID)
    {
        // Prepare SQL query to fetch messages along with admin responses
        $query = "
    SELECT 
        tblchat.message, 
        tblchat.sentAt, 
        tblstudent.MatricNo AS sender, 
        tblchat.response, 
        tblchat.responseAt
    FROM 
        tblchat 
    JOIN 
        tblstudent ON tblchat.userID = tblstudent.StudentID
    WHERE 
        tblchat.exerciseID = ? 
    ORDER BY 
        tblchat.sentAt ASC";

        // Prepare the SQL statement
        $stmt = $this->conn->prepare($query);

        // Check for preparation error
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Bind parameters (i: integer)
        $stmt->bind_param('i', $exerciseID);

        // Execute the query
        if (!$stmt->execute()) {
            throw new Exception("Error fetching messages: " . $stmt->error);
        }

        // Fetch the result
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Method to delete a message by its ID
    public function deleteMessage($messageID)
    {
        // Prepare SQL delete statement
        $stmt = $this->conn->prepare("DELETE FROM tblchat WHERE messageID = ?");

        // Check if the statement was prepared successfully
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Bind the messageID parameter (i: integer)
        $stmt->bind_param('i', $messageID);

        // Execute the statement
        if ($stmt->execute()) {
            return "Message deleted successfully!";
        } else {
            throw new Exception("Error deleting message: " . $stmt->error);
        }
    }
}
