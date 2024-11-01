<?php
include 'mop_session_check.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
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
        .selectpicker {
            width: 100%;

        }

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
                    <li class="nav-item active">
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
    <main class="container mt-4 mb-4">
        <div class="card shadow mt-4">
            <div class="card-body">
                <h2>Other Updates</h2>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="card shadow mt-4">
                <div class="card-body">
                    <h3>Units</h3>
                    <div class="row">
                        <div class="col-6">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Unit Name</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    require "connection.php";

                                    $query = "SELECT * FROM units";

                                    $units_table_rs = Database::search($query);
                                    $units_table_num = $units_table_rs->num_rows;


                                    for ($x = 0; $x < $units_table_num; $x++) {
                                        $units_table_data = $units_table_rs->fetch_assoc();

                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $x + 1; ?></th>
                                            <td><?php echo $units_table_data['name']; ?></td>
                                        </tr>

                                    <?php


                                    }

                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-6">
                            <p>
                                <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseUnit" aria-expanded="false" aria-controls="collapseWidthExample">
                                    New Unit
                                </button>
                            </p>
                            <div style="min-height: 120px;">
                                <div class="collapse width" id="collapseUnit">
                                    <div class="card card-body shadow" style="width: 420px;">
                                        <form>
                                            <h4>Add New Unit</h4>
                                            <div class="form-group">
                                                <label for="unit">Unit</label>
                                                <input type="text" class="form-control form-control-sm" id="unit" required>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-sm " onclick="add_unit();">Add Unit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <hr class="mt-5 mb-5" />

            <div class="card shadow mt-4">
                <div class="card-body">
                    <h3>GRN Types</h3>
                    <div class="row">
                        <div class="col-6">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">GRN Type</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $query2 = "SELECT * FROM grn_type";

                                    $grn_table_rs = Database::search($query2);
                                    $grn_table_num = $grn_table_rs->num_rows;


                                    for ($x = 0; $x < $grn_table_num; $x++) {
                                        $grn_table_data = $grn_table_rs->fetch_assoc();

                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $x + 1; ?></th>
                                            <td><?php echo $grn_table_data['name']; ?></td>
                                        </tr>

                                    <?php


                                    }

                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-6">
                            <p>
                                <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseGRN" aria-expanded="false" aria-controls="collapseWidthExample">
                                    New GRN Type
                                </button>
                            </p>
                            <div style="min-height: 120px;">
                                <div class="collapse width" id="collapseGRN">
                                    <div class="card card-body shadow" style="width: 420px;">
                                        <form>
                                            <h4>Add New GRN Type</h4>
                                            <div class="form-group">
                                                <label for="unit">GRN Type</label>
                                                <input type="text" class="form-control form-control-sm" id="grn" required>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-sm" onclick="add_grn();">Add GRN Type</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <hr class="mt-5 mb-5" />

            <div class="card shadow mt-4">
                <div class="card-body">

                    <h3>Suppliers</h3>
                    <div class="row">
                        <div class="col-8">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Company</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $query3 = "SELECT * FROM supplier";

                                    $sup_table_rs = Database::search($query3);
                                    $sup_table_num = $sup_table_rs->num_rows;


                                    for ($x = 0; $x < $sup_table_num; $x++) {
                                        $sup_table_data = $sup_table_rs->fetch_assoc();

                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $x + 1; ?></th>
                                            <td><?php echo $sup_table_data['sup_name']; ?></td>
                                            <td><?php echo $sup_table_data['contact']; ?></td>
                                            <td><?php echo $sup_table_data['name']; ?></td>
                                        </tr>

                                    <?php


                                    }

                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-4">
                            <p>
                                <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseSupplier" aria-expanded="false" aria-controls="collapseWidthExample">
                                    New Supplier
                                </button>
                            </p>
                            <div style="min-height: 120px;">
                                <div class="collapse width" id="collapseSupplier">
                                    <div class="card card-body shadow" style="width: 420px;">
                                        <form>
                                            <h4>Add New Supplier</h4>
                                            <div class="form-group">
                                                <label for="supplierName">Supplier Name</label>
                                                <input type="text" class="form-control form-control-sm" id="supplierName" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="company">Company Name</label>
                                                <input type="text" class="form-control form-control-sm" id="company" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="mobile">Mobile</label>
                                                <input type="number" class="form-control form-control-sm" id="mobile" required>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-sm" onclick="add_supplier();">Add Supplier</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <hr class="mt-5 mb-5" />

            <div class="card shadow mt-4">
                <div class="card-body">

                    <h3>Item Group</h3>
                    <div class="row">
                        <div class="col-8">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Item Group ID</th>
                                        <th scope="col">Item Group Name</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $query4 = "SELECT * FROM mop_item_group";

                                    $item_group_table_rs = Database::search($query4);
                                    $item_group_num = $item_group_table_rs->num_rows;


                                    for ($x = 0; $x < $item_group_num; $x++) {
                                        $item_group_data = $item_group_table_rs->fetch_assoc();

                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $x + 1; ?></th>
                                            <td><?php echo $item_group_data['code']; ?></td>
                                            <td><?php echo $item_group_data['name']; ?></td>
                                        </tr>

                                    <?php


                                    }

                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-4">
                            <p>
                                <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseig" aria-expanded="false" aria-controls="collapseWidthExample">
                                    New Item Group
                                </button>
                            </p>
                            <div style="min-height: 120px;">
                                <div class="collapse width" id="collapseig">
                                    <div class="card card-body shadow" style="width: 420px;">
                                        <form>
                                            <h4>Add New Item Group</h4>
                                            <div class="form-group">
                                                <label for="igc">Item Group Code</label>
                                                <input type="text" class="form-control form-control-sm" id="igc" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="ign">Item Group Name</label>
                                                <input type="text" class="form-control form-control-sm" id="ign" required>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-sm" onclick="mop_add_item_group();">Add Item Group</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <hr class="mt-5 mb-5" />

            <div class="card shadow mt-4">
                <div class="card-body">

                    <h3>Item Sub Group</h3>
                    <div class="row">
                        <div class="col-8">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Item Sub Group ID</th>
                                        <th scope="col">Item Sub Group Name</th>
                                        <th scope="col">Item Group ID</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $query4 = "SELECT * FROM mop_item_sub_group";

                                    $mop_item_group_sub_table_rs = Database::search($query4);
                                    $mop_item_group_sub_num = $mop_item_group_sub_table_rs->num_rows;


                                    for ($x = 0; $x < $mop_item_group_sub_num; $x++) {
                                        $item_sub_group_data = $mop_item_group_sub_table_rs->fetch_assoc();

                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $x + 1; ?></th>
                                            <td><?php echo $item_sub_group_data['sub_code']; ?></td>
                                            <td><?php echo $item_sub_group_data['name']; ?></td>
                                            <td><?php echo $item_sub_group_data['mop_item_group_code']; ?></td>
                                        </tr>

                                    <?php


                                    }

                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-4">
                            <p>
                                <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseisg" aria-expanded="false" aria-controls="collapseWidthExample">
                                    New Sub Item Group
                                </button>
                            </p>
                            <div style="min-height: 120px;">
                                <div class="collapse width" id="collapseisg">
                                    <div class="card card-body shadow" style="width: 420px;">
                                        <form>
                                            <h4>Add New Item Sub Group</h4>
                                            <div class="form-group">
                                                <label for="itmgp">Item Group</label>
                                                <select class="form-control" id="itmgp">
                                                    <option value="0" disabled selected>Select a Item Group</option>
                                                    <?php

                                                    $mop_item_group_rs = Database::search("SELECT * FROM `mop_item_group`");
                                                    $mop_item_group_num = $mop_item_group_rs->num_rows;

                                                    for ($x = 0; $x < $mop_item_group_num; $x++) {
                                                        $mop_item_group_data = $mop_item_group_rs->fetch_assoc();

                                                    ?>

                                                        <option value="<?php echo $mop_item_group_data["code"]; ?>"><?php echo $mop_item_group_data["name"]; ?></option>

                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="igc">Item Sub Group Code</label>
                                                <input type="text" class="form-control form-control-sm" id="igc1" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="ign">Item Sub Group Name</label>
                                                <input type="text" class="form-control form-control-sm" id="ign1" required>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-sm" onclick="mop_add_item_sub_group();">Add Item Sub Group</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>



        </div>



    </main>

    <?php include 'footer.php'; ?>

    <script src="assets/js/script.js"></script>
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
    </script>
</body>

</html>