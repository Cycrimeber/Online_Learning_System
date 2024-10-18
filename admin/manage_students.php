<?php
include_once './admin_includes/header.php';
include_once './admin_includes/aside.php';
include_once './admin_includes/action_buttons.php';
include_once './classes/Users.php'; // Include the Users class

// Create an instance of the Users class
$users = new Users();

// Fetch all students
$students = $users->fetchAllStudents();
?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-table me-1"></i> Student List</span>
        <!-- <a href="create_student.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Student</a> -->
    </div>
    <div class="card-body">
        <table id="datatablesSimple" class="table table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Matric No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Mobile No</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Student ID</th>
                    <th>Matric No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Mobile No</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php if ($students && count($students) > 0): ?>
                    <?php foreach ($students as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['StudentID']); ?></td>
                            <td><?php echo htmlspecialchars($row['MatricNo']); ?></td>
                            <td><?php echo htmlspecialchars($row['Fname']); ?></td>
                            <td><?php echo htmlspecialchars($row['Lname']); ?></td>
                            <td><?php echo htmlspecialchars($row['Address']); ?></td>
                            <td><?php echo htmlspecialchars($row['MobileNo']); ?></td>
                            <td class="text-center">
                                <a href="edit_student.php?id=<?php echo htmlspecialchars($row['StudentID']); ?>" class="text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete_student.php?id=<?php echo htmlspecialchars($row['StudentID']); ?>" class="text-danger ms-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="return confirm('Are you sure you want to delete this student?');">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No students available</td>
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