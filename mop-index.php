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

        html,
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .navbar {
            margin-bottom: 0;
        }

        .content {
            height: calc(100vh - 56px);
            overflow-y: auto;
        }

        .custom-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 0.5rem;
        padding: 1.5rem;
    }

    .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    /* Icon Styling */
    .custom-icon i {
        font-size: 2.5rem;
    }

    /* Text Styling */
    .card-title {
        font-size: 1rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .display-6 {
        font-size: 2rem;
        font-weight: 700;
    }
    .mousep {
        cursor: pointer;
    }
    </style>
</head>

<body>

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

        <!-- Main Content -->
        <div id="content" class="w-100">

            <?php
            require "connection.php";

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
                <div class="container">
                    <div class="row text-center my-5">
                        <!-- Card 1: Updated Today -->
                        <div class="col-lg-3 col-md-6 mb-4 mousep">
                            <div class="card custom-card shadow border-0 rounded">
                                <div class="card-body text-center">
                                    <div class="custom-icon text-success mb-3"><i class="bi bi-calendar-day"></i></div>
                                    <h5 class="card-title mb-1 text-secondary">Updated Today</h5>
                                    <h2 class="display-6 text-dark font-weight-bold"><?php echo $today_updated; ?></h2>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Updated This Month -->
                        <div class="col-lg-3 col-md-6 mb-4 mousep">
                            <div class="card custom-card shadow border-0 rounded">
                                <div class="card-body text-center">
                                    <div class="custom-icon text-warning mb-3"><i class="bi bi-calendar-week"></i></div>
                                    <h5 class="card-title mb-1 text-secondary">Updated This Month</h5>
                                    <h2 class="display-6 text-dark font-weight-bold"><?php echo $this_month_updated; ?></h2>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Low Stock Alerts -->
                        <div class="col-lg-3 col-md-6 mb-4 mousep">
                            <div class="card custom-card shadow border-0 rounded">
                                <div class="card-body text-center">
                                    <div class="custom-icon text-danger mb-3"><i class="bi bi-bell"></i></div>
                                    <h5 class="card-title mb-1 text-secondary">Low Stock Alerts</h5>
                                    <h2 class="display-6 text-dark font-weight-bold"><?php echo $low_stock_count; ?></h2>
                                </div>
                            </div>
                        </div>

                        <!-- Card 4: Total Items -->
                        <div class="col-lg-3 col-md-6 mb-4 mousep">
                            <div class="card custom-card shadow border-0 rounded">
                                <div class="card-body text-center">
                                    <div class="custom-icon text-info mb-3"><i class="bi bi-boxes"></i></div>
                                    <h5 class="card-title mb-1 text-secondary">Total Items</h5>
                                    <h2 class="display-6 text-dark font-weight-bold"><?php echo $total_item_count; ?></h2>
                                </div>
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

    <?php include 'footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

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