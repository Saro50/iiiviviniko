<STYLE TYPE="text/css">
.k-webkit .k-editor-toolbar li, .k-ff .k-editor-toolbar li, .k-ie9 .k-editor-toolbar li{
  float: left;
}
</STYLE>
<h2 class='a-title-en'>Collection</h2>
<div class='a-wrapper'>
 
  <div class='a-section'>
    <h3>系列 </h3>
    <div class='a-w-flash'>
        <span class='k-icon k-i-note'></span>
        <span class='a-tips'>注: <span>是否启用</span>将决定该系列是否会显示在子菜单上，默认值是不启用,子系列默认为"CAMPAIGN,LOOKBOOK,ACC"三个，若要添加或者修改用逗号分割，用同样的形式可以增加修改或者删除子系列</span>
     </div>
    <div class='a-help'><a id='help_btn' href='#' data-action='help' class='help' title='基本说明'>?</a>
    </div>
        <div class='a-help-info ' style='display:none;' data-action='close_help'>
             <div class='a-w-flash'>
                <span class='impt'>注:点击此方块内任意淡蓝色部位，或者右上角的红X，可以关闭本文档</span>
            </div>
            <h2 data-action='close_help'>系列添加步骤说明</h2>
                <div class='a-w-flash'>第一步:添加系列</div>
                <img  width='800' src="../img/help_c1.jpg">
                <div class='a-w-flash'>
                上述所添加的数据，对应出现在导航处位置，如下图，<span class='impt'>注:子系列，各系列之间需要用<em>英文逗号</em>分割</span>
                </div>
                <img width='800' src="../img/help_c2.png">
            <h2 data-action='close_help'>产品添加</h2>
              <div class='a-w-flash'>第二步:添加展示产品，点击已经添加的系列主题，产品添加项目将会出现在下方</div>
                <img src="../img/help_c3.png" width='400'>
                <img src="../img/help_c4.png" width='800'>
                <img src="../img/help_c5.png" width='800'>
                <img src="../img/help_c6.png" width='800'>
                <div class='a-w-flash'>注意前台页面展示描述数据位置</div>
        </div>
    <div id='s_grid'>
  	</div>
  </div>

  <div class='a-section'>
    <h3>添加产品</h3>
    <div id='render_container' style='display:none;'>
        <h4 class='a-title-tiny'>asds</h4>    
    
        <input type='hidden' id='s_id' >
        <ul id='p_tab' class='a-l-tab'>
            <li><a>新增</a></li>
            <li><a>详细</a></li>
        </ul>
        <div class='tab_content a-content'>
            <div class='a-w-flash'>
             <span class='k-icon k-i-note'></span><span  class='a-tips'>请选择分类，然后上传，上传图片宽高比例为<span>3:2.像素约为720x480最佳</span></span>
            </div>
            <br>
            <select id='s_sub'></select>
            <div id='warn'></div>
            <input id='files'  name="files"  type='file'>

        </div>
        <div class='tab_content a-content'>
            <div class='a-section'>
                <a class='k-button' data-action = 'add'>新增</a>
                <a class='k-button' data-action = 'show_pre' >图片排序</a>
            </div>
            <div id='p_grid'></div>
        </div>
    </div>
  </div>

