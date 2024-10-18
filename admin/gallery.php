<?php
include_once './admin_includes/header.php';
include_once './admin_includes/aside.php';
include_once './admin_includes/action_buttons.php';
include_once 'classes/Courses.php';

// Create an instance of the Course class
$course = new Course();

// Fetch all lessons that are categorized as "video"
$videoLessons = $course->fetchAllVideos();

if (!$videoLessons || count($videoLessons) === 0) {
    echo "<div class='alert alert-danger'>No video lessons found!</div>";
    exit();
}
?>

<div class="container">
    <div class="row">
        <?php foreach ($videoLessons as $lesson) { ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-video me-1"></i> <?php echo htmlspecialchars($lesson['LessonTitle']); ?>
                    </div>
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Chapter: <?php echo htmlspecialchars($lesson['LessonChapter']); ?></h6>
                        <video width="100%" height="auto" controls>
                            <source src="<?php echo htmlspecialchars($lesson['FileLocation']); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="card-footer text-muted">
                        Category: <?php echo htmlspecialchars($lesson['Category']); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include './admin_includes/footer.php'; ?>