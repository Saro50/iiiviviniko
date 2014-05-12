<h2 class='a-title-en'>Exhibition</h2>
<div class='a-wrapper'>
 
  <div class='a-section'>
    <h3>展览</h3>
      <div class='a-w-flash'>
        <span class='k-icon k-i-note'></span>
        <span class='a-tips'>注: 点击展览标题可以在此标题下添加对应图片,序列数字越大出现位置越靠前</span>
     </div>
    <div id='ex_grid'>
  	</div>
  </div>

  <div class='a-section'>
    <h3>添加展览图片</h3>
    <div id='render_container' style='display:none;'>
        <h4 class='a-title-tiny'>asds</h4> 
        <input type='hidden' id='ex_id' >
        <ul id='p_tab' class='a-l-tab'>
            <li><a>新增</a></li>
            <li><a>详细</a></li>
        </ul>
        <div class='tab_content a-content'>
            <div class='a-w-flash'>
             <span class='k-icon k-i-note'></span><span  class='a-tips'>上传图片宽高比例为<span>3:2.像素约为720x480最佳</span></span>
            </div>
            <br>
            <div id='warn'></div>
            <input id='files'  name="files"  type='file'>

        </div>
        <div class='tab_content a-content'>
            <div class='a-section'>
                <a class='k-button' data-action = 'add'>新增</a>
               <!--  <a class='k-button' data-action = 'show_pre' >图片排序</a> -->
            </div>
            <div id='p_grid'></div>
        </div>
    </div>
  </div>

</div> 
<div id='pre_cover' class='a-pre-wrapper'>
  <div class='close'>
    预览排序 
    <a class='k-button' data-action='preview'  id='pre_btn_container' data-id='0'>预览</a> 
    </span> 
    <a href='#' data-action='close_pre'  class='k-button'>
    <span class='k-icon k-i-close' data-action='close_pre' ></span>
    关闭
    </a>

    <a style='margin-left:300px;' class='k-button' data-action='save_pre' href='#'>保存</a>
    <a href='#' class='k-button'  ><span  data-action='refresh_pre' class='k-icon k-i-refresh'></span></a>
    <strong id='cur_sub'></strong>

    </div>
    <div class='a-w-flash'><span class='k-icon k-i-note'></span>请点击上方按钮选择需要预览的类型 <strong class='impt'>操作完成之后，记得点击上方的保存！</strong></div>
    <div class='content clearfix '>
        <ul id='img_list'>
        </ul>
    </div>