</div> 
<div id='pre_cover' class='a-pre-wrapper'>
  <div class='close'>
    预览排序 
    <span id='pre_btn_container'>
    </span>
    <a href='#' data-action='close_pre'  class='k-button'>
    <span class='k-icon k-i-close' data-action='close_pre' ></span>
    关闭
    </a>

    <a    style='margin-left:300px;' class='k-button' data-action='save_pre' href='#'>保存</a>
    <a href='#' class='k-button'  ><span  data-action='refresh_pre' class='k-icon k-i-refresh'></span></a>
    <strong id='cur_sub'></strong>

    </div>
    <div class='a-w-flash'><span class='k-icon k-i-note'></span>请点击上方按钮选择需要预览的类型 <strong class='impt'>如果是第一次排序，请在排序前先保存一次！操作完成之后，记得点击上方的保存！</strong></div>
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
   var $s_id =  $("#s_id");
   var $s_sub = $("#s_sub");
   var s_sub_data = new kendo.data.DataSource({
        data: [
        { val: "Jane Doe", text: 30 }
      ]
    });

   $s_sub.kendoDropDownList({
        dataSource: s_sub_data,
        dataTextField: "val",
        dataValueField: "text"
        });

    VI.addEvent("click",'render_products',function(){

       var title = this.getAttribute("data-title"),
          serises = this.getAttribute("data-data").split(",");

        s_sub_data.fetch(function(){
                while( s_sub_data.total()!= 0 ){
                     s_sub_data.remove( s_sub_data.at( 0 ) );
                }
                s_sub_data.sync();
                
                 $.each(serises , function(){
                    s_sub_data.add({
                        val:this,
                        text:this
                    });
                });
                s_sub_data.sync();
        });


        $con =  $("#render_container");
        $con.show();
        $con.find("h4").html(title);

        $s_id.val( this.getAttribute("data-id") );
        $s_id[0].setAttribute("data-title",title);
        $s_id[0].setAttribute("data-serise",serises.join(","));
        pData.fetch();
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
                pData.fetch();
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
        var contents = "",
            serises  = $s_id[0].getAttribute("data-serise").split(",");
            $.each(serises,function(){
                contents += "<a class='k-button' data-action='preview' >" + this + "</a> ";
            });
          $("#pre_btn_container").html( contents );
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
        pData.fetch();
    });

    function getImg( sub ){
          $.ajax({
            url:"<?php echo $this->Html->url(array(
                              "controller" => "admin",
                              "action" => "ImgSort"
                               )) ?>?=" + Math.random(),//prevent IE cache
            data : { 
                id:$("#s_id").val(),
                s : sub
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
                                        "action" => "createPr"
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
                                id : $s_id.val(),
                                series : $s_sub.val(),
                                model : "Product"
                            };
                            return result;
                        },
                        success : function(res){
                            },
                         error : function(e){
                            alert("登录超时！");
                            forbiddenHandle();
                          }
                    });

    /**
     *  grid for serise;
     */

 	var seriseData =   new kendo.data.DataSource({
                            transport: {
                                read:  {
                                url: "<?php echo $this->Html->url(array(
      							            "controller" => "admin",
      							            "action" => 'readSe'
      							             )) ?>",
                                dataType: "json"
                                      },
                                update: {
                                url: "<?php echo $this->Html->url(array(
        							            "controller" => "admin",
        							            "action" => 'updateSe'
                  							               )) ?>",
                  									dataType: "jsonp",
                  									type:"POST"
                                  },
                                destroy: {
                                url: "<?php echo $this->Html->url(array(
            							            "controller" => "admin",
            							            "action" => 'destroySe'
            							             )) ?>",
            									dataType: "jsonp",
                                                type:"POST"
                                            },
                                            create: {
                                    url: "<?php echo $this->Html->url(array(
							            "controller" => "admin",
							            "action" => 'createSe'
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
                                        return options;

                                    }else{
                                      if(options.s_use === false){
                                          options.s_use = 0;
                                      }
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
                                        s_title: { editable: true  , validation: { required: true , maxLength:30 } },
                                        s_use: { defaultValue: false ,  type: "boolean" },
                                        s_sub: { editable: true  , defaultValue :"CAMPAIGN,LOOKBOOK,ACC" },
                                        s_description: { editable: true  },
                                        s_date : {editable: false}
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

                    $("#s_grid").kendoGrid({
                        dataSource:seriseData ,
                        toolbar: ["create"],
     					sortable: {
	                            mode: "single",
	                            allowUnsort: false
	                        },
                        pageable: true,
                        // filterable: true,
                        columns: [{
                            field: "s_title",
                            title: "主题",
                            template: "<a data-action='render_products' data-data = '#:s_sub#' data-title = '#:s_title#' data-id='#:id#'>#:s_title# </a>"
                        }, {
                            field: "s_use",
                            title: "是否启用"
                        }, {
                            field: "s_sub",
                            title: "子系列",
                            template: "#:s_sub.replace(/,/g,' ')#"
                        }, {
                            field: "s_description",
                            editor: descriptionEditor, 
                            title: "描述",
                            template: "<p title='#:s_description#'>#:s_description.substr(0,30) + '...'#</p>"
                        },{
                            field: "s_date",
                            title: "创建日期"
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
                        },
                      remove : function( e ){ 
                        if(confirm("确认删除？")){

                         return true;
                        }else{

                          e.preventDefault();
                          $kgrid.cancelChanges();
                          return false ;
                        }
                      }

                    });

      function descriptionEditor(container, options){
          $('<textarea name="s_description" rows="10"  style="height:440px;width:600px;" ></textarea>')
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

					var $kgrid = $("#s_grid").data("kendoGrid");

                    var pData = new kendo.data.DataSource({
                            transport: {
                                read:  {
                                    url: "<?php echo $this->Html->url(array(
                                        "controller" => "admin",
                                        "action" => 'readPr'
                                         )) ?>",
                                    dataType: "json",
                                  
                                },
                                update: {
                                    url: "<?php echo $this->Html->url(array(
                                        "controller" => "admin",
                                        "action" => 'updatePr'
                                         )) ?>",
                                    dataType: "jsonp",
                                    type:"POST"
                                },
                                destroy: {
                                    url: "<?php echo $this->Html->url(array(
                                        "controller" => "admin",
                                        "action" => 'destroyPr'
                                         )) ?>",
                                    dataType: "jsonp",
                                    type:"POST"
                                },
                                parameterMap: function(options, operation) {
                                    if (operation !== "read" && options.models) {
                                 
                                        return {models: kendo.stringify(options.models)};
                                    }else{
                                        /**
                                         * [tmp for IE]
                                         * @avoid 302
                                         */
                                        options.tmp = new Date().getTime();
                                        options.s_id = $s_id.val();
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
                                        p_thumb : { editable: false },
                                        p_path: { editable: false  , validation: { required: true } },
                                        p_belong : { editable: false },
                                        p_series: { editable: false },
                                        p_description: { editable: true  },
                                        p_date : {editable: false},
                                        p_sort : {editable: false},
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
                        dataSource:pData ,
                        sortable: {
                                mode: "single",
                                allowUnsort: false
                            },
                        pageable: true,
                        // filterable: true,
                        columns: [{
                            field : "p_thumb",
                            title: "缩略图",
                            template : "<img src='../#:p_thumb#'  height='80' >"    
                        }, 
                        {
                            field: "p_path",
                            title: "路径"
                        }, {
                            field: "p_belong",
                            title: "属于" ,
                            template : function(){
                                return $s_id[0].getAttribute('data-title');
                            }
                        }, {
                            field: "p_series",
                            title: "系列" 
                        }, {
                            field: "p_description",
                            title: "描述"
                        },{
                            field: "p_date",
                            title: "上传日期"
                        },{
                            field : 'p_sort',
                            title : "图片显示序列"
                        },{ 
                            command: [ "edit", "destroy"], title: "&nbsp;", width: "160px" 
                        }],
                        editable:"inline"
                    });
                var $kp_grid = $("#p_grid").data("kendoGrid");

                });

</script>
