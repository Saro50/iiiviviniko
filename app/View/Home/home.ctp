
<div class='h-w-main'>
	<div id="slider" class="h-carousel carousel slide" data-ride="carousel" >



	  <!-- Wrapper for slides -->
		    <div class="carousel-inner">
		    	<?php foreach ($data as $key => $value): ?>
			    
			    <div class="item <?php  echo $key == 0 ? 'active' : ''; ?>"  >
			       <img src="<?php echo $value['path']; ?>" alt="<?php echo $value['alternate']; ?>" title="<?php echo $value['alternate']; ?>"  >

			    </div>
			<?php endforeach; ?>
	
		  	</div>

		  <!-- Controls -->
		  <a class="left carousel-control" href="#slider" data-slide="prev">
			 <span class="arrow-right"></span>
		  </a>
		  <a class="right carousel-control" href="#slider" data-slide="next">
			<span class="arrow-left"></span>
		  </a>
	</div>
</div>

<script type="text/javascript">
window.onload = function(){
		var $items = $('#slider').find(".item"),
			$left = $('#slider').find(".left"),
			$right = $('#slider').find(".right"),
			begin_src = '<?php echo $data[ count($data) -1 ]['path']; ?>',
			end_src = '<?php echo $data[1]['path']; ?>';

			$left.css({
				background :"url(" + begin_src + ") right"
			});
			$right.css({
				background:"url(" + end_src + ") left"
			});
		$('#slider').on('slide.bs.carousel', function ( e ){
			var target = e.relatedTarget,
				pre = target.previousElementSibling ? target.previousElementSibling : $items[2],
				next = target.nextElementSibling ? target.nextElementSibling : $items[0];
			
			var p_img_src = pre.getElementsByTagName("IMG")[0].src;  
			var n_img_src = next.getElementsByTagName("IMG")[0].src;
			$left.css({
				background:"url("+p_img_src+") right"
			});
			$right.css({
				background:"url("+n_img_src+") left"
			});
		});

};

</script>