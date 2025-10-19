<?php
session_start();

$host = 'localhost';
$user = 'u429834259_admin';
$pass = 'Sqwe123@@';
$db   = 'u429834259_asiatekindo';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi fetchAll untuk mengambil semua data dari query
function fetchAll($query){
    global $conn;
    $result = $conn->query($query);
    $rows = [];
    if($result){
        while($row = $result->fetch_assoc()){
            $rows[] = $row;
        }
    }
    return $rows;
}
?>
