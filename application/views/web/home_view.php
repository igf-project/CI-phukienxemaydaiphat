<!-- Main Content -->
<section>
<section class="container">
<ul class="homeproduct appliance">
<?php
foreach ($products as $key => $value) {
$link = base_url().$value['code'].'.html';
echo '<li>
<a href="'.$link.'" title="'.$value['name'].'">
<figure>
<img src="'.base_url().$value['thumb'].'" alt="'.$value['name'].'">
<figcaption>
<h3>'.$value['name'].'</h3>
<strong>'.number_format($value['start_price']).'₫</strong>
<div class="promotion">';
echo '<span>'.$value['intro'].'</span>
</div>
<p></p>
</figcaption>
</figure>
</a>
</li>';
}
?>
</ul>
</section>
</section>
<br>
<!-- End Main Content -->