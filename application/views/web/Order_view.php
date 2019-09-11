<section class="body main-content component">
	<header class="page-header">
		<div id="path">
			<div class="container">
				<div class="box-breadcrumb">
					<div class="row">
						<div class="col-md-9 col-md-offset-3">
							<ul class="breadcrumb">
								<li><a href="<?php echo base_url()?>" title="Trang chủ"><i class="fa fa-home" aria-hidden="true" style="font-size:18px"></i></a></li>
								<li><a href="<?php echo base_url().'gio-hang'?>" title="Giỏ hàng">Giỏ hàng</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- Navbar -->
	<div class="container">
		<div class="row">
			<div class="col-md-3 main-menu">
				<div class="header-main-menu">
					<i class="fa fa-bars"></i>Danh mục sản phẩm
				</div>
				<ul class="main_menu_dropdown">
					<?php
					$i=0;
					foreach ($catalog as $key => $item) {
						$i++;
						echo PHP_EOL.'<li class="hadsub-menu">';
						echo PHP_EOL.'<a href="'.$item["url"].'" class="menu-link" title="'.$item["alias"].'">
						<i class="menu-0'.$i.'"></i>
						<h2 class="">'.$item["alias"].'</h2>
						<i class="fa fa-angle-right"></i>
						</a>';
						if(!empty($item['child'])){
							echo PHP_EOL.'<span>';
							foreach ($item['child'] as $key1 => $child1) {
								if($key1<3){
									echo '<a href="'.$child1["url"].'" title="'.$child1["alias"].'">'.$child1["alias"].'</a>,';
								}else if($key1==3){
									echo '<a href="'.$child1["url"].'" title="'.$child1["alias"].'">'.$child1["alias"].'</a>';
								}
							}
							echo PHP_EOL.'</span>';

								// Submenu-lv1
							echo PHP_EOL.'<ul class="submenu-lv1">';
							foreach ($item['child'] as $child1) {
								if(empty($child1['child2'])){
									echo PHP_EOL.'<li>';
									echo PHP_EOL.'<a href="'.$child1['url'].'" title="'.$child1['alias'].'">'.$child1['alias'].'</a>';
								}else{
									echo PHP_EOL.'<li>';
									echo PHP_EOL.'<a href="'.$child1['url'].'" title="'.$child1['alias'].'" class="title">'.$child1['alias'].'</a>';

										// Submenu-lv2
									echo PHP_EOL.'<ul class="child2 submenu-lv2">';
									foreach ($child1['child2'] as $child2) {
										echo PHP_EOL.'<li>';
										echo PHP_EOL.'<a href="'.$child2['url'].'" title="'.$child2['alias'].'">'.$child2['alias'].'</a>';
										echo PHP_EOL.'</li>';
									}
									echo PHP_EOL.'</ul>';
								}

								echo PHP_EOL.'</li>';
							}
							echo PHP_EOL.'</ul>';
						}
						echo PHP_EOL.'</li>';
					}
					?>
					<?php
					foreach ($tags as $key => $item) {
						$i++;
						echo PHP_EOL.'<li class="hadsub-menu">';
						echo PHP_EOL.'<a href="'.$item["url"].'" class="menu-link" title="'.$item["name"].'">
						<i class="menu-0'.$i.'"></i>
						<h2 class="">'.$item["name"].'</h2>
						<i class="fa fa-angle-right"></i>
						</a>';
						if(!empty($item['child'])){
							echo PHP_EOL.'<span>';
							foreach ($item['child'] as $key1 => $child1) {
								if($key1<3){
									echo '<a href="'.$child1["url"].'" title="'.$child1["name"].'">'.$child1["name"].'</a>,';
								}else if($key1==3){
									echo '<a href="'.$child1["url"].'" title="'.$child1["name"].'">'.$child1["name"].'</a>';
								}
							}
							echo PHP_EOL.'</span>';

								// Submenu-lv1
							echo PHP_EOL.'<ul class="submenu-lv1">';
							foreach ($item['child'] as $child1) {
								if(empty($child1['child2'])){
									echo PHP_EOL.'<li>';
									echo PHP_EOL.'<a href="'.$child1['url'].'" title="'.$child1['name'].'">'.$child1['name'].'</a>';
								}else{
									echo PHP_EOL.'<li>';
									echo PHP_EOL.'<a href="'.$child1['url'].'" title="'.$child1['name'].'" class="title">'.$child1['name'].'</a>';

										// Submenu-lv2
									echo PHP_EOL.'<ul class="child2 submenu-lv2">';
									foreach ($child1['child2'] as $child2) {
										echo PHP_EOL.'<li>';
										echo PHP_EOL.'<a href="'.$child2['url'].'" title="'.$child2['name'].'">'.$child2['name'].'</a>';
										echo PHP_EOL.'</li>';
									}
									echo PHP_EOL.'</ul>';
								}

								echo PHP_EOL.'</li>';
							}
							echo PHP_EOL.'</ul>';
						}
						echo PHP_EOL.'</li>';
					}
					?>
				</ul>
			</div>
			<div class="col-md-9"></div>
		</div>
	</div>
	<!-- End Navbar -->
	<section id="page-body" class="container page-order">
		<div class="row list-order">
			<div class="box-product col-md-8">
				<h1 class="block-title">Giỏ hàng</h1>
				<form method="post" action="<?= base_url().'order/update_quantity'?>">
					<table class="table table-order">
						<tr>
							<th>Ảnh</th>
							<th>Mã</th>
							<th>Tên</th>
							<th>Giá</th>
							<th>Số lượng</th>
							<th></th>
						</tr>
						<?php
						$total = $amount = 0;
						if(isset($_SESSION['CART']) && count($_SESSION['CART']) > 0){
							$n = count($_SESSION['CART']);
							for ($i=0; $i < $n; $i++) { 
								$name = $_SESSION['CART'][$i]['name'];
								$pro_code = $_SESSION['CART'][$i]['pro_code'];
								$thumb = base_url().$_SESSION['CART'][$i]['thumb'];
								$link = base_url().'san-pham/'.$_SESSION['CART'][$i]['code'].'/'.$pro_code;

								/*Tính tổng tiền*/
								$amount = $_SESSION['CART'][$i]['sl'] * $_SESSION['CART'][$i]['start_price'];
								$total += $amount;

								echo '<tr>
								<td><img src="'.$thumb.'" alt="'.$name.'" class="img-responsive"></td>
								<td><b>'.$pro_code.'</b></td>
								<td>'.$name.'</td>
								<td><span class="price">'.number_format($_SESSION['CART'][$i]['start_price']).'</span>₫</td>
								<td><input type="number" class="btn-quantity" min=0 name="quantity[]" value="'.$_SESSION['CART'][$i]['sl'].'"></td>
								<td class="tbl_actions"><a href="'.base_url().'order/delete/'.$_SESSION['CART'][$i]['id'].'" title="Xóa" onclick="return confirm(\'Bạn có chắc muốn xóa ?\')"><i class="fa fa-trash red" aria-hidden="true"></i>Delete</a></td>
								</tr>';
							}
						}
						?>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>Tổng tiền : <span class="price"><?= number_format($total).'₫' ?></span></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td colspan="2" class="text-right">
								<input type="submit" name="update" class="btn btn-primary" value="Cập nhật giỏ hàng">
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div class="col-md-4" style="background-color: #f5f5f5">
				<h2>Thông tin khách hàng</h2>
				<small>(Các mục có dấu <font color="red">*</font> là thông tin bắt buộc)</small>
				<form method="post" action="<?= base_url().'order/addnew'?>">
					<input type="hidden" name="txt_totalmoney" value="<?= $total ?>">
					<div class="form-group">
						<label>Họ</label><font color="red">*</font>
						<input type="text" name="txt_lastname" class="form-control" placeholder="Họ đệm của bạn" required>
					</div>
					<div class="form-group">
						<label>Tên</label><font color="red">*</font>
						<input type="text" name="txt_firstname" class="form-control" placeholder="Tên của bạn" required>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="txt_email" class="form-control" placeholder="Email (nếu có)">
					</div>
					<div class="form-group">
						<label>SĐT</label><font color="red">*</font>
						<input type="tel" name="txt_phone" class="form-control" placeholder="Số điện thoại">
					</div>
					<div class="form-group">
						<label>Địa chỉ</label><font color="red">*</font>
						<textarea name="txt_address" class="form-control" placeholder="Địa chỉ"></textarea>
					</div>
					<div class="form-group text-center">
						<input type="submit" name="submit_checkout" class="btn btn-primary" value="Gửi thông tin">
					</div>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
	</section>
</section>
