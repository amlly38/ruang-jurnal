<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Ambil user_id dari tabel users
$username = $_SESSION['user'];
$sqlUser = "SELECT id FROM users WHERE username='$username'";
$resultUser = mysqli_query($conn, $sqlUser);
$rowUser = mysqli_fetch_assoc($resultUser);
$userId = $rowUser['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['like'])) {
        $journalId = $_POST['journal_id'];

        // Periksa apakah pengguna sudah like jurnal ini sebelumnya
        $sqlCheck = "SELECT * FROM likes WHERE user_id='$userId' AND journal_id='$journalId'";
        $resultCheck = mysqli_query($conn, $sqlCheck);

        if (mysqli_num_rows($resultCheck) == 0) {
            // Jika pengguna belum like, tambahkan like baru
            $sqlInsert = "INSERT INTO likes (user_id, journal_id) VALUES ('$userId', '$journalId')";
            if (mysqli_query($conn, $sqlInsert)) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $sqlInsert . "<br>" . mysqli_error($conn);
            }
        } else {
            // Jika pengguna sudah like sebelumnya, hapus like
            $sqlDelete = "DELETE FROM likes WHERE user_id='$userId' AND journal_id='$journalId'";
            if (mysqli_query($conn, $sqlDelete)) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $sqlDelete . "<br>" . mysqli_error($conn);
            }
        }
    } elseif (isset($_POST['unlike'])) {
        $journalId = $_POST['journal_id'];

        // Hapus like
        $sqlDelete = "DELETE FROM likes WHERE user_id='$userId' AND journal_id='$journalId'";
        if (mysqli_query($conn, $sqlDelete)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $sqlDelete . "<br>" . mysqli_error($conn);
        }
    }
}
?>
