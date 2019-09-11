<style type="text/css">
.clear{
	clear: both;
}
.fun_icon{
	width: 145px;
	height: 110px;
	text-align: center; 
	display: block; 
	float: left;
	margin: 10px;
	overflow: hidden;  
	border: #DDDDDD 1px solid;
}
.fun_icon img{ 
	width: 80px; 
	height: 80px; 
	margin: 3px; 
	border: none; 
	clear:both
}
</style>

<section class="content-header">
	<h1>Dashboard<small>Control panel</small></h1>
</section>
<section class="content">
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
		<tr>
			<td valign="top" scope="col">
				<div style='clear:both;display:block;'>
					<!-- <div class="fun_icon"><a href="<?php echo base_url()?>admin/roles"><img src="<?php echo base_url()?>assets/admin/images/icon-user.jpg"/></a><div>Phân quyền</div></div> -->
					<div class="fun_icon"><a href="<?php echo base_url()?>admin/users"><img src="<?php echo base_url()?>assets/admin/images/user-info-icon.png"/></a><div>Quản lý người dùng</div></div>
					<div class="fun_icon"><a href="<?php echo base_url()?>admin/config"><img src="<?php echo base_url()?>assets/admin/images/icon_config.png"/></a><div>Cấu hình website</div></div>
				</div>
			</td>
			<td></td>
		</tr>
	</table>
</section>