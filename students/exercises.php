<?php
include_once './student_includes/header.php';
include_once './student_includes/aside.php';
include_once './student_includes/action_buttons.php';
include_once './classes/Courses.php'; // Include the Course class
include_once './classes/Exercise.php'; // Include the Exercise class

$exercise = new Exercise(); // Create an instance of the Exercise class
$exercises = $exercise->fetchAllExercises(); // Fetch all exercises
?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-table me-1"></i> Available Exercises</span>
    </div>
    <div class="card-body">
        <!-- Exercise Table with Serial Column -->
        <table id="exerciseTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Serial</th>
                    <th>Chapter</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($exercises && count($exercises) > 0): ?>
                    <?php $serial = 1; // Initialize serial counter 
                    ?>
                    <?php foreach ($exercises as $row): ?>
                        <tr>
                            <td><?php echo $serial++; ?></td> <!-- Serial Number -->
                            <td><?php echo $row['LessonChapter']; ?></td>
                            <td><?php echo $row['LessonTitle']; ?></td>
                            <td class="text-center">
                                <a href="view_exercises.php?id=<?php echo $row['ExerciseID']; ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> View Exercise
                                </a>
                                <!-- Add Chat Button with Bootstrap modal target -->
                                <button class="btn btn-primary btn-sm chat-btn" data-bs-toggle="modal" data-bs-target="#chatModal" data-exercise-id="<?php echo $row['ExerciseID']; ?>">
                                    <i class="fas fa-comments"></i> Chat
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No exercises available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Chat Modal -->
<div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chatModalLabel">Exercise Chat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="chatMessages" class="mb-3" style="max-height: 400px; overflow-y: auto;">
                    <!-- Messages will be loaded here via AJAX -->
                </div>
                <div class="input-group">
                    <input type="text" id="chatMessage" class="form-control" placeholder="Type a message...">
                    <button class="btn btn-primary" id="sendMessageBtn">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var exerciseID;

        // Open Chat Modal on Button Click
        $('.chat-btn').click(function() {
            exerciseID = $(this).data('exercise-id');
            console.log("Chat button clicked for Exercise ID: " + exerciseID); // Debugging line
            loadChatMessages(exerciseID);
            $('#chatModal').modal('show');
        });

        // Send Message on Button Click
        $('#sendMessageBtn').click(function() {
            var message = $('#chatMessage').val();
            if (message.trim() !== '') {
                $.ajax({
                    url: 'send_message.php',
                    method: 'POST',
                    data: {
                        exerciseID: exerciseID,
                        message: message
                    },
                    success: function(response) {
                        $('#chatMessage').val(''); // Clear input field
                        loadChatMessages(exerciseID); // Reload chat messages
                    }
                });
            }
        });

        // Load Chat Messages Function
        function loadChatMessages(exerciseID) {
            $.ajax({
                url: 'fetch_messages.php',
                method: 'GET',
                data: {
                    exerciseID: exerciseID
                },
                success: function(response) {
                    $('#chatMessages').html(response);
                    $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight); // Scroll to bottom
                }
            });
        }

        // Auto-reload chat messages every 5 seconds for real-time updates
        setInterval(function() {
            if ($('#chatModal').is(':visible')) {
                loadChatMessages(exerciseID);
            }
        }, 5000);
    });
</script>

<script>
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>

<?php include './student_includes/footer.php'; ?>