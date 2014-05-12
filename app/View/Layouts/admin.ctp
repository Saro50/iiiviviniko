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

$description = __d('cake_dev', 'IIIVIVINIKO.COM:ADMIN');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $description ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php
		echo $this->Html->meta('icon');
   		echo $this->Html->css('kendo/kendo.common.min');
   		echo $this->Html->css('kendo/kendo.silver.min');
   		echo $this->Html->css('admin');
      	echo $this->Html->script('lib/jquery.min');
   		echo $this->Html->script('lib/kendo.web.min');
   		echo $this->Html->script('vivi');
		echo $this->fetch('meta');
		echo $this->fetch('css');
	?>
</head>
<body>
	<?php 
		echo $this->element("admin/menu");
	?>
	<div class='a-w-main'>	
		<?php echo $this->fetch('content'); ?>
	</div>
	<?php
		echo $this->element("admin/footer");
	?>

	<?php

	 echo $this->fetch('script');
	 echo $this->element('sql_dump');
	 ?>

</body>
</html>
