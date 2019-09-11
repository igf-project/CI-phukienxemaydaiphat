<section class="body main-content component">
	<header class="page-header">
		<div id="path">
			<div class="container">
				<div class="box-breadcrumb">
					<div class="row">
						<div class="col-md-9 col-md-offset-3">
							<ul class="breadcrumb">
								<li><a href="<?php echo base_url()?>" title="Trang chủ"><i class="fa fa-home" aria-hidden="true" style="font-size:18px"></i></a></li>
								<li><a href="<?php echo base_url().'tin-tuc/'.$result['category']['code'] ?>" title="<?= $result['category']['name'] ?>"><?= $result['category']['name'] ?></a></li>
								<li><a href="<?php echo base_url().'tin-tuc/'.$result['code'].'.html' ?>" title="<?= $result['title'] ?>"><?= $result['title'] ?></a></li>
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
			<article class="col-md-9">
				<h1 class="block-title"><?= $result['title'] ?></h1>
				<div class="post-detail">
					<div class="p-intro"><?= $result['intro'] ?></div>
					<?php
					if(count($result['related'])>0){
						echo '<div class="post-related">
						<ul class="list-related-news">';
						foreach ($result['related'] as $item) {
							echo'<li>
							<i class="fa fa-circle" aria-hidden="true"></i>
							<a href="'.base_url().'tin-tuc/'.$item['code'].'.html" title="'.$item['title'].'" class="name">'.$item['title'].'</a>
							</li>';
						}
						echo '</ul>
						</div>';
					}
					?>
					<div class="fulltext"><?= $result['fulltext'] ?></div>
				</div>
			</article>
			<aside class="col-md-3">
				<aside class="box-module news">
					<div class="title">Tin mới nhất</div>
					<?php
					foreach ($listHot as $key => $item) {
						$link = base_url().'tin-tuc/'.$item['code'].'.html';
						$date = date('H:i d/m/Y', strtotime($item['cdate']));
						if($key==0){
							echo '<article class="item item-first">
							<a href="'.$link.'" title="'.$item['title'].'" class="box-thumb">
							<figure>
							<img src="'.base_url().$item['thumb'].'" class="thumb img-responsive">
							</figure>
							</a>
							<p class="article-title"><a href="'.$link.'" title="'.$item['title'].'">'.$item['title'].'</a></p>
							<div class="article-meta">
							<span class="article-publish"><i class="fa fa-calendar" aria-hidden="true"></i>'.$date.'</span>
							<div class="article-desc">'.$item['intro'].'</div>
							</div>
							</article>';
						}else{
							echo '<article class="item">
							<a href="'.$link.'" title="'.$item['title'].'" class="box-thumb">
							<figure>
							<img src="'.base_url().$item['thumb'].'" class="thumb img-responsive">
							</figure>
							</a>
							<p class="article-title"><a href="'.$link.'" title="'.$item['title'].'">'.$item['title'].'</a></p>
							<div class="article-meta">
							<span class="article-publish"><i class="fa fa-calendar" aria-hidden="true"></i>'.$date.'</span>
							</div>
							</article>';
						}
					}
					?>
				</aside>
			</aside>
		</div>
		<aside class="box-relatedcontent">
			<h3 class="box-title">Bài viết cùng chuyên mục</h3>
			<div class="row">
				<?php
				foreach ($posts_same_group as $item) {
					echo '
					<div class="col-md-3 item">
					<figure>
					<a href="'.base_url().'tin-tuc/'.$item['code'].'.html" title="'.$item['title'].'" class="box-thumb">
					<img src="'.base_url().$item['thumb'].'" atl="'.$item['title'].'" class="thumb img-responsive">
					</a>
					<figcaption>
					<p class="article-title"><a href="'.base_url().'tin-tuc/'.$item['code'].'.html" title="'.$item['title'].'">'.$item['title'].'</a></p>
					<div class="p-intro lab-hide">'.$item['intro'].'</div>
					</figcaption>
					</figure>
					</div>';
				}
				?>
			</div>
		</aside>
	</section>
</section>
