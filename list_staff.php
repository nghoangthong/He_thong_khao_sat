

<?php include 'db_connect.php' ?>
<?php
// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $middlename = $_POST["middlename"];
    $contact = $_POST["contact"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $type = 3; // Type mặc định

    // Kiểm tra email đã được sử dụng chưa
    $sql = "SELECT id FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $email_error = "Email đã được sử dụng";
    } else {
        // Thêm user vào database
        $sql = "INSERT INTO users (firstname, lastname, middlename, contact, address, email, password, type) 
                VALUES ('$firstname', '$lastname', '$middlename', '$contact', '$address', '$email', '$password', $type)";
        if (mysqli_query($conn, $sql)) {
            header("Location: login.php"); // Chuyển hướng sang trang login.php
            exit();
        } else {
            $error_message = "Đăng ký không thành công: " . mysqli_error($conn);
        }
    }
}

// Đóng kết nối database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Đăng ký tài khoản</title>
</head>

<body>
    <h1>Đăng ký tài khoản</h1>
    <form method="post">
        <label for="firstname">Họ:</label>
        <input type="text" id="firstname" name="firstname" required><br>

        <label for="lastname">Tên:</label>
        <input type="text" id="lastname" name="lastname" required><br>

        <label for="middlename">Tên đệm:</label>
        <input type="text" id="middlename" name="middlename"><br>

        <label for="contact">Số điện thoại:</label>
        <input type="tel" id="contact" name="contact"><br>

        <label for="address">Địa chỉ:</label>
        <input type="text" id="address" name="address"><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <?php if(isset($email_error)) { echo "<span style='color:red'>$email_error</span>"; } ?>
        <br>

        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Đăng ký">
    </form>
    <?php if(isset($error_message)) { echo "<p style='color:red'>$error_message</p>"; } ?>
</body>

</html>
