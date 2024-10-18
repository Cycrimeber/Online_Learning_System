<?php
include_once './admin_includes/header.php';
include_once './admin_includes/aside.php';
include_once './admin_includes/action_buttons.php';
include_once 'classes/Courses.php';
include_once 'classes/Exercise.php'; // Include the Exercise class

$course = new Course();
$exercise = new Exercise();

// Fetch all lessons for the select dropdown
$lessons = $course->fetchAllLessons();

// Initialize variables
$message = '';
$exerciseData = null;

// Check if we're editing an exercise
if (isset($_GET['id'])) {
    $exerciseID = $_GET['id'];
    // Fetch existing exercise data by ID
    $exerciseData = $exercise->fetchExerciseByID($exerciseID); // Assume you have this method implemented in the Exercise class
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data
    $lessonID = $_POST['lesson_id'];
    $question = $_POST['question'];
    $choiceA = $_POST['choice_a'];
    $choiceB = $_POST['choice_b'];
    $choiceC = $_POST['choice_c'];
    $choiceD = $_POST['choice_d'];
    $answer = $_POST['answer'];

    // Call the method to handle exercise editing
    try {
        $message = $exercise->updateExercise($exerciseID, $lessonID, $question, $choiceA, $choiceB, $choiceC, $choiceD, $answer);
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}
?>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-edit me-1"></i> Edit Exercise
    </div>
    <div class="card-body">
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="lesson_id" class="form-label">Select Lesson</label>
                <select class="form-select" id="lesson_id" name="lesson_id" required>
                    <option value="">Select Lesson</option>
                    <?php foreach ($lessons as $lesson): ?>
                        <option value="<?php echo $lesson['LessonID']; ?>" <?php echo ($exerciseData && $exerciseData['LessonID'] == $lesson['LessonID']) ? 'selected' : ''; ?>>
                            <?php echo $lesson['LessonTitle'] . " - " . $lesson['LessonChapter']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="question" class="form-label">Question</label>
                <textarea class="form-control" id="question" name="question" rows="3" required><?php echo $exerciseData['Question'] ?? ''; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="choice_a" class="form-label">Choice A</label>
                <input type="text" class="form-control" id="choice_a" name="choice_a" value="<?php echo $exerciseData['ChoiceA'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="choice_b" class="form-label">Choice B</label>
                <input type="text" class="form-control" id="choice_b" name="choice_b" value="<?php echo $exerciseData['ChoiceB'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="choice_c" class="form-label">Choice C</label>
                <input type="text" class="form-control" id="choice_c" name="choice_c" value="<?php echo $exerciseData['ChoiceC'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="choice_d" class="form-label">Choice D</label>
                <input type="text" class="form-control" id="choice_d" name="choice_d" value="<?php echo $exerciseData['ChoiceD'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="answer" class="form-label">Correct Answer</label>
                <select class="form-select" id="answer" name="answer" required>
                    <option value="">Select Correct Answer</option>
                    <option value="A" <?php echo ($exerciseData && $exerciseData['Answer'] == 'A') ? 'selected' : ''; ?>>Choice A</option>
                    <option value="B" <?php echo ($exerciseData && $exerciseData['Answer'] == 'B') ? 'selected' : ''; ?>>Choice B</option>
                    <option value="C" <?php echo ($exerciseData && $exerciseData['Answer'] == 'C') ? 'selected' : ''; ?>>Choice C</option>
                    <option value="D" <?php echo ($exerciseData && $exerciseData['Answer'] == 'D') ? 'selected' : ''; ?>>Choice D</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Exercise</button>
        </form>
    </div>
</div>

<?php include './admin_includes/footer.php'; ?>