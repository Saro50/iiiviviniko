<!doctype html>
<html lang="cn">

	<head>
		<meta charset="utf-8">

		<title>reveal.js - The HTML Presentation Framework</title>

		<meta name="description" content="A framework for easily creating beautiful presentations using HTML">
		<meta name="author" content="Wn">

		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<?php 
			echo $this->Html->css('reveal.min');
	   		echo $this->Html->css('theme/serif.css');
		?>

		<!-- If the query includes 'print-pdf', use the PDF print sheet -->
		<script>
			document.write( '<link rel="stylesheet" href="css/print/' + ( window.location.search.match( /print-pdf/gi ) ? 'pdf' : 'paper' ) + '.css" type="text/css" media="print">' );
		</script>

		<!--[if lt IE 9]>
		<script src="lib/js/html5shiv.js"></script>
		<![endif]-->
	</head>
<style type="text/css">
 .head{
  background-color: #000;
  padding: 15px;
  position: relative;
 }
.head nav{
  position: absolute;
  display: block;
  left: 80px;
  top:80px;
 }
 #mainTitle{
  color: #fff;
  font-family: Impact, Charcoal, sans-serif;
 }
 nav a {
 	  border-radius: 5px;
	  vertical-align: text-top;
	  display: inline-block;
	  background-color: #333;
	  text-decoration: none;
	  color: #333;
	  padding: 5px;
      transition-duration:0.3s;
      transition-timing-function:ease-in-out;
      transition-property:padding , background-color;

      -webkit-transition-duration:0.3s;
      -webkit-transition-timing-function:ease-in-out;
      -webkit-transition-property:padding , background-color;

      -ms-transition-duration:0.3s;
      -ms-transition-timing-function:ease-in-out;
      -ms-transition-property:padding , background-color;
      
      -moz-transition-duration:0.3s;
      -moz-transition-timing-function:ease-in-out;
      -moz-transition-property:padding , background-color;
  }
  	nav a.active,
   nav a:hover{
      color: #fff;
      background-color: #fff;
    }

  .animation{
      transition-duration:0.5s;
      transition-timing-function:ease-in-out;
      transition-property:background-color;

      -webkit-transition-duration:2s;
      -webkit-transition-timing-function:ease-in-out;
      -webkit-transition-property:background-color,transform;

      -ms-transition-duration:2s;
      -ms-transition-timing-function:ease-in-out;
      -ms-transition-property:background-color,transform;
      
      -moz-transition-duration:2s;
      -moz-transition-timing-function:ease-in-out;
      -moz-transition-property:background-color,rotate,transform;

    }

</style>
	<body>
    <div class='head'>
      <h1 id='mainTitle'>iiiviviniko</h1>
       <nav id='nav_wrapper'>
	       <a class='active' href='#/s1'></a>
	       <a href='#/s2'></a>
	       <a href='#/s3'></a>
      </nav>
    </div>
    
		<div class="reveal">

			<!-- Any section element inside of this container is displayed as a slide -->
			<div class="slides">
				<section id='s1'>
					<h1>iiiviviniko</h1>
					<h3>简单的新鲜感</h3>
					<p><img src="src/1.jpg">
						<small>Created by <a href="http://hakim.se">时尚的错觉</a> / <a href="#">@hakimel</a></small>
					</p>
				</section>

				<section  id='s2' data-transition="linear" data-background="#4d7e65" data-background-transition="slide">
					<h2>简介</h2>
					<p><img src="src/2.jpg">
						创立于2006年，始终以"简单的新鲜感"作为品牌设计理念。主张用最极简的手法，表现对新鲜感的理解。通过对"色彩、素材、体积"这三者关系的重新认识和塑造，并且在服装设计中融入对建筑美学的理解，营造具有时代特征的质感街头风格。
					</p>

					<aside class="notes">
						 "简单纯粹、廓形鲜明"，具有显著的北欧时装风格。
					</aside>
				</section>

				<!-- Example of nested vertical slides -->
				<section id='s3'>
					<h2>Vertical Slides</h2>
						<img src="src/3.jpg">
						<p>
							上海市普陀区怒江北路561弄8号
							Add: No. 8, 561 Long, Nujiang Road(N), Putuo, Shanghai
							Tel：6265 3073<a href="#" class="navigate-down">down</a>.
						</p>
						<a href="#" class="image navigate-down">
						</a>
				</section>

			


			</div>

		</div>

		<?php 
	   		echo $this->Html->script('reveal.min.js');
		?>

		<script>
 
			// Full list of configuration options available here:
			// https://github.com/hakimel/reveal.js#configuration
			Reveal.initialize({
				controls: false,
				progress: true,
				// history: true,
				center: true,
				touch: true,
				loop:true,
        top:"-10%",
         minScale: 1,
				 autoSlide: 3000,
				// theme: Reveal.getQueryHash().theme, // available themes are in /css/theme
				transition: Reveal.getQueryHash().transition || 'default', // default/cube/page/concave/zoom/linear/fade/none

				// Optional libraries used to extend on reveal.js
				dependencies: [
					// { src: 'lib/js/classList.js', condition: function() { return !document.body.classList; } },
					// { src: 'plugin/markdown/marked.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
					// { src: 'plugin/markdown/markdown.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
					// { src: 'plugin/highlight/highlight.js', async: true, callback: function() { hljs.initHighlightingOnLoad(); } },
					// { src: 'plugin/zoom-js/zoom.js', async: true, condition: function() { return !!document.body.classList; } }
					// { src: 'plugin/notes/notes.js', async: true, condition: function() { return !!document.body.classList; } },
					// { src: 'plugin/search/search.js', async: true, condition: function() { return !!document.body.classList; } },
					// { src: 'plugin/remotes/remotes.js', async: true, condition: function() { return !!document.body.classList; } }
				]
			});
	var nav = document.getElementById("nav_wrapper");

	Reveal.addEventListener( 'slidechanged', function( event ) {
		var a_els = nav.getElementsByTagName("A"),
			len = a_els.length;

		for(var i = 0; i < len ; ++ i ){
			a_els[i].className = "";
		}
			a_els[event.indexh].className = "active";
    // event.previousSlide, event.currentSlide, event.indexh, event.indexv
		console.dir(arguments);
		console.log(event.indexh);
	} );
		</script>

	</body>
</html>
