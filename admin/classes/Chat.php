<?php

class Chat
{
    private $conn;

    public function __construct()
    {
        // Include the database connection
        include '../config/dbcon.php';
        $this->conn = $conn; // Assuming $conn is a MySQLi connection instance
    }

    // Fetch chats grouped by exercise titles for a specific lecturer
    public function fetchGroupedChatsByLecturer($lecturerID)
    {
        // SQL query to fetch chats, lesson titles, and student matric numbers
        $query = "SELECT
                tblchat.chatID,
                tblchat.exerciseID,
                tblchat.message,
                tblchat.response,
                tblchat.sentAt,
                tblchat.responseAt,
                tblstudent.MatricNo,
                tbllesson.LessonTitle
                FROM
                tblchat
                JOIN
                tblstudent ON tblchat.userID = tblstudent.StudentID
                JOIN
                tblexercise ON tblchat.exerciseID = tblexercise.exerciseID
                JOIN
                tbllesson ON tblexercise.lessonID = tbllesson.lessonID
                WHERE
                tblexercise.lecturerID = ?
                ORDER BY
                tbllesson.lessonTitle, tblchat.sentAt ASC";

        // Prepare the SQL statement
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Bind the lecturer ID (i: integer)
        $stmt->bind_param('i', $lecturerID);

        // Execute the query
        if (!$stmt->execute()) {
            throw new Exception("Error executing query: " . $stmt->error);
        }

        // Fetch the result
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Method to update the response to a chat
    public function updateResponse($chatID, $response)
    {
        // SQL query to update the response and responseAt field
        $stmt = $this->conn->prepare("UPDATE tblchat SET response = ?, responseAt = NOW() WHERE chatID = ?");

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Bind the parameters (s: string, i: integer)
        $stmt->bind_param('si', $response, $chatID);

        // Execute the query
        if ($stmt->execute()) {
            return "Response updated successfully!";
        } else {
            throw new Exception("Error updating response: " . $stmt->error);
        }
    }
}
