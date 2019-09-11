<?php 
$base_url = base_url().'admin/users/';
?>
<div id="path">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url()?>admin">Admin</a></li>
		<li class="active">Users</li>
	</ol>
</div>
<form id="frm_list" method="get" action="<?php echo $base_url ?>">
	<div class="frm-search-box form-inline pull-left">
		<label class="mr-sm-2" for="">Từ khóa: </label>
		<input class="form-control mb-2 mr-sm-2 mb-sm-0" type="text" value="<?php echo $q?>" name="q" id="txtkeyword" placeholder="Keyword" value=""/>&nbsp;
		<button type="submit" id="_btnSearch" class="btn btn-success">Tìm kiếm</button>
		<select name="action" class="form-control" id="cboActive">
			<option value="all">Tất cả</option>
			<option value="1">Hiển thị</option>
			<option value="0">Ẩn</option>
		</select>
		<script type="text/javascript">
			cbo_Selected('cboActive','<?php echo $action;?>');
		</script>
	</div>
</form>
<div class="pull-right">
	<a href="<?php echo $base_url.'add' ?>" class="btn btn-success button"><i class="fa fa-plus" aria-hidden="true"></i> Thêm mới</a>
</div>
<div class="clearfix"></div>
<?php
if (isset($success_message)) {
	echo $success_message;
}
if (isset($error_message)) {
	echo $error_message;
}
?>
<table class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>#</th>
			<th>Tên đăng nhập</th>
			<th>Tên</th>
			<th>Email</th>
			<th>Đổi mật khẩu</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=0; $img='';
		
		foreach ($users as $value) {
			$i++;
			if($value['isactive']==1){
				$img = '<a href="'.$base_url.'active/'.$value['id'].'" title="Hiển thị"><i class="fa fa-check green" aria-hidden="true"></i>Public</a>';
			}else{
				$img = '<a href="'.$base_url.'active/'.$value['id'].'" title="Hiển thị"><i class="fa fa-times red" aria-hidden="true"></i>Public</a>';
			}
			echo '<tr>
			<td>'.$i.'</td>
			<td>'.$value['username'].'</td>
			<td>'.$value['firstname'].' '.$value['lastname'].'</td>
			<td>'.$value['email'].'</td>
			<td><a href="'.$base_url.'changepass/'.$value['id'].'" title="Đổi mật khẩu">Đổi mk</a></td>';
			echo '<td class="tbl_actions">
			'.$img.'
			<a href="'.$base_url.'edit/'.$value['id'].'" title="Sửa"><i class="fa fa-pencil-square-o blue" aria-hidden="true"></i>Edit</a>
			<a href="'.$base_url.'delete/'.$value['id'].'" title="Xóa" onclick="return confirm(\'Bạn có chắc muốn xóa ?\')"><i class="fa fa-trash red" aria-hidden="true"></i>Delete</a>
			</td>
			</tr>';
		}
		?>
	</tbody>
</table>
<div class="text-right">
	<?php if (isset($links)) { ?>
	<?php echo $links ?>
	<?php } ?>
</div>