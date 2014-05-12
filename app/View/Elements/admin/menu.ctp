<div class='a-head'>
  <div class='a-h-btn' data-action='title_list'>
    <ul >
      <?php
        foreach($menu as $key=>$value):
      ?>
      <li><a href='<?php echo $this->Html->url(array(
            "controller" => "admin",
            "action" => $value
             )); ?>'><?php echo $key; ?></a></li>
      <?php
        endforeach;
      ?>
    </ul>
  </div>
    <h1>Manager System</h1>
    <div class='a-nav-w'>
        <ul>
          <li><a class='nav1' href='<?php echo $this->Html->url(array(
              "controller" => "admin",
              "action" => "index"
               )) ?>'><span>首页</span></a></li>
          <li><a class='nav3' href='<?php echo $this->Html->url(array(
              "controller" => "admin",
              "action" => "user"
               )) ?>'><span>用户</span></a></li>
        </ul>
    </div>
</div>
<?php 
    if(isset($userName)):
?>
<div class='a-login-tip'>
    welcome <strong class='a-word-orange'><?php echo $userName; ?></strong> <span class='a-split'>|</span> <a class='out' href='<?php echo $this->Html->url(array(
            "controller" => "admin",
            "action" => "loginOut"
             )) ?>'>login out</a>
</div>
<?php
 endif;
?>
