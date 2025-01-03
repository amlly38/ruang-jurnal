<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Pastikan email memiliki domain unsika.ac.id
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@.*unsika\.ac\.id$/', $email)) {
        $error = "Please enter a valid email with unsika.ac.id domain.";
    } else {
        // Check if username or email already exists
        $check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $check_result = mysqli_query($conn, $check_query);
        if (mysqli_num_rows($check_result) > 0) {
            $error = "Username or email already exists.";
        } else {
            // Encrypt password
            $encrypted_password = encryptPassword($password);

            // Insert user data into the database
            $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$encrypted_password', '$email')";

            if (mysqli_query($conn, $sql)) {
                $_SESSION['user'] = $username;
                header("Location: login.php"); // Redirect to login page after successful registration
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}

// Function to encrypt password
function encryptPassword($password) {
    global $encryption_key;
    return openssl_encrypt($password, 'AES-128-ECB', $encryption_key);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Register</title>
    <style>
        body {
            background-image: url('asetfoto/bgpolos.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .container2 {
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 15px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .container2 h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .container2 input[type="email"], .container2 input[type="text"], .container2 input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container2 button {
            width: 90%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: white;
            cursor: pointer;
        }
        .container2 button:hover {
            background-color: #555;
        }
        .container2 .error {
            color: red;
            margin-bottom: 10px;
        }

        .container2 p a {
            color: black;
            text-decoration: none;
        }
        .container2 p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-semibold text-dark" href="index.php">
        <img src="asetfoto/logo.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
        <i class="text-black ms-2"> Ruang Jurnal </i>
        </a>
        <ul class="nav justify-content-end me-auto">  
            <li class="nav-item">
            <a class="btn btn-dark" aria-current="page" href="home.php">Home</a>
            </li>
        </ul>
    </div>
    </nav>
    <div class="container2 mt-5">
        <h1>Register</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="register.php" method="post" style="margin-top:7%;">
            <input type="email" name="email" placeholder="Email (unsika.ac.id)" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <br>
            <button type="submit" style="width: 91%;">Buat Akun</button>
        </form>
        <p class="mt-5 mb-2">Already have an account? <strong><a href="login.php">Login here</a></strong></p>
    </div>
</body>
</html>