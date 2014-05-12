<div class='h-w-main' style='margin:120px auto;'>
	<table class='h-contact-table'>
		<tbody>
			<tr>
				<td>如果您有什么意见或建议，请邮件我们</td>
				<td>
					<form action='<?php echo $this->Html->url(array(
				            "controller" => "home",
				            "action" =>"sendMessage"
				             )); ?>'  method='post' >
					<ul class='form-list' >
						<li><input type='text' class="form-control" name='user' required placeHolder='name' ></li>
						<li><input type='text'  class="form-control" name='email' required placeHolder='email'></li>
						<li><textarea name='message' required  class="form-control" rows='8' cols='40'></textarea></li>
						<li><input required  type='text' class='form-control' style='display:inline-block;width:150px;' name='capt'>
							<img id='capt' style='cursor:pointer;height:34px;' src="<?php echo $this->Html->url(array(
				            "controller" => "home",
				            "action" =>"capt"
				             )); ?>">  </li>
						<li><input type='submit'  class="btn btn-form" value='CONTACT' ></li>
					</ul>
					</form>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<script type="text/javascript">

	document.getElementById("capt").onclick = function(){
		this.src =  '<?php echo $this->Html->url(array(
				            "controller" => "home",
				            "action" =>"capt"
				             )); ?>?sid=' + Math.random();
	};
</script>