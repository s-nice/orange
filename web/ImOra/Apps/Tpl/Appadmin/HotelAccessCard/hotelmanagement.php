
<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="right_search">
                <form id="js_search_form" method="get" action="{:U('Appadmin/HotelAccessCard/hotelmanagement','',false)}">
                    <input type="hidden" name="sort" value="{$params['sort']}">
                    <input style="width:130px;"  class="s_key" type="text"  placeholder="输入酒店名称" name="keyword"
                    <if condition="isset($params['keyword'])"> value="{$params['keyword']}"</if>/>
                    <input style="width:130px;" type="text" placeholder="请输入城市" class="s_key" name="keyword3"
                    <if condition="isset($params['keyword3'])"> value="{$params['keyword3']}"</if>
                    />
                    <input style="width:130px;"  class="s_key" type="text"  placeholder="输入发卡单位" name="keyword2"
                    <if condition="isset($params['keyword2'])"> value="{$params['keyword2']}"</if>/>
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
                <a href="{:U('Appadmin/HotelAccessCard/addHotel','','','',true)}" target="_blank"><button type="button">添加</button></a>
               <a href="{:U('Appadmin/HotelAccessCard/importPage','','','',true)}" target="_blank"><button type="button">导入</button></a>
            </div>
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
            <div class="agreement_list userpushlist_name js_list_name_title">
            	<span class="span_span1 hand" order='id'>
                	<u>酒店名称</u>
                </span>
                <span class="span_span10">发卡单位</span>
                <span class="span_span10">城市</span>
                <span class="span_span3">门禁卡加密类型</span>
            	<span class="span_span1 hand" >
           	    	<u>添加时间</u>
                         <if condition=" $params['sort'] eq 'asc'">
                             <em class="list_sort_asc js_sort" type="asc"   ></em>
                             <else/>
                             <em class="list_sort_desc js_sort" type="desc"   ></em>
                         </if>

            	</span>
                <span class="span_span1">操作</span>
            </div>
            <if condition="isset($data) && $data['status'] eq 0">
                <if condition="$data['data']['numfound'] gt 0">
                    <volist name="data['data']['list']" id="list">
                        <div class="agreement_list userpushlist_c checked_style list_hover js_x_scroll_backcolor">
                            <span class="span_span1" title="{$list.name}">{$list.name}</span>
                            <span class="span_span10" title="{$list.unitname}">{$list.unitname}</span>
                            <span class="span_span10" title="{$list.city}">{$list.city}</span>
                            <span class="span_span3"  title="{$list.encryptname}">{$list.encryptname}</span>
                            <span class="span_span1" title="{:date('Y-m-d H:i',$list['createtime'])}">{:date('Y-m-d H:i',$list['createtime'])}</span>
            	            <span class="span_span1">
                                 <em class="hand js_isrec" data-id="{$list.id}" data-isrec="{$list.isrec}">
                                     <if condition="$list['isrec'] eq '1'">取消推荐<else/>推荐</if>
                                 </em>|
                                   <a href="{:U('Appadmin/HotelAccessCard/addHotel',array('id'=>$list['id']),'','',true)}" target="_blank">
                                       <em class="hand js_edit" data-id="{$list.id}">修改</em>|</a>
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
<!--酒店管理弹框-->
<div class="oraq-dialog" style="display:none; " id="js_add_wrap">
    <div class="dai-menu-list js_select clear">
        <span>发卡单位:</span>
        <div class="list-card">
            <input type="text" id="js_unit_input"
                value="{$units[0]['lssuername']}" val="{$units[0]['id']}"
          readonly="readonly" />
            <img class="dia-xia" src="__PUBLIC__/images/icons/appadmin_xiala_icon.png" alt="">
            <ul style="max-height: 300px">
                <volist name="units" id="vo">
                    <li data-id="{$vo.id}">{$vo.lssuername}</li>
                </volist>
            </ul>
        </div>
    </div>
    <div class="dai-menu-list clear">
        <span>酒店名称:</span>
        <div class="list-card">
            <input type="text" name="name" class="js_name_input"/>
        </div>
    </div>
    <div class="city-dia-menu clear">
        <div class="dai-menu-list js_select">
            <span>城市:</span>
            <div class="list-card">
                <input type="text" id="js_province_input"
                    value="{$provinces[0]['province']}" val="{$provinces[0]['provincecode']}"
              readonly="readonly" />
                <img class="dia-xia" src="__PUBLIC__/images/icons/appadmin_xiala_icon.png" alt="">
                <ul style="max-height: 300px">
                    <volist name="provinces" id="vo">
                        <li data-id="{$vo.provincecode}">{$vo.province}</li>
                    </volist>
                </ul>
            </div>
        </div>
        <div class="dai-menu-list js_select">
            <div class="list-card list-card-right">
                <input type="text" id="js_city_input"
                    value="{$provinces[0]['province']}" val=""
              readonly="readonly" />
                <img class="dia-xia" src="__PUBLIC__/images/icons/appadmin_xiala_icon.png" alt="">
                <ul style="max-height: 300px"></ul>
            </div>
        </div>
    </div>
    <div class="dai-menu-list clear">
        <span>门禁卡加密类型:</span>
        <div class="list-card js_select" >
            <input type="text"  readonly="readonly" id="js_encryption_type_input"
                value="{$EncryptionTypes[0]['name']}" val="{$EncryptionTypes[0]['id']}"
         />

            <img class="dia-xia" src="__PUBLIC__/images/icons/appadmin_xiala_icon.png" alt="">
            <ul style="max-height: 300px">
                <volist name="EncryptionTypes" id="vo2">
                    <li data-id="{$vo2.id}">{$vo2.name}</li>
                </volist>
            </ul>
        </div>
    </div>
    <div class="q-btn clear">
        <button class="middle_button" type="button" id="js_add_confirm" >确定</button>
        <button class="middle_button" type="button" id="js_add_cancel">取消</button>
    </div>
</div>
<script>
    var  doUrl ="{:U('Appadmin/HotelAccessCard/doOneHotel','','','',true)}";
    var  gUrl="{:U('Appadmin/HotelAccessCard/hotelmanagement','','','',true)}";
    function closeWindow(object, isReload) //编辑后的刷新页面
    {
        object.close();
        isReload===true  && window.location.reload();
    }
    $(function(){
        $.dataTimeLoad.init();//日历插件
        $.hotelCard.hotelInit();
    })
</script>