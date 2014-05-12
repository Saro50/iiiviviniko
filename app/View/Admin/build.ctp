
<div class='a-wrapper'>

  <h2 class='a-title-1'><?php echo $site["title"]; ?></h2>
  <h3 class='a-title-2'>新增子栏目</h3>
  <form id='t_form' onsubmit='return false;'>
    <ul class='a-list-form'>
        <li>
            <label>标题 : </label>
            <input type ='text' class="k-textbox" required pattern="[^\@]{0,20}" validationMessage="必填项,最长只能输入20个字符,可以包含空格，但不能包含@符号" name ='title'>
  
            <span class="k-invalid-msg" data-for="title"></span>
        </li>
        <li>
             <label><span class='k-icon k-i-note'></span></label><span class='a-tips'>栏目的标题</span>
        </li>   
        <li>
            <label>类型 : </label>
            <select id="type" name = 'type'>
               <option value='list'>列表</option>
               <option value='gallery'>图片长廊</option>
               <option value='blog'>博客</option>
            </select>
       </li>
       <li>
          <label><span class='k-icon k-i-note'></span></label>
           <span class='a-tips'>栏目内容的展示类型，现有3种类型，<span>列表类型</span>适用于发布新闻信息，<span>图片长廊</span>适用于发布多产品图片，<span>博客类型</span>适用于描述性内容</span>
       </li>
       <li>
          <label>描述 : </label>
          <textarea name = 'description' class='k-textbox'></textarea>
       </li>
        <li>
          <label><span class='k-icon k-i-note'></span></label>
           <span class='a-tips'>栏目描述</span>
       </li>
       <li>
        <label>是否启用 : </label>
          <select id="use" name = 'use'>
               <option value='1'>是</option>
               <option value='0'>否</option>
          </select>
       </li>
         <li>
          <label><span class='k-icon k-i-note'></span></label>
           <span class='a-tips'>启用栏目，可以使得栏目出现在网站上,不启用栏目将不会出现</span>
       </li>
       <li>
            <button style='margin-left:85px;' data-action='submit' data-form = 't_form' class='k-button'>增加</button>
       </li>
     </ul>
    </form> 
<h3 class='a-title-2'>新增栏目</h3>
    <div class='a-tips-panel'><span class='k-icon k-i-note'></span>提示
        <div class='tips-panel'>
            <ul class='a-list-in'>
                <li>
                    <label><span class='k-icon k-i-cancel'></span></label><span  class='a-tips'>符号表示此栏目未被启用</span></li>
                <li>
                    <label><span class='k-icon  k-i-tick'></span></label><span class='a-tips'>符号表示此栏目被启用</span>
                </li>
            </ul>
        </div>
    </div>


    <ul class='a-list-topic' id='t_list'>
  <?php
    if( count($topics) == 0 ):
  ?> 
   <li><span  class='a-tips'><span class='k-icon k-i-note'></span>暂无栏目!</span></li>
<?php 
 else:
 ?>

      <?php
        foreach ($topics as $val):
      ?>
        <li>
          <span class='k-icon <?php  echo $val['Subject']['s_use'] == 1 ?'k-i-tick' : 'k-i-cancel'; ?>'></span>
          <a href="?s=<?php echo $val['Subject']['s_id']; ?>"><?php  echo $val['Subject']['s_title']; ?></a>
          <?php if($val['Subject']['s_description'] !== ""): ?>
          <span  class='a-tips'><span class='k-icon k-i-note'></span><?php  echo $val['Subject']['s_description']; ?></span>
          <?php  endif; ?>
        </li>

      <?php
        endforeach;
        endif;
      ?>
    </ul>
    <div class='a-pager' >
      <?php
          echo $this->Paginator->numbers(array("separator"=>""));
      ?>
    </div>
</div>
<script type="text/x-kendo-template" id="template">
    <li>
      <span class="k-icon # if(use== '1'){ # k-i-tick # } else {# k-i-cancel # } #"></span>
      <a href='?#= id #'>#= title #</a>
      #if( description !== ""){#
      <span  class="a-tips"><span class="k-icon k-i-note"></span>#= description #</span>
      #} #
    </li>
</script>

          <script>
                $(document).ready(function() {
                    $("#type").kendoDropDownList();
                    $("#use").kendoDropDownList();
                    var $K_tpl = kendo.template($("#template").html());

                  var validator = $("#t_form").kendoValidator().data("kendoValidator");

                    VI.addEvent("click","submit" , function(){
                        if( validator.validate() ){
                          var d =  VI.Util.serialize($("#t_form")[0] );
                          $.ajax({
                            url : "<?php echo $this->Html->url(array(
                            "controller" => "admin",
                            "action" => "addTopic"
                             )) ?>",
                            type : 'post',
                            data : d ,
                            dataType: "json",
                            sendBefore: function(){
                              alert(1);
                            },
                            success : function( response ){
                              var msg = "", p;
                              if(response.status == 0){
                                msg = response.msg;
                                var df = document.createElement("div");
                                df.innerHTML = $K_tpl(response.data);
                                var list = $("#t_list")[0];
                                console.log( response  );
                                list.insertBefore(df , list.children[0] );


                              }else{
                                  for( p in response.msg){
                                  msg += p + " : " + response.msg[p] ;
                                }
                              }
                              alert(msg);
                            }
                          });
                        }else{
                          return ;
                        }
                      });


                  // var crudServiceBaseUrl = "http://demos.kendoui.com/service",
                  //       dataSource = new kendo.data.DataSource({
                  //           transport: {
                  //               read:  {
                  //                   url: "",
                  //                   dataType: "jsonp"
                  //               },
                  //               update: {
                  //                   url:"",
                  //                   dataType: "jsonp"
                  //               },
                  //               destroy: {
                  //                   url: crudServiceBaseUrl + "/Products/Destroy",
                  //                   dataType: "jsonp"
                  //               },
                  //               parameterMap: function(options, operation) {
                  //                   if (operation !== "read" && options.models) {
                  //                       return {models: kendo.stringify(options.models)};
                  //                   }
                  //               }
                  //           },
                  //           batch: true,
                  //           pageSize: 10,
                  //           schema: {
                  //               model: {
                  //                   id: "id",
                  //                   fields: {
                  //                       id: { editable: false, nullable: true },
                  //                       title: { validation: { required: true } },
                  //                       type: { type: "number", validation: { required: true, min: 1} },
                  //                       Discontinued: { type: "boolean" },
                  //                       UnitsInStock: { type: "number", validation: { min: 0, required: true } }
                  //                   }
                  //               }
                  //           }
                  //       });

                  //   $("#grid").kendoGrid({
                  //       dataSource: dataSource,
                  //       pageable: true,
                  //       height: 430,
                  //       columns: [
                  //           { field:"ProductName", title: "Product Name" },
                  //           { field: "UnitPrice", title:"Unit Price", format: "{0:c}", width: "100px" },
                  //           { field: "UnitsInStock", title:"Units In Stock", width: "100px" },
                  //           { field: "Discontinued", width: "100px" },
                  //           { command: ["edit", "destroy"], title: "&nbsp;", width: "160px" }],
                  //       editable: "popup"
                  //   });
       
                });
            </script>