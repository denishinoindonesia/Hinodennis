<?php
// login.php
session_start();
require_once 'config.php'; // pastikan path benar

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi.';
    } else {
        // Ambil user berdasarkan username
        $user = fetchOnePrepared($pdo, "SELECT id, username, password FROM users WHERE username = :u LIMIT 1", [
            ':u' => $username
        ]);

        if ($user && password_verify($password, $user['password'])) {
            // optional: rehash jika diperlukan
            if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                execPrepared($pdo, "UPDATE users SET password = :p WHERE id = :id", [
                    ':p' => $newHash,
                    ':id' => $user['id']
                ]);
            }

            // Set session — gunakan ID, bukan username, dan regenerate session id
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];

            header('Location: index.php');
            exit;
        } else {
            // jangan jelaskan apakah username atau password salah (menghindari user enumeration)
            $error = 'Username atau password salah.';
        }
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Admin Panel - Hino Official</title>

    <!-- Favicon -->
    <link rel="icon" href="../img/favicon.png" type="image/png" />

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <style>
        /* === BODY === */
        body {
            background: linear-gradient(135deg, #0d6efd, #5a9bfd, #a2c8ff);
            background-size: 300% 300%;
            animation: gradientShift 10s ease infinite;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        /* === LOGIN CARD === */
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(13, 110, 253, 0.3);
            width: 100%;
            max-width: 400px;
            padding: 45px 40px;
            backdrop-filter: blur(8px);
            text-align: center;
        }
        .login-card:hover {
            box-shadow: 0 18px 45px rgba(13, 110, 253, 0.4);
            transform: translateY(-2px);
            transition: 0.3s;
        }
        /* === LOGO === */
        .login-card img {
            width: 130px;
            margin-bottom: 20px;
        }
        /* === TITLE === */
        .brand-title {
            font-weight: 700;
            font-size: 1.6rem;
            color: #0d6efd;
            margin-bottom: 8px;
        }
        .brand-subtitle {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 25px;
        }
        /* === INPUT === */
        .input-group {
            display: flex;
            align-items: center;
            background: #f8f9fb;
            border-radius: 12px;
            border: 1px solid #dee2e6;
            overflow: hidden;
            margin-bottom: 20px;
            transition: 0.3s;
        }
        .input-group i {
            color: #0d6efd;
            font-size: 17px;
            padding: 0 14px;
        }
        .input-group input {
            border: none;
            background: transparent;
            flex: 1;
            padding: 12px;
            font-size: 15px;
            color: #333;
            outline: none;
        }
        .input-group:focus-within {
            box-shadow: 0 0 8px rgba(13, 110, 253, 0.3);
            border-color: #0d6efd;
        }
        /* === BUTTON === */
        .btn-login {
            background: linear-gradient(135deg, #0d6efd, #5a9bfd);
            border: none;
            border-radius: 12px;
            height: 45px;
            font-weight: 600;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #005ce6, #3b82f6);
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }
        /* === ERROR TEXT === */
        .text-danger {
            font-size: 0.9rem;
            margin-top: 15px;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <img src="../img/favicon.png" alt="Logo Hino" />
        <div class="brand-title">Login Admin Panel Hino Official</div>
        <div class="brand-subtitle">Masuk ke panel administrasi</div>

        <form method="post" novalidate>
            <div class="input-group">
                <i class="fa fa-user"></i>
                <input type="text" name="username" placeholder="Username" required autofocus />
            </div>

            <div class="input-group">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required />
            </div>

            <button name="login" class="btn-login" type="submit">Masuk</button>
        </form>

        <?php if (isset($error)) : ?>
            <div class="text-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
