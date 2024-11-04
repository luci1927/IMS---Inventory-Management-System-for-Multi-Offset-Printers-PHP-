<?php
include 'mop_session_check.php';
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="refresh" content="10">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventory Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link rel="icon" href="assets/favicon/favicon.png" type="image/png">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .fixed-date-time {
            position: fixed;
            top: 60px;
            left: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            z-index: 9999;
        }

        @media (max-width: 768px) {
            .fixed-date-time {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="mop-index.php">Inventory System | Multi Offset Printers</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="mop-index.php">Home</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="mop-inventory.php">Inventory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mop-inventory-out.php">Inventory Out</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="mop-requests.php">Issue Request</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mop-reports.php">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mop-other.php">Others</a>
                    </li>
                    <li class="nav-item mt-1">
                        <button id="logoutButton" onclick="confirmLogout()" class="btn btn-danger"
                            style="font-weight: bold; cursor: pointer; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-people-fill"></i>
                        </button>


                        <script>
                            function confirmLogout() {
                                if (confirm("Are you sure you want to logout?")) {
                                    signout();
                                }
                            }
                        </script>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div id="dateTimeDisplay" class="fixed-date-time"></div>

    <!-- Main Content -->
    <main class="container mt-5">

        <div class="card shadow ">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Inventory | Issue Request List</h2>

                </div>

                <h3 class="mt-5">Today Issue Request List</h3>
                <div class="table-responsive">
                    <table class="table table-hover table-hover mt-3" id="issueRequestTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Refference No</th>
                                <th>Description</th>
                                <th>Name</th>
                                <th>Time Requested</th>
                                <th>Time Approved</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <?php

                        $results_per_page = 10;

                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        if ($page <= 0) $page = 1;

                        $offset = ($page - 1) * $results_per_page;

                        $query_total = "SELECT COUNT(*) AS total FROM request
                INNER JOIN request_status ON request.request_status_id = request_status.id 
                INNER JOIN request_user ON request_user.email = request.request_user_email 
                WHERE (request.request_status_id = '2' OR request.request_status_id = '3') 
                AND DATE(request.time_requested) = CURDATE() ;";
                        $total_result = Database::search($query_total);
                        $total_row = $total_result->fetch_assoc();
                        $total_records = $total_row['total'];

                        $total_pages = ceil($total_records / $results_per_page);

                        $query = "SELECT request.ref_no AS ref_no, request.`description` AS descr, request_user.`name` AS reqName, request.request_status_id AS istatus_id,
                request.time_requested AS time_requested, request.time_approved AS time_approved, request_status.`name` AS status_name
                FROM request
                INNER JOIN request_status ON request.request_status_id = request_status.id 
                INNER JOIN request_user ON request_user.email = request.request_user_email 
                WHERE (request.request_status_id = '2' OR request.request_status_id = '3')
                AND DATE(request.time_requested) = CURDATE() 
                ORDER BY request.time_approved DESC 
                LIMIT $results_per_page OFFSET $offset;";

                        $item_table_rs = Database::search($query);
                        $item_table_num = $item_table_rs->num_rows;
                        ?>

                        <tbody>
                            <?php
                            for ($x = 0; $x < $item_table_num; $x++) {
                                $item_table_data = $item_table_rs->fetch_assoc();
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $x + 1; ?></th>
                                    <td><?php echo $item_table_data['ref_no']; ?></td>
                                    <td><?php echo nl2br(htmlspecialchars($item_table_data['descr'])) . "<br>"; ?></td>
                                    <td><?php echo $item_table_data['reqName']; ?></td>
                                    <td><?php echo $item_table_data['time_requested']; ?></td>
                                    <td><?php echo $item_table_data['time_approved']; ?></td>
                                    <td><?php
                                        if ($item_table_data["istatus_id"] == 2) {
                                        ?>
                                            <button id="ub<?php echo $item_table_data['ref_no']; ?>" class="btn btn-danger" onclick="change_mop_issue_status('<?php echo $item_table_data['ref_no']; ?>', 'Viewed');">Approved</button>
                                        <?php
                                        } else if ($item_table_data["istatus_id"] == 3) {
                                        ?>
                                            <button disabled id="ub<?php echo $item_table_data['ref_no']; ?>" class="btn btn-success" onclick="change_mop_issue_status('<?php echo $item_table_data['ref_no']; ?>', 'Approved');">Viewed</button>
                                        <?php
                                        } else {
                                            echo "No action available";
                                        }
                                        ?>

                                        <script>
                                            function confirmAction(refNo, action) {
                                                if (confirm('Are you sure you want to mark this request as ' + action + '?')) {
                                                    change_mop_issue_status(refNo);
                                                }
                                            }
                                        </script>


                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>

                </div>

                <nav>
                    <ul class="pagination justify-content-center mt-4">
                        <?php if ($page > 1) { ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>

                        <?php if ($page < $total_pages) { ?>
                            <li class="page-item">
                                <a class="pa        ge-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>

    </main>

    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        function updateDateTime() {
            const dateTimeDisplay = document.getElementById('dateTimeDisplay');
            const now = new Date();

            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const formattedDate = now.toLocaleDateString('en-US', options);

            const formattedTime = now.toLocaleTimeString('en-US', {
                hour12: false
            });

            dateTimeDisplay.innerHTML = `Today is ${formattedDate} - ${formattedTime}`;
        }

        setInterval(updateDateTime, 1000);

        updateDateTime();

        setInterval(function() {
            location.reload();
        }, 10000); // 10 seconds
    </script>
</body>

</html>