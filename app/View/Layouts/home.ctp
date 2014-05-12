<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html xmlns:wb="http://open.weibo.com/wb">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $description ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta property="wb:webmaster" content="9d6e27bfe5b6519e" />
	<?php
		echo $this->Html->css('bootstrap');
   		echo $this->Html->css('bootstrap-theme');
   		echo $this->Html->css('commom');
      	echo $this->Html->script(array('lib/jquery.min'));
      	echo $this->Html->script('vivi.min');
   		echo $this->Html->script('bootstrap.min');
   		echo $this->Html->css('home');
		echo $this->fetch('meta');
		echo $this->fetch('css');
	?>

	
</head>
<body>
	<div class='h-w-main h-head'>
    <a href='<?php echo $this->Html->url(array(
                  "controller" => "home",
                  "action" =>"index"
                   )) ?>'>
	   <h1 class='c-logo text-hide'>iivi</h1>
    </a>
  </div>
	<?php 

	echo $this->element("home/nav");
	echo $this->fetch('content'); 
	echo $this->element("home/bottom_nav");
	echo $this->element("home/footer");
	echo $this->fetch('script');
	?>
	<div id='about_cover' class = 'cover' style='display:none'>
		<a href='<?php echo $this->Html->url(array(
                  "controller" => "home",
                  "action" =>"about"
                   )) ?>'>
          <img src="<?php echo $about_cover['Slider']['path'];?>" title='<?php echo $about_cover['Slider']['alternate'];?>' alter='<?php echo $about_cover['Slider']['alternate'];?>' id='index_1' class='img-responsive' style = 'margin:0px auto;' >
		</a>
	</div>
	<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
	<div id='share' class='h-share' style='display:none;'>
		<ul class='share-list bdsharebuttonbox'>
			<li><a href="#" style='display:inline-block;float:none;height:18px;vertical-align: top;' class="bds_tsina" data-cmd="tsina"></a><span class = 'share-label' >Weibo</span></li>
			<li><a href="#" style='display:inline-block;float:none;height:18px;vertical-align: top;' class="bds_renren" data-cmd="renren"></a><span class = 'share-label' >Renren</span> </li>
			<li><a href="#" style='display:inline-block;float:none;height:18px;vertical-align: top;' class="bds_qzone" data-cmd="qzone"></a><span class = 'share-label' >Qzone</span> </li>
			<li><a href="#" style='display:inline-block;float:none;height:18px;vertical-align: top;' class="bds_fbook" data-cmd="fbook"></a><span class = 'share-label' >Facebook</span> </li>
			<li><a href="#" style='display:inline-block;float:none;height:18px;vertical-align: top;' class="bds_twi" data-cmd="twi"></a><span class = 'share-label' >Twitter</span> </li>
		</ul>
	</div>
	<script type="text/javascript" src = 'js/share.js'></script>
</body>
</html>
