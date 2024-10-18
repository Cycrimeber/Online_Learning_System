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

    // Fetch the lesson data by ID to pre-fill the form for editing
    $lesson = $course->fetchLessonByID($lessonID);

    if (!$lesson) {
        echo "<div class='alert alert-danger'>Lesson not found!</div>";
        exit();
    }
}

// Check if the form is submitted via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lessonChapter = $_POST['lesson_chapter'];
    $lessonTitle = $_POST['lesson_title'];
    $category = $_POST['category'];
    $file = $_FILES['lesson_file'];

    // Call the method to handle lesson update
    $message = $course->updateLesson($lessonID, $lessonChapter, $lessonTitle, $category, $file);
}

?>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-edit me-1"></i> Update Lesson
    </div>
    <div class="card-body">
        <?php if (isset($message)) { ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php } ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="lesson_chapter" class="form-label">Lesson Chapter</label>
                <input type="text" class="form-control" id="lesson_chapter" name="lesson_chapter" value="<?php echo htmlspecialchars($lesson['LessonChapter']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="lesson_title" class="form-label">Lesson Title</label>
                <input type="text" class="form-control" id="lesson_title" name="lesson_title" value="<?php echo htmlspecialchars($lesson['LessonTitle']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Content Type</label>
                <select class="form-select" id="category" name="category">
                    <option value="">Select Content Type</option>
                    <option value="video" <?php echo $lesson['Category'] == 'video' ? 'selected' : ''; ?>>Video</option>
                    <option value="doc" <?php echo $lesson['Category'] == 'doc' ? 'selected' : ''; ?>>Document</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="lesson_file" class="form-label">Upload Lesson File</label>
                <input type="file" class="form-control" id="lesson_file" name="lesson_file">
                <small class="text-muted">Leave blank to keep the current file.</small>
            </div>
            <button type="submit" class="btn btn-primary">Update Lesson</button>
        </form>
    </div>
</div>

<?php include './admin_includes/footer.php'; ?>