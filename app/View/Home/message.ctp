<script type="text/javascript">
alert("<?php echo $message['mes']; ?>");
window.location.href = '<?php 
		if($message['stauts'] == 0 ){
			echo $this->Html->url(array(
				            "controller" => "home",
				            "action" =>"index"
				             ));
		}else{
			echo $this->Html->url(array(
	            "controller" => "home",
	            "action" =>"Contacts"
	             ));
		}
				               ?>'; 
</script>