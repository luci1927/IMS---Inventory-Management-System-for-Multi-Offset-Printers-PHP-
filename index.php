<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="assets/favicon/favicon.png" type="image/png">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }

        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 20px;
            }
        }

        .error-message {
            display: none;
            color: red;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="login-container ">
        <h2 class="login-title">Inventory Management System</h2>

        <form id="loginForm" onsubmit="event.preventDefault(); signIn();">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter your username" required>
                <div class="error-message" id="usernameError">Username must be at least 3 characters long.</div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                <div class="error-message" id="passwordError">Password must be at least 6 characters long.</div>
            </div>

            <div class="form-group">
                <label for="department">Department</label>
                <select class="form-control" id="department" required>
                    <option value="" disabled selected>Select your department</option>
                    <?php

                    require "connection.php";

                    $dep_rs = Database::search("SELECT * FROM `departments`");
                    $dep_num = $dep_rs->num_rows;

                    for ($x = 0; $x < $dep_num; $x++) {
                        $dep_data = $dep_rs->fetch_assoc();

                    ?>

                        <option value="<?php echo $dep_data["dep_id"]; ?>"><?php echo $dep_data["dep_name"]; ?></option>

                    <?php
                    }

                    ?>
                </select>
                
                <div class="error-message" id="departmentError">Please select a department.</div>
            </div>
            <button type="submit" class="btn btn-success btn-block" >Login</button>
        </form>
    </div>
     <script src="assets/js/script.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>