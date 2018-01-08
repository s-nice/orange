<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="right_search">
                <form  id="js_search_form" method="get" action="{:U('Appadmin/HotelAccessCard/index','',false)}">
                    <input type="hidden" name="sort" value="{$params['sort']}">
                <input  class="s_key" type="text"  placeholder="输入加密类型名称" name="keyword"
                <if condition="isset($params['keyword'])"> value="{$params['keyword']}"</if>>
                <div class="select_time_c">
                    <span class="span_name">时间</span>
                    <div class="time_c">
                        <input id="js_begintime" class="time_input" readonly="readonly" type="text" name="startTime" <if condition="isset($params['startTime'])"> value="{$params['startTime']}"</if> />
                        <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                    </div>
                    <span>--</span>
                    <div class="time_c">
                        <input id="js_endtime" class="time_input" readonly="readonly" type="text" name="endTime" <if condition="isset($params['endTime'])"> value="{$params['endTime']}"</if> />
                        <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                    </div>
                </div>
                <div class="serach_but">
                    <input id="js_search" class="butinput cursorpointer" type="submit" value="" />
                </div>
                    </form>
            </div>
            <div class="section_bin rule_btn" style="margin-bottom:8px;">
                <button type="button" id="js_add">添加</button>
           <!--     <button type="button">导入</button>-->
            </div>
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
            <div class="agreement_list userpushlist_name js_list_name_title">
                <span class="span_span11"></span>
            	<span class="span_span1 hand" order='id'>
                	<u>ID</u>
                </span>
                <span class="span_span2">加密类型名称</span>
            	<span class="span_span8 hand" >
           	    	<u>添加时间</u>
                         <if condition=" $params['sort'] eq 'asc'">
                             <em class="list_sort_asc js_sort" type="asc"  ></em>
                             <else/>
                             <em class="list_sort_desc js_sort" type="desc"  ></em>
                         </if>
            	</span>
                <span class="span_span7">操作</span>
            </div>
            <if condition="isset($data) && $data['status'] eq 0">
                <if condition="$data['data']['numfound'] gt 0">
                    <volist name="data['data']['list']" id="list">
                        <div class="agreement_list userpushlist_c checked_style list_hover js_x_scroll_backcolor">
                            <span class="span_span11"></i></span>
                            <span class="span_span1">{$list.id}</span>
                            <span class="span_span2 " title="{$list.name}">{$list.name}</span>
                            <span class="span_span8" title="{:date('Y-m-d H:i',$list['createtime'])}">{:date('Y-m-d H:i',$list['createtime'])}</span>
            	            <span class="span_span7">
                                <em class="hand js_edit" data-id="{$list.id}" data-name="{$list.name}" data-key="{$list.key}">修改</em>  |
                                 <em class="hand js_del" data-id="{$list.id}">删除</em>
            	             </span>
                        </div>
                    </volist>
                    <else/>
                    NO DATA
                </if>
            </if>
            <div class="appadmin_pagingcolumn">
                <!-- 翻页效果引入 -->
                <include file="@Layout/pagemain" />
            </div>
        </div>
    </div>
</div>
<!--门禁卡加密类型弹框-->
<div class="oraq-dialog " style="display:none;" id="js_add_wrap">
	<div class="input-i">
		<input class="input-text js_name_input" type="text" placeholder="加密类型名称" >
	</div>
	<div class="input-i">
		<textarea class="input-area js_key_input" name="" id="" cols="30" rows="10"  placeholder="秘钥"></textarea>
	</div>
	<div class="q-btn">
		<button class="middle_button" type="button"  id="js_add_confirm">确定</button>
		<button class="middle_button" type="button" id="js_add_cancel">取消</button>
	</div>
</div>

<!--酒店BSSID弹框-->
<div class="bssid-dialog" style="display:none;">
	<div class="menu-float">
		<div class="dai-menu-list dia-span-width">
	        <span>发卡单位:</span>
	        <div class="list-card">
	            <input type="text" value="希尔顿酒店" readonly="readonly" />
	            <img class="dia-xia" src="__PUBLIC__/images/shoppingcart_select.jpg" alt="">
	            <ul>
	                <li>希尔顿酒店</li>
	            </ul>
	        </div>
	    </div>
	    <div class="dai-menu-list dia-span-width">
	        <span>酒店名称:</span>
	        <div class="list-card">
	            <input type="text" value="希尔顿酒店" readonly="readonly" />
	            <img class="dia-xia" src="__PUBLIC__/images/shoppingcart_select.jpg" alt="">
	            <ul>
	                <li>希尔顿酒店</li>
	            </ul>
	        </div>
	    </div>
	</div>
	<div class="menu-float">
		<div class="dai-menu-list dia-span-width">
	        <span>BSSID:</span>
	        <div class="list-card">
	            <input type="text" value="希尔顿酒店" />
	        </div>
	    </div>
	    <div class="dai-menu-list dia-span-width">
	        <span>SSID:</span>
	        <div class="list-card">
	            <input type="text" value="希尔顿酒店" />
	        </div>
	    </div>
	    <div class="add-btn-b">
			<span class="add-span">+</span>
			<span class="let-span">-</span>
	    </div>
	</div>
	<div class="q-btn q-btn-margin">
		<button class="middle_button" type="button"  id="js_add_confirm">确定</button>
		<button class="middle_button" type="button" id="js_add_cancel">取消</button>
	</div>
</div>

<script>
    var  doUrl ="{:U('Appadmin/HotelAccessCard/doOne','','','',true)}";
  $(function(){
      $.dataTimeLoad.init();//日历插件
      $.hotelCard.init();
  })
</script>