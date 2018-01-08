<if condition="$type eq 2">
  <style>
    .select_option {
        width: 105px;
        margin-right: 10px;
    }
  </style>
</if>
<form class="form_marginauto js_search_form"  method='get'>
      <div class="content_search">
        <div class="search_right_c">
        <if condition="$stat_types[$type]['hasSys']">
        <div class="js_sys select_IOS menu_list input_s_width select_option js_s_div">
            <input type="text" name="sys" value="全部系统平台"  readonly="readonly"  disabled="disabled" alltext='全部系统平台' autocomplete='off'/>
            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        <b></b>
                        <input type="hidden" name="platform" value="{$sys_str}" autocomplete='off'>
            <ul class="js_scroll_list" style="max-height:300px;overflow:hidden;">
                  <li title="全部" val="all"><label><input  class="js_i_sys" type="checkbox" >全部</label></li>
                              <foreach name="syss" item="v">
                              <li title="{$v}"><label><input type="checkbox"  value="{$v}" autocomplete='off'<if condition="in_array($v,$sys_check)">checked="checked"</if>>{$v}</label></li>
                              </foreach>
            </ul>
          </div>
        </if>
        <if condition="$stat_types[$type]['hasSoft']">
                  <div class="js_proversion select_IOS menu_list select_option input_s_width js_s_div">
            <input type="text" value="{:$_GET['s_versions']?$_GET['s_versions']:'全部软件版本'}" name='sysPlatform' readonly="readonly"  disabled="disabled" alltext='全部软件版本' autocomplete='off'/>
            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        <b></b>
                        <input type="hidden" name="s_versions" value="{$s_versions_name}" autocomplete='off'>
            <ul class="js_scroll_list" style="max-height:300px;overflow:hidden;">
                              <li title="全部" val="all"><label><input  class="js_i_s" type="checkbox" >全部</label></li>
                              <foreach name="s_versions" item="v">
                              <li title="{$v}"><label><input type="checkbox" value="{$v}" autocomplete='off' <if condition="in_array($v,$s_versions_check)">checked="checked"</if>>{$v}</label></li>
                              </foreach>
            </ul>
          </div>
          </if>
          
          <if condition="$stat_types[$type]['hasFrom']">
                  <div class="select_option select_IOS js_s_div" style="width:100px;">
            <input type="text" value="全部渠道" name='from' readonly="readonly"  disabled="disabled" alltext='全部渠道' autocomplete='off'/>
            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        <b></b>
                        <input type="hidden" name="choose_from" value="{$from_str}" autocomplete='off'>
            <ul class="js_scroll_list" style="max-height:300px;overflow:hidden;">
                              <li title="全部" val="all"><label><input  class="js_i_f" type="checkbox" >全部</label></li>
                              <foreach name="froms" item="v">
                              <li title="{$v}"><label><input type="checkbox" value="{$v}" autocomplete='off' <if condition="in_array($v,$from_check)">checked="checked"</if>>{$v}</label></li>
                              </foreach>
            </ul>
          </div>
          </if>
          <if condition="$stat_types[$type]['hasArea']">
                  <div class="select_option select_IOS js_s_div" style="width:100px;">
            <input type="text" value="全部省份" name='area' readonly="readonly"  disabled="disabled" alltext='全部省份' autocomplete='off'/>
            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        <b></b>
                        <input type="hidden" name="choose_area" value="{$area_str}" autocomplete='off'>
            <ul class="js_scroll_list" style="max-height:300px;overflow:hidden;">
                              <li title="全部" val="all"><label><input  class="js_i_a" type="checkbox" >全部</label></li>
                              <foreach name="areas" item="v">
                              <li title="{$v}"><label><input type="checkbox" value="{$v}" autocomplete='off' <if condition="in_array($v,$area_check)">checked="checked"</if>>{$v}</label></li>
                              </foreach>
            </ul>
          </div>
          </if>
             <div class="select_time_c">
                            <span>{$T->str_time}</span>
                            <if condition="$stat_types[$type]['hasEndTime']">
                              <div class="time_c">
                                    <input id="js_begintime" class="time_input" type="text" name="startTime"  readonly="readonly" value="{$startTime}" autocomplete='off'/>
                                    <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                              </div>
                              
                              <span>--</span>
                            </if>
                              <div class="time_c">
                                    <input id="js_endtime" class="time_input" type="text" name="endTime" readonly="readonly" value="{$endTime}" autocomplete='off'/>
                                    <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                              </div>
                              
                  </div>
              <input class="submit_button" type="submit" value="{$T->str_submit}"/>
        </div>
      </div>        
