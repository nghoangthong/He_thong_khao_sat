<?php 
include('db_connect.php'); // Kết nối với cơ sở dữ liệu MySQL
session_start();

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id = $id"; // Câu lệnh truy vấn lấy thông tin người dùng
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $meta['id'] = $row['id'];
            $meta['firstname'] = $row['firstname'];
            $meta['middlename'] = $row['middlename'];
            $meta['lastname'] = $row['lastname'];
            $meta['email'] = $row['email'];
        }
    } else {
        echo "Không tìm thấy người dùng";
    }
}
?>

<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-user">	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Họ</label>
			<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="name">Tên đệm</label>
			<input type="text" name="middlename" id="middlename" class="form-control" value="<?php echo isset($meta['middlename']) ? $meta['middlename']: '' ?>">
		</div>
		<div class="form-group">
			<label for="name">Tên</label>
			<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="username">Email</label>
			<input type="text" name="email" id="email" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="password">Mật khẩu</label>
			<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
			<small><i>Để trống phần này nếu bạn không muốn thay đổi mật khẩu.</i></small>
		</div>
		
		

	</form>
</div>
<script>
	
	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=update_user',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else{
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					end_load()
				}
			}
		})
	})

</script>