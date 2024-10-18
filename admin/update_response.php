<?php
session_start();
// Check if chatID and response are set
if (isset($_POST['chatID']) && isset($_POST['response'])) {
    try {
        include './classes/Chat.php';
        // Create an instance of the Chat class
        $chat = new Chat();

        // Update the response
        $chatID = intval($_POST['chatID']);
        $response = $_POST['response'];

        // Call the updateResponse method
        $chat->updateResponse($chatID, $response);

        // Redirect back to the chat page with a success message
        header("Location: chats.php?success=1");
        exit();
    } catch (Exception $e) {
        // Handle any errors by redirecting with an error message
        header("Location: chats.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Redirect if invalid request
    header("Location: chats.php?error=Invalid request");
    exit();
}
