<?php
include_once './admin_includes/header.php';
include_once './admin_includes/aside.php';
include_once './admin_includes/action_buttons.php';
require_once 'classes/Courses.php';

$course = new Course();
$message = ""; // Initialize message variable for feedback

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lessonChapter = $_POST['lesson_chapter'] ?? '';
    $lessonTitle = $_POST['lesson_title'] ?? '';
    $category = $_POST['category'] ?? '';
    $file = $_FILES['lesson_file'] ?? null;

    // Call the method to handle lesson creation
    if ($file && isset($file['name'])) {
        $message = $course->createLesson($lessonChapter, $lessonTitle, $category, $file);
    } else {
        $message = "Please fill in all required fields."; // Error message if fields are missing
    }
}

?>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-plus me-1"></i> Create New Lesson
    </div>
    <div class="card-body">
        <?php if (!empty($message)) { ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php } ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="lesson_chapter" class="form-label">Lesson Chapter</label>
                <input type="text" class="form-control" id="lesson_chapter" name="lesson_chapter" required>
            </div>
            <div class="mb-3">
                <label for="lesson_title" class="form-label">Lesson Title</label>
                <input type="text" class="form-control" id="lesson_title" name="lesson_title" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Content Type</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Select Content Type</option>
                    <option value="video">Video</option>
                    <option value="doc">Document</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="lesson_file" class="form-label">Upload Lesson File</label>
                <input type="file" class="form-control" id="lesson_file" name="lesson_file" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Lesson</button>
        </form>
    </div>
</div>

<?php include './admin_includes/footer.php'; ?>