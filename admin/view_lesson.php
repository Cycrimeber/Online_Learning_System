<?php
include_once './admin_includes/header.php';
include_once './admin_includes/aside.php';
include_once './admin_includes/action_buttons.php';
include_once 'classes/Courses.php';

// Create an instance of the Course class
$course = new Course();

// Check if a lesson ID is provided via GET request
if (isset($_GET['id'])) {
    $lessonID = $_GET['id'];

    // Fetch the lesson data by ID
    $lesson = $course->fetchLessonByID($lessonID);

    if (!$lesson) {
        echo "<div class='alert alert-danger'>Lesson not found!</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger'>No lesson ID provided!</div>";
    exit();
}

?>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-book me-1"></i> Lesson Details
    </div>
    <div class="card-body">
        <h5 class="card-title">Chapter: <?php echo htmlspecialchars($lesson['LessonChapter']); ?></h5>
        <h6 class="card-subtitle mb-2 text-muted">Title: <?php echo htmlspecialchars($lesson['LessonTitle']); ?></h6>
        <p class="card-text">Category: <?php echo htmlspecialchars($lesson['Category']); ?></p>

        <?php
        // Check if the lesson file exists and display based on type (video or document)
        if ($lesson['Category'] === 'video') {
            // Display the video file
            echo "<div class='mb-3'>
                    <video width='100%' height='auto' controls>
                        <source src='" . htmlspecialchars($lesson['FileLocation']) . "' type='video/mp4'>
                        Your browser does not support the video tag.
                    </video>
                  </div>";
        } elseif ($lesson['Category'] === 'doc') {
            // Display document icon with download button
            echo "<div class='mb-3'>
                    <i class='fas fa-file-alt fa-3x'></i>
                    <p class='mt-2'>Document: " . htmlspecialchars($lesson['FileLocation']) . "</p>
                    <a href='" . htmlspecialchars($lesson['FileLocation']) . "' class='btn btn-primary' download>Download Document</a>
                  </div>";
        } else {
            echo "<div class='alert alert-warning'>No file associated with this lesson.</div>";
        }
        ?>
    </div>
</div>

<?php include './admin_includes/footer.php'; ?>