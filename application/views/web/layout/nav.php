<div class="col-md-4 col-sm-12 col-sm-12 main-menu hidden">
	<div class="header-main-menu"><i class="fa fa-bars"></i>Danh mục sản phẩm</div>
	<ul class="main_menu_dropdown">
		<?php
		$i=0;
		foreach ($catalog as $key => $item) {
			$i++;
			echo '<li class="hadsub-menu">';
			echo '<a href="'.$item["url"].'" class="menu-link" title="'.$item["alias"].'">
			<i class="menu-0'.$i.'"></i>
			<h2 class="">'.$item["alias"].'</h2>
			<i class="fa fa-angle-right"></i>
			</a>';
			if(isset($item['child']) && !empty($item['child'])){
				echo '<span>';
				foreach ($item['child'] as $key1 => $cata_child) {
					if($key1<3){
						echo '<a href="'.$cata_child["url"].'" title="'.$cata_child["alias"].'">'.$cata_child["alias"].'</a>,';
					}else if($key1==3){
						echo '<a href="'.$cata_child["url"].'" title="'.$cata_child["alias"].'">'.$cata_child["alias"].'</a>';
					}
				}
				echo '</span>';

								// Submenu-lv1
				echo '<ul class="submenu-lv1">';
				foreach ($item['child'] as $cata_child) {
					echo '<li><a href="'.$cata_child['url'].'" title="'.$cata_child['alias'].'">'.$cata_child['alias'].'</a></li>';
				}
				echo '</ul>';
			}
			echo '</li>';
		}
		?>
	</ul>
</div>