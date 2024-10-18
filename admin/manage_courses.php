<?php
include_once './admin_includes/header.php';
include_once './admin_includes/aside.php';
include_once './admin_includes/action_buttons.php';
include_once './classes/Courses.php'; // Include the Course class

$course = new Course(); // Create an instance of the Course class
$lessons = $course->fetchAllLessons(); // Fetch all lessons
?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-table me-1"></i> Available Courses</span>
        <a href="create_lesson.php" class="btn btn-primary"><i class="fas fa-plus"></i> Create New Lesson</a>
    </div>
    <div class="card-body">
        <table id="datatablesSimple" class="table table-bordered">
            <thead>
                <tr>
                    <th>Lesson ID</th>
                    <th>Chapter</th>
                    <th>Course Title</th>
                    <th>Course Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Lesson ID</th>
                    <th>Chapter</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php if ($lessons && count($lessons) > 0): ?>
                    <?php foreach ($lessons as $row): ?>
                        <tr>
                            <td><?php echo $row['LessonID']; ?></td>
                            <td><?php echo $row['LessonChapter']; ?></td>
                            <td><?php echo $row['LessonTitle']; ?></td>
                            <td><?php echo ucfirst($row['Category']); ?></td>
                            <td class="text-center">
                                <a href="edit_lesson.php?q=edie&id=<?php echo $row['LessonID']; ?>" class="text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="view_lesson.php?q=view&id=<?php echo $row['LessonID']; ?>" class="text-success ms-3" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="delete_lesson.php?id=<?php echo $row['LessonID']; ?>" class="text-danger ms-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="return confirm('Are you sure you want to delete this lesson?');">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No lessons available</td>
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