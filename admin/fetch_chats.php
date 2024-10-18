<?php
session_start();
include_once './classes/Chat.php'; // Include the Chat class

// Ensure the lecturer is logged in
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$lecturerID = $_SESSION['admin_id'];

// Create an instance of the Chat class
$chat = new Chat();

// Fetch all chats grouped by lesson titles
$groupedChats = $chat->fetchGroupedChatsByLecturer($lecturerID);

// Return the chat data as JSON
header('Content-Type: application/json');
echo json_encode($groupedChats);
exit();
