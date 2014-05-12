<STYLE TYPE="text/css">
.k-webkit .k-editor-toolbar li, .k-ff .k-editor-toolbar li, .k-ie9 .k-editor-toolbar li{
  float: left;
}
</STYLE>
<h2 class='a-title-en'>Letter/Press</h2>
<div class='a-wrapper'>
 
  <div class='a-section'>
    <h3>Letter</h3>
     <ul id='l_tab' class='a-l-tab'>
            <li><a>新增</a></li>
            <li><a>详细</a></li>
        </ul>

        <div class='a-content l_content' >
            <div class='a-w-flash'>
             <span class='k-icon k-i-note'></span><span  class='a-tips'>上传图片宽高比例为<span>3:2.像素约为720x480最佳,只能是gif,jpg,png等格式，png格式将无透明度</span></span>
            </div>
            <br>
            <input id='lfiles'  name="files"  type='file'>
        </div>
        <div class='a-content l_content' >
            <div id='l_grid'></div>

        </div>
  </div>

    <div class='a-section'>
    <h3>Press</h3>
     <ul id='p_tab' class='a-l-tab'>
            <li><a>新增</a></li>
            <li><a>详细</a></li>
        </ul>

        <div class='a-content p_content'>
            <div class='a-w-flash'>
             <span class='k-icon k-i-note'></span><span  class='a-tips'>上传图片宽高比例为<span>3:2.像素约为720x480最佳,只能是gif,jpg,png等格式，png格式将无透明度</span></span>
            </div>
            <br>
            <input id='pfiles'  name="files"  type='file'>
        </div>
         <div class='a-content p_content' >
            <div id='p_grid'></div>
        </div>
  </div>
</div> 


<script type="text/javascript">
    var p_tab = new VI.widgets.Tab($("#p_tab")[0],{
        onSelect:{
            0:function(){
            },
            1:function(){
                pData.fetch();
            }
        },
        contents:$(".p_content"),
        init:function(){
           this.select(0);
        }
    }),
    l_tab = new VI.widgets.Tab($("#l_tab")[0],{
        onSelect:{
            0:function(){
            },
            1:function(){
                  lData.fetch();
            }
        },
        contents:$(".l_content"),
        init:function(){
           this.select(0);
        }
    });;


    function createUpload( $el , url ,args){
         $el.kendoUpload({
                            async: {
                                saveUrl: url,
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
                                e.data = args;
                                return result;
                            },
                            success : function(res){
                                },
                             error : function(e){
                                alert("登录超时！");
                                forbiddenHandle();
                              }
                        });
        }

    createUpload( $("#pfiles") , "<?php echo $this->Html->url(array(
                                        "controller" => "admin",
                                        "action" => "createPress"
                                         )) ?>" ,{ type_name:"Press" });

    createUpload( $("#lfiles") , "<?php echo $this->Html->url(array(
                                        "controller" => "admin",
                                        "action" => "createLetter"
                                         )) ?>" , { type_name:"Letter" });


  var lData = new kendo.data.DataSource({
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
                                    options.model = "Resource";
                                    options.type_name = "Letter";
                                    options.conditions = "type_name";
                                    if (operation !== "read" && options.models) {
                                 
                                        return {models: kendo.stringify(options.models)};
                                    }else{
                                        /**
                                         * [tmp for IE]
                                         * @avoid 302
                                         */
                                        var date = options.display_date;
                                        if(date){
                                        options.display_date = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate() + " "+ date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
                                        }
                                        options.tmp = new Date().getTime();
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
                                        description: { editable: true  },
                                        display_date : {editable: true ,type: "date"}
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

                                    $kl_grid.cancelChanges();
                                }
                        });

                    $("#l_grid").kendoGrid({
                        dataSource:lData ,
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
                        },{
                            field: "description",
                            editor: descriptionEditor,
                            title: "描述"
                        },{
                            field : 'display_date',
                            title : "显示日期",
                             format: "{0:MM/dd/yyyy}"
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
                          $kl_grid.cancelChanges();
                          return false ;
                        }
                      }
                    });
                var $kl_grid = $("#l_grid").data("kendoGrid");

 var pData = new kendo.data.DataSource({
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
                                    options.model = "Resource";
                                    options.type_name = "Press";
                                    options.conditions = "type_name";
                                    if (operation !== "read" && options.models) {
                                 
                                        return {models: kendo.stringify(options.models)};
                                    }else{
                                        /**
                                         * [tmp for IE]
                                         * @avoid 302
                                         */
                                          var date = options.display_date;
                                          if(date){
                                        options.display_date = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate() + " "+ date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
                                        }
                                        options.tmp = new Date().getTime();
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
                                        description: { editable: true  },
                                        display_date : {editable: true ,type: "date"}
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

                                    $kl_grid.cancelChanges();
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
                            field : "thumb",
                            title: "缩略图",
                            template : "<img src='../#:thumb#'  height='80' >"    
                        }, 
                        {
                            field: "path",
                            title: "路径"
                        },{
                            field: "description",
                            title: "描述"
                        },{
                            field : 'display_date',
                            title : "显示日期",
                             format: "{0:MM/dd/yyyy}"
                        },{ 
                            command: [ "edit", "destroy"], title: "&nbsp;", width: "160px" 
                        }],
                        editable:{
                          mode: "popup",
                          window: {
                              title: "My Custom Title",
                              animation: false,
                              actions: [ "Minimize", "Maximize" ]
                          }
                        },
                      remove : function( e ){ 
                        if(confirm("确认删除？")){

                         return true;
                        }else{

                          e.preventDefault();
                          $kp_grid.cancelChanges();
                          return false ;
                        }
                      }
                    });
                var $kp_grid = $("#p_grid").data("kendoGrid");

    function descriptionEditor(container, options){
          $('<textarea name="description" rows="10"  style="height:440px;width:600px;" ></textarea>')
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
