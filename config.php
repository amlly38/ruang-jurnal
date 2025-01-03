<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "website";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Kunci untuk enkripsi dan dekripsi password
$encryption_key = "your_encryption_key_here";

// Periksa apakah fungsi encryptPassword() sudah ada sebelumnya
if (!function_exists('encryptPassword')) {
    // Fungsi untuk melakukan enkripsi password
    function encryptPassword($password) {
        global $encryption_key;
        return openssl_encrypt($password, 'AES-128-ECB', $encryption_key);
    }
}

// Periksa apakah fungsi decryptPassword() sudah ada sebelumnya
if (!function_exists('decryptPassword')) {
    // Fungsi untuk melakukan dekripsi password
    function decryptPassword($encrypted_password) {
        global $encryption_key;
        return openssl_decrypt($encrypted_password, 'AES-128-ECB', $encryption_key);
    }
}
?>
