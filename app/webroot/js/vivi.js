/**
 * @date 2013-12-27
 * version : 1.0
 * 
 */
var VI = {};
(function(window,undefined){
    var events = {},
        inits = {},
        _ = {},
        ACTION = 'data-action',
        $ = window.$,
        doc = window.document ;

        VI._ = _ ;
        
        VI.Util = _ ;

    _.getAttribute = function( el ,name ){
        return el.getAttribute(name);
    };

    _.type = function( val ){
        if(val === null){
            return "null";
        }
     var toString = Object.prototype.toString;
       return toString.call(val).split(" ")[1].replace("]","");
    };


   _.getAgent = (function(){
    var nvg= window.navigator,
      browser_id =["Chrome","MSIE","Firefox","Opera","Safari"] ,
      vendors = ["Google"],
      browserName = "",
      browserVersion = "",
      search = function(orginStr,matcher){
        var i = matcher.length,
          result = -1;
        while( i > 0 ){
          if((result = orginStr.indexOf(matcher[--i]))!=-1){
            break;
          }
        }
        return {
          index:result,
          position:i
        };
      },
      get_version = function(name){
        var agent = nvg.userAgent,
          begin = agent.indexOf(name),
          restAgent = agent.substring(begin);
          version = /(\d+([.]\d+)*)/;
          if(version.test(restAgent)){
            return RegExp.$1;
          }

          return null;
      };
      var vendor = search(nvg.vendor?nvg.vendor:"",vendors);
      if(vendor.index!=-1){
          browserName = browser_id[vendor.position];
          browserVersion = get_version(browserName);
      }else{
        var agent = search(nvg.userAgent,browser_id);
          browserName = browser_id[agent.position];
          browserVersion = get_version(browserName);
      }
    return function(){
      return {
        name:browserName,
        version:browserVersion
      };
    };
  })();

    /**
     * [aop description]
     * @param  {[type]} orgFn    [description]
     * @param  {[type]} beforeFn [description]
     * @param  {[type]} afterFn  [description]
     * @return {[fn]}          [description]
     */
    _.aop = function( orgFn  , opts  ){
      return function(){
        var slice = Array.prototype.slice;
        opts.before&&opts.before();

        orgFn.apply(opts.context ? opts.context : null , slice.call(arguments,0));

        opts.after&&opts.after();
      } ;
    };

    _.define = function( space , name , val ){
            var p ;
            if(!space[name]){
                space[name] = {};
            }
            for( p in val ){
                if( val.hasOwnProperty( p ) ){
                    space[name][p] = val[p];    
                }
            }
        };

    _.each = function(arr,fn){
            var i=0;
            for( ; i<arr.length ; ++i ){
                fn.apply(arr[i],[ arr[i] , i ]);
            }
        };

    /**
     * [templateParser description]
     * @param  {[string]} template [description]
     * @param  {[object || array ]} data     [description]
     * @param  {[string]} reg      [description]
     * @return {[string]}  content   [description]
     */
    _.templateParser = function(template,data,fn){
        var reg = "#";
        var content = "";

        function renderFromObject(t,d){
            var p ,regexp,content = t;
            for(p in d){
                regexp =new RegExp(reg+p+reg);
                if(d.hasOwnProperty(p)){    
                    while(content.match(regexp)){
                      if(d[p]){
                        content = content.replace(regexp,d[p]);
                      }else{
                        content = content.replace(regexp,"");
                      }
                    }
                }
            }
            return content;
        }
        if (typeof data !== "object"){
            try{
              
            }catch(e){
                throw {
                    message:"wrong data"
                };
            }
        }
        if(!(data instanceof Array) ){
            data = [data];
        }

        var i = 0,
            len = data.length ;
        for(;i < len ; ++i ){
            content += renderFromObject(template,data[i]);
        }  
        if(fn){
          content = fn(content);
        }

        return content;
    };
/**
 *  @render localStorage for lt IE8
 *   
 */
    if(!window.localStorage){
        doc.onreadystatechange  = function(){
            if( doc.readyState === "complete" ) {
            _.define( window , "localStorage" ,(function(){
                var domain = window.location.host ,
                    behaviorUrl = '#default#userData',
                    dataSource = doc.createElement("DIV");
                    doc.body.appendChild(dataSource);
                    dataSource.style.display = "none";
                    dataSource.style.behavior = "url(" + behaviorUrl + ")";
                    dataSource.addBehavior( behaviorUrl );
                    window.localStorage = {
                            setItem : function( name , value ){
                                dataSource.load( domain );
                                dataSource.setAttribute( name , value );
                                dataSource.save( domain );
                            },
                            getItem : function( name ){
                                dataSource.load( domain );
                                return dataSource.getAttribute( name );
                            },
                            removeItem : function( key ){
                                dataSource.load( domain );
                                dataSource.removeAttribute( key );
                                dataSource.save( domain );
                            }
                    };
            })());
            doc.onreadystatechange = null;
        }
        };
    }
    _.addEvent = function(el,type,fn ,pup){
                    if(el.addEventListener){
                        return el.addEventListener(type , fn ,pup );
                    }else{
                        return el.attachEvent("on"+type , fn);
                    }
                };
    /**
     * [serialize jQuery needed]
     * @param  {[type]} form [description]
     * @param  {[type]} opts [description]
     * @return {[type]}      [description]
     */
    _.serialize = function( form , opts ){
        opts = opts ? opts : {};
         return $.map($(form).serialize().split("&") , function( el  ){
            var tmp = el.split("=");
            return (tmp[0] in opts)?tmp[0] + "=" + opts[tmp[0]](tmp[1]) : tmp.join("=");
         }).join("&");
    };

    /**
     * [date_getDistance description]
     * @return {[type]} [description]
     */
    _.date_getDistance = function( ms ){
      var d = [1e3 *  36e2 * 24 , 1e3 * 36e2 , 1e3 * 60 , 1e3],
        result = [],
        i = 0;
        for(; i < d.length ; ++i ){
          result.push( Math.floor(ms/d[i]) );
          ms = ms%d[i];
        }
        return result;
    };
/**
 * [addEvent Proxy global event ]
 * @param {[string]}  type [event type 'click , mousemove , ...']
 * @param {[string]}  tag  [ trigger tag ]
 * @param {Function} fn   [event callback]
 */
    VI.addEvent =  function( type , tag , fn ){
        if( !events[type] ){
            events[type] = {};
            events[type][tag] = fn;
            _.addEvent( doc.body , type ,function(e){
                var cur = e.target || e.srcElement,
                    action = cur.nodeType === 1 ? _.getAttribute( cur , ACTION ) : false ;
                    if(!action){return;}
                    else{
                        if( action in events[type] ){
                            if( _.type( events[type][action] ) === "Function" ){
                                events[type][action].apply(cur,[e]);
                            }
                        }
                    }
            });

        }else{
            events[type][tag] = fn;
        }
    };

/**
 * [removeEvent description]
 * @param  {[string]} type 
 * @param  {[string]} tag  
 */
    VI.removeEvent = function( type , tag ){
        events[type][tag] = null;
    };

/**
 * [register description]
 * 注册页面交互js
 * @param  {[String]}   flag [唯一的页面标识]
 * @param  {Function} fn   [页面交互的初始化函数]
 */
    VI.register = function( flag , fn ){
        if( !inits[flag] ){
            inits[flag] = fn;
        }else{
            throw {
                message:flag + " has been registered !"
            };
        }
    };
/**
 * [init description]
 * 页面初始化
 * @param  {[String]} flag [唯一的页面标识]
 */
    VI.init = function( flag ){
        inits[flag]();
    };

/**
 * VI.widget
 */
    VI.widgets = {};
    VI.widgets.window = function( opts){
        if(!(this instanceof VI.widgets.window )){
            return new VI.widgets.window( opts );
        }
       opts = opts ? opts : {};
        this._init( opts );

        return this;
    };
    VI.widgets.window.prototype = (function(){
        var hasCover = false,
            DEFAULT = {
                        W_CLASSNAME : "c-window",
                        C_CLASSNAME : "c-cover"
                    };
        return {
                _cover : {
                    el:doc.createElement("DIV"),
                    hide:function(){
                        this.el.style.display='none';
                    },
                    show:function(){
                        this.el.style.display='block';
                    },
                    off : function(){
                        doc.body.removeChild( this.el );
                    },
                    on : function(){
                        doc.body.appendChild( this.el );
                    },
                    _init:function(){
                        this.el.className = DEFAULT.C_CLASSNAME;
                        this.el.setAttribute('data-action','close');
                        doc.body.appendChild( this.el );
                        this.hide();
                    }
                },
                hide : function(){
                    if(this.events['beforeHide']){
                       this.events['beforeHide']();
                    }
                    this.el.style.display = "none";
                    this._cover.hide();
                },
                show : function(){
                    this.el.style.display = 'block';
                    this.position();
                    this._cover.show();
                },
                open : function( content ){
                    if(content){
                        this.getContent(content);
                    }
                    this.show();
                },
                addEvent : function( name ,  fn){
                    this.events[name] = fn;
                },
                position : function( x , y ){
                    var w_h = window.outerHeight || doc.documentElement.offsetHeight;
                    var width = this.el.offsetWidth || this.el.clientWidth,
                        height = this.el.offsetHeight || this.el.clientHeight;
                    this.el.style.marginTop = "-" + height/2 + "px";
                    this.el.style.marginLeft = "-" + width/2  + 'px';
                },
                SIMPLETEMPLATE : "<div class='c-w-h'><div class='c-w-sub'>#title#</div> <span class='c-w-close' data-action='close'></span></div><div class='c-w-c'><div class='c-w-section'>#content#</div></div>", 
                _init : function( opts  ){
                    var that = this,
                        content = opts.content ? opts.content : "";

                    this.el = doc.createElement("DIV");
                    this.events = {};
                    if(!hasCover){
                        this._cover._init();
                        hasCover = true;
                    }
                    // this.el.style.cssText = "top:0px;left:0px";
                    this.el.className = DEFAULT.W_CLASSNAME;
                    doc.body.appendChild(this.el);
                    this.getContent( content );

                    this.el.className += " img-responsive";
                    var w_h = window.outerHeight || doc.documentElement.offsetHeight;
                    this.position( (doc.body.offsetWidth - this.el.offsetWidth)/2 , (w_h - this.el.offsetHeight)/2 );
                    this.hide();
                    VI.addEvent("click", "close" , function(){
                        that.hide();
                    });

                    this.el.onclick = function( e ){
                        if(!e){
                            e = window.event;
                        }
                      var cur = e.target || e.srcElement,
                        action = cur.getAttribute("data-action");
                        if(that.events[action]){
                            that.events[action].apply(that , [e]);
                        }
                    };
                },
                getContent : function( content ){
                    if( _.type(content) === "String" ){
                        this.el.innerHTML = content;
                    }else{
                        this.el.appendChild(content);
                    }
                },
                getSimpleContent : function( title , content ){
                    var r_id = "_a_" + Math.random();
                        this.getContent(_.templateParser(this.SIMPLETEMPLATE , {
                            title : title ,
                            content : "<div id='" + r_id + "'></div>" 
                        }));

                   
                    if( _.type(content) === "String" ){
                            var p = document.getElementById( r_id ).parentNode;
                            p.innerHTML = content;
                    
                    }else{
                        // setTimeout(function(){
                            var p = document.getElementById( r_id ).parentNode;
                            p.innerHTML = "";
                            p.appendChild( content );
                        // },0);
                    }
                },
                error:function(content, title){
                    this.getSimpleContent(title || '错误信息' ,  "<span class='c-w-wrong'>" + content + "</span><div style='text-align: center;'><a data-action='close' class='c-red-btn'>确定</a></div>" );
                    this.show();
                },
                tip:function(content, title){
                    this.getSimpleContent(title || '提示信息', "<span class='c-dp'>" + content + "</span><div style='text-align: center;'><a data-action='close' class='c-red-btn'>确定</a></div>" );
                    this.show();
                }
            };
    })();


    VI.widgets.flash = function( wrapper , opts ){
        if(!(this instanceof VI.widgets.flash )){
            return new VI.widgets.flash( opts );
        }
        this.wrapper = wrapper;
        var flashWrapper = document.createElement("div");
        this.el =  flashWrapper;
        flashWrapper.className = "a-w-flash";
        flashWrapper.style.display = 'none';
        this.wrapper.appendChild(flashWrapper);
        this.timer = null;
    };

    VI.widgets.flash.prototype = {
      getText : function( text ){
        this.el.innerHTML = "<span class='k-icon k-i-note'></span> " + text;
      },
      reset : function(text){
        if(text){
          this.getText(text);
        }
        var that = this;
        
        that.el.style.display ='block';

        if(!this.timer){
         this.timer = setTimeout(function(){
                that.el.style.display = "none";
              },5000);
          }else{
            clearTimeout(this.timer);
            this.timer = setTimeout(function(){
                that.el.style.display = "none";
              },5000);
          }
      }
    };

    /*
    Validate for form

        @Autor: WuNing
        @date: 2013-3-21 
        @main method:
            setHandle:{
                handle:{
                    clickPager:fn,
                    setPager:fn,
                    pre:fn,
                    next:fn
                }
            }
            destroy:

        @config style by CONST value
*/
_.getAgent = (function(){
        var nvg= window.navigator,
            browser_id =["Chrome","MSIE","Firefox","Opera","Safari"] ,
            vendors = ["Google"],
            browserName = "",
            browserVersion = "",
            search = function(orginStr,matcher){
                var i = matcher.length,
                    result = -1;
                while( i > 0 ){
                    if((result = orginStr.indexOf(matcher[--i]))!==-1){
                        break;
                    }
                }
                return {
                    index:result,
                    position:i
                };
            },
            get_version = function(name){
                var agent = nvg.userAgent,
                    begin = agent.indexOf(name),
                    restAgent = agent.substring(begin),
                    version = /(\d+([.]\d+)*)/;
                    if(version.test(restAgent)){
                        return RegExp.$1;
                    }

                    return null;
            };
            var vendor = search(nvg.vendor?nvg.vendor:"",vendors);
            if(vendor.index!==-1){
                    browserName = browser_id[vendor.position];
                    browserVersion = get_version(browserName);
            }else{
                var agent = search(nvg.userAgent,browser_id);
                    browserName = browser_id[agent.position];
                    browserVersion = get_version(browserName);
            }
        return function(){
            return {
                name : browserName ,
                nameAndVersion : browserName + browserVersion,
                version : browserVersion
            };
        };
    })();
    VI.widgets._validate = function(){
            var id = 0,
                isIE = _.getAgent().name ==="MSIE" ? true : false,
                invalid_handle = function(el){
                    if(isIE){
                        el.checkValidity = function(){
                            var pattern = this.attributes["pattern"],
                                /*
                                    @modify by wuning 2013/3/26 
                                    FOR damn IE
                                    lt IE7: this.attributes["required"] always eixsted;
                                    gt IE7: when required specified , this.attributes["required"] existed;
                                */
                                required = this.attributes["required"]?this.attributes["required"].specified:false,
                                value =$.trim(this.value);          
                                if(value === ""){
                                    if(required){
                                        if(typeof this.oninvalid === "function"){
                                            this.oninvalid();
                                        }
                                        return false;
                                    }else{
                                        return true;
                                    }
                                }else{
                                    if(pattern&&pattern.specified){
                                    var reg = new RegExp("^" + pattern.value + "$");
                                        if(reg.test(value)){
                                            return true;
                                        }else{
                                            if(typeof this.oninvalid === "function"){
                                                this.oninvalid();
                                            }
                                        return false;
                                        }
                                    }else{
                                        return true;
                                    }
                                }
                        };
                    }
                };
            return function(options){
                var that = this,
                    el = options.el,
                    blur = options.blur,
                    change = options.change,
                    focus = options.focus,
                    wraper = options.wraper,
                    invalid = options.invalid;
       
                this.invalid = invalid;
                this.change = change;
                this.focus = focus;
                this._id = id++;
                this.el = el;
                this.wraper = wraper;
                /*
                    @modify by wuning 2013/5/7
                    render blur listener
                */
                this.blur = blur;
                this.name = el.name;
                this.id = el.id;
                
                this.update = function(){
                    if(that.name in wraper.rules){
                        that.rules = wraper.rules[that.name];
                    }
                    return that;
                };
                this.update();

                this.check = function(){
                    var rules = that.rules||null , valid;
                    if(rules){
                        valid = rules.apply(that.el,[that.el.checkValidity.apply(that.el,[null]),that]);
                        if(!valid){
                            this.el.oninvalid();
                        }
                    }else{
                        valid = that.el.checkValidity.apply(that.el,[null]);
                    }
                 
                    return valid;
                };
                this.el.onchange = function( e ){
                    if(that.change){
                        that.change.apply(this,[that , e]);
                        }
                };
                this.el.oninvalid = function(e){
                    e = e || {};
                    if( this.getAttribute("required")!== null &&this.value === "" ){
                      e.dld_status = 'emptyValue';
                    }else{
                      e.dld_status = "invalidValue"
                    }
                    if(that.invalid){
                        that.invalid.apply(this,[that,e]);
                    }

                };
                this.el._dldValidate = this;
                /*
                    @modify by wuning 2013/5/7
                    render blur listener
                */
                this.el.onblur = function( e ){
                    that.blur && that.blur.apply(this,[that,e]);
                };
                /*
                    @modify by wuning 2013/5/9
                    register focus listener
                */
                this.el.onfocus = function(e){
                    that.focus && that.focus.apply(this,[that,e]);
                };
                if(!isIE){
                    /*  
                        @modify by wuning 2013/3/27
                        required can not validate when there will only blank
                    */
                    if($(el).attr("required")&&($(el).attr("pattern")!="")){
                        // $(el).attr("pattern","[^\\s]*");
                    }
                }
                invalid_handle(el);
            };
        }();


        VI.widgets.validateForm = function(){
            var id = 0;
            return function(form , opts ){
                var that = this,
                    submit_handle = function(e){
                        var checkResult = that.check(); 
                        var result = that.handle["onsubmit"]?that.handle["onsubmit"].apply(that,[checkResult,e]):true;
                        return result;
                        
                    };
                if(!opts){
                    opts = {};
                }
                this._id = id++;
                this.handle = {};
                this.rules = {};
                var rules = opts.rules || {},
                    handle = opts.handle || {};
                that.validations = [];
                this.el = form;
                // novalidate='true'
                var elType = {
                    "SELECT":true,
                    "INPUT":true,
                    "TEXTARE":true
                };
                this._init = function(){
                    _.each(form.elements,function(){
                        if(this.tagName in elType){
                            that.validations.push(new  VI.widgets._validate({
                                el:this,
                                wraper:that,
                                invalid:that.handle["invalid"],
                                change:that.handle["change"],
                                blur:that.handle["blur"],
                                focus:that.handle["focus"],
                                rules:that.rules
                                }));
                        }
                    });
                    return this;
                };
                form.noValidate=true;
                this.el.onsubmit = submit_handle;
                this.setHandle(handle);
                this.setRules(rules);
                this._init();
            };
        }();

        VI.widgets.validateForm.prototype = {
            check:function(){
                var invalid = false;
                _.each(this.validations,function(){
                    if( !this.check() ){
                        invalid = true;
                    }
                });
                if(this.handle["onCheckAll"]){
                    if( !this.handle["onCheckAll"]() ) {
                        invalid = true;
                    }
                }
                return invalid ? false : true;
            },
            setHandle : function(handle){
                var handle = handle ||{};
                this.handle["invalid"] = handle["invalid"];
                this.handle['onsubmit'] = handle["onsubmit"];
                this.handle["change"] = handle["change"];
                this.handle["onCheckAll"] = handle["onCheckAll"];
                /*
                    @modify by wuning 2013/5/7
                    render blur listener
                */
                this.handle['blur'] = handle['blur'];
                /*
                    @modify by wuning 2013/5/9
                    register focus and check listener
                */

                this.handle['focus'] = handle['focus'];
                return this;
            },
            setRules : function(rules){
                this.rules = rules;
                return this;
            },
            submit:function(){
                    this.el.submit();
                }
        };


  
  /**
   * [Player description]
   * @param {[type]} time [description]
   * @param {[type]} ani  [description]
   * @param {[type]} opts [description]
   */
   _.Player = function( time , ani ){
          var timer ,auto = false;     

              this.stop = function(){
                if( auto){
                  clearInterval( timer );
                }else{
                  clearTimeout( timer );
                }
              };

              this.start = function( auto ){
                if( auto ){
                  auto = true;
                  timer = setInterval(ani , time );
                }else{
                  timer = setTimeout( ani , time );
                }
              };

      };



  VI.widgets.Slider = function( el , time , type , opts ){
          var TIME = time || 10000 ,o = opts ? opts : {},
              curNum = 2 , auto = o.auto || true , 
              actionObj = {},
              pages =  $(el).find("[data-page]"),
              block = false ,
              pNums =(function(){
                 var p = $(el).find('[data-role="pager"]')[0],
                      dNums,
                      i = 0 ,l = pages.length , content = "";
                      for( ; i < l ; ++i ){
                        content += "<li><a class=''  data-action='" + type + "' data-num = '" + (i + 1) + "' >" + (i + 1) + "</a></li>";
                      }
                    p.innerHTML = content;
                    dNums = $(p).find('[data-num]');

                    dNums[0].className = 'on'; 
                  return function( num ){
                    for( i = 0 ;i < l ; ++ i ){
                      dNums[i].className = "";
                    }
                    dNums[ num - 1 ].className = 'on';
                  };
              })(),
              typeFactory = function( type ) {
                   var T = {
                        fade :{
                          cover : null ,
                          init : function(){
                            actionObj["fade"] = function( cur ){
                                var pageNum = parseInt(cur.getAttribute("data-num") , 10 );
                                if(!block){
                                  categoryObj.animate( pageNum  );
                                  curNum = pageNum;
                                  pNums( pageNum );
                                }
                            };
                            var len = pages.length , i = 0;
                              this.els = [];
                              this.MAX = len;
                              for( i ; i < len ; ++ i ){
                                pages[i].style.position = "absolute" ;
                                pages[i].style.zIndex = len - i + 1;
                                pages[i].style.display = "none";
                              }
                              pages[0].style.display = "";
                              this.cover = pages[0];
                          },
                          resetIndex : function( num ){
                              var i = num  , j = 0 , len = pages.length;
                              for( ; i < len ; ++ i ){
                                pages[i].style.zIndex = len - (j++) + 1; 
                              }
                              for( i = 0 ; i < num ; ++ i ){
                                pages[i].style.zIndex = len - (j++) + 1;
                              }
                          },
                          animate : function( pNum ,opts ){
                            opts = opts ? opts : {};
                            var callback = opts.callback;
                            if(this.cover === pages[pNum-1]){
                              return;
                            }
                            block = true;
                            var cover_index = parseInt( this.cover.style.zIndex ,10 ),
                                that = this;
                            pages[ pNum - 1 ].style.display = "";
                            pages[ pNum - 1 ].style.zIndex = cover_index - 1; 

                            $( this.cover ).fadeOut(1000 ,function(){
                              that.cover = pages[ pNum - 1 ];
                              that.resetIndex( pNum-1 );
                               block = false;
                               callback&&callback();
                                  
                            });
                          }
                        },
                      slide : {
                          init : function(){
                            var len = pages.length , i = 0 ,dx;
                                dx = this.dX = pages[0].offsetWidth,
                                that = this;
                                this.f = pages[0].parentNode;
                                this.els = [];
                                this.MAX = len;
                                this.f.style.width = (len * dx) + 'px';
                                this.f.style.position = 'absolute';
                                this.f.style.zIndex = '1';
                                var preBtn = $(el).find('[data-action="pre"]')[0],
                                    nextBtn = $(el).find('[data-action="next"]')[0];

                                this.pre = preBtn ? preBtn : null ;

                                this.next = nextBtn ? nextBtn : null ;

                                this.first = pages[0] ;
                                $.each(pages , function(){
                                  this.style.cssText = "float:left;";
                                });
                                this.cur = 0;

                                actionObj["slide"] = function( cur , auto){
                                  var pageNum = parseInt(cur.getAttribute("data-num") , 10 );
                                  if(!block){
                                    categoryObj.animate( pageNum  , {
                                      auto : auto
                                    } );
                                    curNum = pageNum;
                                    pNums( pageNum );
                                  }
                                };

                                actionObj["pre"] = function( cur ){
                                    actionObj["slide"]( cur ) ;
                                 };

                                actionObj["next"] = function( cur ){
                                   actionObj["slide"]( cur ,  true ) ;
                                };
                                that.resetNavBtn(1);
                          },
                          resetNavBtn : function( num ){
                            if(this.pre){
                                this.pre.setAttribute("data-num" ,0 < ( num - 1 ) ?( num - 1 ) + '' : this.MAX );
                            }
                            if(this.next){
                              this.next.setAttribute("data-num",num + 1 <= this.MAX ? num + 1 : 1 );
                            }
                          },
                          animate : function(pNum , opts ){
                              opts = opts ? opts : {};
                            var callback = opts.callback,
                                auto = opts.auto;

                            block = true;
                            var dX = this.dX,first = this.first,
                                max = this.MAX,f =this.f,
                                that = this ;

                            if( pNum === 1 && auto && that.cur !== 1 ){
                              $(this.first).css({
                                position : "relative",
                                top : 0,
                                left : max*dX-1,
                                zIndex : 1
                              });

                                $(f).animate({
                                  left:-1*dX*max
                                },"slow",function(){
                                  block = false;
                                   $(f).css({
                                    left:0
                                   });
                                  that.resetNavBtn(pNum);
                                  first.style.position = "";
                                  first.style.left = "";
                                  callback&&callback();
                                });

                            }else{
                              $(f).animate({
                                left:-1*this.dX*(pNum - 1)
                              },"slow",function(){
                                that.resetNavBtn(pNum);
                                block = false;
                                callback&&callback();
                              });
                            }


                            that.cur = pNum;
                          }
                        }
                      };
                      return T[type];
              },
              play;

              var categoryObj = typeFactory(type);

              categoryObj.init(el);

              play = new _.Player( TIME ,function(){
                  categoryObj.animate(curNum , {
                    auto : true ,
                    callback : function(){
                      pNums( curNum );
                      if( curNum === pages.length ){
                         curNum = 1;
                        }else{
                          curNum ++ ;
                        }
                      }
                  });
           
                  });

            play.start(auto);

            $(el).click(function(e){
                var event = e || window.event,
                    cur = event.srcElement || event.target,
                    action = cur.getAttribute('data-action');
                    if(!action){return;}
                    try{
                      actionObj[action]( cur );
                    }catch(e){
                      alert(e.message);
                    }
            });
      };  


    _.getDefault = function( src ,  dest ){
            var p ;
            for( p in src ){
                if( src.hasOwnProperty(p) ) {
                    dest[p] = src[p];
                }
            }
            return dest;
    };

    /**
     * [Tab description]
     * @param {[type]} el   [description]
     * @param {[type]} opts [description]
     */
    VI.widgets.Tab = function(el , opts){
        if( el.tagName !== "UL" ){
            throw {
                message : "Must UL element"
            };
        }
        var lis = el.getElementsByTagName("LI"),
            l = lis.length,that = this,
            defaultOpts = _.getDefault(opts , {
                className : "selected"
            }),
            i = 0;
            this.opts = defaultOpts;
            this.contents = defaultOpts.contents || []; 
            this.lis = lis;
            this.cName = defaultOpts.className;
            for( ; i < l ; ++ i ){
               lis[i].setAttribute("data-tab" , i ); 
            }

            _.addEvent(el , "click" , function(event){
                var e = event || window.event,
                    cur = e.target || e.srcElement;
                    if(cur.tagName === 'UL'){
                        return;
                    }
                    while(cur.tagName !== "LI" ){
                        cur = cur.parentNode;
                    }
                    var tab = cur.getAttribute('data-tab');
                    that.select( tab );
            });
            if(defaultOpts.init){
                defaultOpts.init.call(this);
            }
    };
    VI.widgets.Tab.prototype = {
        select : function( num ){
            var lis = this.lis,contents = this.contents,
                l = lis.length,
                i = 0;

                for( ; i < l; ++i ){
                    lis[i].className = "";
                    if(contents[i]){
                    contents[i].style.display = "none";
                  }
                }
                lis[num].className = this.cName;
                if(contents[num]){
                contents[num].style.display = "";
               }
                if( this.opts.onSelect[num] ) {
                    this.opts.onSelect[num].call(lis[num] , this);
                }

        }
    };
})(window,undefined);