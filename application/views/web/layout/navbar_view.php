<!-- Navbar -->
<nav class="navbar" role="navigation">
	<div class="container main-content">
		<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 col-left-ct">
			<div class="row">
				<div class="col-md-4 col-sm-12 col-sm-12 main-menu">
					<div class="header-main-menu"><i class="fa fa-bars"></i>Danh mục sản phẩm</div>
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
				<div class="col-md-8 col-sm-12 col-xs-12 main-slider">
					<div class="owl-carousel owl-theme">
						<?php
						foreach ($slider as $value) {
							echo '<div class="item"><a href="'.$value['link'].'" title="'.$value['name'].'"><img src="'.base_url().$value['image'].'" alt="'.$value['name'].'" class="img-responsive"></a></div>';
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col-right-ct">
			<div class="suport-box"> 
				<div class="info-title">
					<?= $box4['name'] ?>
				</div> 
				<?= $box4['content'] ?>
			</div>
		</div>
	</div>
</nav>
<!-- End Navbar -->