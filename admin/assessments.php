<?php
include_once './admin_includes/header.php';
include_once './admin_includes/aside.php';
include_once './admin_includes/action_buttons.php';
include_once './classes/Assessment.php'; // Include the Assessment class
include_once './classes/Courses.php'; // Include the Courses class
include_once './classes/Exercise.php'; // Include the Exercise class

$assessment = new Assessment();
$lesson = new Course();

// Fetch all assessments
$assessments = $assessment->fetchAllAssessments();
$lessons = $lesson->fetchAllLessons();

$results = []; // Initialize an empty array for processed results

foreach ($assessments as $row) {
    $lessonDetails = $lesson->getLessonDetails($row['LessonID']);
    $lessonCount = $lesson->countLessons($row['ExerciseID']);

    $results[] = [
        'LessonTitle' => $lessonDetails['LessonTitle'],
        'LessonChapter' => $lessonDetails['LessonChapter'],
        'Category' => $lessonDetails['Category'],
        'ExerciseID' => $row['ExerciseID'],
        'StudentID' => $row['StudentID'],
        'NoItems' => $row['NoItems'],
        'Answer' => $row['Answer'],
        'Score' => $row['Score'],
        'Submitted' => $row['Submitted'],
        'LessonCount' => $lessonCount
    ];
}
?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-table me-1"></i> Assessments</span>
    </div>
    <div class="card-body">
        <table id="datatablesSimple" class="table table-bordered">
            <thead>
                <tr>
                    <th>Lesson Title</th>
                    <th>Lesson Chapter</th>
                    <th>Category</th>
                    <th>Exercise ID</th>
                    <th>Student ID</th>
                    <th>No. of Items</th>
                    <th>Answer</th>
                    <th>Score</th>
                    <th>Submitted</th>
                    <th>Number of Lessons</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Lesson Title</th>
                    <th>Lesson Chapter</th>
                    <th>Category</th>
                    <th>Exercise ID</th>
                    <th>Student ID</th>
                    <th>No. of Items</th>
                    <th>Answer</th>
                    <th>Score</th>
                    <th>Submitted</th>
                    <th>Number of Lessons</th>
                </tr>
            </tfoot>
            <tbody>
                <?php if (!empty($results)): ?>
                    <?php foreach ($results as $assessment): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($assessment['LessonTitle']); ?></td>
                            <td><?php echo htmlspecialchars($assessment['LessonChapter']); ?></td>
                            <td><?php echo htmlspecialchars($assessment['Category']); ?></td>
                            <td><?php echo htmlspecialchars($assessment['ExerciseID']); ?></td>
                            <td><?php echo htmlspecialchars($assessment['StudentID']); ?></td>
                            <td><?php echo htmlspecialchars($assessment['NoItems']); ?></td>
                            <td><?php echo htmlspecialchars($assessment['Answer']); ?></td>
                            <td><?php echo htmlspecialchars($assessment['Score']); ?></td>
                            <td><?php echo htmlspecialchars($assessment['Submitted']); ?></td>
                            <td><?php echo htmlspecialchars($assessment['LessonCount']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">No assessments available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>

<?php include './admin_includes/footer.php'; ?>