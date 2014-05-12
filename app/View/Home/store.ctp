<div class='h-w-main'>
	<div id="slider" class="h-carousel carousel slide" data-ride="carousel" >


	  <!-- Wrapper for slides -->
		    <div class="carousel-inner">
		    	<?php foreach ($sliders as $key => $value): ?>
			    
			    <div class="item <?php  echo $key == 0 ? 'active' : ''; ?>"  >
			       <img src="<?php echo $value['path']; ?>" class='img-responsive' alt="<?php echo $value['alternate']; ?>" title="<?php echo $value['alternate']; ?>" >

			    </div>
			<?php endforeach; ?>
	
		  	</div>

		  <!-- Controls -->
		  <a class="left carousel-control" href="#slider" data-slide="prev">
		  	<span class='arrow-right'></span>
		  </a>
		  <a class="right carousel-control" href="#slider" data-slide="next">
		  	<span class='arrow-left'></span>
		  </a>
	</div>
</div>

<script type="text/javascript">
window.onload = function(){
		var $items = $('#slider').find(".item");
			$left = $('#slider').find(".left"),
			$right = $('#slider').find(".right"),
			begin_src = '<?php echo $sliders[ count($sliders) -1 ]['path']; ?>',
			end_src = '<?php echo $sliders[1]['path']; ?>';

		$left.css({
				background :"url(" + begin_src + ") right"
			});
			$right.css({
				background:"url(" + end_src + ") left"
			});

		$('#slider').on('slide.bs.carousel', function ( e ){
			var target = e.relatedTarget,
				pre = target.previousElementSibling ? target.previousElementSibling : $items[2],
				next = target.nextElementSibling ? target.nextElementSibling : $items[0];
			
			var p_img_src = pre.getElementsByTagName("IMG")[0].src;  
			var n_img_src = next.getElementsByTagName("IMG")[0].src;
			$left.css({
				background:"url("+p_img_src+") right"
			});
			$right.css({
				background:"url("+n_img_src+") left"
			});

		})
};

</script>
<div class='h-w-main clearfix' style='padding:0px 40px;margin-top:60px;'>


		<div class='h-store-l'>
			<h5 class='h-t-sub'>REGION</h5>
		      <ul class='h-list-store' id='region_list'>
		      	<li><a  data-action='region' data-data = "hd"  >华东区</a></li>
		      	<li><a  data-action='region' data-data = "hz"  >华中区</a></li>
		      	<li><a  data-action='region' data-data = "hn"  >华南区</a></li>
		      	<li><a  data-action='region' data-data = "hb"  >华北区</a></li>
		      	<li><a  data-action='region' data-data = "db"  >东北区</a></li>
		      	<li><a  data-action='region' data-data = "xn"  >西南区</a></li>
		      	<li><a  data-action='region' data-data = "xb"  >西北区</a></li>
		      </ul>
		</div>
		<div class='h-store-l'>
			<h5 class='h-t-sub'>CITY</h5>
			    <ul class='h-list-store' id='city_list'>
					<li>CHOOSE REGION</li>
			    </ul>
		</div>
		<div class='h-store-l'>
			<h5 class='h-t-sub'>STORE</h5>
			      <ul class='h-list-store' id='store_list'>
						<li>CHOOSE CITY</li>
			      </ul>
			<h5 class='h-t-sub'>DETAILS</h5>  
			<ul class='h-list-store' id='detail_list'>
				<li>CHOSE STORE</li>
			</ul>
		</div>

		<div class='h-store-detail' id='map_warpper' style='display:none;'  >
		<div id="container" class='h-map-container img-responsive'></div>
		</div>
</div>
<script type="text/javascript"  src="http://api.map.baidu.com/api?v=1.5&ak=A2a30f4ead944586eeae378c8801d794&callback=initialize"></script>

<script type="text/template" id='store_template'>
	 <li><a  data-action='show_detail' data-id = '#id#'>#s_name#</a></li>
