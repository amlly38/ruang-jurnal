<?php
// functions.php

function countLikes($conn, $journalId) {
    $sql = "SELECT COUNT(*) AS total_likes FROM likes WHERE journal_id='$journalId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_likes'];
}
?>