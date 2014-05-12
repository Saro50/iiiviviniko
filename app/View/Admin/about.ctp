<?php
	$this->start("css");
	echo $this->Html->css('commom');
	echo $this->Html->css('home');
	$this->end();
?>
<style type="text/css">
	.h-a-wrapper{
			min-width: 985px;
		}
	.h-a-wrapper .a-page{
		display: block;
	}
	.a-arrow-right{
		display: none;
	}
</style>
	<div  class="h-w-main" style='margin:1em auto;'><span class='k-icon k-i-note'></span> 
		<span class='a-tips'>将鼠标移至手势变为文字选择状，点击可以修改关于我们的具体内容,需要插入图片，要先在首页上传类型为Resource的图片，然后可以在插入图片中看到，将图片拖拽到想要的位置即可.修改完毕后，点击<span>保存修改</span>，完成编辑</span></div>

	<div id="example" contentEditable class="h-w-main">
		<?php
			echo $content;
		?>
	</div>

  
<script type="text/template" id='default_tpl'>
<div class='h-a-wrapper' id='pages_container'>
	<a  class="a-arrow-left"  style='display:none;'>
			<span class='glyphicon glyphicon-chevron-left' data-action='pre'></span>
		</a>
		<a  class="a-arrow-right" >
			<span class='glyphicon glyphicon-chevron-right' data-action='next'></span>
		</a>
	<div class='a-page a-active'>
			<h3>ABOUT III VIVINIKO</h3>
			<p>
			III VIVINIKO 创立于2006年，始终以“ 简单的新鲜感 Minimun+ ”作为品牌设计理念。主张用极简的手法，表现对新鲜感的理解。通过对“色彩、素材、体积”这三者关系的重新认识和塑造，并且在服装设计中融入对建筑美学的理解，从而提供现代职业女性时髦而得体，实用而有艺术感的日常着装。“简单纯粹、廓形鲜明、功能主义”，具有显著的时代特征。
			</p>
			<h4 style='margin-top:60px;'>
				Company information
			</h4>
			<ul> 
				<li>万趣集团 Shanghai Wanqu Industrial Development Co.,Ltd.</li>
				<li>1F, No.8, 561Nong, Nujiang(North)Road, Putuo District, Shanghai 200333</li>
				<li>Tel: 86 21 6265 3073 Fax: 86 21 6265 3066</li>
			</ul>
		</div>
		<div class='a-page text-center'>
			<h2 style='font-size:21px;margin-top:50px;'>宣言</h2>
			<p>
			我想建立一种风格<br>
			一种不矫揉造作  不无病呻吟<br>
			简单而纯粹  舒展而轮廓清晰事实上<br>
			在坚持自己风格的同时<br>
			能够与时俱进的一种街头风格
				<br><br>
			我想建立一个品牌<br>
			一个风格突出而不缺少时代通感<br>
			一个能够和热爱时尚的女性产生共鸣而且触手可得的品牌
			</p>
		</div>
		<div class='a-page a-theme-1'>
			<h3>简单的新鲜感 Minimum+</h3>
			<p style='padding-top: 5px;'>
			所谓“简单的新鲜感 Minimum+”就是赋予了极简主义以现代艺术感和街头文化之后所呈现出来的一种具有时代特征的新鲜感。要理解这三者之间的关系，就必须了解极简主义、现代艺术、街头文化，这三者的基本特征。
			</p>
			<p>
			现代艺术的基本特点：打破艺术家、作品和观众之间的区别。主张艺术干预人类生活，深受现代社会文化影响，又立足批判现实社会对人性的压抑，呈现出自由而辩证的风格。
			</p>
			<p>
			街头文化有很多，几乎在街头任何的艺术都可以成为街头文化。近代的街头文化在20世纪的70年代得到发展，集中在欧美地区，特别是美国的街头时尚，出现了RABRAP（说唱）、摇滚音乐、街舞、滑板等形式，充满时代感和运动感。
			</p>
			<p>
			将三者有机结合，使极简主义不再朴素和一成不变，更增添了一种现代艺术美感和街头文化中的时代感和运动感，最终呈现出一种新鲜感，我们称之为“简单的新鲜感 Minimum+”。
			</p>
		</div>
</div>
</script>
<div id='window' style='display:none;'></div>
<script type="text/template" id='imgTpl'>
	<img src='../#path#'  style='padding:10px;' >
</script>
<script type="text/javascript">
   $(document).ready(function() {
   	     var $window = $("#window").kendoWindow({
   	     	    			width:400,
                            title: "插入图片",
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
								            "action" => 'updateAb'
								             )); 
	                  			?>",
	                  		dataType : "json",
	                  		type:"post",
	                  		data : {
	                  			id : 1 ,
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