<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập SSO</title>
</head>
<body>
    <h2>Đăng nhập</h2>
    <form method="POST">
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
        <label>Tên đăng nhập:</label>
        <input type="text" name="name" required><br>
        <label>Mật khẩu:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Đăng nhập</button>
    </form>
</body>
</html>
