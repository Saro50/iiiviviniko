<h2 class='a-title-en'>Activity</h2>

<div class='a-wrapper'>
 
  <div class='a-section'>
    <h3>动态,Activity</h3>
    <div id='grid'>

  	</div>
  </div>



</div> 
<script type="text/javascript">
 $(document).ready(function (){

 	var data = new kendo.data.DataSource({
                            transport: {
                                read:  {
                                    url: "<?php echo $this->Html->url(array(
							            "controller" => "admin",
							            "action" => 'readNe'
							             )); ?>",
                                    dataType: "json",
                                  
                                },
                                update: {
                                    url: "<?php echo $this->Html->url(array(
							            "controller" => "admin",
							            "action" => 'updateNe'
							             )) ?>",
									dataType: "jsonp",
									type:"POST"
                                },
                                destroy: {
                                    url: "<?php echo $this->Html->url(array(
							            "controller" => "admin",
							            "action" => 'destroyNe'
							             )) ?>",
									dataType: "jsonp",
                                    type:"POST"
                                },
                                create: {
                                    url: "<?php echo $this->Html->url(array(
							            "controller" => "admin",
							            "action" => 'createNe'
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
                                        var date = options.a_modified_date;
                                        options.a_modified_date = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate() + " "+ date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
                                        console.log(options);
                                        console.log( options.a_modified_date );
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
                                        a_title: { editable: true  , validation: { required: true } },
                                        a_type : { editable:true , validation: { required: true }},
                                        a_link: {  type: "string" },
                                        a_path : { editable: true  },
                                        a_content: { editable: true  },
                                        a_modified_date: { editable: true ,  type: "date"  },
                                        a_date : {editable: false}
                                    }
                                }
                            },
                            sync :  function(e){
                                this.fetch();
                            }, 
                            error : function(e){
                            		var p,err = e.errors,
                            			mes = "";
								   if(err){
								   		for(p in err)mes += p + " : " + err[p] + "\n";
								   	 		alert(mes);
								   	}
								   	/**
								   	 *  cancelChanges
								   	 */
								   	grid.cancelChanges();
								}
                        });


      $("#grid").kendoGrid({
                        dataSource:data ,
                        toolbar: ["create"],
     					sortable: {
	                            mode: "single",
	                            allowUnsort: false
	                        },
                        pageable: true,
                        // filterable: true,
                        columns: [{
                            field: "a_title",
                            title: "标题",
                            template: "<a data-action='modify' data-title = '#:a_title#' data-id='#:id#'>#:a_title# </a>"
                        }, {
                            field: "a_link",
                            title: "链接",
                            template:function(data){
                                if(data.a_link!==""){
                                    return  "<a href='"+ data.a_link +"' >点我查看</a>";
                                }else{
                                    return "";
                                }
                            }
                        },{
                            field : "a_type",
                            title : "类型" ,
                            editor: typeDropDownEditor, 
                        },{
                            field : "a_path",
                            title : "图片",
                            editor: imageUploadEditor, 
                            template:function(data){
                                if(data.a_path!==""){
                                    return "<img src = '../" + data.a_path + "' height='60' >";
                                }else{
                                    return "";
                                }
                            }
                        }, {
                            field: "a_content",
                             editor: descriptionEditor, 
                            title: "内容"
                        }, {
                            field: "a_modified_date",
                            title: "显示日期",
                            format: "{0:MM/dd/yyyy}"
                        },{
                            field: "a_date",
                            title: "创建日期"
                        },{ 
                        	command: [ "edit", "destroy"], title: "&nbsp;", width: "160px" 
                    	}],
                    	editable: {
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

		var grid = $("#grid").data("kendoGrid");

          function descriptionEditor(container, options){
          $('<textarea name="a_content" rows="10"  style="height:440px;width:600px;" ></textarea>')
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

        function imageUploadEditor(container, options){
            $('<input type="file" name="files"  />')
                .appendTo(container)
                .kendoUpload({
                   async: {
                    saveUrl: "uploader",
                    autoUpload: true
                        },
                    success : function( e ){
                        options.model.set("a_path" , e.response.file);
                    }
                });
        }

       function typeDropDownEditor(container, options){
            $('<input required  data-bind="value:' + options.field + '"/>')
                .appendTo(container)
                .kendoDropDownList({
                    dataSource: {
                        data :  [
                            { val: "ACTIVITY", text: "ACTIVITY" }
                          ]
                    },
                    value : { val: "ACTIVITY", text: "ACTIVITY" },
                    dataTextField: "text",
                    dataValueField: "val"
                });
                 options.model.set( options.field, "ACTIVITY");
        }
 });
</script>