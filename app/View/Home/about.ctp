
<div class='h-w-main' style='margin:120px auto;'>
	<?php
		echo $content;
	?>
</div>
<script type="text/javascript">
	(function(){
		var $pages = $(".a-page"),
			arrow = $("#pages_container").find("a");
			current = $pages[0];
		VI.addEvent( "click" , "next" , function(){
			if( $(current).next("DIV").length !== 0 ){
				$(current).removeClass("a-active");
				current = $(current).next("DIV")[0];
				$(current).addClass("a-active");	
				$(arrow[0]).show();
				$(arrow[1]).show();
				if(current === $pages[$pages.length - 1]){
					$(arrow[1]).hide();
				}
			}
		});
		VI.addEvent( "click" , "pre" , function(){
			if( $(current).prev("DIV").length !== 0 ){
				$(current).removeClass("a-active");
				current = $(current).prev("DIV")[0];
				$(current).addClass("a-active");	
				$(arrow[0]).show();
				$(arrow[1]).show();

				if(current === $pages[0]){
					$(arrow[0]).hide();
				}
			}
		});

	})();
</script>