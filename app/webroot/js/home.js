$(document).ready(function(){
  VI.addEvent("click","showCover",function(){
    $('#about_cover').fadeIn(500);
  });

  VI.addEvent("click","dimensional",function(){
    $("#code_panel").show();
  });

  VI.addEvent("mouseout",'hide_dimensional',function(){
     $("#code_panel").fadeOut();
    });

  var iterator = 0;
  var $imgs = $("#g_list").find(".lazy_img");

function checkImg(img ,num){
          if(!img){
            return false;
          }
          var imgOffsetTop =  $(img).offset().top , // 图片顶部相对文档的位置
              scrollTop = document.body.scrollTop || document.documentElement.scrollTop,
              //滚动高度位置
              innerHeight = window.innerHeight || document.documentElement.offsetHeight;
              //视图可见高度
              if( (imgOffsetTop - innerHeight - scrollTop) > 0 ){
                return false;
              }else{
                  var n_img = img.parentNode.getElementsByTagName("IMG")[1];
                  var random = Math.random();
                  n_img.src = n_img.getAttribute('data-lazy') + "?" + random;
                  var f = img.parentNode;
                  n_img.onload = function(){
                   f.removeChild(img);
                   n_img.style.display = "";
                  };
                  $imgs[num] = null;
                  return true;
              }
        }

  function lazyLoadPic(){
      /**
       * 迭代器 
       */
      var i = 0;
      for( ; i < $imgs.length ; ++ i ){
       checkImg($imgs[i] , i)
      }
  }
  lazyLoadPic();
  window.onscroll = function(){
       lazyLoadPic();
  };

});    