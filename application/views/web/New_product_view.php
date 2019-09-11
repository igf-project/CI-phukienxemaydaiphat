<section class="body main-content component">
	<div class="bg-design-pattern"></div>
	<header class="page-header">
		<div id="path">
			<div class="container">
				<div class="box-breadcrumb">
					<div class="row">
						<div class="col-md-9 col-md-offset-3">
							<ul class="breadcrumb">
								<li><a href="<?php echo base_url()?>" title="Trang chủ"><i class="fa fa-home" aria-hidden="true" style="font-size:18px"></i></a></li>
								<li><a href="<?php echo base_url().'san-pham-moi' ?>" title="Sản phẩm mới">Sản phẩm mới</a></li>
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

	<section id="page-body" class="container page-post-detail">
		<div class="row">
			<div class="blog-product col-md-9">
				<h1 class="block-title">Sản phẩm mới</h1>
				<div class="row box-product">
					<?php
					foreach ($listProduct as $key => $item) {
						$link = base_url().$item['code'].'.html';
						$img = '<img src="'.base_url().$item['thumb'].'" alt="'.$item['name'].'" class="img-responsive">';
						?>
						<div class="col-md-4 col-sm-6 col-xs-6 product">
							<figure>
								<a href="<?= $link ?>" title="<?= $item['name'] ?>" class="box-thumb">
									<img src="<?= base_url().$item['thumb'] ?>" class="img-responsive thumb" alt="<?= $item['name'] ?>">
								</a>
								<figcaption>
									<h3 class="name"><a href="<?= $link ?>" title="<?= $item['name'] ?>"><?= $item['name'] ?></a></h3>
									<div class="price"> <?= number_format($item['start_price']) ?>₫</div>
								</figcaption>
							</figure>
						</div>
						<?php
					}
					?>
				</div>
				<div class="clearfix"></div>
				<?php if (isset($links)) { ?>
					<?php echo $links ?>
				<?php } ?>
			</div>
			<aside class="col-md-3 fillter">
				<div class="filter-sidebar suport-box"> 
					<div class="info-title">
						<?= $box4['name'] ?>
					</div> 
					<?= $box4['content'] ?>
				</div>
				<div class="filter-sidebar">
					<div class="title">
						<span>Sản phẩm nổi bật</span>
					</div>
					<div class="content">
						<?php
						foreach ($hot_products as $k => $v) {
							echo '<article class="item">
							<a href="'.base_url().$v['code'].'.html" class="box-thumb" title="'.$v['name'].'">
								<figure>
									<img src="'.$v['thumb'].'" class="thumb img-responsive">
								</figure>
							</a>
							<p class="article-title"><a href="'.base_url().$v['code'].'.html" '.$v['name'].'>'.$v['name'].'</a></p>
							<div class="article-meta">
								<span class="article-price">'.number_format($v['start_price']).'<small> ₫</small></span>
							</div>
							</article>';
						}
						?>
					</div>
				</div>
			</aside>
		</div>
	</section>
</section>
