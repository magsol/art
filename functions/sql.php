<?php

function update_oauth($conn, $handle, $token, $secret) {
    $sql = 'SELECT * FROM users WHERE handle = ?';
    $result = mysqli_query($conn, "SELECT * FROM users WHERE handle = '" .
        $handle . "'");
    $rows = mysqli_num_rows($result);
    if ($rows > 0) {
        // User exists; do an update.
        $sql = "UPDATE users SET access_token = ?, access_secret = ?, " . 
                "WHERE handle = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $token, $secret, $handle);
        $results = mysqli_stmt_execute($stmt);
        if ($results === false) {
            return false;
        }
        mysqli_stmt_close($stmt);
    }
    return true;
}

function update_gc($conn, $handle, $user, $pass, $hour, $min) {
    // User exists; do an update.
    $sql = "UPDATE users SET gcname = ?, gcpass = ?, hour = ?, minute = ? " .
            "WHERE handle = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssiis', $user, $pass, $hour, $min,
        $handle);
    $results = mysqli_stmt_execute($stmt);
    if ($results === false) {
        return false;
    }
    mysqli_stmt_close($stmt);
    return true;
}

?>