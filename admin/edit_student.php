<?php
include_once './admin_includes/header.php';
include_once './admin_includes/aside.php';
include_once './admin_includes/action_buttons.php';
include_once './classes/Users.php';

$user = new Users();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentID = $_POST['StudentID'];
    $data = [
        'MatricNo' => $_POST['MatricNo'],
        'Fname' => $_POST['Fname'],
        'Lname' => $_POST['Lname'],
        'Address' => $_POST['Address'],
        'MobileNo' => $_POST['MobileNo'],
    ];

    try {
        $user->editStudent($studentID, $data);
        echo "<div class='alert alert-success'>Student updated successfully!</div>";
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
    }
}

if (isset($_GET['id'])) {
    $studentID = $_GET['id'];
    // Fetch student details to populate the form
    $students = $user->fetchAllStudents();
    $student = array_filter($students, fn($s) => $s['StudentID'] == $studentID);
    $student = reset($student); // Get the first matching student
    if (!$student) {
        echo "<div class='alert alert-danger'>Student not found!</div>";
        exit();
    }
}
?>

<div class="card mb-4">
    <div class="card-header">Edit Student</div>
    <div class="card-body">
        <form method="POST" action="">
            <input type="hidden" name="StudentID" value="<?php echo $student['StudentID']; ?>">
            <div class="mb-3">
                <label>Matric No</label>
                <input type="text" name="MatricNo" class="form-control" value="<?php echo htmlspecialchars($student['MatricNo']); ?>" required>
            </div>
            <div class="mb-3">
                <label>First Name</label>
                <input type="text" name="Fname" class="form-control" value="<?php echo htmlspecialchars($student['Fname']); ?>" required>
            </div>
            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" name="Lname" class="form-control" value="<?php echo htmlspecialchars($student['Lname']); ?>" required>
            </div>
            <div class="mb-3">
                <label>Address</label>
                <input type="text" name="Address" class="form-control" value="<?php echo htmlspecialchars($student['Address']); ?>" required>
            </div>
            <div class="mb-3">
                <label>Mobile No</label>
                <input type="text" name="MobileNo" class="form-control" value="<?php echo htmlspecialchars($student['MobileNo']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Student</button>
        </form>
    </div>
</div>

<?php include './admin_includes/footer.php'; ?>