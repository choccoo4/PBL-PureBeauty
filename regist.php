<?php
include 'koneksi.php';

// Proses registrasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $name = trim($_POST['name']); // pastikan 'nama' sesuai dengan input form
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Enkripsi password
    $nomor_telepon = !empty($_POST['nomor_telepon']) ? $_POST['nomor_telepon'] : NULL;
    $foto_profil = NULL; // Bisa diisi default, misalnya 'default.jpg'
    $alamat = !empty($_POST['alamat']) ? $_POST['alamat'] : NULL;

    // Cek apakah email atau username sudah terdaftar
    $checkQuery = $koneksi->prepare("SELECT * FROM pembeli WHERE email = ? OR username = ?");
    $checkQuery->bind_param("ss", $email, $username);
    $checkQuery->execute();
    $result = $checkQuery->get_result();

    if ($result->num_rows > 0) {
        // Jika email atau username sudah terdaftar
        echo "<script>alert('Email atau username sudah terdaftar! Anda sudah punya akun.'); window.location.href='login.php';</script>";
    } else {
        // Simpan ke database jika belum ada
        $query = $koneksi->prepare("INSERT INTO pembeli (email, name, username, password) VALUES (?, ?, ?, ?)");
        $query->bind_param("ssss", $email, $name, $username, $password); // Pastikan variabel 'name' yang dikirim ke query
        if ($query->execute()) {
            // Berhasil registrasi
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='login.php';</script>";
        } else {
            // Gagal registrasi
            echo "<script>alert('Terjadi kesalahan saat registrasi.');</script>";
        }
    }

    $query = $koneksi->prepare("INSERT INTO pembeli (email, nama, username, password, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $query->bind_param("ssss", $email, $name, $username, $password);
    $query = $koneksi->prepare("UPDATE pembeli SET email = ?, nama = ?, username = ?, password = ?, updated_at = NOW() WHERE id = ?");
    $query->bind_param("ssssi", $email, $name, $username, $password, $userId);
}

$koneksi->close();
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="\PBL_OKE\assets\css\regist.css" />
    <title>Sign Up | PureBeauty</title>
</head>

<body>
    <div class="form-container">
        <h1 class="logo">PureBeauty</h1>
        <p>Sign up to see our products!</p>
        <form id="signupForm" action="#" method="post">
            <div>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <div class="error-message" id="emailError" style="display: none;">Please enter a valid email</div>
            </div>
            <div>
                <input type="text" id="name" name="name" placeholder="Name" required>
                <div class="error-message" id="nameError" style="display: none;">Please enter your name</div>
            </div>
            <div>
                <input type="text" id="username" name="username" placeholder="Username" required>
                <div class="error-message" id="usernameError" style="display: none;">Please enter a username</div>
            </div>
            <div>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <div class="error-message" id="passwordError" style="display: none;">Please enter a password of at least 6 characters</div>
            </div>
            <button type="submit">Sign Up</button>
        </form>
        <div class="success-message" id="successMessage" style="display: none;">Welcome to PUREBEAUTY!</div>
        <br>
        <p>Have an account? <a href="login.php">Log in</a></p>
    </div>
</body>

</html>