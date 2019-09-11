<?php 
$base_url = base_url().'admin/Product/';
?>
<div id="path">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url()?>admin">Admin</a></li>
		<li class="active">Sản phẩm</li>
	</ol>
</div>
<form action="<?php echo $base_url ?>" method="get" enctype="multipart/form-data">
	<div class="frm-search-box form-inline pull-left">
		<label class="mr-sm-2" for="">Từ khóa: </label>
		<input class="form-control mb-2 mr-sm-2 mb-sm-0" type="text" value="<?php echo $q?>" name="q" id="txtkeyword" placeholder="Keyword" value=""/>&nbsp;
		<button type="submit" id="button" class="btn btn-success">Tìm kiếm</button>
		<select name="cata" class="form-control" id="cboCatalog">
			<option value="">-- Tất cả --</option>
			<?php
			foreach ($catalog as $key => $value) {
				if($value['id'] == $cata){
					echo '<option value="'.$value['id'].'" selected>'.$value['name'].'</option>';
				}else{
					echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
				}
			}
			?>
		</select>
		<select name="action" class="form-control" id="cboActive">
			<option value="all">Tất cả</option>
			<option value="1">Hiển thị</option>
			<option value="0">Ẩn</option>
		</select>
		<script type="text/javascript">
			cbo_Selected('cboActive','<?php echo $action;?>');
		</script>
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
			<th>Tên</th>
			<th>Mã code</th>
			<th>Nhóm</th>
			<th>Ngày tạo</th>
			<th>Hot</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=0; $img=''; $ishot='';
		foreach ($result as $value) {
			$i++;
			if($value['isactive']==1){
				$img = '<a href="'.$base_url.'active/'.$value['id'].'" title="Hiển thị"><i class="fa fa-check green" aria-hidden="true"></i>Public</a>';
			}else{
				$img = '<a href="'.$base_url.'active/'.$value['id'].'" title="Hiển thị"><i class="fa fa-times red" aria-hidden="true"></i>Public</a>';
			}

			if($value['ishot']==1){
				$ishot = '<a href="'.$base_url.'ishot/'.$value['id'].'" title="Sản phẩm nổi bật"><i class="fa fa-check green" aria-hidden="true"></i>isHot</a>';
			}else{
				$ishot = '<a href="'.$base_url.'ishot/'.$value['id'].'" title="Sản phẩm nổi bật"><i class="fa fa-times red" aria-hidden="true"></i>isHot</a>';
			}
			echo '<tr>
			<td>'.$i.'</td>
			<td>'.$value['name'].'</td>
			<td>'.$value['pro_code'].'</td>
			<td>'.$value['catalog'].'</td>
			<td>'.date('d/m/Y', strtotime($value['cdate'])).'</td>';
			echo '<td class="tbl_actions">'.$ishot.'</td>';
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
<div class="clearfix"></div>
<?php if (isset($links)) { ?>
<?php echo $links ?>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#cboCatalog').select2();
	})
</script>
