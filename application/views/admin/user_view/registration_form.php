<html>
<?php
if (isset($this->session->userdata['LOGIN_ADMIN'])) {
	header("location: ".base_url()."admin/home");
}
?>
<head>
	<title>Registration Form</title>
	<meta content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" name="viewport">
	<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">	
	<script src="<?php echo base_url() ?>assets/js/jquery-1.11.2.min.js"></script>
	<style type="text/css">
		<?php include 'style.css'; ?>
	</style>
</head>
<body>
	<div id="main">
		<div id="login">
			<h2>Registration Form</h2>
			<hr/>
			<div class='error_msg'>
				<?php //echo validation_errors(); ?>
			</div>
			<form action="<?php echo base_url()?>admin/user_controller/new_user_registration" method="post" accept-charset="utf-8">
				<label>Create Username : </label>
				<br>
				<input type="text" name="username" value="">
				<div class="error_msg">
					<?php if (isset($message_display)) {
						echo $message_display;
					} ?>
				</div>
				<br>
				<label>Email : </label>
				<br>
				<input type="email" name="email_value" value="">
				<br>
				<br>
				<label>Password : </label>
				<br>
				<input type="password" name="password" value="">
				<br>
				<br>
				<input type="submit" name="submit" value="Sign Up">
			</form>
			<a href="<?php echo base_url()?>admin ">For Login Click Here</a>
		</div>
	</div>
</body>
</html>