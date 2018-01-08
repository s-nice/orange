<layout name="../Layout/Company/AdminLTE_layout" />
<div class="cardlist-warp">
	<div class="cardlist-pub14 cardlist-title">正在使用的名片模板：</div>
	<div class="cardlist-cont">
		<div class="cardlist-left">
            <if condition="$tpl['picture'] eq ''">
            <img src='__PUBLIC__/images/companycard/company-listpica.jpg'>
            <else/>
            <a href="{:U('Company/CompanyInfo/cardView')}?src={$tpl.picture}" target='_blank'><img src='{$tpl.picture}'></a>
            </if>
			<if condition="$tpl['picturea'] eq ''">
            <img src='__PUBLIC__/images/companycard/company-listpica.jpg'>
            <else/>
            <a href="{:U('Company/CompanyInfo/cardView')}?src={$tpl.picturea}" target='_blank'><img src='{$tpl.picturea}'></a>
            </if>
		</div>
		<div class="cardlist-right">
			<div class="box-footer">
				<button id='edit' href="{:U('Company/CompanyInfo/cardpage4')}?tempid={$tpl.tempid}" class="btn pull-left button_bgcolor" type="submit">编辑</button>
			</div>
			<if condition="$tmpTemplate neq ''">
            <div class="box-footer">
				<button id='publish' data-loading-text="发布中..." href="{:U('Company/CompanyInfo/cardPublish')}" class="btn pull-left button_bgcolor" >发布</button>
			</div>
			</if>
			
		</div>
	</div>
	<empty name="historys">
    <else/>
    <div class="cardlist-border"></div>
    <div class="cardlist-pub14 cardlist-title">历史名片模板：</div>
    <div class="cardlist-content">
    	<foreach name="historys" item="v">
    		<div class="cardlist-t14 cardlist-time">{$v.usestart|substr=0,10}至{$v.modifedtime|substr=0,10}</div>
    		<div class="cardlist-dl">
    			<span><a href="{:U('Company/CompanyInfo/cardView')}?src={$v.picture}" target='_blank'><img src='{$v.picture}'></a></span>
    			<span><a href="{:U('Company/CompanyInfo/cardView')}?src={$v.picturea}" target='_blank'><img src='{$v.picturea}'></a></span>
    		</div>
    	</foreach>
    </div>
	</empty>
</div>
<script type='text/javascript'>
$(function(){
	$('#edit').on('click', function(){
		location.href=$(this).attr('href');
	});
	
	$('#publish').on('click', function(){
		var url=$(this).attr('href');
		$(this).button('loading');
		$.ajax({
	        url: url,
	        async:false,
	        success:function(rst){
	        	$('#publish').button('reset');
	        	rst = $.parseJSON(rst);
	        	if (rst.status==0){
	        		$.global_msg.init({gType:'warning', msg:rst.msg1, btns:true, icon:1});
	        		setTimeout(function(){
	        			location.reload();
		        	}, 2000);
	        	} else {
	        		$.global_msg.init({gType:'warning', msg:rst.msg1, btns:true, icon:0});
		        } 
	        },
	        error:function(rst){
	            return false;
	        }
	    });
	});
});
</script>