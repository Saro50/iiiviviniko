<?php 
	$this->start("script");
	echo $this->Html->script('md5');
	$this->end();

?>
<style type="text/css">
.login-section{
	padding: 1em;
	background-color: #fff;
	border-radius: 5px;
	border:2px solid #d7d7d7;
	width: 300px;
	margin: 200px auto;
	position: relative;
}

.login-section div{
	margin: 10px 0px;
}
.login-section label{
	width: 60px;
	text-align: right;
	display: inline-block;
	vertical-align: middle;
}


.a-text-box{
  vertical-align: middle;
  padding: 5px;
  font-size: 14px;
  border-radius: 5px;
  box-shadow: 1px 1px 2px #ccc;
  border: 1px solid #d7d7d7;
}
.a-logon-btn{
  vertical-align: middle;
  padding: 10px;
  font-size: 14px;
}
</style>
<form method='post' action='login' class='login-section' id='login_form'>
		<div >
		<label>Name : </label> <input class='a-text-box' type='text' name='name' >
		</div>
		<div>
		<label>password : </label> <input class='a-text-box' id='pwd' type='password' name = 'password'>
		</div>
		<div style='padding-left:60px;'>
		<input class='a-text-box' style='width:2em;' name ='ct_captcha'> <img id='capt' style='cursor:pointer;vertical-align: middle;' src="capt" height='40px;'>
		</div>
		<div  style='padding-left:60px;'>
			<input class='k-button' type='submit' >
		</div>
<?php
	echo $this->Session->flash();
?>
</form>
<script type="text/javascript">
	document.getElementById("capt").onclick = function(){
		this.src =  'capt?sid=' + Math.random();
	};
	var l_form  = document.getElementById("login_form")
	l_form.onsubmit = function(){
		var pwd = document.getElementById("pwd");
			if(pwd.value === "" || l_form[0].value === "" || l_form[2].value === ""){
				alert("请填写完整信息！");
				return false;
			}else{

			pwd.value = MD5.hex_md5(pwd.value);
			}
			return true;
	};
</script>
