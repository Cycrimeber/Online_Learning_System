<?php
include_once './classes/Chat.php';
$chat = new Chat();

if (isset($_GET['exerciseID'])) {
    $exerciseID = $_GET['exerciseID'];
    $messages = $chat->fetchMessages($exerciseID);

    // Generate HTML for chat messages
    foreach ($messages as $message) {
        // Display the user's message and sent time on the left
        echo "
        <div class='d-flex justify-content-between mb-2'>
            <div>
                <strong>{$message['sender']}:</strong> {$message['message']}
                <small class='text-muted'>({$message['sentAt']})</small>
            </div>";

        // If admin has responded, display the response on the right
        if (!empty($message['response'])) {
            echo "
            <div class='text-end'>
                <strong>Admin:</strong> {$message['response']}
                <small class='text-muted'>({$message['responseAt']})</small>
            </div>";
        }

        echo "</div><hr>"; // Divider between messages
    }
}
