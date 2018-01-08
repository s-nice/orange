<layout name="../Layout/Company/AdminLTE_layout" />
<div class="staff_warp">
    <div class="container_right">
        <div class="staff_table">
            <div class="search_div_no">
                <a href="{:U('customRules')}"><input type="button" value="自定义"></a>
            </div>
            <div class="data-list">
                <div class="list_tab">
                    <span class="col-md-5ths col-xs-5ths border_left">共享组</span>
                    <span class="col-md-5ths col-xs-5ths">成员</span>
                    <span class="col-md-5ths col-xs-5ths">类型</span>
                    <span class="col-md-5ths col-xs-5ths">状态</span>
                    <span class="col-md-5ths col-xs-5ths">操作</span>
                </div>
                <foreach name="list" item="val">
                    <div class="list_tab_c">
                        <span class="col-md-5ths col-xs-5ths border_left">{$val['name']}</span>
                        <span class="col-md-5ths col-xs-5ths">{$val['num']|default=0}人</span>
                        <span class="col-md-5ths col-xs-5ths">
                            <if condition="$val['type'] eq 1">
                                部门
                                <else />
                                自定义
                            </if>
                        </span>
                    <span class="col-md-5ths col-xs-5ths" data-key="{$val['departid']}">
                        <if condition="$val['status'] eq 1">
                            <switchbtn class="js_open css_open">开启</switchbtn>
                            <switchbtn class="js_close css_close">关闭</switchbtn>
                            <else />
                            <switchbtn class="js_open css_close">开启</switchbtn>
                            <switchbtn class="js_close css_open">关闭</switchbtn>
                        </if>

                    </span>
                    <span class="col-md-5ths col-xs-5ths" >
                        <a class="blue_text" href="{:U('/Company/Staff/customRules/type/1/',array('pid'=>$val['departid']))}">编辑</a>
                        <a class="blue_text js_delete" data-key="{$val['departid']}">删除</a>
                    </span>
                    </div>
                </foreach>
            </div>
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<script>
    $(function(){
        $.staff.customerShareJs();
    });
</script>