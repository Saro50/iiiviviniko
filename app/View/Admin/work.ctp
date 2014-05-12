<?php
	$this->start("css");
	echo $this->Html->css('commom');
	echo $this->Html->css('home');
	$this->end();
?>
	<div  class="h-w-main" style='margin:1em auto;'><span class='k-icon k-i-note'></span> 
			<span class='a-tips'>将鼠标移至手势变为文字选择状，点击可以修改关于我们的具体内容,需要插入图片，要先在首页上传类型为Resource的图片，然后可以在插入图片中看到，将图片拖拽到想要的位置即可.修改完毕后，点击<span>保存修改</span>，完成编辑</span></div>

	<div id="example" contentEditable class="h-w-main">
		<?php
			echo $content;
		?>
	</div>
<script type="text/template" id='default_tpl'>
<section class="text-section text-width"><h2 class="h-center">WORKING AT III VIVINIKO</h2>
<p>III VIVINIKO 崇尚多元化文化，每个加入III VIVINIKO的人都有独立的生活方式，有所坚持，相信梦想。
			我们追求美的事物，并希望通过实用性的表达来改善人们的自我感受和生活质量。
			我们认为好的影响并不是彻底推翻，而是愈加得体和自然，正如我们的Slogan:简单的新鲜感。简单的新鲜感觉123123123</p>
<p><strong>如果你想加入我们，请将简历发送到:HR@IIIVIVINIKO.COM</strong>
		</p>
</section><div style="margin-top:60px;margin-bottom:120px;"><ul class="h-l-gallery clearfix" style="min-height:240px;">
<li><a><img data-action="show_detail" data-id="" data-path="img/e1.jpg" src="img/e1.jpg" /></a>
			 </li>
<li><a><img data-action="show_detail" data-id="" data-path="img/e2.jpg" src="img/e2.jpg" /></a>
			 </li>
<li><a><img data-action="show_detail" data-id="" data-path="img/e3.jpg" src="img/e3.jpg" /></a>
			 </li>
<li><a><img data-action="show_detail" data-id="" data-path="img/e4.jpg" src="img/e4.jpg" /></a>
			 </li>
</ul>
</div>
</script>
  
<div id='window' style='display:none;'></div>
<script type="text/template" id='imgTpl'>
	<img src='../#path#'  style='padding:10px;' >
</script>
<script type="text/javascript">
   $(document).ready(function() {
   	    var $window = $("#window").kendoWindow({
                            title: "插入图片",
                            width:400,
                            actions: [
                                "Pin",
                                "Minimize",
                                "Maximize",
                                "Close"
                            ]
                        }).data("kendoWindow");


   	     VI.addEvent("click","insertImage",function(){
   	     	$.ajax({
   	     		url : "<?php echo $this->Html->url(array(
								            'controller' => 'admin',
								            'action' => 'read'
								            )); ?>?" + queryStr(),
				dataType : "json",
				success : function(res){
					var imgs = res.data;
					var c_str = "";
					for(var i = 0 , l = imgs.length; i < l ; ++i ){

					c_str += VI.Util.templateParser($("#imgTpl").html() , imgs[i]);

					}
					$window.content(c_str);
					$window.center();
					$window.open();
				},
				error : function(){

				}				            
   	     	});
   	     });
   	function queryStr(){
   		var params = {
   			take:10,
			skip:0,
			page:1,
			pageSize:10,
			tmp:Math.random(),
			model:"Slider",
			conditions:"s_type",
			s_type :"Resource" 
			},query = "";

			for(var p in params){
				query += p + "=" + params[p] + "&"; 
			}
			return query;

   	}
                  var $kEditor =  $("#example").kendoEditor({
                        tools: [
                        "formatting","bold", "italic","underline", "strikethrough",
                        "fontName", "fontSize", "foreColor", "backColor", "createLink", "unlink", "insertImage",
                        "justifyLeft", "justifyCenter", "justifyRight", "justifyFull","viewHtml" ,
                         {
			                    name: "custom",
			                    tooltip: "Save your changes",
			                    template: "<button class='k-button' data-action='save' >保存修改</button>"
			                }, {
			                    name: "custom2",
			                    tooltip: "reset to default",
			                    template: "<button class='k-button' data-action='reset' >重置</button>"
			                }, {
			                    name: "custom3",
			                    tooltip: "insertImage",
			                    template: "<button class='k-button' data-action='insertImage' >插入Resource的图片</button>"
			                }
                        ]
                    }).data("kendoEditor");

                  var blocker = false;

                  VI.addEvent("click","save",function(){
                  	if(!blocker){
                  		blocker = true;
	                  	$.ajax({
	                  		url : "<?php 
	                  			echo $this->Html->url(array(
								            "controller" => "admin",
								            "action" => 'updateWork'
								             )); 
	                  			?>",
	                  		dataType : "json",
	                  		type:"post",
	                  		data : {
	                  			id : 2 ,
	                  			content :  $kEditor.value()
	                  		},
	                  		success : function(){
	                  			blocker = false;
	                  			alert("保存成功！");
	                  		},
	                  		error : function(){
	                  			blocker = false;
	                  			alert("保存失败！请联系开发人员！");
	                  			console.log("error");
	                  		}
	                  	});
                 	 }else{
                 	 	alert("正在处理，请稍后保存");
                 	 }
                  });


             VI.addEvent("click","reset",function(){
                  	if(confirm("确定重置你的修改吗？之前所有编辑都会被撤销为默认模版")){
                  		$kEditor.value($("#default_tpl").html());

                  	}
                  });


                });

</script>