<header class="header">
	<!-- Mobile navbar -->
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="ct-mobile-navbar">
		<div class="container">
			<div class="navbar-header">
				<div class="col-sm-2 col-xs-2">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="col-sm-8 col-xs-8 ct-navbar-logo">
					<a href="<?= base_url()?>"></a>
				</div>
				<div class="col-sm-2 col-xs-2 ct-navbar-cart cart-mo">
					<img alt="Giỏ hàng" src="<?= base_url()?>assets/images/emty-cart-1.png"> 
					<div class="cartTopRightQuantity cart-quantity-mo" style="display: block;">1</div> 
				</div>
				<!-- Search mobile -->
				<div class="ct-navbar-search-full-width" id="ct-navbar-search-full-width">
					<form method="GET" action="<?= base_url() ?>tim-kiem">
						<div class="form-group">
							<input type="text" value="<?php if(isset($q)) echo $q ?>" class="form-control search-input" name="q" aria-label="Search here..." placeholder="Nhập tên sản phẩm muốn tìm..." required="">
							<button id="btn-search" type="submit" class="btn btn-default btn-search"><i class="fa fa-search"></i></button>
						</div>
					</form>
				</div>
				<!-- End Search mobile -->
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<!-- Left nav -->
				<ul class="nav navbar-nav ct-cat-menu">
					<?php
					$i=0;
					foreach ($catalog as $key => $item) {
						$i++;
						echo PHP_EOL.'<li>';
						if(empty($item['child'])){
							echo PHP_EOL.'<a href="'.$item["url"].'" title="'.$item["alias"].'">'.$item["alias"].'</a>';
						}
						else{
							echo PHP_EOL.'<a href="'.$item["url"].'" title="'.$item["alias"].'">'.$item["alias"].' <span class="caret"></span></a>';

							// Submenu-lv1
							echo PHP_EOL.'<ul class="dropdown-menu child1 last-sub-menu">';
							foreach ($item['child'] as $ch1 => $child1) {
								echo PHP_EOL.'<li>';

								// Submenu-lv2
								if(empty($child1['child2'])){
									echo PHP_EOL.'<a href="'.$child1['url'].'" title="'.$child1['alias'].'">'.$child1['alias'].'</a>';
								}
								else{
									echo PHP_EOL.'<a href="'.$child1['url'].'" title="'.$child1['alias'].'">'.$child1['alias'].' <span class="caret"></span></a>';

									echo PHP_EOL.'<ul class="dropdown-menu child2 end-menu">';
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
					$i=0;
					foreach ($tags as $key => $item) {
						$i++;
						echo PHP_EOL.'<li>';
						if(empty($item['child'])){
							echo PHP_EOL.'<a href="'.$item["url"].'" title="'.$item["name"].'">'.$item["name"].'</a>';
						}
						else{
							echo PHP_EOL.'<a href="'.$item["url"].'" title="'.$item["name"].'">'.$item["name"].' <span class="caret"></span></a>';

							// Submenu-lv1
							echo PHP_EOL.'<ul class="dropdown-menu child1 last-sub-menu">';
							foreach ($item['child'] as $ch1 => $child1) {
								echo PHP_EOL.'<li>';

								// Submenu-lv2
								if(empty($child1['child2'])){
									echo PHP_EOL.'<a href="'.$child1['url'].'" title="'.$child1['name'].'">'.$child1['name'].'</a>';
								}
								else{
									echo PHP_EOL.'<a href="'.$child1['url'].'" title="'.$child1['name'].'">'.$child1['name'].' <span class="caret"></span></a>';

									echo PHP_EOL.'<ul class="dropdown-menu child2 end-menu">';
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
			</div><!--/.nav-collapse -->
		</div><!--/.container -->
	</nav>
	<!-- End Mobile navbar -->
	<!-- Panel fix -->
	<div class="top-panel-fixed-wrp">
		<div class="container top-panel-fixed">
			<div class="col-md-3 col-sm-12 col-sm-12 main-menu-fixed"></div>
			<div class="col-lg-2 col-md-3 col-sm-12 col-sm-12 home-logo-fixed">
				<a href="<?php echo base_url();?>" title="Trang chủ">
					<img src="<?php echo base_url();?>assets/images/logo1.png" class="logo img-responsive" alt="trang chủ">
				</a>
			</div>
			<div class="col-lg-5 col-md-3 col-sm-12 col-xs-12 search-top-fixed search-box"></div>
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 cart-fixed" id="cartTopRightFix"></div>
		</div>
	</div>
	<!-- End Panel fix -->
	<!-- Top Header -->
	<nav class="top-header" role="navigation">
		<div class="container">
			<ul class="nav navbar-nav navbar-right">
				<?php
				foreach ($menu as $key => $item) {
					echo '<li><a href="'.$item['url'].'" title="'.$item['title'].'" class="'.$item['class'].'">'.$item['title'].$item['icon'].'</a></li>';
				}
				?>
			</ul>
		</div>
	</nav>
	<!-- End Top Header -->
	<!-- Middle Header -->
	<div class="middle-header" id="ct-nav-tabpc">
		<div class="container">
			<div class="row">
				<div class="col-md-2 col-sm-2">
					<a class="navbar-brand" href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo1.png" class="logo img-responsive" title="trang chủ"></a>
				</div>
				<div class="col-md-8 col-sm-8 search-box search-top m-t-2">
					<form method="GET" action="<?= base_url() ?>tim-kiem">
						<div class="input-group">
							<input type="text" value="<?php if(isset($q)) echo $q ?>" class="form-control search-input" name="q" aria-label="Search here..." placeholder="Nhập tên sản phẩm muốn tìm..." required="">
							<div class="input-group-btn">
								<button id="btn-search" type="submit" class="btn btn-default btn-search"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</form>
					<div class="suggested-search">
						Tìm nhiều: <a href="" title="Led 2 tang">Led 2 tầng</a> 
						<a href="" title="Khoa Smartkey">Khóa Smartkey</a> 
						<a href="" title="lọc gió BMC">lọc gió BMC</a> 
						<a href="" title="phuoc racingboy">phuộc racingboy</a> 
						<a href="" title="vo xe michelin">vỏ xe michelin</a> 
						<a href="" title="NSD SSS">NSD SSS</a> 
					</div>
				</div>
				<div class="col-md-2 col-sm-2 cart-btn cart-top hidden-xs m-t-2">
					<a href="<?= base_url()?>gio-hang" class="btn btn-theme">
						<i class="fa fa-shopping-cart"></i> <span class="count_cart"><?php if(isset($_SESSION['CART'])) echo count($_SESSION['CART']); else echo '0'; ?></span> <span class="caret"></span>
					</a>
				</div>
			</div>
		</div>
	</div>
	<!-- End Middle Header -->
</header>
<!-- Slide mobile -->
<div class="owl-carousel owl-theme" id="ct-slider-mobile">
	<?php
	foreach ($slider as $value) {
		echo '<div class="item"><a href="'.$value['link'].'" title="'.$value['name'].'"><img src="'.base_url().$value['image'].'" alt="'.$value['name'].'" class="img-responsive"></a></div>';
	}
	?>
</div>
<!-- End Slide mobile -->
