<div class='h-w-main h-center' id='g_list'>
	<section class='text-section' style=' padding:0px; '>
		<h2 class='h-bottom-title2'>ABOUT III VIVINIKO'S LETTER</h2>
		<p class='h-param'  style='font-size:14px;'>在每季新品发布之际，<br>IIIVIVINIKO 总是想通过一种方式和亲爱的兄弟姐妹们分享我们的感悟，所以便有了这样一本手札</p>
	</section>
	<?php 
		foreach ($data as $key => $value):
	?>
	<section class='img-section'>
		<img class='lazy_img'  src='img/lazy.gif'>
		<img class='img-responsive' style='margin:0px auto;display:none;' data-lazy="<?php echo $value["path"]; ?>">
		<div>
			<?php echo $value["description"]; ?>
		</div>
	</section>
	<?php 
		endforeach;
	?>

</div>	