<!-- Footer -->
<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-4 item">
				<div class="title"><span><?= $module1['name'] ?></span></div>
				<div class="content">
					<ul>
						<?php
						foreach ($box1 as $key => $value) {
							echo '<li><a href="'.base_url().'tin-tuc/'.$value['code'].'html" title="'.$value['title'].'"><i class="fa fa-caret-right"></i>'.$value['title'].'</a></li>';
						}
						?>
					</ul>
				</div>
			</div>
			<div class="col-md-3 col-sm-4 item">
				<div class="title"><span><?= $module1['name'] ?></span></div>
				<div class="content">
					<ul>
						<?php
						foreach ($box1 as $key => $value) {
							echo '<li><a href="'.base_url().'tin-tuc/'.$value['code'].'html" title="'.$value['title'].'"><i class="fa fa-caret-right"></i>'.$value['title'].'</a></li>';
						}
						?>
					</ul>
				</div>
			</div>
			<div class="col-md-3 col-sm-4 item">
				<div class="title"><span>SẢN PHẨM NỔI BẬT</span></div>
				<div class="content">
					<ul>
						<?php
						foreach ($hot_products as $key => $value) {
							echo '<li><a href="'.base_url().$value['code'].'.html" title="'.$value['name'].'"><i class="fa fa-caret-right"></i>'.$value['name'].'</a></li>';
						}
						?>
					</ul>
				</div>
			</div>
			<div class="col-md-3 col-sm-12 item">
				<div class="title"><i class="fa fa-share-alt"></i>CỘNG ĐỒNG</div>
				<div class="content">
					<div class="social-link">
						<ul class="social-icon">
							<li>
								<a target="_blank" href="<?= base_url() ?>" title="Trang chủ">
									<img src="<?= base_url() ?>assets/images/2banh_icon.jpg" alt="Trang chủ">
								</a>
							</li> 
							<li> 
								<a target="_blank" rel="nofollow" href="<?= $config['facebook'] ?>" title="Facebook">
									<img src="<?= base_url() ?>assets/images/fb_icon.jpg" alt="Facebook">
								</a> 
							</li> 
							<li> 
								<a target="_blank" href="<?= $config['gplus'] ?>" title="google +">
									<img src="<?= base_url() ?>assets/images/gplus_icon.jpg" alt="google +">
								</a> 
							</li> 
							<li> 
								<a target="_blank" rel="nofollow" href="<?= $config['youtube'] ?>" title="youtube">
									<img src="<?= base_url() ?>assets/images/youtube_icon.jpg" alt="youtube">
								</a> 
							</li> 
						</ul>
					</div>
					<?php
					echo $box3['content'];
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="bottom">
		Copyright ©2018 <?= $config['title'] ?>. All rights reserved.
	</div>
</footer>
<!-- End Footer -->
<div id="back-top" style="display: block;">
	<a href="#" class="top" style="display: block;"><i class="fa fa-arrow-up fa-lg"></i></a>
</div>
<script src="<?= base_url()?>assets/js/index.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".owl-carousel").owlCarousel({
			navigation : true, // Show next and prev buttons
			slideSpeed : 300,
			paginationSpeed : 400,
			items : 1, 
			itemsDesktop : false,
			itemsDesktopSmall : false,
			itemsTablet: false,
			itemsMobile : false,
			loop:true,
		    autoplay:true,
		    autoplayTimeout:4000,
		    autoplayHoverPause:true
		});
	})

	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 400) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});
</script>
<script type="text/javascript">
	$(".ct-search-mini").click(function() {
		$('.ct-search-mini i').toggleClass('fa-times');
		$('.ct-search-mini i').toggleClass('fa-search');
		$('body').toggleClass('not-home-show-search');
	});
	$(window).on('scroll', function() {
		var scrollTop = $(this).scrollTop();
		if (scrollTop <= 0) {
			$('#ct-mobile-navbar').removeClass('ct-navbar-active');
		} else {
			$('#ct-mobile-navbar').addClass('ct-navbar-active');
		}
	});
	var $mainMenu = $('.ct-menu-parent').on('click', 'span.sub-arrow', function(e) {
		var obj = $mainMenu.data('smartmenus');
		if (obj.isCollapsible()) {
			var $item = $(this).parent(),
			$sub = $item.parent().dataSM('sub'),
			subIsVisible = $sub.dataSM('shown-before') && $sub.is(':visible');
			$sub.dataSM('arrowClicked', true);
			obj.itemActivate($item);
			if (subIsVisible) {
				obj.menuHide($sub);
			}
			e.stopPropagation();
			e.preventDefault();
		}
	}).bind({
		'beforeshow.smapi': function(e, menu) {
			var obj = $mainMenu.data('smartmenus');
			if (obj.isCollapsible()) {
				var $menu = $(menu);
				if (!$menu.dataSM('arrowClicked')) {
					return false;
				}
				$menu.removeDataSM('arrowClicked');
			}
		},
		'show.smapi': function(e, menu) {},
		'hide.smapi': function(e, menu) {}
	});
</script>
</body>
</html>
