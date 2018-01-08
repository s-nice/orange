<layout name="../Layout/H5Layout" />
<header class="head_box" style='display: none;'>
	<div class="getask_box"><span class="name_top">关于公司名片...</span><em class="em_Wishlists"><img src="__PUBLIC__/images/mobile_img_fxiang.png" /></em></div>
</header>
<section class="content">
	<div class="consult_c">
		<div class="ask_title">{$data.title}</div>
		<div class="ask_namelogo">
			<div class="ask_left_pic">
				<!-- <i><img src="__PUBLIC__/images/mobile_img_name.png" /></i> -->
				<i><img src="{$data.avatarpath}" /></i>
				<em>{$data.realname}</em>
			</div>
			<div class="ask_right_c">
				<i>{$data.datetime|substr=0,10}</i>
				<em>{$data.datetime|substr=11}</em>
			</div>
		</div>
		<div class="ask_cont">
			<p>{$data.content}</p>
		</div>
		
		<!-- <div class="ask_piccard"><img src="__PUBLIC__/images/mobile_img_card.png" /></div> -->
		<foreach name="resources" item='b'>
            <div class="ask_piccard"><img src="{$b.path}" /></div>
        </foreach>
		<div class="ask_quest">
			<foreach name="comments['list']" item='b'>
			<div class="diban">
				<div class="ask_topy"></div>
				<div class="ask_bottomy"></div>
				<div class="ask_quest_c">
					<div class="left_namepic">
						<i><img src="{$b.avatarpath}" /></i>
						<em>{$b.realname}</em>
					</div>
					<div class="right_content_c">
						<p><i><if condition="$b.toname neq ''">{$T->str_orangeh5_reply}{$b.toname}：</if></i><aa>{$b.content}</aa></p>
						<span><em><img src="__PUBLIC__/images/mobile_imgname_icon.png" /></em><i>{$b.date}</i></span>
					</div>
				</div>
			</div>
			</foreach>
			<if condition="$comments['isNext']">
                <div class="ask_more"><i>{$T->str_orangeh5_more}</i><em><img src="__PUBLIC__/images/mobile_img_more.png" /></em></div>
			</if>
		</div>
	</div>
	<script type="text/javascript">
	var lang_reply = "{$T->str_orangeh5_reply}";
	var urlcomment = "{:U('H5/News/comment')}";
	var p=2;
	var loading=false;
	var showid = "{$showid}";
    $(function(){
        //加载更多
        $('.ask_more').on('click',function(){
            if (loading) return;
            loading=true;
            $.post(urlcomment,{p:p,showid:showid},function(json){
                var data=$.parseJSON(json);
                if (!data.isNext) $('.ask_more').hide();

                for(var i=0;i<data.list.length;i++){
                    var tmp=data.list[i];
                    var obj=$('.diban:first').clone();
                    obj.find('.left_namepic img').attr('src',tmp.avatarpath);
                    obj.find('.left_namepic em').html(tmp.realname);
                    
                    if (tmp.toname){
                    	obj.find('.right_content_c i:first').html(lang_reply+tmp.toname+'：');    
                    }
                    obj.find('.right_content_c aa').html(tmp.content);
                    obj.find('.right_content_c i:last').html(tmp.date);
                    $('.ask_more').before(obj);
                }
                p++;
                loading=false;
                emoticon();
            });
        });
        
        //表情替换
        function emoticon(){
            $('aa').each(function(){
            	$(this).html($.expBlock.textFormat($(this).html()));
            });
        }
        emoticon();
        $('.ask_cont').html($.expBlock.textFormat($('.ask_cont').html()));
    });

    
	</script>
</section>
