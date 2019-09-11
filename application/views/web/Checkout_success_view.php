<section class="body main-content component">
	<header class="page-header container">
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
		<div class="list-order">
			<?php
			if (isset($success_message)) {
				echo $success_message;
				echo '<div style="margin-bottom:20px;">Chúc mừng bạn đã đặt hàng thành công. <span style="font-style: italic;"><b style="color: red; font-weight: 500">Gia dụng Đại Phát</b> sẽ tiếp nhận thông tin và liên hệ tới bạn trong vòng 1 ngày làm việc. Xin cảm ơn!</span></div>';
			}
			if (isset($error_message)) {
				echo $error_message;
			}
			?>
			<div class="text-center">
				<a href="<?= base_url() ?>" class="btn btn-success" title="Trang chủ">Về trang chủ</a>
			</div>
			<div class="clearfix"></div>
		</div>
	</section>
</section>
