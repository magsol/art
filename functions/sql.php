<?php

function update_oauth($conn, $handle, $token, $secret) {
    $sql = 'SELECT * FROM users WHERE handle = ?';
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $handle);
    $results = mysqli_stmt_execute($stmt);
    $rows = mysqli_num_rows($result);
    if ($rows > 0) {
        // User exists; do an update.
        mysqli_stmt_close($stmt);
        $sql = "UPDATE users SET access_token = ?, access_secret = ?, " . 
                "WHERE handle = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $token, $secret, $handle);
        $results = mysqli_stmt_execute($stmt);
        if ($results === false) {
            return false;
        }
        mysqli_stmt_close($stmt);
    } else {
        // Doesn't exist; do an insert.
        mysqli_stmt_close($stmt);
        $sql = 'INSERT INTO users (handle, access_token, access_secret) VALUES ' .
                '(?, ?, ?)';
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $handle, $token, $secret);
        $results = mysqli_stmt_execute($stmt);
        if ($results === false) {
            return false;
        }
        mysqli_Stmt_close($stmt);
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

function delete_user($conn, $handle) {
    $sql = 'DELETE FROM users WHERE handle = ?';
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $handle);
    $results = mysqli_stmt_execute($stmt);
    if ($results === false) {
        return false;
    }
    mysqli_stmt_close($stmt);
    return true;
}

?>