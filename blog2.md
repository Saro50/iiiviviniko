编程小技巧分享(队列回调)
===

>前言:
某天我在做一个项目的时候，遇到个需要像类似瀑布图那样去ajax数据的地方，请求非常原子化,如果直接打开会一次性发出N个请求，这样对服务端造成压力。所以我希望改成每次只发一条请求，待请求回来后，再发送第二个，这样看上去数据展示是一块一块出来的。既减小了瞬时压力，由于是从左至右的依次展示，也不太影响阅读体验，大致效果如下。
<img src="blog2_1.png">
可如何在请求回调中来写请求，代码才读起来舒服呢？

正文：
下面，我就来解答上面的问题.下面是我的这段代码:

    var queuePool = (function(){
    var pools = [] , 
        isRunning = false ;
        function walk(){
            var runner = pools.shift();
            if( runner ){
                runner( walk );
            }else{
                isRunning = false ;
            }
        }
        return {
            add : function( fn ){
                pools.push( fn );
            } ,
            run : function(){
                if( !isRunning ){
                    isRunning = true ;
                    walk();
                }
            }
        };
    })();

    queuePool.add( function( callback ){
        $.ajax({
            url : rTimelineUrl ,
            data : {
                date : formatTime( new Date() ),
                referer : data.referer
            } ,
            dataType : "json" ,
            success : function( response ){
                var data = [] , i = 0 ,
                    result = response.result.data;
                for( ; i < result.length ; ++i ){
                    data.push( Number( result[i].counter ) );
                }
                $(el).kendoSparkline({
                                data: data 
                            }); 
                callback();             
            } ,
            fail : function(){ 
                callback(); 
            }
        });     
    });
    queuePool.run(); 