</form>
<link href="__PUBLIC__/js/jsExtend/datetimepicker/datetimepicker.css" rel="stylesheet" text="text/css">
<script src="__PUBLIC__/js/jsExtend/datetimepicker/datetimepicker.js"></script>
<if condition="$stat_types[$type]['hasEndTime']">
  <script>
    $(function(){
      $.dataTimeLoad.init({format:'Y-m-d',timepicker : false});
    });
  </script>
<else />
  <script>
    $(function(){
      $('#js_endtime').datetimepicker({format:'Y-m-d'});
    });
  </script>
</if>
<script>   
$(function(){
  //下拉框添加滚动条
  $('.js_scroll_list').mCustomScrollbar({
      theme:"dark", //主题颜色
      autoHideScrollbar: false, //是否自动隐藏滚动条
      scrollInertia :0,//滚动延迟
      horizontalScroll : false,//水平滚动条
  });
  
  //点击区域外关闭此下拉框
    $(document).on('click',function(e){
        if(!$(e.target).parents('.js_s_div').length){
            $('.js_s_div>ul').hide();
        }
    });

    //下拉
    $('.js_s_div').on('click',function(e){
        if(!$(e.target).parents('ul').length){
            $(this).find('ul').toggle();
        }
    });
    
  $('.js_s_div').each(function(){
    //全选
    var $all=$(this).find('ul input:first');
    $all.on('click', function(){
      var $ul=$(this).parents('ul');
      $ul.find('input').prop('checked', $(this).prop('checked'));
      setValues($ul);
      if($(this).parents('.js_sys').length&&($('.js_proversion').length)){
          checkProversion();
      }
    });

    //单选
    var $items=$(this).find('ul input:gt(0)');
    $items.on('click', function(){
      setValues($(this).parents('ul'));
      if($(this).parents('.js_sys').length&&($('.js_proversion').length)){
          checkProversion();
      }
    });

    //加载时是否全选
    var hiddenVal=$(this).find('input:eq(1)').val();
    if (hiddenVal=='' || (hiddenVal.split(',').length==$items.length)){
      $all.prop('checked',false);
      $all.click(); 
    }
  });

    //赋值
  function setValues($ul){
    var isAllChecked=true;
    var val=[];
    $ul.find('input:gt(0)').each(function(){
      if ($(this).prop('checked')){
        val.push($(this).val());
      } else {
        isAllChecked=false;
      }
    });

     $ul.find('input:first').prop('checked', isAllChecked);
      if (isAllChecked){
        var $input=$ul.parent().find('input:eq(0)');
        $input.val($input.attr('alltext'));
    } else {
      var otherUl  = $ul.parents('.js_s_div').siblings('.js_s_div').find('ul');
      otherUl.find('input').prop('checked',true);
      $.each(otherUl,function(k,v){
         setValues($(this));
      });
      var textVal=val.join(',');
      $ul.parent().find('input:eq(0)').val(textVal);
      $ul.parent().attr('title',textVal);
    }
      $ul.parent().find('input:eq(1)').val(val.join(','));
  }

  //检验选择的的哪个系统，并显示隐藏对应的软件版本
  function checkProversion(){
    $('.js_sys ul li input').each(function(){
      var title = $(this).parents('li').attr('title');
      if(title=='iOS'){
        if($(this).prop('checked')){
          $(".js_proversion ul li[title^='iOS']").show();
        }else{
          $(".js_proversion ul li[title^='iOS']").hide();
        }
      }else if(title=='android'){
        if($(this).prop('checked')){
          $(".js_proversion ul li[title^='A']").show();
        }else{
          $(".js_proversion ul li[title^='A']").hide();
        }
      }
    })
  }
});
</script>