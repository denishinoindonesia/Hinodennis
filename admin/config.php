<?php
session_start();

$host = 'localhost';
$user = 'u142136422_officialhino';
$pass = 'D3n15h1no35!';
$db   = 'u142136422_officialhino';

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
