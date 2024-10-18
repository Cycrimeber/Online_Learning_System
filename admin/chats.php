<?php
session_start();
include_once './admin_includes/header.php';
include_once './admin_includes/aside.php';
include_once './admin_includes/action_buttons.php';
?>

<div class="card mb-4">
    <div class="card-header">
        <span><i class="fas fa-comments me-1"></i> Student Chats</span>
    </div>
    <div class="card-body" id="chat-container">
        <!-- Chats will be loaded here dynamically by JavaScript -->
        <p class="text-center">Loading chats...</p>
    </div>
</div>

<?php include './admin_includes/footer.php'; ?>

<!-- JavaScript to fetch and update the chats asynchronously -->
<script>
    let isTyping = false; // Variable to track if user is typing

    // Function to fetch chats from the server
    function fetchChats() {
        // Only refresh chats if the user is not typing
        if (!isTyping) {
            fetch('fetch_chats.php') // Fetch from the separate PHP file
                .then(response => response.json())
                .then(data => {
                    // If there was an error in fetching, display it
                    if (data.error) {
                        document.getElementById('chat-container').innerHTML = `<p class="text-center text-danger">${data.error}</p>`;
                        return;
                    }

                    // Otherwise, update the chat container with the fetched chats
                    let chatHTML = '';
                    let currentLesson = null;

                    if (data.length > 0) {
                        data.forEach(chatItem => {
                            if (currentLesson !== chatItem.LessonTitle) {
                                currentLesson = chatItem.LessonTitle;
                                chatHTML += `<h5 class="mt-4">${currentLesson}</h5><hr>`;
                            }

                            chatHTML += `
                                <div class="chat-item mb-3">
                                    <p><strong>Matric No:</strong> ${chatItem.MatricNo}</p>
                                    <p><strong>Message:</strong> ${chatItem.message}</p>
                                    <p><strong>Sent At:</strong> ${chatItem.sentAt}</p>
                                    
                                    <form method="POST" action="update_response.php">
                                        <input type="hidden" name="chatID" value="${chatItem.chatID}">
                                        <div class="mb-3">
                                            <label for="response">Response:</label>
                                            <textarea name="response" class="form-control response-textarea" rows="2">${chatItem.response}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Submit Response</button>
                                    </form>

                                    <p><strong>Response At:</strong> ${chatItem.responseAt || 'No response yet'}</p>
                                </div>
                                <hr>`;
                        });
                    } else {
                        chatHTML = '<p class="text-center">No chats available.</p>';
                    }

                    document.getElementById('chat-container').innerHTML = chatHTML;

                    // Re-attach focus and blur event listeners after the chat is re-rendered
                    attachFocusListeners();
                })
                .catch(error => {
                    document.getElementById('chat-container').innerHTML = `<p class="text-center text-danger">Error loading chats: ${error.message}</p>`;
                });
        }
    }

    // Function to attach focus and blur listeners to the textarea fields
    function attachFocusListeners() {
        document.querySelectorAll('.response-textarea').forEach(textarea => {
            textarea.addEventListener('focus', () => {
                isTyping = true; // User is typing
            });
            textarea.addEventListener('blur', () => {
                isTyping = false; // User stopped typing
            });
        });
    }

    // Fetch chats every 5 seconds
    setInterval(fetchChats, 5000);

    // Fetch chats immediately on page load
    fetchChats();
</script>