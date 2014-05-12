 <nav class="h-nav-bar" >
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class='h-collapse clearfix'>
          <ul class="nav navbar-nav">
           <?php
              foreach($menu as $key=>$value):
              if( is_array($value) ):
            ?>
            <li >
              <a  data-action="showCover" style='cursor:pointer;' ><?php echo $key; ?></a>
            </li>   
              <?php
              else:
              ?>

            <li class='<?php echo $cur_action == $value ? "act" : ""; ?>' >
              <a class='h-m-title' href='<?php echo $this->Html->url(array(
                  "controller" => "home",
                  "action" => $value
                   )) ?>'><?php echo $key; ?></a></li>
            <?php
              endif;
              endforeach;
            ?>
        </ul>
      </div>
  </nav>



