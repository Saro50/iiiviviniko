<div class='h-w-main clearfix' style='margin-top:60px;' id='g_list'>
	<?php
	$d1 = array();
	$d2 = array();
	$d3 = array();  
	for($i = 0 , $j = count($data); $i < $j ; $i += 3 ){
		if( isset($data[$i] ) ){
			array_push( $d1 , $data[$i]);
		}else{
			break;
		}
		if( isset($data[$i+1] ) ){

			array_push( $d2 , $data[$i+1]);
		}else{
			break;
		}
		if( isset($data[$i+2] ) ){

			array_push( $d3 , $data[$i+2]);		
		}else{
			break;
		}
	}


	?>


		<div class='h-d3'><div class='l-section'>
			<?php
				foreach ($d1 as  $value) :
			?>
		    <div class="thumbnail">
		    	<?php if($value['path'] != ""): ?>
		    	<img class='lazy_img'  src='img/lazy.gif'>
		      <img   style='display:none;' data-lazy="<?php echo $value['path']; ?>" alt="<?php echo $value['description']; ?>">
		    	<?php endif; ?>
		      <div class="caption">
		   
		        <div class='date clearfix'>
					<span><?php echo $value['description']; ?> <?php echo $value['display_date']; ?></span>
					<a href='#' data-action='share' data-pic = 'www.iiiviviniko.com/<?php echo $value['path']; ?>'  data-data = '<?php echo $value['description']; ?>' class='h-link share'>Share</a>
				</div>
		      </div>
		    </div>
		    <?php
		    	endforeach;
		    ?>
		</div>
	</div>

	<div class='h-d3'><div class='l-section'>
			<?php
				foreach ($d2 as  $value) :
			?>
		    <div class="thumbnail">
		    	<?php if($value['path'] != ""): ?>
		    	<img class='lazy_img'  src='img/lazy.gif'>
		      	<img style='display:none;' data-lazy="<?php echo $value['path']; ?>" alt="<?php echo $value['description']; ?>">
		    	<?php endif; ?>
		      <div class="caption">
		   
		        <div class='date clearfix'>
					<span><?php echo $value['description']; ?> <?php echo $value['display_date']; ?></span>
					<a href='#' data-action='share' data-pic = 'www.iiiviviniko.com/<?php echo $value['path']; ?>'   data-data = '<?php echo $value['description']; ?>' class='h-link share'>Share</a>
				</div>
		      </div>
		    </div>
		    <?php
		    	endforeach;
		    ?>
		</div>
	</div>

	<div class='h-d3'><div class='l-section'>
			<?php
				foreach ($d3 as  $value) :
			?>
		    <div class="thumbnail">
		    	<?php if($value['path'] != ""): ?>
		    	<img class='lazy_img'  src='img/lazy.gif'>
		       <img  style='display:none;' data-lazy="<?php echo $value['path']; ?>" alt="<?php echo $value['description']; ?>">
		    	<?php endif; ?>
		      <div class="caption">
		   
		        <div class='date clearfix'>
					<span><?php echo $value['description']; ?> <?php echo $value['display_date']; ?></span>
					<a href='#' data-action='share' data-pic = 'www.iiiviviniko.com/<?php echo $value['path']; ?>'   data-data = '<?php echo $value['description']; ?>' class='h-link share'>Share</a>
				</div>
		      </div>
		    </div>
		    <?php
		    	endforeach;
		    ?>
		</div>
	</div>
</div>	