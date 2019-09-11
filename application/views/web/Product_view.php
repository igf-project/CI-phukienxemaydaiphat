<section class="body main-content component">
	<header class="page-header">
		<div id="path">
			<div class="container">
				<div class="box-breadcrumb">
					<div class="row">
						<div class="col-md-9 col-md-offset-3">
							<ul class="breadcrumb">
								<li><a href="<?php echo base_url()?>" title="Trang chủ"><i class="fa fa-home" aria-hidden="true" style="font-size:18px"></i></a></li>
								<li><a href="<?php echo base_url().$group_product['code']?>" title="<?= $group_product['name'] ?>"><?= $group_product['name'] ?></a></li>
								<li><a href="<?php echo base_url().$result['code']?>.html" title="<?= $result['name'] ?>"><?= $result['name'] ?></a></li>
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
	<section id="page-body" class="container page-product-detail">
		<div class="row">
			<div class="col-md-9">
				<div class="row">
					<?php
					$result['images'] = json_decode($result['images']);
					?>
					<aside class="col-md-5">
						<div class="img-detail">
							<img src='<?= base_url().$result['images'][0] ?>' id="Zoomer" class='img-responsive' alt="<?= $result['name'] ?>"/>
						</div>
						<div class="products-slider-detail">
							<div id="list-image">
								<?php
								foreach ($result['images'] as $key => $value) {
									if($value != ''){
										echo '<div class="item"><img src="'.base_url().$value.'" alt="" class="img-thumbnail"></div>';
									}
								}
								?>
							</div>
						</div>
					</aside>
					<article class="col-md-7">
						<h1 class="block-title"><?= $result['name'] ?></h1>
						<?php if($result['intro'] != ''){ ?>
						<div class="product-intro">
							<p class="p-intro"><?= $result['intro'] ?></p>
						</div>
						<?php } ?>

						<?php if(!empty($related_tag)){ ?>
						<div class="external">
							<span>Dùng cho xe:</span>
							<?php
							foreach ($related_tag as $k => $v) {
								echo '<a href="'.base_url().$v['link'].'-'.$v['id'].'.html" title="'.$v['name'].'">'.$v['name'].'</a>';
							}
							?>
						</div>
						<?php } ?>
						<div class="info-detail">
							<div class="price">Giá: 
								<span><?= number_format($result['start_price']) ?> đ</span> 
								<span class="pro_unit">Đơn vị: Cái</span> 
								<div class="status-detail">
									<i class="fa fa-check-circle"></i>Còn hàng
								</div> 
							</div> 
							<div class="price">
								Mã sản phẩm: <strong class="pro_code"><?= $result['pro_code'] ?></strong>
							</div>
							<div class="box-number">
								<div class="input-qty">
									<input type="text" id="sl_number" value="1" class="form-control text-center" style="display: block;">
								</div>
							</div>
							<div class="buy-btn"> 
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
									<button data-id="<?= $result['id'] ?>" data-pro-code="<?= $result['pro_code'] ?>" class="btn btn-danger btn-lg buy-btn-detail" id="addToCart">MUA NGAY</button> 
								</div> 
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"> 
									<div class="whatsapp-icon col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
										<i class="fa fa-whatsapp" style="font-size: 38px; padding: 0px;" aria-hidden="true"></i>
									</div> 
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10"> 
										<strong>Hỗ trợ mua hàng Online</strong><br> 
										<span><a href="tel:+84<?= $config['phone'] ?>"><?= '0'.$config['phone'] ?></a></span> 
									</div> 
									<div class="clearFix"></div> 
								</div> 
								<div class="clearFix"></div> 
							</div> 
							<div class="clearFix"></div> 
						</div>
					</article>
				</div>
				<br/><br/><br/>
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#desc" aria-controls="desc" role="tab" data-toggle="tab">Thông tin sản phẩm</a>
					</li>
				</ul>
				<div class="tab-content tab-content-detail">
					<!-- Description Tab Content -->
					<div role="tabpanel" class="tab-pane active" id="desc">
						<div class="well">
							<?= $result['fulltext'] ?>
						</div>
					</div>
				</div>
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

		<div class="clearfix"></div>
		<aside class="box-relatedProduct">
			<h3 class="box-title"><span>Sản phẩm cùng nhóm</span></h3>
			<div class="row">
				<?php
				foreach ($product_same_group as $item) {
					echo '
					<div class="col-md-2 col-sm-4 col-xs-3 item">
					<figure>
					<a href="'.base_url().$item['code'].'.html" title="'.$item['name'].'" class="box-thumb">
					<img src="'.base_url().$item['thumb'].'" atl="'.$item['name'].'" class="thumb img-responsive">
					</a>
					<figcaption>
					<h3 class="article-title"><a href="'.base_url().$item['code'].'.html" title="'.$item['name'].'">'.$item['name'].'</a></h3>
					<span class="price">'.number_format($item['start_price']).'<small style="color:#333"> ₫</small></span>
					</figcaption>
					</figure>
					</div>';
				}
				?>
			</div>
		</aside>
	</section>
</section>
<script type="text/javascript">
	$("#sl_number").TouchSpin({
		verticalbuttons: true,
		prefix: 'Số lượng'
	});
</script>