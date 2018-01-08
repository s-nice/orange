   <!-- 左侧菜单公共部分 -->
    <section class="sidebar">
     <if condition="isset($leftMenu)">
     	<foreach name="leftMenu" item="menuInfo" key="key">
     	<a href='<if condition="isset($menuInfo['url'])">{$menuInfo['url']}<else />#</if>'>
    	<dl class="cls_one_menu <if condition="$breadcrumbs['key'] == $key"> {: ' active'}</if>" href="{$menuInfo['url']}">
    		<dt class="{$menuInfo['icon']}"></dt>
    		<dd>{$T->$menuInfo['text']}</dd>
    	</dl>
    	</a>
    	</foreach>
<!--     	<dl>
    		<dt class="email-icon"></dt>
    		<dd>营销邮件</dd>
    	</dl>
    	<dl>
    		<dt class="ji-icon"></dt>
    		<dd>商谈记录</dd>
    	</dl>
    	<dl>
    		<dt class="ren-icon"></dt>
    		<dd>任务</dd>
    	</dl>
    	<dl>
    		<dt class="sets-icon"></dt>
    		<dd>管理设置</dd>
    	</dl> -->
    </if>
    </section>
    <script>
 		$(function(){
/* 			$('.cls_one_menu').click(function(){
				window.location.href = $(this).attr('href');
			}); */
 	 	});
    </script>