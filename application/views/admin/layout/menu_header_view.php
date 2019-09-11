<header class="main-header">
	<a href="<?php echo base_url()?>admin" class="logo">
		<span class="logo-mini"><b>A</b>DM</span>
		<span class="logo-lg"><b>Admin</b></span>
	</a>
	<nav class="navbar navbar-static-top">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo base_url()?>assets/admin/images/user2-160x160.jpg" class="img-circle user-image" alt="User Image">
						<span class="hidden-xs"><?php echo $_SESSION['LOGIN_ADMIN']['FIRST_NAME'].' '.$_SESSION['LOGIN_ADMIN']['LAST_NAME']?></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url()?>admin/users">
								<i class="fa fa-user" aria-hidden="true"></i> Quản lý user
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="<?php echo base_url()?>admin/changepass">
								<i class="fa fa-unlock-alt" aria-hidden="true"></i> Đổi mật khẩu
							</a>
						</li>
						<li class="user-footer">
							<div class="pull-left">
								<a class="btn btn-default btn-flat" href="<?php echo base_url()?>admin/profile">Thông tin cá nhân</a>
							</div>
							<div class="pull-right">
								<a class="btn btn-default btn-flat" href="<?php echo base_url()?>admin/logout">Đăng xuất</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>