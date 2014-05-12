<div class='h-w-main' id='g_list'>



<?php 
		foreach ($data as $value):

?>
<section class='h-center h-ex-section'>
<?php
			foreach ($value as $k => $v ):
				if($k == "Exhibition"):
?>
		<h2 class='h-bottom-title2'><?php echo $v['e_title']; $title = $v['e_title']; ?></h2>
<?php 
	if($v['e_vedio_link']):
?>

	<div style='height:400px;width:800px;margin:10px auto;background:#393939;'>
<embed src="<?php echo $v['e_vedio_link']; ?>" quality="high" width="800" height="400" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>
	</div>
<?php 
	endif;
	echo $v['e_description'];
?>

<?php 
	endif;
	if($k == "Gallery" && count($v)!= 0 ):
?>
	<div>
	<ul class='h-l-gallery clearfix' id='g_list'>
<?php foreach ($v as $i => $j): ?>
<li >
<img class='lazy_img'  src='img/lazy.gif'>
<a >
<img data-action='show_detail' data-title='<?php echo $title; ?>' data-id='<?php echo $j['id'] ?>' data-path = '<?php echo $j['path']; ?>' data-lazy='<?php echo $j['thumb']; ?>' data-sort ='<?php echo $j['sort'] ?>'  >
</a></li>
	  
<?php endforeach; ?>
		</ul>
		</div>
<?php endif;
	 endforeach; ?>
		
	</section>
<?php endforeach; ?>

</div>
<script type="text/template" id='item_info_tpl'>  
<h5 class='h-l-title'>III VIVINIKO</h5>
<p>#Belong#</p>
<p>#description#</p>
<div class='share-block'><a href='#' data-action='share' data-pic ='www.iiiviviniko.com/#thumb#'  data-data='#Belong# #description#' class='h-link share'>Share</a></div>
</script>
<script type="text/javascript">
	var data = <?php echo json_encode($gallery); ?>;
</script>

<?php echo $this->Html->script('img_gallery'); ?>