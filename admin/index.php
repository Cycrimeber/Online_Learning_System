<?php
include_once './admin_includes/header.php';
include_once './admin_includes/aside.php';
include_once './admin_includes/action_buttons.php';
?>


<div class="row">
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-area me-1"></i>
                Welcome to NACEST
            </div>
            <div class="card-body"><img src="../img/nacest.jpg" alt="" class="img-fluid"></div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-1"></i>
                Your Learning Matters to us
            </div>
            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
        </div>
    </div>
</div>

<?php include './admin_includes/footer.php'; ?>