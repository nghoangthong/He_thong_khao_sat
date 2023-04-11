<?php
// Include file kết nối database
include 'db_connect.php';

// Kiểm tra nếu form đã được gửi lên
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Lấy dữ liệu từ form đăng ký
    $username = $_POST['username'];
    $password = $_POST['password'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $type = 3; // loại người dùng Subscriber

    // Kiểm tra tên đăng nhập và email đã tồn tại trong cơ sở dữ liệu chưa
    $check_user_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $check_user_result = mysqli_query($conn, $check_user_query);

    if (mysqli_num_rows($check_user_result) > 0) {
        // Thông báo lỗi nếu tên đăng nhập hoặc email đã tồn tại trong cơ sở dữ liệu
        echo "Tên đăng nhập hoặc email đã tồn tại.";
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $add_user_query = "INSERT INTO users (username, password, full_name, email, type) VALUES ('$username', '$password', '$full_name', '$email', '$type')";
        $add_user_result = mysqli_query($conn, $add_user_query);

        if ($add_user_result) {
            // Hiển thị thông báo thành công và chuyển đến trang đăng nhập
            echo "Đăng ký thành công!";
            header("Location: login.php");
        } else {
            // Thông báo lỗi nếu không thể thêm người dùng vào cơ sở dữ liệu
            echo "Lỗi: Không thể thêm người dùng mới vào cơ sở dữ liệu.";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký tài khoản</title>
</head>
<body>
    <h1>Đăng ký tài khoản</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="full_name">Họ và tên:</label>
        <input type="text" id="full_name" name="full_name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <!-- Thêm trường ẩn để chỉ định loại người dùng là Subscriber -->
        <input type="hidden" id="type" name="type" value="3">

        <input type="submit" value="Đăng ký">
    </form>
</body>
</html>
