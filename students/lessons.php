<?php
include_once './student_includes/header.php';
include_once './student_includes/aside.php';
include_once './student_includes/action_buttons.php';
include_once './classes/Courses.php'; // Include the Course class

$course = new Course(); // Create an instance of the Course class
$lessons = $course->fetchAllLessons(); // Fetch all lessons

// Separate lessons into two categories: videos and files
$videos = array_filter($lessons, function ($lesson) {
    return strtolower($lesson['Category']) === 'video';
});

$files = array_filter($lessons, function ($lesson) {
    return strtolower($lesson['Category']) === 'doc';
});
?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-table me-1"></i> Available Courses</span>
    </div>
    <div class="card-body">
        <!-- Table for Video Lessons -->
        <h5>Video Lessons</h5>
        <table id="videoTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Serial</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($videos)): ?>

                    <?php
                    $count = 1;
                    foreach ($videos as $index => $row): ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $row['LessonTitle']; ?></td>
                            <td class="text-center">
                                <a href="view_lesson.php?q=view&id=<?= $row['LessonID']; ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-play"></i> Play Video
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">No video lessons available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Table for File Lessons -->
        <h5>File Lessons</h5>
        <table id="fileTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Serial</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($files)): ?>
                    <?php
                    $count = 1;
                    foreach ($files as $index => $row): ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $row['LessonTitle']; ?></td>
                            <td class="text-center">
                                <a href="view_lesson.php?id=<?php echo $row['LessonID']; ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> View File
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">No file lessons available</td>
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

<?php include './student_includes/footer.php'; ?>