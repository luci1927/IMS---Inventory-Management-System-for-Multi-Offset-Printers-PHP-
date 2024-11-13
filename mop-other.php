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
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
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

        .table-container {
            max-height: 300px;
            /* Set the max height for vertical scroll */
            overflow-y: auto;
            /* Enables vertical scrolling */
            overflow-x: auto;
            /* Enables horizontal scrolling */
        }

        .table-container2 {
            max-height: 600px;
            /* Set the max height for vertical scroll */
            overflow-y: auto;
            /* Enables vertical scrolling */
            overflow-x: auto;
            /* Enables horizontal scrolling */
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
                        <div class="col-12 col-lg-6 col-xl-6 table-container">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Unit Name</th>
                                        <th scope="col">Action</th>
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
                                            <td>
                                                <button onclick="edit_unit_model('<?php echo $units_table_data['id']; ?>', '<?php echo $units_table_data['name']; ?>');"
                                                    class="btn btn-warning btn-sm"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <!-- Edit Unit Modal -->
                                                <div class="modal fade" id="editUnitModal" tabindex="-1" role="dialog" aria-labelledby="editUnitModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editUnitModalLabel">Edit Unit</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="editUnitForm">
                                                                    <div class="form-group">
                                                                        <label for="editUnitName">Unit Name</label>
                                                                        <input type="text" class="form-control" id="editUnitName" value="<?php echo $units_table_data['name']; ?>" required>
                                                                    </div>
                                                                    <input type="hidden" id="editUnitId" value="<?php echo $units_table_data['id']; ?>">
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary" onclick="saveUnitChanges()">Save changes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($units_table_data["status_status_id"] == 1) {
                                                ?>
                                                    <button id="ub<?php echo $units_table_data['id']; ?>" class="btn btn-success btn-sm" onclick="confirmAction1('<?php echo $units_table_data['id']; ?>', 'Inactive');">Active</button>
                                                <?php
                                                } else if ($units_table_data["status_status_id"] == 2) {
                                                ?>
                                                    <button id="ub<?php echo $units_table_data['id']; ?>" class="btn btn-danger btn-sm" onclick="confirmAction1('<?php echo $units_table_data['id']; ?>', 'Active');">Inactive</button>
                                                <?php
                                                }
                                                ?>
                                                <script>
                                                    function confirmAction1(uID, action) {
                                                        if (confirm('Are you sure you want to mark this item as ' + action + '?')) {
                                                            update_unit_status(uID);
                                                        }
                                                    }
                                                </script>

                                            </td>
                                        </tr>

                                    <?php


                                    }

                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-12 col-lg-6 col-xl-6">
                            <p>
                                <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseUnit" aria-expanded="false" aria-controls="collapseWidthExample">
                                    New Unit
                                </button>
                            </p>
                            <div style="min-height: 120px;">
                                <div class="collapse width" id="collapseUnit">
                                    <div class="card card-body shadow">
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
                        <div class="table-container col-12 col-lg-6 col-xl-6">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">GRN Type</th>
                                        <th scope="col">Action</th>
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
                                            <td>
                                                <button onclick="edit_grn_model('<?php echo $grn_table_data['id']; ?>', '<?php echo $grn_table_data['name']; ?>');"
                                                    class="btn btn-warning btn-sm"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <!-- Edit Grn Modal -->
                                                <div class="modal fade" id="editGrnModal" tabindex="-1" role="dialog" aria-labelledby="editGrnModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editGrnModalLabel">Edit Grn</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="editGrnForm">
                                                                    <div class="form-group">
                                                                        <label for="editGrnName">Grn Name</label>
                                                                        <input type="text" class="form-control" id="editGrnName" value="<?php echo $grn_table_data['name']; ?>" required>
                                                                    </div>
                                                                    <input type="hidden" id="editGrnId" value="<?php echo $grn_table_data['id']; ?>">
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary" onclick="saveGrnChanges()">Save changes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($grn_table_data["status_status_id"] == 1) {
                                                ?>
                                                    <button id="gb<?php echo $grn_table_data['id']; ?>" class="btn btn-success btn-sm" onclick="confirmAction2('<?php echo $grn_table_data['id']; ?>', 'Inactive');">Active</button>
                                                <?php
                                                } else if ($grn_table_data["status_status_id"] == 2) {
                                                ?>
                                                    <button id="gb<?php echo $grn_table_data['id']; ?>" class="btn btn-danger btn-sm" onclick="confirmAction2('<?php echo $grn_table_data['id']; ?>', 'Active');">Inactive</button>
                                                <?php
                                                }
                                                ?>
                                                <script>
                                                    function confirmAction2(gID, action) {
                                                        if (confirm('Are you sure you want to mark this item as ' + action + '?')) {
                                                            update_grn_status(gID);
                                                        }
                                                    }
                                                </script>

                                            </td>
                                        </tr>

                                    <?php


                                    }

                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-12 col-lg-6 col-xl-6 mt-3">
                            <p>
                                <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseGRN" aria-expanded="false" aria-controls="collapseWidthExample">
                                    New GRN Type
                                </button>
                            </p>
                            <div style="min-height: 120px;">
                                <div class="collapse width" id="collapseGRN">
                                    <div class="card card-body shadow">
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
                        <div class="table-container col-12 col-lg-8 col-xl-8">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Action</th>
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
                                            <td>
                                                <button onclick="edit_sup_model('<?php echo $sup_table_data['id']; ?>', '<?php echo $sup_table_data['sup_name']; ?>' , '<?php echo $sup_table_data['contact']; ?>','<?php echo $sup_table_data['name']; ?>');"
                                                    class="btn btn-warning btn-sm"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <!-- Edit Sup Modal -->
                                                <div class="modal fade" id="editSupModal" tabindex="-1" role="dialog" aria-labelledby="editSupModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editSupModalLabel">Edit Supplier</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="editSupForm">
                                                                    <div class="form-group">
                                                                        <label for="editSupName">Supplier Name</label>
                                                                        <input type="text" class="form-control" id="editSupName" value="<?php echo $sup_table_data['sup_name']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="editSupMobile">Supplier Mobile</label>
                                                                        <input type="text" class="form-control" id="editSupMobile" value="<?php echo $sup_table_data['contact']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="editComName">Company</label>
                                                                        <input type="text" class="form-control" id="editComName" value="<?php echo $sup_table_data['name']; ?>" required>
                                                                    </div>
                                                                    <input type="hidden" id="editSupId" value="<?php echo $sup_table_data['id']; ?>">
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary" onclick="saveSupChanges()">Save changes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($sup_table_data["status_status_id"] == 1) {
                                                ?>
                                                    <button id="sb<?php echo $sup_table_data['id']; ?>" class="btn btn-success btn-sm" onclick="confirmAction3('<?php echo $sup_table_data['id']; ?>', 'Inactive');">Active</button>
                                                <?php
                                                } else if ($sup_table_data["status_status_id"] == 2) {
                                                ?>
                                                    <button id="sb<?php echo $sup_table_data['id']; ?>" class="btn btn-danger btn-sm" onclick="confirmAction3('<?php echo $sup_table_data['id']; ?>', 'Active');">Inactive</button>
                                                <?php
                                                }
                                                ?>
                                                <script>
                                                    function confirmAction3(sID, action) {
                                                        if (confirm('Are you sure you want to mark this item as ' + action + '?')) {
                                                            update_sup_status(sID);
                                                        }
                                                    }
                                                </script>

                                            </td>
                                        </tr>

                                    <?php


                                    }

                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-12 col-lg-4 col-xl-4 mt-3">
                            <p>
                                <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseSupplier" aria-expanded="false" aria-controls="collapseWidthExample">
                                    New Supplier
                                </button>
                            </p>
                            <div style="min-height: 120px;">
                                <div class="collapse width" id="collapseSupplier">
                                    <div class="card card-body shadow">
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
                        <div class="table-container col-12 col-lg-8 col-xl-8">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Item Group ID</th>
                                        <th scope="col">Item Group Name</th>
                                        <th scope="col">Action</th>
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
                                            <td>
                                                <button onclick="edit_item_group_model('<?php echo $item_group_data['code']; ?>', '<?php echo $item_group_data['name']; ?>');"
                                                    class="btn btn-warning btn-sm"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <!-- Edit Item Group Modal -->
                                                <div class="modal fade" id="editItemGroupModal" tabindex="-1" role="dialog" aria-labelledby="editItemGroupModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editItemGroupModalLabel">Edit Item Group</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="editItemGroupForm">
                                                                    <div class="form-group">
                                                                        <label for="editItemGroupId">Item Group Name</label>
                                                                        <input type="text" class="form-control" id="editItemGroupId" value="<?php echo $item_group_data['code']; ?>" disabled>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="editItemGroupName">Item Group Name</label>
                                                                        <input type="text" class="form-control" id="editItemGroupName" value="<?php echo $item_group_data['name']; ?>" required>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary" onclick="saveItemGroupChanges()">Save changes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($item_group_data["status_status_id"] == 1) {
                                                ?>
                                                    <button id="igb<?php echo $item_group_data['code']; ?>" class="btn btn-success btn-sm" onclick="confirmAction4('<?php echo $item_group_data['code']; ?>', 'Inactive');">Active</button>
                                                <?php
                                                } else if ($item_group_data["status_status_id"] == 2) {
                                                ?>
                                                    <button id="igb<?php echo $item_group_data['code']; ?>" class="btn btn-danger btn-sm" onclick="confirmAction4('<?php echo $item_group_data['code']; ?>', 'Active');">Inactive</button>
                                                <?php
                                                }
                                                ?>
                                                <script>
                                                    function confirmAction4(igID, action) {
                                                        if (confirm('Are you sure you want to mark this item as ' + action + '?')) {
                                                            update_item_group_status(igID);
                                                        }
                                                    }
                                                </script>

                                            </td>
                                        </tr>

                                    <?php


                                    }

                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-12 col-lg-4 col-xl-4 mt-3">
                            <p>
                                <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseig" aria-expanded="false" aria-controls="collapseWidthExample">
                                    New Item Group
                                </button>
                            </p>
                            <div style="min-height: 120px;">
                                <div class="collapse width" id="collapseig">
                                    <div class="card card-body shadow">
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
                        <div class="table-container2 col-12 col-lg-8 col-xl-8">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 3%;">#</th>
                                        <th scope="col" style="width: 20%;">Sub Group ID</th>
                                        <th scope="col" style="width: 45%;">Sub Group Name</th>
                                        <th scope="col" style="width: 11%;">ID</th>
                                        <th scope="col" style="width: 11%;">Action</th>

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
                                            <td>
                                                <button class="btn btn-sm btn-info">
                                                <i class="bi bi-eye-fill"></i>
                                                </button>
                                            </td>
                                        </tr>

                                    <?php


                                    }

                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-12 col-lg-4 col-xl-4 mt-3">
                            <p>
                                <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseisg" aria-expanded="false" aria-controls="collapseWidthExample">
                                    New Sub Item Group
                                </button>
                            </p>
                            <div style="min-height: 120px;">
                                <div class="collapse width" id="collapseisg">
                                    <div class="card card-body shadow">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

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

        function edit_unit_model(unitId, unitName) {
            $('#editUnitId').val(unitId);
            $('#editUnitName').val(unitName);
            $('#editUnitModal').modal('show');
        }

        function saveUnitChanges() {
            var unitId = $('#editUnitId').val();
            var unitName = $('#editUnitName').val();

            console.log('Unit ID:', unitId);
            console.log('Unit Name:', unitName);
            // Perform AJAX request to save changes
            $.ajax({
                url: 'process_update_unit.php',
                type: 'POST',
                data: {
                    id: unitId,
                    name: unitName
                },
                success: function(response) {
                    // Handle success response
                    if (response == "success") {
                        $('#editUnitModal').modal('hide');
                        location.reload();
                    } else {
                        alert(response);
                    }

                },
                error: function(error) {
                    // Handle error response
                    console.error(error);
                }
            });
        };


        function edit_grn_model(grnId, grnName) {
            $('#editGrnId').val(grnId);
            $('#editGrnName').val(grnName);
            $('#editGrnModal').modal('show');
        }

        function saveGrnChanges() {
            var grnId = $('#editGrnId').val();
            var grnName = $('#editGrnName').val();

            console.log('Grn ID:', grnId);
            console.log('Grn Name:', grnName);
            // Perform AJAX request to save changes
            $.ajax({
                url: 'process_update_grn.php',
                type: 'POST',
                data: {
                    id: grnId,
                    name: grnName
                },
                success: function(response) {
                    // Handle success response
                    if (response == "success") {
                        $('#editGrnModal').modal('hide');
                        location.reload();
                    } else {
                        alert(response);
                    }
                },
                error: function(error) {
                    // Handle error response
                    console.error(error);
                }
            });
        };

        function edit_sup_model(supId, supName, supMobile, comName) {
            $('#editSupId').val(supId);
            $('#editSupName').val(supName);
            $('#editSupMobile').val(supMobile);
            $('#editComName').val(comName);
            $('#editSupModal').modal('show');
        }

        function saveSupChanges() {
            var supId = $('#editSupId').val();
            var supName = $('#editSupName').val();
            var supMobile = $('#editSupMobile').val();
            var comName = $('#editComName').val();

            console.log('Sup ID:', supId);
            console.log('Sup Name:', supName);
            console.log('Sup Mob:', supMobile);
            console.log('Com Name:', comName);
            // Perform AJAX request to save changes
            $.ajax({
                url: 'process_update_sup.php',
                type: 'POST',
                data: {
                    id: supId,
                    name: supName,
                    mobile: supMobile,
                    company: comName
                },
                success: function(response) {
                    // Handle success response


                    if (response == "success") {
                        $('#editSupModal').modal('hide');
                        location.reload();
                    } else {
                        alert(response);
                    }
                },
                error: function(error) {
                    // Handle error response
                    alert(error);
                    console.error(error);
                }
            });
        };

        function edit_item_group_model(itemGroupId, itemGroupName) {
            $('#editItemGroupId').val(itemGroupId);
            $('#editItemGroupName').val(itemGroupName);
            $('#editItemGroupModal').modal('show');

            console.log('itemGroup ID:', itemGroupId);
            console.log('itemGroup Name:', itemGroupName);
        }

        function saveItemGroupChanges() {
            var itemGroupId = $('#editItemGroupId').val();
            var itemGroupName = $('#editItemGroupName').val();

            console.log('itemGroup ID:', itemGroupId);
            console.log('itemGroup Name:', itemGroupName);
            // Perform AJAX request to save changes
            $.ajax({
                url: 'process_update_item_group.php',
                type: 'POST',
                data: {
                    id: itemGroupId,
                    name: itemGroupName
                },
                success: function(response) {
                    // Handle success response
                    if (response == "success") {
                        $('#editItemGroupModal').modal('hide');
                        location.reload();
                    } else {
                        alert(response);
                    }
                },
                error: function(error) {
                    // Handle error response
                    console.error(error);
                }
            });

        };
    </script>
</body>

</html>