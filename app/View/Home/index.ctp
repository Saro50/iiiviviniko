<?php
  $this->start("css");
  echo $this->Html->css('home');
  $this->end();
  $this->start("meta");
?>

  <meta name="description" content="some description">
  <meta name="author" content="iiiviviniko">
  <meta name="keywords" content="时装,设计,fashion,名牌">
  <meta name="robots" content="index,follow">
  <meta name="application-name" content="iiiviviniko.com">
<?php
  $this->end();
?>

                <div class='h-sub-nav' id='sub_nav'  >
                  <?php 
                    foreach( $sub_menu as $key => $val ):
                  ?>
                <div class='sub-title'>
                  <a class='h-link <?php 
                    if(isset($cur_id)){
                      echo $cur_id==$val["id"]?"active":"";   
                    }
                  ?>' href = '<?php echo $this->Html->url(array(
                              "controller" => "home",
                              "action" => "Collection"
                               )) ?>?r=<?php echo $val["id"]; ?>'><?php echo $val["s_title"]; ?></a>
                  </div>
                  <?php 
                    endforeach;
                  ?>
                </div>


<div class='h-w-main clearfix'>
  <div class='h-w-sub'>
      <h2 id='sub_title'><?php echo $series["s_title"]; ?></h2>

      <ul id='sub_list'>
      <?php
        $sub = explode(",",$series["s_sub"]);
        foreach ($sub as $value): 
      ?>
        <li ><a class='h-link' data-data = '<?php  echo $value; ?>' data-id='<?php echo $series["id"]; ?>' data-action='category' href='#<?php echo $value; ?>'><?php echo $value; ?></a></li>
      <?php 
        endforeach;
      ?>
      <li><a class='h-link' data-data = '1' data-id='<?php echo $series["id"]; ?>' data-action='description' href='#'>INSPIRATION</a></li>
      </ul>
  </div>
  <div style='position:relative;'>
  <ul class='h-l-gallery clearfix' id='g_list'>
    <?php
      foreach ($data as $key => $value):
    ?>
    <li >
        <img class='lazy_img'  src='img/lazy.gif'>
        <a >
          <img style='display:none;' data-action='show_detail' data-id='<?php echo $value['id']; ?>' data-path = '<?php echo $value['p_path']; ?>'
         src='img/lazy.gif' data-lazy='<?php echo $value['p_thumb']; ?>' ></a>
    </li>
    <?php
      endforeach;
    ?>

  </ul>
  <div class='h-g-loading img-responsive' id='loader' style='display:none;'></div>
  </div>
</div>

<script type="text/template" id='item_info_tpl'>  
<h5 class='h-l-title'>III VIVINIKO</h5>
<p>#Belong#</p>
<small>#p_series#</small>
<p>#p_description#</p>
<div class='share-block'><a href='#' data-action='share' data-pic ='www.iiiviviniko.com/#p_thumb#'  data-data='#Belong# #p_series# #p_description#' class='h-link share'>Share</a></div>
</script>
<script type="text/javascript">

var s_data = <?php echo json_encode($series); ?>,
    data = <?php echo json_encode($data); ?>;

  var blocker = false,
      $sub_list = $("#sub_list");
      VI.addEvent("click","category",function(){
        $sub_list.find("A").each(function(){
          this.className = "h-link";
        });
        var that = this;
       if(!blocker){
          blocker = true;

          $.ajax({
            url:"<?php echo $this->Html->url(array(
                  "controller" => "home",
                  "action" => "gets"
                   )); ?>",
            type:"get",
            dataType:"json",
            data:{
              t : this.getAttribute("data-data"),
              i : this.getAttribute("data-id")
            },
            beforeSend : function(){
              $("#loader").show();
            },
            success : function( response , status , xhr ){
              $("#loader").hide();
              blocker = false;
              that.className = "h-link active";
              var content = "";
              var g_list = $("#g_list")[0];
                  g_list.innerHTML = "";
                  data = response;
              $.each(response , function( num , item ){
                  var li  = document.createElement("LI"),
                      a = document.createElement("A");
                      a.innerHTML = "<img src='img/lazy.gif' height='240' width='360' >";
                      li.appendChild(a);
                      g_list.appendChild(li);
                  var img = new Image();
                     img.src = item.p_thumb + "?" + Math.random(); //prevent IE from not load img
                     img.className = 'img-responsive';
                     img.setAttribute('data-action' , "show_detail" );
                     img.setAttribute("data-path" , item.p_path );
                     img.setAttribute("data-id",item.id);
                     img.onload = function(){
                        a.innerHTML = "";
                        a.appendChild(img);
                     };

              });
              g_list.style.height = "";

            },
            error : function(){
              blocker = false;
            }
          });
        }
      });
</script>
<?php 
  echo $this->Html->script('img_gallery');
?>
