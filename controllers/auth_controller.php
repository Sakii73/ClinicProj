<?php
// controllers/auth_controller.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/ActivityLog.php';

$action = $_POST['action'] ?? '';

$userModel = new User($conn);
$logModel = new ActivityLog($conn);

// ─── LOGIN ───────────────────────────────────────────────────
if ($action === 'login') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Please enter your username and password.';
        header('Location: ../views/patient/login.php');
        exit;
    }

    $user = $userModel->findByUsername($username);

    if (!$user || !password_verify($password, $user['password'])) {
        $_SESSION['error'] = 'Invalid username or password.';
        header('Location: ../views/patient/login.php');
        exit;
    }

    // Mark user online
    $userModel->markOnline($user['id'], true);

    // Store session
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['username']  = $user['username'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['role']      = $user['role'];

    $logModel->log($user['full_name'] . ' logged in');

    if ($user['role'] === 'admin' || $user['role'] === 'doctor') {
        header('Location: ../views/admin/dashboard.php');
    } else {
        header('Location: ../views/patient/home.php');
    }
    exit;
}

// ─── REGISTER ────────────────────────────────────────────────
if ($action === 'register') {
    $username  = trim($_POST['username']  ?? '');
    $fullname  = trim($_POST['fullname']  ?? '');
    $age       = (int)($_POST['age']       ?? 0);
    $password  = $_POST['password']  ?? '';
    $role      = $_POST['role']      ?? 'patient';

    if (empty($username) || empty($fullname) || empty($password) || $age <= 0) {
        $_SESSION['error'] = 'All fields are required.';
        header('Location: ../views/patient/register.php');
        exit;
    }

    // Username uniqueness check
    if ($userModel->findByUsername($username)) {
        $_SESSION['error'] = 'Username already taken. Please choose another.';
        header('Location: ../views/patient/register.php');
        exit;
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);
    $userModel->create($username, $fullname, $age, $hash, $role);

    $_SESSION['success'] = 'Account created! You can now log in.';
    header('Location: ../views/patient/login.php');
    exit;
}

// ─── LOGOUT ──────────────────────────────────────────────────
if ($action === 'logout') {
    if (isset($_SESSION['user_id'])) {
        $userModel->markOnline($_SESSION['user_id'], false);
        $logModel->log(($_SESSION['full_name'] ?? 'User') . ' logged out');
    }
    session_destroy();
    header('Location: ../views/patient/login.php');
    exit;
}

// Fallback
header('Location: ../views/patient/login.php');
exit;
