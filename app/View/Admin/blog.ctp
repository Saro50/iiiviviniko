<style type="text/css">
    .k-editor-inline {
        margin: 0;
        padding: 10;
        border-width: 1px;
        box-shadow: none;
        background: none;
    }
    .k-editor-inline.k-state-active {
        border-width: 1px;
        padding: 10;
        background: none;
    }
</style>

<div class='a-wrapper'>
  <h2 class='a-title-1' ><?php echo $data["Subject"]["s_title"]; ?></h2>
    <div class='a-panel'>
          <label>选择模版</label>
          <?php
          /**
           * 循环出模版链接
           */
          
           foreach($total_tpl as $key => $val):
          ?>
        <a href='?s=<?php echo $data["Subject"]["s_id"]; ?>&t=<?php  echo $val; ?>'><?php echo $key; ?></a>
        <?php 
            endforeach;
        ?>
    </div>



    <div id='edtor' contentEditable >
        <?php
           echo  $er = @$this->element($tpl ,array("title"=> $data["Subject"]["s_title"] ) );
           if(!$er){
            echo @$this->element("tpl/b1" ,array("title"=> $data["Subject"]["s_title"] ));
           }
        ?>
    </div>


    <div class='a-w-bottom'>
            <button data-action='submit' class='k-button'>保存</button>
    </div>
  
  
       
</div>
     <script>
            VI.addEvent("click" , "submit" , function(){
                var that = this;
                this.innerHTML = '<span class="k-icon k-i-clock"></span>正在保存..';
                this.removeAttribute("data-action");

                $.ajax({
                    url:"<?php echo $this->Html->url(array(
                                                        "controller" => "admin",
                                                        "action" => "readImg"
                                                         )) ?>",
                    dataType : "json" ,
                    beforeSend : function(){},
                    complete:function(){
                        that.setAttribute("data-action","submit");
                        that.innerHTML = '保存';
                    },
                    data:{
                        t:1,
                        content : ""
                    }
                });
            });

                $(document).ready(function() {
                    var decoding = function(text){
                        return text.replace(/&lt;/g , "<").replace(/&gt;/g,">");
                    };
                    
                $("#edtor").kendoEditor({
                                        imageBrowser: {
                                           messages: {
                                            dropFilesHere: "Drop files here"
                                           },
                                           transport: {
                                                read: "<?php echo $this->Html->url(array(
                                                        "controller" => "admin",
                                                        "action" => "readImg"
                                                         )) ?>",
                                                destroy: {
                                                    url: "/service/ImageBrowser/Destroy",
                                                    type: "POST"
                                                },
                                                create: {
                                                    url: "/service/ImageBrowser/Create",
                                                    type: "POST"
                                                },
                                                thumbnailUrl: "/src/",
                                                uploadUrl: "/service/ImageBrowser/Upload",
                                                imageUrl: "/src/"
                                           }
                                        }
                                    });

           

                    $("#editor").kendoEditor({
                        imageBrowser: {
                           messages: {
                            dropFilesHere: "Drop files here"
                           },
                           transport: {
                                read: "<?php echo $this->Html->url(array(
                                        "controller" => "admin",
                                        "action" => "readImg"
                                         )) ?>",
                                destroy: {
                                    url: "/service/ImageBrowser/Destroy",
                                    type: "POST"
                                },
                                create: {
                                    url: "/service/ImageBrowser/Create",
                                    type: "POST"
                                },
                                thumbnailUrl: "/src/",
                                uploadUrl: "/service/ImageBrowser/Upload",
                                imageUrl: "/src/"
                           }
                        }
                    });
                });
            </script>