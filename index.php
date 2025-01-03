<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: home.php");
    exit();
}
include 'config.php';

if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    $profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'profil.png';
} else {
    header("Location: login.php");
    exit();
}

$isCurrentUser = isset($_SESSION['user_id']);

if ($isCurrentUser) {
    $userId = $_SESSION['user_id'];
    $query = "SELECT profile_picture FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

function countLikes($conn, $journalId) {
    $sql = "SELECT COUNT(*) AS total_likes FROM likes WHERE journal_id='$journalId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_likes'];
}

$sql = "SELECT * FROM journals";

if (isset($_GET['faculty'])) {
    $faculty = $_GET['faculty'];
    if (strpos($faculty, ',') === false) {
        $sql .= " WHERE FIND_IN_SET('$faculty', faculty)";
    } else {
        $faculties = explode(',', $faculty);
        $facultyCondition = '';
        foreach ($faculties as $f) {
            $facultyCondition .= " OR FIND_IN_SET('$f', faculty)";
        }
        $facultyCondition = ltrim($facultyCondition, ' OR');
        $sql .= " WHERE $facultyCondition";
    }
    $facultyName = "Fakultas $faculty";
} else {
    $facultyName = "Semua Fakultas";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <style>
        body {
            background-image: url('asetfoto/bgpolos.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Montserrat', sans-serif;
            color: #333;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.9);
        }

        .journal {
            margin: 2%;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        .journal p {
            line-height: 1.6;
        }

        .cariuser {
            padding: 20px;
            display: grid;
            grid-template-columns: 135px 1fr;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 2%;
        }

        .foto {
            height: 175px;
            width: 135px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info {
            padding-left: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .info table {
            width: 100%;
        }

        .info p, .info td {
            margin: 5px 0;
        }

        .button-group {
            margin-top: 10px;
        }

        .btn {
            margin-right: 5px;
        }

        h1, h4 {
            text-align: center;
            margin-top: 20px;
            color: black;
        }

        h4 {
            margin-bottom: 20px;
        }

        .journals {
            padding: 20px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body>
    <?php
    // mencari user
    if (isset($_GET['query']) && !empty($_GET['query'])) {
        $query = $_GET['query'];
        $userSql = "SELECT * FROM users WHERE username LIKE '%$query%' OR bio LIKE '%$query%'";
        $userResult = mysqli_query($conn, $userSql);
        $numUserRows = mysqli_num_rows($userResult);
    } else {
        $numUserRows = 0;
    }

    // cari judul atau penulis
    if (isset($_GET['query']) && !empty($_GET['query'])) {
        $query = $_GET['query'];
        if (strpos($sql, 'WHERE') !== false) {
            $sql .= " AND (title LIKE '%$query%' OR author LIKE '%$query%')";
        } else {
            $sql .= " WHERE (title LIKE '%$query%' OR author LIKE '%$query%')";
        }
    }

    $sql .= " ORDER BY upload_time DESC"; // urutkan berdasarkan waktu unggah

    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    ?>
    <nav class="navbar navbar-light shadow-sm p-3 mb-5 rounded" display-1 id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand fw-semibold text-dark" href="index.php">
                <img src="asetfoto/logo.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
                <i class="text-dark ms-2"> Ruang Jurnal </i>
            </a>
            
            <ul class="nav justify-content-end" style="margin-top: 1%">
                <form class="d-flex" action="index.php" method="GET">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
                    <button class="btn btn-dark" type="submit">Search</button>
                </form>
                <li class="nav-item">
                    <a class="nav-link fw-bold text-dark" href="index.php">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-bold text-dark" href="#" id="navbarDropdown" role="button" 
                    data-bs-toggle="dropdown" aria-expanded="false"><?php echo "Jurnal $facultyName"; ?></a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="index.php?faculty=Ilmu Komputer">Ilmu Komputer</a></li>
                        <li><a class="dropdown-item" href="index.php?faculty=Keguruan dan Ilmu Pendidikan">Keguruan 
                            dan Ilmu Pendidikan</a></li>
                        <li><a class="dropdown-item" href="index.php?faculty=Hukum">Hukum</a></li>
                        <li><a class="dropdown-item" href="index.php?faculty=Ekonomi dan Bisnis">Ekonomi dan Bisnis</a></li>
                        <li><a class="dropdown-item" href="index.php?faculty=Pertanian">Pertanian</a></li>
                        <li><a class="dropdown-item" href="index.php?faculty=Agama Islam">Agama Islam</a></li>
                        <li><a class="dropdown-item" href="index.php?faculty=Teknik">Teknik</a></li>
                        <li><a class="dropdown-item" href="index.php?faculty=Ilmu Sosial dan Ilmu Politik">Ilmu Sosial dan Ilmu Politik</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold text-dark" href="upload.php">Upload</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold text-dark" href="hapus_jurnal.php">Jurnalku</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold text-danger" href="logout.php">Logout</a>
                </li>
                <li class="nav-item" style="margin-top: -1%">
                    <a class="nav-link text-secondary" href="profile.php">
                        <?php if ($isCurrentUser && isset($user)): ?>
                            <?php if (isset($user['profile_picture']) && !empty($user['profile_picture'])): ?>
                                <img src="profile_pictures/<?php echo htmlspecialchars($user['profile_picture']); ?>" 
                                alt="Profile Picture" style="width:40px; height:40px; border-radius:50%;" 
                                class="d-inline-block align-text-top">
                            <?php else: ?>
                                <img src="asetfoto/profil.png" alt="Profile Picture" style="width:30px; height:30px; 
                                border-radius:50%;" class="d-inline-block align-text-top">
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <h1 class="text-dark">Selamat Datang di Ruang Jurnal!</h1>
    <h4><?php echo (isset($_GET['query']) && !empty($_GET['query'])) ? 'Search Results' : 'Recent Journals & Makalah'; ?></h4>

    <div class="journals">
        <?php
        if ($numUserRows > 0) {
            while ($userRow = mysqli_fetch_assoc($userResult)): ?>
                <div class="cariuser">
                    <div class="foto">
                        <?php if ($userRow['profile_picture'] && !empty($userRow['profile_picture'])): ?>
                            <img src="profile_pictures/<?php echo $userRow['profile_picture']; ?>" 
                            alt="Profile Picture" width="130" style="margin-left:3%">
                        <?php else: ?>
                            <img src="asetfoto/profil.png" alt="Profile Picture" width="130">
                        <?php endif; ?>
                    </div>
                    <div class="bio">
                        <div class="info">
                            <table style="margin-top: 5%;">
                                <tr style="line-height:5%;">
                                    <td>
                                        <p><strong>Nama</strong></p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    <td>
                                        <p><?php echo $userRow['username']; ?></p>
                                    </td>
                                </tr>
                                <tr style="line-height:5%;">
                                    <td>
                                        <p><strong>Profile</strong></p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    <td>
                                        <p><i><a href="profile.php?user=<?= $userRow['username']; ?>&show_all=true">
                                            <?= $userRow['username']; ?></a></i></p>
                                    </td>
                                </tr>
                                <tr style="line-height:100%;">
                                    <td>
                                        <p><strong>Bio</strong></p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    <td>
                                        <p><?php echo $userRow['bio']; ?></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endwhile;
        }

        if ($numRows > 0) {
            while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="journal">
                    <p><strong>Judul: </strong> <?= $row['title']; ?></p>
                    <p><strong>Penulis: </strong> <a href="profile.php?user=<?= $row['author']; ?>&show_all=true">
                        <?= $row['author']; ?></a></p>
                    <?php if ($row['file']): ?>
                        <?php $fileExt = pathinfo($row['file'], PATHINFO_EXTENSION); ?>
                        <?php if (in_array($fileExt, array('jpg', 'jpeg', 'png', 'gif'))): ?>
                            <img src="uploads/<?= $row['file']; ?>" alt="<?= $row['title']; ?>" class="journal-image">
                        <?php elseif ($fileExt === 'pdf'): ?>
                            <iframe src="pdf-viewer.html?file=uploads/<?= $row['file']; ?>" width="100%" height="400px" 
                            style="margin-left:-30%;"></iframe>
                        <?php endif; ?>
                        <p style="margin-top:2%;"><strong>Keterangan: </strong><?= $row['content']; ?></p>
                        <div class="button-group">
                            <a href="uploads/<?= $row['file']; ?>" target="_blank" class="btn btn-primary">View</a>
                            <a href="uploads/<?= $row['file']; ?>" download class="btn btn-secondary">Download</a>
                            <form action="like.php" method="post" style="display: inline-block;">
                                <input type="hidden" name="journal_id" value="<?= $row['id']; ?>">
                                <?php
                                    $journalId = $row['id'];
                                    $userId = $_SESSION['user_id']; // Pastikan 'user_id' adalah kunci yang benar
                                    $likeSql = "SELECT * FROM likes WHERE journal_id='$journalId' AND user_id='$userId'";
                                    $likeResult = mysqli_query($conn, $likeSql);
                                    $isLiked = mysqli_num_rows($likeResult) > 0;
                                ?>
                                <button type="submit" name="<?= $isLiked ? 'unlike' : 'like'; ?>" class="btn btn-<?php 
                                echo $isLiked ? 'danger' : 'success'; ?>" style="width: 70px;"><?php echo $isLiked ? 
                                'Unlike' : 'Like'; ?></button>
                                <span><?= countLikes($conn, $row['id']); ?></span>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile;
        } else {
            echo "<p><br><br><br><strong>No journals available for the selected faculty.</strong></p>";
        }
        ?>
    </div>

    <script src="algoritma.js"></script>
</body>
</html>
