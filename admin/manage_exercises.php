<?php
include_once './admin_includes/header.php';
include_once './admin_includes/aside.php';
include_once './admin_includes/action_buttons.php';
include_once './classes/Courses.php'; // Include the Course class
include_once 'classes/Exercise.php'; // Include the Exercise class

$exercise = new Exercise(); // Create an instance of the Course class
$exercises = $exercise->fetchAllExercises(); // Fetch all exercises
?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-table me-1"></i> Available Exercises</span>
        <a href="create_exercise.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Exercise</a>
    </div>
    <div class="card-body">
        <table id="datatablesSimple" class="table table-bordered">
            <thead>
                <tr>
                    <th>Exercise ID</th>
                    <th>Lesson Title</th>
                    <th>Question</th>
                    <th>Choice A</th>
                    <th>Choice B</th>
                    <th>Choice C</th>
                    <th>Choice D</th>
                    <th>Answer</th>
                    <th>Exercise Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Exercise ID</th>
                    <th>Lesson Title</th>
                    <th>Question</th>
                    <th>Choice A</th>
                    <th>Choice B</th>
                    <th>Choice C</th>
                    <th>Choice D</th>
                    <th>Answer</th>
                    <th>Exercise Date</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php if ($exercises && count($exercises) > 0): ?>
                    <?php foreach ($exercises as $row): ?>
                        <tr>
                            <td><?php echo $row['ExerciseID']; ?></td>
                            <td><?php echo $row['LessonTitle']; ?></td>
                            <td><?php echo $row['Question']; ?></td>
                            <td><?php echo $row['ChoiceA']; ?></td>
                            <td><?php echo $row['ChoiceB']; ?></td>
                            <td><?php echo $row['ChoiceC']; ?></td>
                            <td><?php echo $row['ChoiceD']; ?></td>
                            <td><?php echo $row['Answer']; ?></td>
                            <td><?php echo $row['ExercisesDate']; ?></td>
                            <td class="text-center">
                                <a href="edit_exercise.php?id=<?php echo $row['ExerciseID']; ?>" class="text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete_exercise.php?id=<?php echo $row['ExerciseID']; ?>" class="text-danger ms-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="return confirm('Are you sure you want to delete this exercise?');">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">No exercises available</td>
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