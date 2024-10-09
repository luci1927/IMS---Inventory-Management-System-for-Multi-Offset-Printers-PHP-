<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
            /* Responsive width */
        }

        /* Media query to adjust padding on smaller screens */
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

        <!-- Login Form -->
        <form id="loginForm">
            <!-- Username Field -->
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter your username" required>
                <div class="error-message" id="usernameError">Username must be at least 3 characters long.</div>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                <div class="error-message" id="passwordError">Password must be at least 6 characters long.</div>
            </div>

            <!-- Department Dropdown -->
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

            <!-- Login Button -->
            <button type="submit" class="btn btn-success btn-block" onclick="signIn();">Login</button>
        </form>
    </div>

    <!-- JavaScript for validation -->
    <!-- <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            let isValid = true;

            // Username Validation
            const username = document.getElementById('username').value.trim();
            const usernameError = document.getElementById('usernameError');
            if (username.length < 3) {
                usernameError.style.display = 'block';
                isValid = false;
            } else {
                usernameError.style.display = 'none';
            }

            // Password Validation
            const password = document.getElementById('password').value.trim();
            const passwordError = document.getElementById('passwordError');
            if (password.length < 6) {
                passwordError.style.display = 'block';
                isValid = false;
            } else {
                passwordError.style.display = 'none';
            }

            // Department Validation
            const department = document.getElementById('department').value;
            const departmentError = document.getElementById('departmentError');
            if (!department) {
                departmentError.style.display = 'block';
                isValid = false;
            } else {
                departmentError.style.display = 'none';
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault();
            }
        });
    </script> -->

    <!-- Bootstrap JS and dependencies (Optional) -->
     <script src="assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>