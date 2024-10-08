<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventory Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <style>
        .selectpicker {
            width: 100%;
            /* Make the select dropdown full width */
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="rmi-index.php">Inventory System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="rmi-index.php">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="rmi-inventory.php">Inventory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rmi-reports.php">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Main Content -->
    <main class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Manage Inventory</h2>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
                Add New Item
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add New Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Item Code</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1"
                                    placeholder="Item Code">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput2">Item Description</label>
                                <input type="text" class="form-control" id="exampleFormControlInput2"
                                    placeholder="Item Description">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Unit</label>
                                <select class="form-control" id="exampleFormControlSelect1">
                                    <option>Packets</option>
                                    <option>Kg</option>
                                    <option>Item</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" placeholder="Enter quantity"
                                    step="0.01" min="0" max="10000" required />
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Remarks</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->

        <form id="inventoryForm">
            <div class="form-group row mt-3">
                <label for="item" class="col-sm-2 col-form-label">Item</label>
                <div class="col-sm-10">
                    <select class="selectpicker" data-live-search="true" id="item" title="Choose an Item">
                        <option>Bearing 6002</option>
                        <option>Bearing 6001</option>
                        <option>Bearing 6206</option>
                        <option> Needle Bearing HK 2216</option>

                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="quantity" placeholder="Enter quantity" step="0.01"
                        min="0" max="10000" required />
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-block">
                Update Quantity
            </button>
        </form>

        <h3 class="mt-5">Inventory List</h3>
        <table class="table table-striped table-hover mt-3" id="inventoryTable">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Item Description</th>
                    <th>Qty in System</th>
                    <th>Qty on Hand</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>MS0001</td>
                    <td>Bearing 6002</td>
                    <td>10</td>
                    <td>9</td>
                    <td></td>
                </tr>
                <tr>
                    <td>MS0001</td>
                    <td>Bearing 6002</td>
                    <td>10</td>
                    <td>9</td>
                    <td></td>
                </tr>
                <tr>
                    <td>MS0001</td>
                    <td>Bearing 6002</td>
                    <td>10</td>
                    <td>9</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
</body>

</html>