<?php

session_start();

require("server/connection.php");

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $result = $connection->query("SELECT * FROM users
    WHERE email = '$email' AND password = '$password'");

    if ($result->num_rows === 1) {
        $record = $result->fetch_assoc();

        // Set session variables
        $_SESSION["userid"] = $record["userid"];
        $_SESSION["firstname"] = $record["firstname"];
        $_SESSION["lastname"] = $record["lastname"];
        $_SESSION["email"] = $record["email"];
        $_SESSION["bday"] = $record["bday"];
        $_SESSION["gender"] = $record["gender"];
        $_SESSION["phone"] = $record["phone"];
        $_SESSION["homeaddress"] = $record["homeaddress"];
        $_SESSION["date_created"] = $record["date_created"];
        $_SESSION["usertype"] = $record["usertype"];
        $_SESSION["logged_in"] = true;

        $userid = $record["userid"];
        $usertype = $record["usertype"];

        $logtime = date("Y-m-d H:i:s");
        $connection->query("INSERT INTO userlogs (logtime, userid) VALUES ('$logtime', '$userid')");

        // Redirect users based on usertype
        if ($usertype == "Admin") {
            header("Location: /mtmb/admin/dashboard.php");
        } elseif ($usertype == "Staff") {
            header("Location: /mtmb/staff/dashboard.php");
        }
    } else {
        $errorMessage = "Incorrect email or password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTMB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    
    <nav class="navbar navbar-expand-lg py-4 bg-primary fixed-top">
        <div class="container-fluid">
            <img src="images/logo_mtmb.png" class="img-fluid ps-3" style="height: 50px;" alt="MTMB">
          <a class="navbar-brand ps-3 text-white fw-bold" href="home.html">MTMB Online Vehicle Impoundment Portal</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto grid gap-3">
              <li class="nav-item me-3">
                <a class="nav-link text-white fw-bold" href="home.html">HOME</a>
              </li>
              <li class="nav-item me-3">
                <a class="nav-link text-white fw-bold" href="home.html#about">ABOUT</a>
              </li>
              <li class="nav-item me-3">
                <a class="nav-link text-white fw-bold" href="home.html#contact">CONTACT US</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <div class="container-fluid mt-5 pt-5 d-flex align-items-center">
        <div class="card mt-5 col-md-4 mx-auto">
            <div class="card-body">
                <?php
                if (!empty($errorMessage)) {
                    echo "
                    <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>$errorMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                    ";
                }
                ?>
                <h4 class="card-title fw-bold text-center my-3">Admin/Staff Login</h4>
                <form method="POST" action="<?php htmlspecialchars("SELF_PHP"); ?>">
                    <div class="row mt-2">
                        <div class="col input-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email address" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <input type="checkbox" id="showPassword" onclick="togglePassword()"> Show Password
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-grid gap-2">
                            <button type="submit" class="btn btn-primary mt-3 fw-bold">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>

    <!-- Script -->  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>