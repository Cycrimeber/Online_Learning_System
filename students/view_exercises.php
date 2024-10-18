<?php
session_start();
include_once './student_includes/header.php';
include_once './student_includes/aside.php';
include_once './student_includes/action_buttons.php';
include_once './classes/Exercise.php';
include_once './classes/Users.php';
include_once './classes/StudentQuestion.php';
include_once './classes/Score.php';

// Assuming the logged-in student's ID is stored in session
$studentID = $_SESSION['studentid'];

// Create instances of classes
$exercise = new Exercise();
$studentQuestion = new StudentQuestion();
$score = new Score();

// Fetch all exercises
$exercises = $exercise->fetchAllExercises();
$lessonID = $_GET['id'];
// Check if the student has already submitted this exercise
$previousScore = $score->fetchStudentScore($studentID, $lessonID); // Assume this function exists

$alreadySubmitted = false;
if ($previousScore) {
    $alreadySubmitted = true;
}

// On form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$alreadySubmitted) {
    $lessonID = $_POST['lesson_id'];  // Assuming lesson_id is //passed from the form
    // $lessonID = $_GET['id'];
    $totalExercises = count($exercises);  // Total exercises answered
    $scoreCount = 0; // Initialize score

    // Loop through exercises and store answers
    foreach ($exercises as $row) {
        $exerciseID = $row['ExerciseID'];
        $selectedAnswer = $_POST['answer_' . $exerciseID];  // Get selected answer
        $correctAnswer = $row['Answer'];

        // Insert into tblstudentquestion
        $studentQuestion->insertStudentQuestion([
            'ExerciseID' => $exerciseID,
            'LessonID' => $lessonID,
            'StudentID' => $studentID,
            'Question' => $row['Question'],
            'CA' => $row['ChoiceA'],
            'CB' => $row['ChoiceB'],
            'CC' => $row['ChoiceC'],
            'CD' => $row['ChoiceD'],
            'QA' => $selectedAnswer
        ]);

        // Check if selected answer is correct and update score
        if ($selectedAnswer == $correctAnswer) {
            $scoreCount++;
        }
    }

    // Insert into tblscore
    $score->insertScore([
        'LessonID' => $lessonID,
        'ExerciseID' => $exerciseID,
        'StudentID' => $studentID,
        'NoItems' => $totalExercises,
        'Answer' => $selectedAnswer,
        'Score' => $scoreCount,
        'Submitted' => 1  // Mark as submitted
    ]);

    // Set session to track that the exercise is completed
    $_SESSION['exercise_completed'] = true;
    $_SESSION['score'] = $scoreCount;

    // Redirect to the same page to show results
    echo '<script type="text/javascript">
    window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
</script>';
    exit;
}
?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-table me-1"></i> Available Exercises</span>
    </div>
    <div class="card-body">
        <?php if ($alreadySubmitted): ?>
            <h3 class="text-success">You have completed this exercise. Your total score is: <?php echo $_SESSION['score']; ?> / <?php echo count($exercises); ?></h3>
        <?php endif; ?>

        <form method="post" action="">
            <input type="hidden" name="lesson_id" value="<?php echo $lessonID; ?>"> <!-- Assuming lesson ID is available -->
            <?php if ($exercises && count($exercises) > 0): ?>
                <?php foreach ($exercises as $row): ?>
                    <div class="exercise-item mb-4">
                        <h5><?php echo htmlspecialchars($row['Question']); ?></h5>

                        <?php
                        // Determine if this answer has been submitted
                        $correctAnswer = $row['Answer'];
                        $selectedAnswer = null;
                        if ($alreadySubmitted) {
                            $selectedAnswer = $studentQuestion->fetchStudentAnswer($studentID, $row['ExerciseID']); // Assume this method exists
                        }
                        ?>

                        <?php foreach (['A', 'B', 'C', 'D'] as $option): ?>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="answer_<?php echo $row['ExerciseID']; ?>"
                                    value="<?php echo $option; ?>"
                                    <?php echo $alreadySubmitted ? 'disabled' : ''; ?>
                                    <?php echo ($selectedAnswer === $option) ? 'checked' : ''; ?>
                                    style="color: 
                                        <?php if ($alreadySubmitted) {
                                            echo ($option === $correctAnswer) ? 'green' : (($selectedAnswer === $option) ? 'red' : '');
                                        } ?>">
                                <label class="form-check-label">
                                    <?php echo htmlspecialchars($row['Choice' . $option]); ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

                <?php if (!$alreadySubmitted): ?>
                    <button type="submit" class="btn btn-primary">Submit Answers</button>
                <?php endif; ?>
            <?php else: ?>
                <p class="text-center">No exercises available</p>
            <?php endif; ?>
        </form>
    </div>
</div>


<script>
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>

<?php include './student_includes/footer.php'; ?>