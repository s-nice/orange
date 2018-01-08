<layout name="../Layout/Layout"/>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="form_margintop">
                <include file="@Layout/nav_stat" />
                <div id="js_stat_type" class="select_xinzeng margin_top js_se_div">
                    <input type="text" title="{$typename}" value="{$typename}" val="{$type}">
                    <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></i>
                    <ul>
                        <foreach name="stat_types" item="sv" key="sk">
                            <li class="{:($type == $sk ? 'on' : '')}" title="{$sv.name}" val="{$sk}">{$sv.name}</li>
                        </foreach>
                    </ul>
                </div>
                <if condition="isset($child_stat_types)">
                    <div id="js_child_type" class="select_xinzeng margin_top js_se_div">
                        <input type="text" val="{$child_type}" value="{$child_typename}">
                        <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></i>
                        <ul>
                            <foreach name="child_stat_types" item="val" key="kk">
                                <li class="{:($child_type == $kk ? 'on' : '')}" val="{$kk}">{$val}</li>
                            </foreach>
                        </ul>
                    </div>
                </if>
                <if condition="isset($date_types)">
                    <div class="js_stat_date_type">
                        <foreach name="date_types" item="dv" key="dk">
                            <a <if condition="$date_type eq $dk">class="on" </if>>{$dv}</a>
                        </foreach>
                    </div>
                </if>
            </div>
            <!--图表放置-->
            <div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;padding-top:15px;">

            </div>
            <div id="userStatisticsData">
                <div class="Data_bt">
                    <span class="left_s"><em id="js_table_title">{$title}</em>数据表</span>
                    <button id="js_export" class="right_down" type="button">导出</button>
                    <div style="display:none">
                        <iframe id="down-file-iframe" >
                        </iframe>
                        <form id="exportForm" action="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/ExportData')}" method="post" target="down-file-iframe">
                            <input type="hidden" name="data" value='' />
                            <input type="hidden" name="header" value='' />
                            <input type="hidden" name="title" value='' />
                        </form>
                    </div>
                </div>
                <div id="js_table_content" class="table_content">

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var selfUrl = "__URL__/index"
    var postUrl = "__URL__/postData";
    var tabUrl = "__URL__/ajaxTab";
    var colorlist = '{$colorlist}';
    colorlist = JSON.parse(colorlist);
    $(function(){
        $.orauserstatistic.index();
    });
</script>