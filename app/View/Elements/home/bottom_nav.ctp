
<nav class='h-footer-nav'>
<div class='h-w-main'>
	 <?php
	       foreach($bottom_menu as $key=>$value):
           if( is_array($value) ):
            ?>
          <div class='follow'>
            <div class='f-wrap'>
                <?php echo $key; ?>
                 <div class='follow-panel'>
                  <a href="http://weibo.com/iiiviviniko"  target="_blank" title = '新浪微博' >
                    <span class='share-icon sina'></span>
                  </a>

                  <a style = 'cursor:pointer;' title = '微信扫一扫 ' >
                    <span class='share-icon weixin'  data-action='dimensional' ></span>
                  </a>  
            
                  <a href="http://instagram.com/iiiviviniko"  target="_blank" title = 'INSTAGRAM ' >
                    <span class='share-icon instagram'></span>
                  </a>
                 </div>

                 <div id='code_panel' class='code-panel' data-action = 'hide_dimensional'>
                  <img src="img/code.gif" width='64px' height='64px' >
                  <p>
                  订阅号:IIIVIVINIKO
                  </p>
                 </div>
              </div>
            </div> 
              <?php
              else:
              ?>
              <a class='h-m-title' href='<?php echo $this->Html->url(array(
                  "controller" => "home",
                  "action" => $value
                   )) ?>'><?php echo $key; ?></a>
            <?php
              endif;
              endforeach;
            ?>
            
</div>
</nav>