<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];
$isCurrentUser = true;

// Ambil id user yang login
$sqlCurrentUser = "SELECT id, profile_picture, bio FROM users WHERE username='$username'";
$resultCurrentUser = mysqli_query($conn, $sqlCurrentUser);
$user = mysqli_fetch_assoc($resultCurrentUser);
$currentUserId = $user['id'];
$currentProfilePicture = $user['profile_picture'];
$currentBio = $user['bio'];

// Proses penggantian foto profil
if (isset($_FILES['profile_picture'])) {
    // Membuat direktori jika belum ada
    $target_dir = "profile_pictures/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = $_FILES['profile_picture']['name'];
    $file_tmp = $_FILES['profile_picture']['tmp_name'];
    move_uploaded_file($file_tmp, $target_dir . $file_name);

    $sqlUpdateProfilePicture = "UPDATE users SET profile_picture='$file_name' WHERE id='$currentUserId'";
    mysqli_query($conn, $sqlUpdateProfilePicture);
    $_SESSION['profile_picture'] = $file_name;
    header("Location: profile.php");
    exit();
}

// Proses edit atau tambah biografi
if (isset($_POST['submit_bio'])) {
    $bio = $_POST['bio'];
    $sqlUpdateBio = "UPDATE users SET bio='$bio' WHERE id='$currentUserId'";
    mysqli_query($conn, $sqlUpdateBio);
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Protest+Guerrilla&display=swap');

        body {
            background-image: url('asetfoto/bgpolos.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Montserrat', sans-serif;
        }

        .containerprofile {
            padding: 30px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .foto {
            text-align: center;
        }

        .foto img {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border-radius: 50%;
        }

        .info {
            margin-top: 20px;
            text-align: center;
        }

        .info p {
            margin: 5px 0;
        }

        .gantibio,
        .gantifoto {
            margin-top: 20px;
            text-align: center;
        }

        .gantifoto input[type="file"],
        .gantibio textarea,
        .gantifoto button,
        .gantibio button {
            width: 100%;
            max-width: 300px;
            margin: auto;
        }

        .gantifoto button,
        .gantibio button {
            margin-top: 10px;
        }

        .mt-4 {
            margin-top: 20px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="containerprofile">
        <h2 class="text-center fw-bold mb-3">Profile</h2>
        <div class="foto">
            <?php if(isset($currentProfilePicture) && !empty($currentProfilePicture)): ?>
                <img src="profile_pictures/<?php echo $currentProfilePicture; ?>" alt="Profile Picture">
            <?php else: ?>
                <img src="asetfoto/profil.png" alt="Profile Picture">
            <?php endif; ?>
        </div>
        <div class="info">
            <p><strong>Username:</strong> <?php echo $username; ?></p>
            <p><strong>Bio:</strong> <?php echo $currentBio; ?></p>
        </div>
        <div class="gantibio">
            <form action="profile.php" method="post">
                <textarea name="bio" rows="3" class="form-control" placeholder="Masukkan Bio..."><?php 
                echo isset($currentBio) ? $currentBio : ''; ?></textarea>
                <button type="submit" name="submit_bio" class="btn btn-dark">Edit Bio</button>
            </form>
        </div>
        <div class="gantifoto">
            <form action="profile.php" method="post" enctype="multipart/form-data">
                <input type="file" name="profile_picture" class="form-control" accept="image/*">
                <button type="submit" class="btn btn-dark">Edit Profile Picture</button>
            </form>
        </div>
        <div class="mt-4 text-center">
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</body>
</html>
