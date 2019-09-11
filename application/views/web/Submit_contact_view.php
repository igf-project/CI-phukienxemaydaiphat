<section class="body main-content component">
	<header class="page-header">
		<div class="container">
			<h1 class="block-title">Cảm ơn quý khách !</h1>
		</div>
	</header>
	<div id="path">
		<div class="container">
			<div class="box-breadcrumb">
				<div class="row">
					<div class="col-md-9 col-md-offset-3">
						<ul class="breadcrumb">
							<li><a href="<?php echo base_url()?>" title="Trang chủ"><i class="fa fa-home" aria-hidden="true" style="font-size:18px"></i></a></li>
							<li>Cảm ơn</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
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
	<section id="page-body" class="container page-contact padding">
		<div class="box-contact">
			<p>Cám ơn Quý Khách hàng đã quan tâm đến dịch vụ cho vay tín dụng của <span class="red"><?= $config['name'] ?></span>. Tư vấn viên của chúng tôi sẽ liên hệ lại cho bạn để xác nhận trong thời gian sớm nhất.</p><br>
			<div class="clearfix"></div>
			<div class="text-center">
				<a class="btn btn-success" href="<?= base_url()?>">Quay trở về trang chủ.</a><br/>
			</div>
		</div>
	</section>
</section>
