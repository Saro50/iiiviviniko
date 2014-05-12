   VI._.addEvent( window , "load" , function(){

/**
 * [_bd_share_config description]
 * @type {Object}
 * @Comes from
 * http://share.baidu.com/code/advance#config-common
 */
window._bd_share_config = {
  "common":{
    "bdSnsKey":{},
    "bdText":"",
    "bdMini":"2",
    "bdPic":"",
    "bdStyle":"0",
    "bdSize":"16",
    "onBeforeClick" : function(cmd ,config){
      config.bdText = s_text;
      config.bdPic = s_pic;
      return config
    }
  },
  "share":{
    "bdSize" : 16
  }
  // ,
  // "selectShare":{
  //   "bdContainerClass":null,"bdSelectMiniList":["tsina","renren","qzone","fbook","twi"]
  // }
};
  with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
    
    /**
     * share link
     * http://service.weibo.com/share/share.php
     * source:
     * appkey:992505512
     * pic:
     * ralateUid:1864558851
     *
     */
    var f,t,
        c = $("#share")[0], 
        flag = false ,
        s_text = "",
        s_pic = "",
        f_state = "";
        c.setAttribute('data-action' , "share_out");

        var wb = $("#wbBtn")[0];
        c.style.cssText = "display:none;position:absolute;padding:15px;";
        VI.addEvent("mousemove" , "share" , function(e){
            var data = this.getAttribute("data-data"),
                arg = ["url","title","ralateUid=1864558851","pic"];//"appkey=992505512",
                s_text = data ;
                if(flag){
                  flag = false;
                }else{
                  f&&(f.style.position = f_state);
                  flag = false;
                }
                f = this.parentNode;
                if(data){
                  c.style.display = "block";
                  f.appendChild(c);
                  f.style.zIndex = '2';
                  f.style.position = "relative";
                  c.style.left = this.offsetLeft + 'px';
                  c.style.top = this.offsetTop - 25 + 'px';
                  var pic = this.getAttribute('data-pic');
                  if(pic){
                    s_pic = pic ;
                    
                    arg[4] = "pic=" + pic;
                  }else{
                    s_pic = "";

                    arg.pop();
                  }
                  arg[0] ="url=" + encodeURIComponent(window.location.href);
                  arg[1] = "title=" + this.getAttribute('data-data');
                  // wb.href = "http://service.weibo.com/share/share.php?" + arg.join("&");
                }
        });
         $(c).on("mouseleave" ,  function(e){
            f.style.position = f_state;
            c.style.display = "none";
            f.style.zIndex = '1';
            document.body.appendChild(c);
            flag = true;
        });
  });