</script>

<script type="text/template" id='city_template'>
	 <li><a  data-action='show_store' data-city = '#s_city#'>#s_city#</a></li>
</script>
<script type="text/template" id='detail_tempalte'>
		<li class='detail'>
			#s_address#
			<div>
			#s_description#
			</div>
		</li>

	
</script>
<script type="text/javascript">
// <li class='map'>
// 		[VIEW MAP]
// 	</li>
var mapObj = {};
	mapObj.query = function( address , city ){
			var map = this.map;
				
			this.GEO.getPoint(address , function(point){
				if (point) {    
					map.clearOverlays();
				   map.panTo(point);    
				   var marker = new BMap.Marker(point);
				   map.addOverlay(marker);    
				   marker.setAnimation(BMAP_ANIMATION_BOUNCE);
				 }  	
			},city);
	};
function initialize(){
	var map = new BMap.Map("container");          // 创建地图实例  
	var myGEO = new BMap.Geocoder(); 
	
		myGEO.getPoint("上海百联中环购物广场", function(point){    

		 if (point) {    
		   map.centerAndZoom(point, 18);    

		 }    
		});  

	mapObj.GEO = myGEO;
	mapObj.map = map;

}



$(document).ready(function(){
	var $r_list = $("#region_list"),
		$s_list = $("#store_list"),
		$c_list = $("#city_list"),
		$d_list = $('#detail_list'),
		blocker = false,
		s_tpl = $("#store_template").html(),
		c_tpl = $("#city_template").html(),
		d_tpl = $("#detail_tempalte").html(),
		data = <?php echo json_encode($data); ?>;


	VI.addEvent("click","region",function(){
		var region = this.getAttribute("data-data"),
			that = this;
		if(!blocker){
			blocker = true;
		
			$r_list.find("a").each(function(){
				this.className = "";
			});

			$.ajax({
				url:'<?php echo $this->Html->url(array(
	            "controller" => "home",
	            "action" => "getCity"
	             )); ?>',
				dataType:"json",
				data : {
					r:region
				},
				beforeSend : function(){
					$c_list.html("<li><span class='glyphicon glyphicon-time'></span> Loading..</li>");
				},
				success : function(res){
					data = res;
					if( res.length === 0 ){
						$c_list.html("<li>暂无数据</li>");
					}else{
						$c_list.html(VI.Util.templateParser(c_tpl , res)) ;

					}
					that.className = "active";
					blocker = false;
				},
				error : function(res){
					console.dir(res);
					blocker = false;
				}
			});
		}
	});

	VI.addEvent("click" , "show_store", 	function(){
		var city = this.getAttribute("data-city"),
			that = this;
		if(!blocker){
			blocker = true;
		
			$c_list.find("a").each(function(){
				this.className = "";
			});

			$.ajax({
				url:'<?php echo $this->Html->url(array(
	            "controller" => "home",
	            "action" => "getStore"
	             )); ?>',
				dataType:"json",
				data : {
					c:city
				},
				beforeSend : function(){
					$s_list.html("<li><span class='glyphicon glyphicon-time'></span> Loading..</li>");
				},
				success : function(res){
					data = res;
					if( res.length === 0 ){
						$s_list.html("<li>暂无数据</li>");
					}else{
						$s_list.html(VI.Util.templateParser(s_tpl , res)) ;

					}
					that.className = "active";
					blocker = false;
				},
				error : function(res){
					console.dir(res);
				}
			});
		}
	});


	VI.addEvent("click","show_detail",function(){
			$s_list.find("a").each(function(){
				this.className = "";
			});
			var id = this.getAttribute("data-id")  + "";
			$.each(data , function(){
				if(this.id === id ){
					$d_list.html(VI.Util.templateParser(d_tpl , this)) ;
					mapObj.query(this.s_address,this.s_city);
					return false;	
				}
				
			});
			this.className = "active";
			$("#map_warpper").show();
	});



});
</script>