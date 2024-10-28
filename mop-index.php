<?php
include 'mop_session_check.php';
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Inventory Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/favicon/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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

        body {
            height: 100vh;
            /* Set body to full viewport height */
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
                    <li class="nav-item active">
                        <a class="nav-link" href="mop-index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mop-inventory.php">Inventory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mop-inventory-out.php">Inventory Out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mop-reports.php">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mop-other.php">Others</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="signout();" style="color: red;" href="index.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Date and Time Display -->
    <div id="dateTimeDisplay" class="fixed-date-time"></div>

    <div class="d-flex">
        <!-- Sidebar -->
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                <a class="navbar-brand" href="mop-index.php">Inventory System | Multi Offset Printers</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="mop-index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mop-inventory.php">Inventory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mop-inventory-out.php">Inventory Out</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mop-reports.php">Reports</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mop-other.php">Others</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="signout();" style="color: red;" href="index.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <div id="content" class="w-100">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-dark">
                        <i class="fas fa-align-left"></i>
                    </button>
                    <h5 class="ml-auto">Welcome to the Inventory Management System</h5>
                </div>
            </nav>

            <?php
            require "connection.php";
// date is not working correctly!!
            $today_rs = Database::search("SELECT COUNT(*) AS daily_count
                        FROM mop_stock 
                        WHERE DATE(date_time) = CURDATE();");
            $today_data = $today_rs->fetch_assoc();
            $today_updated = $today_data['daily_count'];

            $month_rs = Database::search("SELECT COUNT(*) AS monthly_count 
                        FROM mop_stock 
                        WHERE MONTH(date_time) = MONTH(CURDATE()) 
                        AND YEAR(date_time) = YEAR(CURDATE());");

            $month_data = $month_rs->fetch_assoc();
            $this_month_updated = $month_data['monthly_count'];

            $low_stock_rs = Database::search("SELECT 
                        COUNT(*) AS low_stock_count
                        FROM 
                        mop_inventory
                        INNER JOIN 
                        mop_stock ON 
                        mop_stock.mop_inventory_item_code = mop_inventory.item_code
                        WHERE 
                        mop_inventory.status_status_id = '1' AND  mop_stock.qty_hand <=5 AND
                        mop_stock.date_time = (
                        SELECT MAX(sub_stock.date_time)
                        FROM mop_stock sub_stock
                        WHERE sub_stock.mop_inventory_item_code = mop_inventory.item_code
                        )
                        ORDER BY 
                        mop_stock.date_time DESC");

            $low_stock_data = $low_stock_rs->fetch_assoc();
            $low_stock_count = $low_stock_data['low_stock_count'];

            $total_item_rs = Database::search("SELECT COUNT(*) AS total_item_count
                        FROM mop_inventory WHERE mop_inventory.status_status_id = '1'");

            $total_item_data = $total_item_rs->fetch_assoc();
            $total_item_count = $total_item_data['total_item_count'];
            ?>

            <main class="container mt-4">
                <!-- Statistics Section -->
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h5 class="card-title">Updated Today</h5>
                                <h3><?php echo $today_updated; ?></h3>
                                <i class="fa-solid fa-calendar-day fa-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning">
                            <div class="card-body">
                                <h5 class="card-title">Updated This Month</h5>
                                <h3><?php echo $this_month_updated; ?></h3>
                                <i class="fa-solid fa-calendar-week fa-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-info">
                            <div class="card-body">
                                <h5 class="card-title">Low Stock Alerts</h5>
                                <h3><?php echo $low_stock_count; ?></h3>
                                <i class="fa-solid fa-bell fa-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-danger">
                            <div class="card-body">
                                <h5 class="card-title">Total Items</h5>
                                <h3><?php echo $total_item_count; ?></h3>
                                <i class="fa-solid fa-boxes-stacked fa-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Section -->
                <div class="row mt-5">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Update Quantity</h5>
                                <p>Update item quantity daily to adjust stock levels.</p>
                                <a href="mop-inventory.php" class="btn btn-success">Update Quantity</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Add New Item</h5>
                                <p>Add new items to the inventory database.</p>
                                <a href="mop-inventory.php" class="btn btn-success">Add new Item</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Section -->
                <div class="row mt-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center">Stock Level Overview</h5>
                                <canvas id="stockChart"></canvas> <!-- Placeholder for a chart -->
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sample Chart.js script for stockChart and reportChart


        // Fetch stock data from the PHP file
        fetch('mop_get_stock_data.php')
            .then(response => response.json())
            .then(data => {
                // Prepare data for the chart
                const labels = data.map(item => item.item_name); // Item names for x-axis
                const stockData = data.map(item => item.stock_quantity); // Stock levels for y-axis

                // Initialize the chart
                const ctx1 = document.getElementById('stockChart').getContext('2d');
                const stockChart = new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Stock Levels',
                            data: stockData,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>

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
    </script>
</body>

</html>