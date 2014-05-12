<h2 class='a-title-en'>Store</h2>

<div class='a-wrapper'>
 
  <div class='a-section'>
    <h3>店铺信息</h3>
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
							            "action" => 'readSt'
							             )) ?>",
                                    dataType: "json",
                                  
                                },
                                update: {
                                    url: "<?php echo $this->Html->url(array(
							            "controller" => "admin",
							            "action" => 'updateSt'
							             )) ?>",
									dataType: "jsonp",
									type:"POST"
                                },
                                destroy: {
                                    url: "<?php echo $this->Html->url(array(
							            "controller" => "admin",
							            "action" => 'destroySt'
							             )) ?>",
									dataType: "jsonp",
                                    type:"POST"
                                },
                                create: {
                                    url: "<?php echo $this->Html->url(array(
							            "controller" => "admin",
							            "action" => 'createSt'
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
                                        var date = options.s_join_date;
                                        options.s_join_date = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate() + " "+ date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
                                        console.log(options);
                                        console.log( options.s_join_date );
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
                                        s_name: { editable: true  , validation: { required: true } },
                                        s_city: { editable: true  , validation: { required: true } },
                                        s_address: { editable: true  , validation: { required: true } },
                                        s_area : { editable: true  , validation: { required: true } },
                                        s_link: {  editable: true  },
                                        s_image: { editable: true  },
                                        s_join_date: { editable: true ,  type: "date"  },
                                        s_description : {editable: true}
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
                            field : "s_name",
                            title : "店铺名称"
                        },{
                            field: "s_city",
                            title: "城市"
                        },{
                            field: "s_address",
                            title: "地址"
                        }, {
                            field: "s_area",
                            editor: areaDropDownEditor, 
                            title: "地区",
                            template : function(data){
                                return area[data.s_area];
                            }
                        }, {
                            field: "s_link",
                            title: "链接",
                            template: function( data ){
                                if(data.s_link!==''){
                                    return "<a href='"+ data.s_link +"' >点我查看</a>";
                                }else{
                                    return "";
                                }
                            }
                        }, {
                            field: "s_image",
                            title: "图片",
                            editor: imageUploadEditor, 
                            template:function(data){
                                if(data.s_image!==""){
                                    return "<img src = '../" + data.s_image + "' height='60' >";
                                }else{
                                    return "";
                                }
                            }
                        },{
                            field: "s_description",
                            title: "描述"
                        },{
                            field: "s_join_date",
                            title: "加入日期",
                            format: "{0:MM/dd/yyyy}"
                        },{ 
                        	command: [ "edit", "destroy"], title: "&nbsp;", width: "160px" 
                    	}],
                    	editable: "popup"
                    });

		var grid = $("#grid").data("kendoGrid");
        var area = {
                "hd": "华东区" ,
                "hz": "华中区" ,
                "hn": "华南区" ,
                "hb": "华北区" ,
                "db": "东北区" ,
                "xn": "西南区" ,
                "xb": "西北区" 
                    };
        function areaDropDownEditor(container, options){
            $('<input required  data-bind="value:' + options.field + '"/>')
                .appendTo(container)
                .kendoDropDownList({
                    dataSource: {
                        data :  [
                            { val: "hd", text: "华东区" },
                            { val: "hz", text: "华中区" },
                            { val: "hn", text: "华南区" },
                            { val: "hb", text: "华北区" },
                            { val: "db", text: "东北区" },
                            { val: "xn", text: "西南区" },
                            { val: "xb", text: "西北区" },
                          ]
                    },
                    value : { val: "hb", text: "华东区" },
                    dataTextField: "text",
                    dataValueField: "val"
                });
                 options.model.set( options.field, "hd");
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
                        options.model.set("s_image" , e.response.file);
                    }
                });

        }

 });
</script>