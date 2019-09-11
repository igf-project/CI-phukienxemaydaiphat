<?php 
$base_url = base_url().'admin/Order/';
/* Status
-1 : Hủy
0: Đã xử lý
1: Đơn hàng mới
2: Đang xử lý
*/
?>
<div id="path">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url()?>admin">Admin</a></li>
		<li class="active">Đặt hàng</li>
	</ol>
</div>
<form action="<?php echo $base_url ?>" method="get" enctype="multipart/form-data">
	<div class="frm-search-box form-inline pull-left">
		<label class="mr-sm-2" for="">Từ khóa: </label>
		<input class="form-control mb-2 mr-sm-2 mb-sm-0" type="text" value="<?php echo $q?>" name="q" id="txtkeyword" placeholder="Họ đệm, tên, số điện thoại" value=""/>&nbsp;
		<label class="mr-sm-2" for="">Trạng thái đơn hàng: </label>
		<select name="t" class="form-control" id="cboStatus">
			<option value="all">Tất cả</option>
			<option value="1">Đơn hàng mới</option>
			<option value="2">Đang xử lý</option>
			<option value="0">Hoàn thành</option>
			<option value="-1">Đã hủy</option>
		</select>
		<script type="text/javascript">
			cbo_Selected('cboStatus','<?php echo $t;?>');
		</script>
		<button type="submit" id="button" class="btn btn-success">Tìm kiếm</button>
	</div>
	<div class="pull-right">
		<a href="<?php echo $base_url ?>add" class="btn btn-success button"><i class="fa fa-plus" aria-hidden="true"></i> Thêm mới</a>
	</div>
</form>
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
			<th>Họ</th>
			<th>Tên</th>
			<th>Phone</th>
			<th>Email</th>
			<th>Địa chỉ</th>
			<th>Tổng tiền</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=0; $img='';
		foreach ($result as $value) {
			$i++;
			if($value['status']==1){
				$img = '<a href="javascript:void(0)" title="Đơn hàng mới"><i class="fa fa-times red" aria-hidden="true"></i><b class="red">Đơn mới</b></a>';
			}else if($value['status'] == 0){
				$img = '<a href="javascript:void(0)" title="Đơn hàng đã xử lý"><i class="fa fa-check green" aria-hidden="true"></i><span class="green">Hoàn thành</span></a>';
			}else if($value['status'] == -1){
				$img = '<a href="javascript:void(0)" title="Đơn hàng đã hủy"><i class="fa fa-times" style="color:#777" aria-hidden="true"></i>Hủy</a>';
			}else if($value['status']==2){
				$img = '<a href="javascript:void(0)" title="Đơn hàng đang xử lý"><i class="fa fa-times info" aria-hidden="true"></i><span class="info">Đang xử lý</span></a>';
			}
			echo '<tr>
			<td>'.$i.'</td>
			<td>'.$value['lastname'].'</td>
			<td>'.$value['firstname'].'</td>
			<td>'.$value['phone'].'</td>
			<td>'.$value['email'].'</td>
			<td>'.$value['address'].'</td>
			<td>'.number_format($value['totalmoney']).' đ</td>
			<td class="tbl_actions">
			'.$img.'
			<a href="'.$base_url.'edit/'.$value['id'].'" title="Thông tin"><i class="fa fa-pencil-square-o blue" aria-hidden="true"></i><span class="blue">Xem chi tiết</span></a>
			</td>
			</tr>';
		}
		?>
	</tbody>
</table>
<div class="clearfix"></div>
<?php if (isset($links)) { ?>
<?php echo $links ?>
<?php } ?>
