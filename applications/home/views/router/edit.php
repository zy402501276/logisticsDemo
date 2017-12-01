<div class="right-side fr">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    ));
    ?>
            <div class="right-first">
                <input type="text" name="detail" placeholder="搜索地址关键字" class="inp" style="width: 870px;margin-right: 20px;" value=""/>
                <button class="btn add-btn" id="searchDetail" type="button"  style="margin-left: -15px;">搜索</button>
            </div>

            <table style="margin-top: 20px;" class="address-table" id="search_address">
                <tr>
                    <th>标签</th>
                    <th>地址</th>
                    <th>公司名称</th>
                    <th>操作</th>
                </tr>
            </table>
            <div class="clearfix center"></div>
            <table style="margin-top: 20px;" class="address-table add_address" >

            </table>
            <div class="right-first">
                <?php echo $form->textField($model, 'name',array('placeholder'=>'请填写线路名称','class'=>'inp','style'=>'width: 644px;margin-right: 20px;float: left;'));?>
                <div class="radio-form fs14 fr">
                    <label><span class="check-icon"></span><input name="type" type="radio" value="1"/>高速 </label>
                    <label><span class="check-icon"></span><input name="type" type="radio" value="2"/>普通 </label>
                    <label><span class="check-icon"></span><input name="type" type="radio" value="3"/>不限制 </label>
                </div>
            </div>
            <div class="foot">
                <button class="btn"  id="save">保存</button>
            </div>
    <?php $this->endWidget();?>
</div>
<?php
$url = url('router/searchaddress');
$urlAddRouter = url('router/addRouter');
$js = <<<js
     function addressArr(){
            var checkedList = new Array();   
            $("input[name='addressId[]']").each(function() {   
                checkedList.push($(this).val());   
            }); 
            return checkedList;
     }
     $('#save').click(function() {
         var type = $('input:radio[name="type"]:checked').val();
         if( type != null){
              var routerName = $("[name='RouterForm[name]']").val();
              routerName = $.trim(routerName); // 用jQuery的trim方法删除前后空格
              if( routerName== ''){
                  $('#del_content').html('请填写线路名称');
                  $('.pop5').show();    
                  return false;
                 }
                 
              if ($('.add_address tr').length > 0) {
                  $("#save").submit()  ;
               }else{
                  $('#del_content').html('请先添加路线');
                  $('.pop5').show();    
                  return false;
               }
         }else{
                  $('#del_content').html('请选择路面类型');
                  $('.pop5').show();    
                  return false; 
         }

     })

     //搜索地址
     $(document).on("click", "#searchDetail", function(){
        var detail = $("[name='detail']").val();
         $.get("{$url}", {"detail":detail}, function(callbackData){
                 $("#address_detail").remove();   
                 $("#search_address ").append(callbackData);
          });
       
    });
    
   	$("label").each(function() {
		$(this).click(function() {
			$(this).children('.check-icon').addClass('checkbox');
			$(this).addClass('checkcolor');
			
			$(this).siblings().children('.check-icon').removeClass('checkbox');
			$(this).siblings().removeClass('checkcolor');
		})

	});

         //添加路线_起始点
   	   $(document).on("click", "#type_1", function(){
     	    var addressArray = addressArr();
   	        var id = $(this).parent().siblings("#addressId").val();
   	        console.log(addressArray,id);
   	        var index = $.inArray(id,addressArray);
   	        if(index >= 0){
   	            return false; 
   	        }else {
   	             var type = 1;
   	             $.get("{$urlAddRouter}", {"id":id,"type":type}, function(callbackData){
   	             $('#router_begin').remove();
   	             $('.add_address').prepend(callbackData);
          });
   	        }
   	      
   	        
   	   });
   	   //添加路线_途径点
   	   $(document).on("click", "#type_2", function(){
   	   	     var addressArray = addressArr();
   	        var id = $(this).parent().siblings("#addressId").val();
   	        console.log(addressArray,id);
   	        var index = $.inArray(id,addressArray);
   	        if(index >= 0){
   	            return false;
   	        }else {
   	            var type = 2;
                if( $('#router_begin').length>0){
                     $.get("{$urlAddRouter}", {"id":id,"type":type}, function(callbackData){
                         if($('.router_middle').length>0){
                             $('.router_middle').last().after(callbackData);
                         }else{
                              $('#router_begin').after(callbackData);
                         }
                     });
                }else{
                    //改样式~
                    alert('请先添加起点');
                }   
   	        }

   	   });
   	   //添加路线_终点
   	   $(document).on("click", "#type_3", function(){
   	        var addressArray = addressArr();
   	        var id = $(this).parent().siblings("#addressId").val();
   	        console.log(addressArray,id);
   	        var index = $.inArray(id,addressArray);
   	        if(index >= 0){
   	            return false;
   	        }else {
   	             var type = 3;
                if( $('#router_begin').length>0){
                     $.get("{$urlAddRouter}", {"id":id,"type":type}, function(callbackData){
                         if($('.router_middle').length>0){
                             $('#router_finish').remove();
                             $('.router_middle').last().after(callbackData);
                         }else{
                              $('#router_finish').remove();
                              $('#router_begin').after(callbackData);
                         }
                     });
                }else{
                    //改样式~
                    alert('请先添加起点');
                }   
   	        }

   	   });
    	   
   	   //路线_下调
   	   $(document).on("click", ".address_next", function(){
   	       var addressArray = addressArr();
   	       if(addressArray.length ==1){
   	            return;   
   	       }
   	       var nextObj = $(this).parent().parent().parent().next();
            if( nextObj){
                var tag = $(this). parent().parent().siblings().find('.tag').html();
                var detail = $(this). parent().parent().siblings().find('.detail').html();
                var id = $(this). parent().parent().siblings().find("[name='addressId[]']").val();
                
                var tag_next = nextObj.children().find('.tag').html();
                var detail_next = nextObj.children().find('.detail').html();
                var id_next = nextObj.children().find("[name='addressId[]']").val();
                
                $(this). parent().parent().siblings().find('.tag').html(tag_next);
                $(this). parent().parent().siblings().find('.detail').html(detail_next);
                $(this). parent().parent().siblings().find("[name='addressId[]']").val(id_next);
                
                nextObj.children().find('.tag').html(tag);
                nextObj.children().find('.detail').html(detail);
                nextObj.children().find("[name='addressId[]']").val(id);
            }   	        
   	   });
   	   //路线_上调
   	   $(document).on("click", ".address_prev", function(){
   	       var prevObj = $(this).parent().parent().parent().prev();
            if( prevObj){
                var tag = $(this). parent().parent().siblings().find('.tag').html();
                var detail = $(this). parent().parent().siblings().find('.detail').html();
                var id = $(this). parent().parent().siblings().find("[name='addressId[]']").val();
                
                var tag_prev = prevObj.children().find('.tag').html();
                var detail_prev = prevObj.children().find('.detail').html();
                var id_prev = prevObj.children().find("[name='addressId[]']").val();
                
                $(this). parent().parent().siblings().find('.tag').html(tag_prev);
                $(this). parent().parent().siblings().find('.detail').html(detail_prev);
                $(this). parent().parent().siblings().find("[name='addressId[]']").val(id_prev);
                
                prevObj.children().find('.tag').html(tag);
                prevObj.children().find('.detail').html(detail);
                prevObj.children().find("[name='addressId[]']").val(id);
            }   	        
   	   });
js;
cs()->registerScript('routerEdit', $js, CClientScript::POS_END);
?>