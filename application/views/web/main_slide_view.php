<!-- Slide Main -->
<section id="slide-main">
	<div class="swiper-container">
		<div class="swiper-wrapper">
			<?php
			foreach ($slider as $value) {
				echo '<div class="swiper-slide"><img src="'.base_url().$value['image'].'" alt="slide1" class="img-responsive"></div>';
			}
			?>
		</div>
		<div class="swiper-button-next arrow-right"><span class="arrow arrow-left"><img src="<?php echo base_url()?>assets/images/arrow-left.png"></span></div>
		<div class="swiper-button-prev arrow-left"><span class="arrow arrow-right"><img src="<?php echo base_url()?>assets/images/arrow-right.png"></span></div>
	</div>
</section>
<!-- End Slide Main -->