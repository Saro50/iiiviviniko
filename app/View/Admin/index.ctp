<div class='a-wrapper'>

  <div>
  	<div class='a-help'><a id='help_btn' href='#' data-action='help' class='help' title='基本帮助'>?</a></div>
  	<div class='a-help-info ' style='display:none;' data-action='close_help'>
  		<h2>这是一个说明文档示例</h2>
  	</div>
     <ul class='a-list-topic' id='t_list'>
   <li><span  class='a-tips'><span class='k-icon k-i-note'></span>在编辑页面中点击右上角 问号标识，可查看说明文档</span></li>
    </ul>
    

    <h3 class='a-title-en'>home/shop 轮播 | 编辑插入图片 | About动画图片</h3>
  	 <div class='a-w-flash'>
        <span class='k-icon k-i-note'></span>
        <span class='a-tips'>注: <span>home/shop</span> 轮播 | <span>resource</span> 编辑插入图片 | <span>About</span> 关于我们动画图片 所有轮播推荐上传图片尺寸<span>1067x600</span>，<span>一般上传的图片,请使用相关工具如PS,AI等导出为web所用格式</span>，注:排序数字越大越靠前</span>
     </div>
     <div id='s_grid'>
     </div>

       <h3 class='a-title-en'>用户留言</h3>
       <div id='m_grid'>

       </div>
  </div>

</div> 

<script type="text/javascript">
$(document).ready(function(){

var gData = new kendo.data.DataSource({
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
                                        options.model = "Slider";
                                        return options;

                                    }else{
                                      if(options.s_use === false){
                                          options.s_use = 0;
                                      }
                                      options.model = "Slider";
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
                                        s_type: { editable: true   },
                                        path: { editable: true  },
                                        alternate : { editable: true  },
                                        sort : {type:"number" , editable: true , validation: { min: 1},defaultValue: 1}
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
                      $sgrid.cancelChanges();
                  }
              });

                    $("#s_grid").kendoGrid({
                        dataSource:gData ,
                        toolbar: ["create"],
                        sortable: {
                              mode: "single",
                              allowUnsort: false
                          },
                        pageable: true,
                        // filterable: true,
                        columns: [{
                                field: "path",
                                title: "图片",
                                template:function(data){
                                  if(data.a_path!==""){
                                      return "<img src = '" + data.path + "' height='60' >";
                                  }else{
                                      return "";
                                  }
                                 },
                                editor: imageUploadEditor 
                            },{
                              field: "s_type",
                              title: "所属",
                              editor: typeDropDownEditor 
                            },{
                              field: "alternate",
                              title: "描述"
                            },{
                              field: "sort",
                              title: "排序"
                            },{ 
                              command: [ "edit", "destroy"], title: "&nbsp;", width: "160px" 
                          }],
                       editable:"popup"
                    });

          var $sgrid = $("#s_grid").data("kendoGrid");

    function imageUploadEditor(container, options){
            $('<input type="file" name="files"  />')
                .appendTo(container)
                .kendoUpload({
                   async: {
                    saveUrl: '<?php echo $this->Html->url(array(
                                        "controller" => "admin",
                                        "action" => "uploader"
                                         )) ?>',
                    autoUpload: true
                        },
                    success : function( e ){
                        options.model.set("path" , e.response.file);
                    }
                });
        }

       function typeDropDownEditor(container, options){

          var d_val = options.model.s_type ? options.model.s_type : "Home";
            $('<input required  data-bind="value:' + options.field + '"/>')
                .appendTo(container)
                .kendoDropDownList({
                    dataSource: {
                        data :  [
                            { val: "Home", text: "Home" },
                            { val: "Shop", text: "Shop" },
                            { val: "Resource", text: "Resource" },
                            { val: "About", text: "About" }
                          ]
                    },
                    value : { val: d_val, text: d_val },
                    dataTextField: "text",
                    dataValueField: "val"
                });
                 options.model.set( options.field, d_val);
        }


        /**
         *  message
         */
        
        var mData = new kendo.data.DataSource({
                            transport: {
                                read:  {
                                    url: "<?php echo $this->Html->url(array(
                                    "controller" => "admin",
                                    "action" => 'read'
                                     )) ?>",
                                    dataType: "json"
                                  
                                },
                                parameterMap: function(options, operation) {
                                       if (operation === "read" ) {
                                        /**
                                         * [tmp for IE]
                                         * @avoid 302
                                         */
                                        options.tmp = new Date().getTime();
                                        options.model = "Message";
                                        
                                        return options;
                                    }
                              }
                            },
                            serverPaging: true,
                            serverFiltering: true,
                            serverSorting: true,
                            pageSize: 5,
                            schema: {
                                data : function(res){
                                  return  res.data;
                                },
                                total: "total",
                                model: {
                                    id: "id",
                                    fields: {
                                      id : { editable: false },
                                        user: { editable: false   },
                                        email: { editable: false  },
                                        message : { editable: false  },
                                        m_date : {editable: false }
                                    }
                                }
                            }
              });

   $("#m_grid").kendoGrid({
                        dataSource:mData ,
                        sortable: {
                              mode: "single",
                              allowUnsort: false
                          },
                        pageable: true,
                        // filterable: true,
                        columns: [{
                                field: "user",
                                title: "用户名称"
                            },{
                              field: "email",
                              title: "邮箱"
                            },{
                              field: "message",
                              title: "消息主题"
                            },{
                              field: "m_date",
                              title: "发布时间"
                            }]
                    });
});


</script>