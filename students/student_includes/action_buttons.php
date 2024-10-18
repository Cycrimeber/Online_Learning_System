<?php

include_once './student_includes/header.php';
include_once './student_includes/aside.php';
include_once './student_includes/action_buttons.php';
require_once './classes/Users.php'; // Use require_once here
require_once './classes/Exercise.php'; // Ensure all are using require_once
require_once './classes/Courses.php'; // Ensure all are using require_once

$users = new Users();
$exercise = new Exercise();
$courses = new Course();

$studentCount = count($users->fetchAllStudents());
$exerciseCount = count($exercise->fetchAllExercises());
$lessonCount = count($courses->fetchAllLessons());
$videoCount = count($courses->fetchAllVideos());
$documentCount = count($courses->fetchAllDocuments());
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Student Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row mx-auto">

                <div class="col-xl-2 col-md-3">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">
                            <h1 class="text-center"><?php echo $exerciseCount; ?></h1>
                        </div>
                        <div class="card-footer ">
                            <p class="small text-white text-center">Total Exercises</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-3">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">
                            <h1 class="text-center"><?php echo $lessonCount; ?></h1>
                        </div>
                        <div class="card-footer ">
                            <p class="small text-white text-center">Total Lessons</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-3">
                    <div class="card bg-info text-white mb-4">
                        <div class="card-body">
                            <h1 class="text-center"><?php echo $videoCount; ?></h1>
                        </div>
                        <div class="card-footer ">
                            <p class="small text-white text-center">Total Videos</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-3">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">
                            <h1 class="text-center"><?php echo $documentCount; ?></h1>
                        </div>
                        <div class="card-footer ">
                            <p class="small text-white text-center">Total Documents</p>
                        </div>
                    </div>
                </div>