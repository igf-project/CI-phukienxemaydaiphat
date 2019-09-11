<html>
<?php
if (isset($this->session->userdata['LOGIN_ADMIN'])) {
	header("location: ".base_url()."admin/home");
}
?>
<head>
	<title>Login Form</title>
	<meta content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" name="viewport">
	<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
	<script src="<?php echo base_url() ?>assets/js/jquery-1.11.2.min.js"></script>
	<style type="text/css">
		<?php include 'style.css'; ?>
	</style>
</head>
<body>
	<div id="main">
		<?php
		if (isset($logout_message)) {
			echo "<div class='message'>";
			echo $logout_message;
			echo "</div>";
		}
		?>
		<?php
		if (isset($message_display)) {
			echo "<div class='message'>";
			echo $message_display;
			echo "</div>";
		}
		?>

		<div id="login">
			<h2>Login Form</h2>
			<hr/>
			<form id="frm_login" action="<?php echo base_url()?>admin/users/user_login_process" method="post" accept-charset="utf-8">
				<div class='error_msg'>
					<?php
					if (isset($error_message)) {
						echo $error_message;
					}
					?>
				</div>
				<div class="form-group">
					<label>UserName :</label>&nbsp&nbsp<span id="err_user_name" class="error"></span>
					<input type="text" name="username" id="user_name" placeholder="username" required />
				</div>
				<div class="form-group">
					<label>Password :</label>&nbsp&nbsp<span id="err_password" class="error"></span>
					<input type="password" name="password" id="password" placeholder="**********" required/>
				</div>
				<input type="submit" value=" Login " name="submit"/><br />
				<!-- <a href="<?php echo base_url() ?>admin/register">To SignUp Click Here</a> -->
			</form>
		</div>
	</div>
	<script>
		function checkinput(){
			if($("#user_name").val()==""){
				$("#err_user_name").text("Vui lòng điền vào trường này.");
				$("#user_name").focus();
				return false;
			}else{
				$("#err_user_name").text();
			}
			if($("#password").val()==""){
				$("#err_password").text("Vui lòng điền vào trường này.");
				$("#password").focus();
				return false;
			}else{
				$("#err_password").text();
			}
			return true;
		}

		$(document).ready(function() {
			$('#frm_login').submit(function(){
				return checkinput();
			})
		})
	</script>
</body>
</html>