</div>
<script type="text/javascript">

 $(document).ready(function () {

  function forbiddenHandle(){
    window.location.href='<?php echo $this->Html->url(array(
                              "controller" => "admin",
                              "action" => "login"
                               )) ?>';
  }
  /**
    *  event for Products; 
    */
   var $ex_id =  $("#ex_id");
   var $s_sub = $("#s_sub");
 



    VI.addEvent("click",'render_products',function(){

       var title = this.getAttribute("data-title"),
           id = this.getAttribute("data-id");
        $con =  $("#render_container");
        $con.show();
        $con.find("h4").html(title);

        $ex_id.val( this.getAttribute("data-id") );
        $ex_id[0].setAttribute("data-title",title);
        gData.fetch();
    });

    VI.addEvent("click","add",function(){
        tab.select(0);
    });
    
    var save_blocker = false;
    VI.addEvent("click","save_pre",function(){
        if(!save_blocker){
            if( drag_data.length === 0 ){
              alert("没有修改");
              return;
            }
            save_blocker = true;
              $.ajax({
                url:"<?php echo $this->Html->url(array(
                      "controller" => "admin",
                      "action" => "saveImgSort"
                       )) ?>",
                type:"post",
                data : { 
                    data:drag_data
                 },
                dataType:"json",
                beforeSend : function(){

                },
                success : function( res ){
                    console.log("success");
                    console.log(res);
                    save_blocker = false;
                    drag_data = [];
                    getImg( $("#cur_sub").html() );
                    alert("修改成功！");
                },
                error : function(res){
                      save_blocker = false;
                      alert("出现错误，请联系管理员!");
                     console.log("fail");
                     console.log(res);
                }
            });
          }else{
            alert("正在处理，请稍后保存！");
          }
    });

  VI.addEvent("click","refresh_pre",function(){
    if( $("#cur_sub").html() !== ""){
      getImg( $("#cur_sub").html() );
    }
  });

    var tab  = new VI.widgets.Tab($("#p_tab")[0],{
        onSelect:{
            0:function(){
            },
            1:function(){
                gData.fetch();
            }
        },
        contents:$(".tab_content"),
        init:function(){
           this.select(0);
        }
    });


    /**
     *  img sort
     */
     VI.addEvent("click","show_pre",function(){
          $("#pre_btn_container")[0].setAttribute("data-id",$ex_id.val());

          $("#pre_cover").addClass("down");
     });

    VI.addEvent("click","close_pre",function(){
      if(drag_data.length !== 0){
         if(confirm("关闭将丢失未保存的修改，确定吗？")){
            drag_data = [];
            $("#pre_cover").removeClass("down");
            $("#img_list").html("");
          }else{
            return;
          }
        }else{
            $("#pre_cover").removeClass("down");
            $("#img_list").html("");
        }
        gData.fetch();
    });

    function getImg( sub ){
          $.ajax({
            url:"<?php echo $this->Html->url(array(
                              "controller" => "admin",
                              "action" => "ImgSort"
                               )) ?>?=" + Math.random(),//prevent IE cache
            data : { 
                id:$ex_id.val(),
                m : "Gallery",
                sort : 'sort'
             },
            dataType:"json",
            success : function( res ){
                console.log(res);
                var content = "";
                $.each(res,function(){
                    var sort;
                    if(!this.p_sort){
                      sort = this.id;

                      /**
                       * if sort is null set default equal id
                       * @type {[type]}
                       */
                      drag_data.push({
                        id : sort,
                        p_sort : sort
                      });

                    }else{
                      sort = this.p_sort;
                    }
                    content += " <li><img data-id='"+ this.id +"' data-sort='" + sort + "' data-action='drag' src='../" + this.p_path + "' ></li>";
                });
                $("#img_list").html(content);
            },
            error : function(res , status , info){
              if(info === "Forbidden"){
                alert("登录超时，请重新登录!");
                forbiddenHandle();
              }else{
                alert(info);
              }
            }
        });
    }
    VI.addEvent("click","preview",function(){
        var sub = this.innerHTML ; 
        $("#cur_sub").html(sub);
        getImg(sub);
    });

    var drag_data = [],
        img_container_1,img_1,img_2,img_container_2;

    $("#pre_cover").on("dragstart",function(e){
        var cur = e.target || e.srcElement,
            action = cur.getAttribute("data-action");
            if(!action){
                return;
            }
            img_container_1 = cur.parentNode;
            img_1 = cur;
    });
    $("#pre_cover").on("dragend",function(e){
        var cur = e.target || e.srcElement,
            action = cur.getAttribute("data-action");
            if(!action){
                return;
            }
        if (e.preventDefault) {
         e.preventDefault(); // Necessary. Allows to drop.
         }
         var id_1 = img_1.getAttribute("data-id");
         var id_2 = img_2.getAttribute("data-id");
         var sort_1 = img_2.getAttribute("data-sort"),
             sort_2 = img_1.getAttribute("data-sort");
             img_2.setAttribute("data-sort", sort_2);
             img_1.setAttribute("data-sort",sort_1 );

         drag_data.push({
            id : id_1,
            p_sort : sort_1
         });

         drag_data.push({
            id : id_2,
            p_sort : sort_2
         });
         img_2.className = "" ;
         img_1.className = "" ;
         img_container_1.appendChild(img_2);
         img_container_2.appendChild(img_1);
    });

    $("#pre_cover").on("dragover",function(e){
        if (e.preventDefault) {
          e.preventDefault(); // Necessary. Allows to drop.
         }
         var cur = e.target || e.srcElement,
            action = cur.getAttribute("data-action");
            if(!action){
                return;
            }
         cur.className = "d-over";
         img_2 = cur;
         img_container_2 = cur.parentNode;
    });

   $("#pre_cover").on("dragleave",function(e){
        if (e.preventDefault) {
         e.preventDefault(); // Necessary. Allows to drop.
         }
         var cur = e.target || e.srcElement,
            action = cur.getAttribute("data-action");
            if(!action){
                return;
            }
         cur.className = "";
    });


    var tips = new VI.widgets.flash(document.getElementById("warn"));

     $("#files").kendoUpload({
                        async: {
                            saveUrl: "<?php echo $this->Html->url(array(
                                        "controller" => "admin",
                                        "action" => "createGl"
                                         )) ?>",
                            autoUpload: true
                    },
                    upload : function(e){
                            var result = true;
                            $.each(e.files , function(){
                                if(!(/.png|jpg|jpeg|gif/.test(this.extension.toLowerCase())) ){
                                    result = false;
                                    return false;
                                }
                            });
                            if(!result){
                                tips.reset("只能上传jpg,png,gif格式的图片文件！");
                               e.preventDefault();
                            }
                            e.data = {
                                belong : $ex_id.val()
                            };
                            return result;
                        },
                        success : function(res){
                            },
                         error : function(e){
                            // alert("登录超时！");
                            // forbiddenHandle();
                          }
                    });

    /**
     *  grid for exhibition;
     */

 	var exData =   new kendo.data.DataSource({
                            transport: {
                                read:  {
                                    url: "<?php echo $this->Html->url(array(
          							            "controller" => "admin",
          							            "action" => 'read'
          							             )) ?>",
                                    dataType: "json"
                                  
                                },
                                update: {
                                    url: "<?php echo $this->Html->url(array(
                							            "controller" => "admin",
                							            "action" => 'update'
                							             )) ?>",
                  									dataType: "jsonp",
                  									type:"POST"
                                },
                                destroy: {
                                    url: "<?php echo $this->Html->url(array(
              							            "controller" => "admin",
              							            "action" => 'destroy'
              							             )) ?>",
              									    dataType: "jsonp",
                                    type:"POST"
                                },
                                create: {
                                    url: "<?php echo $this->Html->url(array(
                							            "controller" => "admin",
                							            "action" => 'create'
                							             )) ?>",
                                    dataType: "jsonp",
                                    type:"POST"
                                },
                                parameterMap: function(options, operation) {
                                    if (operation === "read" ) {
                                        /**
                                         * [tmp for IE]
                                         * @avoid 302
                                         */
                                        options.tmp = new Date().getTime();
                                        options.model = "Exhibition";
                                        return options;

                                    }else{
                                      if(options.s_use === false){
                                          options.s_use = 0;
                                      }
                                      options.model = "Exhibition";
                                        return options;
                                    }


                                }
                            },
                            serverPaging: true,
                            serverFiltering: true,
                            serverSorting: true,
                            pageSize: 5,
                            schema: {
                								errors : "errors",
                								data : function(res){
                									return	res.data;
                								},
                								total: "total",
                                model: {
                                    id: "id",
                                    fields: {
                                    	id : { editable: false },
                                        e_title: { editable: true  , validation: { required: true , maxLength:30 } },
                                        e_address: { editable: true  },
                                        e_vedio_link : { editable: true  },
                                        e_description: { editable: true  },
                                        e_rank : { editable: true ,type: "number" }
                                    }
                                }
                            },
                            sync :  function(e){
                                this.fetch();
                            }, 
                            error : function(e){
                            		var p,err = e.errors,
                                    status = e.status,
                            			mes = "";
              								   if(err){
              								   		for(p in err)mes += p + " : " + err[p] + "\n";
              								   	 		alert(mes);
              								   	}
                                 if(status === "error" && e.errorThrown === "Forbidden"){
                                   alert("登录超时，请重新登录");
                                   forbiddenHandle();
                               }
								   	/**
								   	 *  cancelChanges
								   	 */
								   	$kgrid.cancelChanges();
								}
                        });

                    $("#ex_grid").kendoGrid({
                        dataSource:exData ,
                        toolbar: ["create"],
     					          sortable: {
	                            mode: "single",
	                            allowUnsort: false
	                        },
                        pageable: true,
                        // filterable: true,
                        columns: [{
                            field: "e_title",
                            title: "主题",
                            template: "<a data-action='render_products'  data-title = '#:e_title#' data-id='#:id#'>#:e_title# </a>"
                            },{
                                field: "e_address",
                                title: "地址"
                            },{
                                field: "e_description",
                                editor: descriptionEditor, 
                                title: "描述"
                            },{
                                field: "e_vedio_link",
                                title: "视频链接"
                            },{
                                field: "e_rank",
                                title: "序列"
                            },{ 
                            	command: [ "edit", "destroy"], title: "&nbsp;", width: "160px" 
                        	}],
                    	 editable:{
                          mode: "popup",
                          window: {
                              title: "My Custom Title",
                              animation: false,
                              actions: [ "Minimize", "Maximize" ],
                              minWidth : 700,
                              open : function(e){
                                this.maximize();
                              },
                              close : function(){

                              }
                          }
                        }
                    });

					var $kgrid = $("#ex_grid").data("kendoGrid");
          var gData = new kendo.data.DataSource({
                            transport: {
                                read:  {
                                    url: "<?php echo $this->Html->url(array(
                                        "controller" => "admin",
                                        "action" => 'read'
                                         )) ?>",
                                    dataType: "json",
                                  
                                },
                                update: {
                                    url: "<?php echo $this->Html->url(array(
                                        "controller" => "admin",
                                        "action" => 'update'
                                         )) ?>",
                                    dataType: "jsonp",
                                    type:"POST"
                                },
                                destroy: {
                                    url: "<?php echo $this->Html->url(array(
                                        "controller" => "admin",
                                        "action" => 'destroy'
                                         )) ?>",
                                    dataType: "jsonp",
                                    type:"POST"
                                },
                                parameterMap: function(options, operation) {
                                    options.model = "Gallery";
                                    if (operation !== "read" && options.models) {
                                 
                                        return {models: kendo.stringify(options.models)};
                                    }else{
                                        /**
                                         * [tmp for IE]
                                         * @avoid 302
                                         */
                                        options.tmp = new Date().getTime();
                                         options.conditions = "belong";
                                         options.belong = $ex_id.val();
                                        return options;
                                    }
                                }
                            },
                            serverPaging: true,
                            serverFiltering: true,
                            serverSorting: true,
                            pageSize: 5,
                            schema: {
                                errors : "errors",
                                data : function(res){
                                    return  res.data;
                                },
                                total: "total",
                                model: {
                                    id: "id",
                                    fields: {
                                        id : { editable: false },
                                        thumb : { editable: false },
                                        path: { editable: false  , validation: { required: true } },
                                        belong : { editable: false },
                                        description: { editable: true  },
                                        sort : {editable: true , type:"number"}
                                    }
                                }
                            },
                            sync :  function(e){
                                this.fetch();
                            }, 
                            error : function(e){
                                    var p,err = e.errors,
                                        status = e.status,
                                        mes = "";
                                   if(err){
                                        for(p in err)mes += p + " : " + err[p] + "\n";
                                            alert(mes);
                                    }
                                    /**
                                     *  cancelChanges
                                     */
                                  if(status === "error" && e.errorThrown === "Forbidden"){
                                   alert("登录超时，请重新登录");
                                   forbiddenHandle();
                                  }

                                    $kp_grid.cancelChanges();
                                }
                        });

                    $("#p_grid").kendoGrid({
                        dataSource:gData ,
                        sortable: {
                                mode: "single",
                                allowUnsort: false
                            },
                        pageable: true,
                        // filterable: true,
                        columns: [{
                            field : "thumb",
                            title: "缩略图",
                            template : "<img src='../#:thumb#'  height='80' >"    
                        }, 
                        {
                            field: "path",
                            title: "路径"
                        }, {
                            field: "belong",
                            title: "属于" ,
                            template : function(){
                                return $ex_id[0].getAttribute('data-title');
                            }
                        }, {
                            field: "description",
                            title: "描述"
                        },{
                            field : 'sort',
                            title : "图片显示序列"
                        },{ 
                            command: [ "edit", "destroy"], title: "&nbsp;", width: "160px" 
                        }],
                        editable:"inline"
                    });
                var $kp_grid = $("#p_grid").data("kendoGrid");

                });

    function descriptionEditor(container, options){
          $('<textarea name="e_description" rows="10"  style="height:440px;width:600px;" ></textarea>')
                .appendTo(container)
                .kendoEditor({
                   tools:[
                      "bold",
                      "italic",
                      "underline",
                      "strikethrough",
                      "justifyLeft",
                      "justifyCenter",
                      "justifyRight",
                      "justifyFull",
                      "insertUnorderedList",
                      "insertOrderedList",
                      "indent",
                      "outdent",
                      "createLink",
                      "unlink",
                      "insertImage",
                      "subscript",
                      "superscript",
                      "createTable",
                      "addRowAbove",
                      "addRowBelow",
                      "addColumnLeft",
                      "addColumnRight",
                      "deleteRow",
                      "deleteColumn",
                      "viewHtml",
                      "formatting",
                      "fontName",
                      "fontSize",
                      "foreColor",
                      "backColor"
                  ]
                });
      }

</script>
