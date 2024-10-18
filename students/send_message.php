<?php
include_once './classes/Chat.php';
$chat = new Chat();

if (isset($_POST['exerciseID'], $_POST['message'])) {
    session_start(); // Assuming session stores logged in user's info
    $userID = $_SESSION['studentid']; // Fetch the logged-in user ID
    $exerciseID = $_POST['exerciseID'];
    $message = $_POST['message'];

    $chat->sendMessage($exerciseID, $userID, $message);
}
