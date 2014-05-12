<?php 
	$this->start("script");
	echo $this->Html->script('md5');
	$this->end();

?>

<div class='a-wrapper'>

  <h2 class='a-title-1'>用户中心</h2>
  	<?php 
  	foreach($u_data as $key => $val ):
  	?>
  <div class='a-section'>
 	<ul>
    <li>用户: <?php  echo $val["User"]["u_name"]; ?></li>
    <li>创建时间: <?php echo $val["User"]["u_create_date"]; ?> </li>
    <li><button class='k-button' data-action='show' data-id = '<?php  echo $val["User"]["id"]; ?>' data-name = '<?php  echo $val["User"]["u_name"]; ?>'>修改密码</button></li>
 	</ul>
  </div>
  	<?php
  		endforeach;
  	?>
          <div id="window" style='display:none;'>
               <ul class='form-ul'>
                <li><label>用户名:</label> <input type='text' readOnly='true' style='border-color:#d7d7d7;background:#ccc;' id='name_field' class='k-textbox' ></li>
                <li><label>原密码:</label> <input type = 'password' id ='order_pwd' class='k-textbox' ></li>
                <li><label>新密码:</label> <input type = 'password' id='new_pwd' class='k-textbox'> </li>
                <li><input type = 'button' data-action='update' class='k-button' value='确认'> </li>
               </ul>
            </div>

</div> 
<script type="text/javascript">
	window.onload = function(){
    var id = 0,
        name = "";
     var $window = $("#window").kendoWindow({
                            title: "修改账户",
                            actions: [
                                "Pin",
                                "Minimize",
                                "Maximize",
                                "Close"
                            ]
                        }).data("kendoWindow");

          VI.addEvent("click","show",function(){
            id = this.getAttribute("data-id");
            name = this.getAttribute("data-name");
            $("#name_field").val(name);
            $window.center();
            $window.open();
          });
          var block = false;

          VI.addEvent("click","update",function(){
              if(!block){
                block = true; 
                $("#name_field").val(name);
                $.ajax({
                  url:"<?php 
                          echo $this->Html->url(array(
                            "controller" => "admin",
                            "action" => 'updateUser'
                             )); 
                          ?>",
                  type:"post",
                  dataType :"json",
                  data : {
                    id : id,
                    name : $("#name_field").val(),
                    new_pwd : MD5.hex_md5($("#new_pwd").val()),
                    older_pwd : MD5.hex_md5($("#order_pwd").val())
                  },
                  success : function(res){
                    console.dir(res);
                    if(res.status == "0"){
                        alert(res.message);
                    }else{
                      alert(res.message);
                      $window.close();
                    }
                    block = false;
                  },
                  error : function(arg){
                     block = false;
                    console.dir(arg);
                  }
                });
              }
          });

	};


</script>