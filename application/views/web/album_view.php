<section class="body">
	<header class="page-header"></header>
	<div id="path">
		<div class="container">
			<div class="box-breadcrumb">
				<ul class="breadcrumb">
					<li><a href="index.html" title="Trang chủ"><i class="fa fa-home" aria-hidden="true" style="font-size:18px"></i></a></li>
					<li><a href="<?php echo base_url()?>thu-vien-anh" title="Thư viện ảnh">Thư viện ảnh</a></li>
				</ul>
			</div>
		</div>
	</div>
	<section id="page-body" class="container">
		<div class="page-profile">
			<section id="box-gallery">
				<div class="container">
					<h1>Thư viện ảnh <span class="red">Hà Nội</span><br/>
						<small class="intro">Album HOT, khoảnh khắc đẹp về Hà Nội</small>
					</h1>
					<div class="row">
						<?php
						$i = $j = 1;
						foreach ($album as $value) {
							if($i==1){
								$isBig='col-md-6 item item-big';
								$i++;
							}else if($i<$j+5){
								$isBig='col-md-3 item';
								$i++;
							}else if ($i==$j+5) {
								$isBig='col-md-6 item item-big';
								$i=1;
							}
							$link = base_url().'thu-vien-anh/'.stripslashes($value['code']).'.html';
							echo '
							<div class="'.$isBig.'">
							<a href="'.$link.'" title="'.stripslashes($value['name']).'">
							<figure>
							<img src="'.stripslashes($value['thumb']).'" alt="'.stripslashes($value['name']).'" class="thumb-album">
							<figcaption class="caption">'.stripslashes($value['name']).'</figcaption>
							</figure>
							<div class="caption-icon"><i class="fa fa-camera" aria-hidden="true"></i></div>
							</a>
							</div>
							';
						}
						?>
					</div>
				</div>
			</section>
		</div>
	</section>
</section>