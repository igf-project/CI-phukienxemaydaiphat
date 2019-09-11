<section class="body">
	<header class="page-header"></header>
	<div id="path">
		<div class="container">
			<div class="box-breadcrumb">
				<ul class="breadcrumb">
					<li><a href="<?php echo base_url()?>" title="Trang chủ"><i class="fa fa-home" aria-hidden="true" style="font-size:18px"></i></a></li>
					<li><a href="<?php echo base_url()?>thu-vien-anh" title="Giới thiệu">Thư viện ảnh</a></li>
					<li><a href="#" title="Thư viện ảnh <?php echo $page_title ?>">Thư viện ảnh <?php echo $page_title ?></a></li>
				</ul>
			</div>
		</div>
	</div>
	<section id="page-body" class="container">
		<section class="page-gallery">
			<section>
				<h1>Thư viện ảnh <span class="red"><?php echo $page_title ?></span><br/>
					<small class="intro">Album HOT, khoảnh khắc đẹp về Hà Nội</small>
				</h1>
				<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
					<div class="slides"></div>
					<h3 class="title"></h3>
					<a class="prev">‹</a>
					<a class="next">›</a>
					<a class="close">×</a>
					<a class="play-pause"></a>
					<ol class="indicator"></ol>
				</div>
				<div id="list-images" class="row">
					<?php
					foreach ($gallery as $item) {
						echo '<div class="col-md-3 item">
						<a href="'.base_url().$item['link'].'" title="'.$item['name'].'" data-gallery>
						<img src="'.base_url().$item['link'].'" alt="'.$item['name'].'" class="img-responsive">
						</a>
						</div>';
					}
					?>
				</div>
				<script>
					document.getElementById('links').onclick = function (event) {
						event = event || window.event;
						var target = event.target || event.srcElement,
						link = target.src ? target.parentNode : target,
						options = {index: link, event: event},
						links = this.getElementsByTagName('a');
						blueimp.Gallery(links, options);
					};
				</script>
			</section>
		</section>
	</section>
</section>
