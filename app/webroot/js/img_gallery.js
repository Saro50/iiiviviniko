/**
 *  需要全局对象 data 
 *   data = <?php echo json_encode($data); ?>; 当前所有产品对象
 *
 *  局部对象 item_info_tpl 需要有一个模版
 */
$(document).ready(function(){

    var loading_img = new Image();
        loading_img.src = 'css/kendo/Silver/loading-image.gif';
    var load_container = document.createElement("DIV");
        load_container.className = "c-w-loading";
        load_container.appendChild(loading_img);

    var agent = VI.Util.getAgent();
    var item_info_tpl = $("#item_info_tpl").html();
    var isIE = false;
    if(agent.name === "MSIE" && parseInt( agent.version , 10) < 9 ){
      isIE = true;
    }
      

      var win = new VI.widgets.window();
      
      
      VI.addEvent("click","show_detail",function(e){
        var img = new Image();
        var id = this.getAttribute("data-id")+""; 
        var that = this;
        var d = {};
           
        $.each(data,function(){
          if(this.id === id){
            d = this;
            return false;
          }
        });
        if(!d.p_description){
          d.p_description = " ";
        }
        var des = VI.Util.templateParser(item_info_tpl ,d ,function( content ){
          var title = $("#sub_title")[0] ? $("#sub_title").html() : that.getAttribute("data-title");
          return  content.replace( /#Belong#/g , title );
        });
        img.src = this.getAttribute("data-path") + "?" +  Math.random() ;//prevent IE from not load img
        img.setAttribute("data-action","close");
        img.width =720 ;
        // var win_h = window.innerHeight || document.documentElement.offsetHeight,
        //     win_w = window.innerWidth || document.documentElement.offsetWidth;
        if(isIE){
          img.style.cssText = "width:720px;height:auto;";
        }else{
          img.className = 'img-responsive'; 
        }
        win.getSimpleContent(des,load_container );
        img.onload = function(){
            win.getSimpleContent(des,img);
            win.position();
        };

      if(window.innerWidth < 770){
        return;
      }
        win.show();
        win.position();
      });

    VI.addEvent("click","description",function(){
        var info  = "<div class='info-block'  >" + s_data.s_description + "</div>";
        var d = {
          p_series : s_data.s_title ,
          Belong : "INSPIRATION" 
        };
        var des = VI.Util.templateParser(item_info_tpl ,d ,function( content ){
          console.log(content);
          content = content.replace(/#p_description#/,"");
          content = content.replace(/#p_description#/,'iiiviviniko 时装' +  s_data.s_title);
          content = content.replace(/data-pic ='http%3A%2F%2Fwww.iiiviviniko.com%2Ftest%2F#p_thumb#'/,"");
          return  content;
        }); 
         win.getSimpleContent(des,info);
         win.show();
    });
      window.onresize = function(){
        win.position( (document.body.offsetWidth - win.el.offsetWidth)/2 , (window.outerHeight - win.el.offsetHeight)/2 );
      };

    });