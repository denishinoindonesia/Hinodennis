<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password_lama = $_POST['password_lama'] ?? '';
    $password_baru = $_POST['password_baru'] ?? '';
    $konfirmasi_password = $_POST['konfirmasi_password'] ?? '';

    $admin = fetchOnePrepared($pdo, "SELECT password FROM users WHERE id = :id LIMIT 1", [':id' => $admin_id]);

    if (!$admin) {
        $error = "Akun tidak ditemukan!";
    } elseif (!password_verify($password_lama, $admin['password'])) {
        $error = "Password lama salah!";
    } elseif ($password_baru !== $konfirmasi_password) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
        execPrepared($pdo, "UPDATE users SET password = :p WHERE id = :id", [':p'=>$password_hash, ':id'=>$admin_id]);
        $success = "Password berhasil diubah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Ganti Password Admin</title>
</head>
<body>
<h2>Ganti Password</h2>

<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

<form method="post">
    <label>Password Lama:</label><br>
    <input type="password" name="password_lama" required><br><br>

    <label>Password Baru:</label><br>
    <input type="password" name="password_baru" required><br><br>

    <label>Konfirmasi Password:</label><br>
    <input type="password" name="konfirmasi_password" required><br><br>

    <button type="submit">Ganti Password</button>
</form>

</body>
</html>
