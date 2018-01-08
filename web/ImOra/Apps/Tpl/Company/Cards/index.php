<layout name="../Layout/CompanyLayout" />
    <style>
        .none {display: none;}
        .content{width: 900px; margin: 0 auto; background: RGB(204,204,204);}
        .cards-list-content { width: 100%; overflow-x:auto;}
        .content-nav {width: 100%; height: 40px; clear: both;}
        .cards-list-tab{
            display: inline-block;
            width: 20px; 
            height: 20px;
            margin: 10px;
            cursor: default;
            float: left;
        }
        .content-nav .list-type1 { background: red;}
        .content-nav .list-type0 { background: green;}
        .cardslist-all-sle {display:inline-block; width: 40px; height: 40px; line-height: 40px; margin-left: 20px; float: left;}
        .cardslist-search {float: left; height: 20px; margin: 10px 20px;}
        .cardslist-search input {width: 125px;margin-left: 5px;}
        .cardslist-search span {margin-left: 20px;}
        .cardslist-buttons {float: left; height: 40px; margin-left: 20px;}
        .cardslist-buttons div{float:left; margin: 6px; background: #666;padding: 7px 15px;text-align: center;font: 14px/14px "微软雅黑";color: #ccc;cursor: pointer;
                }
        .cards-list-scroll { width: 1800px; overflow: hidden;}
        .cards_list_name,.cards-list-detail {width: 100%; }
        .cards_list_name span { display:inline-block;width: 120px; overflow: hidden; height: 30px;}
        .cards_list_c span { display:inline-block;width: 120px; overflow: hidden; height: 30px; overflow: hidden; text-overflow:ellipsis; line-height: 30px;}
        .cards-list-noscroll { width: 900px; overflow: hidden; clear: both;}
        .cards-list-noscroll .cards-list-block { width: 200px; height: 120px; float: left; margin:10px; border: 1px solid RGB(194,194,194);}
        .cards_list_c .span_span2 img { width: 40px; height: 24px;}
        .cards-list-block img { width: 200px; height: 120px;}
        .cards-list-block.active { border: 3px solid RGB(0,128,0); margin: 8px;}
    </style>

    <div class="content">
        <div class="content-nav">
            <a href="{:U(MODULE_NAME.'/Cards/index',array('p'=>$p,'t'=>$ntype,'account'=>$account,'start_time'=>$start_time,'end_time'=>$end_time,'batchid'=>$batchid))}"><span id="js-list-tab" class="cards-list-tab list-type{$type}"></span></a>
            <span id="js-all-check" class="cardslist-all-sle">全选</span>
            <div class="cardslist-search">
                <form id="myForm" action="__ACTION__" method="get">
                    <input type="hidden" name="t" value="{$type}" />
                    <input type="hidden" name="batchid" value="{$batchid}">
                    <span>用户账号</span><input type="text" name="account" value="{$account}" />
                    <span>扫描时间</span><input type="text" name="start_time" value="{$start_time}" />~<input type="text" name="end_time" value="{$end_time}" />
                </form>
            </div>
            <div class="cardslist-buttons">
                <div class="js-sle-btn">查询</div>
                <a  href="{:U(MODULE_NAME.'/Export/exportinfo',array('batchid'=>$batchid,'account'=>$account,'startTime'=>$start_time,'endTime'=>$end_time),'',true)}"><div>导出</div></a>
            </div>
        </div>
        <div class="cards-list-content">
            <if condition="$type eq 1">
                <div class="cards-list-noscroll">
                    <foreach name="list" item="val">
                        <div class="cards-list-block"><img src="{$val.picture}"></div>
                    </foreach>
                </div>
            <else />
                <div class="cards-list-scroll">
                    <div class="cards_list_name">
                        <span class="span_span1">选择</span>
                        <span class="span_span2">图片</span>
                        <span class="span_span3">用户姓名</span>
                        <span class="span_span4">用户账号</span>
                        <span class="span_span5">姓名</span>
                        <span class="span_span6">手机</span>
                        <span class="span_span7">职位</span>
                        <span class="span_span8">公司</span>
                        <span class="span_span9">部门</span>
                        <span class="span_span10">邮箱</span>
                        <span class="span_span11">网址</span>
                        <span class="span_span12">公司地址</span>
                        <span class="span_span13">电话</span>
                        <span class="span_span14">扫描时间</span>
                    </div>
                    <div class="cards-list-detail">
                        <foreach name="list" item="val">
                        <div class="cards_list_c">
                            <span class="span_span1"><input type="checkbox"></span>
                            <span class="span_span2"><img src="{$val.picture}" /></span>
                            <span class="span_span3">{$val.accountname}</span>
                            <span class="span_span4">{$val.account}</span>
                            <span class="span_span5">{$val.FN}</span>
                            <span class="span_span6">{$val.TEL}</span>
                            <span class="span_span7">{$val.title}</span>
                            <span class="span_span8">{$val.ORG}</span>
                            <span class="span_span9">{$val.DEPAR}</span>
                            <span class="span_span10">{$val.EMAIL}</span>
                            <span class="span_span11">{$val.URL}</span>
                            <span class="span_span12">{$val.ADR}</span>
                            <span class="span_span13">{$val.name}</span>
                            <span class="span_span14">{:date('Y-m-d',$val['createtime'])}</span>

                        </div>
                        </foreach>
                    </div>

                </div>
            </if>
        </div>
        
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
        
    </div>
    <script>
        $(function(){
            new cards();
        });
    </script>