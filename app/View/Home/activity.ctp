
<div class='h-w-main clearfix'   id='g_list' >
	<?php 
			$tmp = array();
			foreach ($year as $key => $value){
				$tmp_date = explode(" ", $value[0]['date']);
				// var_dump($tmp_date);
				if( !array_key_exists($tmp_date[0] , $tmp) ){
					$tmp[$tmp_date[0]] = array();
					array_push($tmp[$tmp_date[0]] , $tmp_date[1]);
				}else{
					array_push($tmp[$tmp_date[0]] , $tmp_date[1]);
				}
			
			}

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
<div class='h-banner-container'>
	<div class='h-down-btn'>Select <b class="caret"></b>
	<ul class='s-list-1'>
		<?php foreach ($tmp as $key => $value): ?>
			<li><a href='?y=<?php  echo $key; ?>' class='h-link' ><?php  echo $key; ?></a>
				<ul class='s-list-2' >
					<?php foreach ($value as $k => $v):?>
					<li><a class='h-link' href='?y=<?php  echo $key; ?>&m=<?php echo $v; ?>'><?php echo $v; ?>.</a></li>
					<?php endforeach; ?>
				</ul>

			</li>
		<?php endforeach; ?>
	</ul>
	</div>
</div>	
		<div class='h-d3'><div class='l-section'>
			<?php
				foreach ($d1 as  $val) :
			?>
		    <div class="thumbnail">
		    	<?php if($val['a_path'] != ""): ?>
		    	<img class='lazy_img'  src='img/lazy.gif'>
		        <img  style='display:none;' data-lazy="<?php echo $val['a_path']; ?>" title="<?php echo $val['a_content']; ?>">
		    	<?php endif; ?>
		      <div class="caption">
		       
		       	<p><?php echo $val['a_content']; ?></p>
		       	<?php if($val['a_link'] != ""): ?>
		        <p><span class='glyphicon glyphicon-hand-right'></span> <a href="<?php echo $val['a_link']; ?>"  role="button">detail</a></p>
		        	<?php endif; ?>
		        <div class='date clearfix'>
					<span><?php echo $val['a_modified_date']; ?></span>
					<a href='#' data-action='share' data-pic = 'www.iiiviviniko.com/<?php echo $val['a_path']; ?>'  data-data = '<?php echo $val['a_content']; ?>' class='h-link share'>Share</a>
				</div>
		      </div>
		    </div>
		    <?php
		    	endforeach;
		    ?>
		</div>
	</div>
		<div class='h-d3'><div class='c-section'>
			<?php
				foreach ($d2 as  $val) :
			?>
		    <div class="thumbnail">
		    	<?php if($val['a_path'] != ""): ?>
		    	<img class='lazy_img'  src='img/lazy.gif'>
		      <img  style='display:none;' data-lazy="<?php echo $val['a_path']; ?>" title="<?php echo $val['a_content']; ?>" >
		    	<?php endif; ?>
		      <div class="caption">
		       
		       	<p><?php echo $val['a_content']; ?></p>
		       	<?php if($val['a_link'] != ""): ?>
		        <p><span class='glyphicon glyphicon-hand-right'></span> <a href="<?php echo $val['a_link']; ?>"  role="button">detail</a></p>
		        	<?php endif; ?>
		        <div class='date clearfix'>
					<span><?php echo $val['a_modified_date']; ?></span>
					<a href='#' data-action='share' data-pic = 'www.iiiviviniko.com/<?php echo $val['a_path']; ?>'  data-data = '<?php echo $val['a_content']; ?>'  class='h-link share'>Share</a>
				</div>
		      </div>
		    </div>
		    <?php
		    	endforeach;
		    ?>
		</div></div>
		<div class='h-d3'><div class='r-section'>
		 	<?php
				foreach ($d3 as  $val) :
			?>
		    <div class="thumbnail">
		    	<?php if($val['a_path'] != ""): ?>
		    		<img class='lazy_img'  src='img/lazy.gif'>
		      <img  style='display:none;' data-lazy="<?php echo $val['a_path']; ?>" title="<?php echo $val['a_content']; ?>" >
		    	<?php endif; ?>
		      <div class="caption">
		       
		       	<p><?php echo $val['a_content']; ?></p>
		       	<?php if($val['a_link'] != ""): ?>
		        <p><span class='glyphicon glyphicon-hand-right'></span> <a href="<?php echo $val['a_link']; ?>"  role="button">detail</a></p>
		        	<?php endif; ?>
		        <div class='date clearfix'>
					<span><?php echo $val['a_modified_date']; ?></span>
					<a href='#' data-action='share' data-pic = 'www.iiiviviniko.com/<?php echo $val['a_path']; ?>'  data-data = '<?php echo $val['a_content']; ?>'  class='h-link share'>Share</a>
				</div>
		      </div>
		    </div>
		    <?php
		    	endforeach;
		    ?>
		</div>
	</div>
</div>

