<div class="appadmin_section_left">
  <if condition="isset($leftMenu)">
	<h2>{$leftMenu.title}</h2>
	<ul>

	  <volist name="leftMenu['menus']" id="menuInfo">
	    <if condition="linkGetAccess($menuInfo['link'])">
	    <if condition="isset($menuInfo['active']) && $menuInfo['active']">
		  <li class="active"><a href="{:U($menuInfo['link'],'','',true)}">{$menuInfo.title}</a></li>
		<else/>
		  <li><a href="{:U($menuInfo['link'],'','',true)}">{$menuInfo.title}</a></li>
		</if>
		</if>
	  </volist>
	</ul>
  <elseif condition="isset($leftMenu2)"/>

  <h2>{$T->str_show_imora}</h2>

  <ul>
  	<volist name="leftMenu2['menus']" id="menu_val2" length="7" key="k" offset="7">
		<if condition="linkGetAccess($menu_val2['link'])&&!isset($menu_val2['hide'])"><li class="{: isset($menu_val2['active'])?$menu_val2['active']:''}"><i><a href="{:U($menu_val2['link'],'','',true)}">{$menu_val2['title']}</a></i></li></if>
  	</volist>
  </ul>
  <elseif condition="isset($leftMenu3)"/>
  <!-- 针对资讯采集单独做的 -->
  	<if condition="$action_name eq 'index' AND $cid eq ''">
  	<h2 class="active"><a href="{:U('Collection/index')}">{$T->str_menu_coll_parent}</a></h2>
  	<else/>
  	<h2><a href="{:U('Collection/index')}">{$T->str_menu_coll_parent}</a></h2>
  	</if>
	<ul id="collLeftCate" style="height:300px;">
	 <volist name="leftMenu3" id="menuInfo">
	 	<if condition="$cid eq $menuInfo['id']">
	 		<li class="active" id="js_coll_{$menuInfo['id']}"><a href="{:U(CONTROLLER_NAME.'/index',array('cid'=>$menuInfo['id']),'',true)}">{$menuInfo.category}</a></li>
	 	<else/>
	 		<li id="js_coll_{$menuInfo['id']}"><a href="{:U(CONTROLLER_NAME.'/index',array('cid'=>$menuInfo['id']),'',true)}">{$menuInfo.category}</a></li>
	 	</if>
	 </volist>
	</ul>
	<if condition="$action_name eq 'showChannelTpl'">
		<h2 class="active"><a href="{:U('Collection/showChannelTpl')}">{$T->str_menu_edit_channel}</a></h2>
	<else/>
		<h2><a href="{:U('Collection/showChannelTpl')}">{$T->str_menu_edit_channel}</a></h2>
	</if>
	<elseif condition="isset($leftMenu4)"/>
	<h2>{$leftMenu4.title}</h2>
	<ul>
	  <volist name="leftMenu4['menus']" id="menuInfo">
	    <if condition="isset($menuInfo['active']) && $menuInfo['active']">
		  <li class="active"><a href="{:U($menuInfo['link'],'','',true)}">{$menuInfo.title}</a><em>{$menuInfo.num}</em></li>
		<else/>
		  <li><a href="{:U($menuInfo['link'],'','',true)}">{$menuInfo.title}</a><em>{$menuInfo.num}</em></li>
		</if>
	  </volist>
	</ul>
<elseif condition="isset($leftMenu5)"/>
<!-- 针对统计单独做-->
<foreach name="leftMenu5" item="v">
<if condition="isset($v['active']) && $v['active']">
	<h2 class="active">
<else />
    <h2>
</if>
<if condition="empty($v['link'])">
	{$v.title}</h2>
<else />
  <if condition="linkGetAccess($v['link'])">
  	<a href="{:U($v['link'],'','',true)}<if condition='isset($v["isAnchor"])&&($v["isAnchor"]==1)'>#anchor_{$key}</if>" <if condition='isset($v["isAnchor"])&&($v["isAnchor"]==1)'>id="anchor_{$key}"</if>>
  	{$v.title}</a></h2><else /></h2></if>
</if>
	<ul>
	 <if condition="isset($v['menus'])">
	  <volist name="v['menus']" id="menuInfo">
	  	<if condition="linkGetAccess($menuInfo['link'])">
		    <if condition="isset($menuInfo['active']) && $menuInfo['active']">
			  <li class="active"><a href="{:U($menuInfo['link'],'','',true)}<if condition='isset($menuInfo["isAnchor"])&&($menuInfo["isAnchor"]==1)'>#anchor_{$key}</if>" <if condition='isset($menuInfo["isAnchor"])&&($menuInfo["isAnchor"]==1)'>id="anchor_{$key}"</if>>{$menuInfo.title}</a></li>
			<else/>

			  <li><a href="{:U($menuInfo['link'],'','',true)}<if condition='isset($menuInfo["isAnchor"])&&($menuInfo["isAnchor"]==1)'>#anchor_{$key}</if>" <if condition='isset($menuInfo["isAnchor"])&&($menuInfo["isAnchor"]==1)'>id="anchor_{$key}"</if>>{$menuInfo.title}</a></li>
			</if>
		</if>
	  </volist>
	  </if>
	</ul>
</foreach>
<!--设置单独-->
<elseif condition="isset($leftMenu6)" />
	  <volist name="leftMenu6" id="vo">
		  <if condition="isset($vo['link']) && linkGetAccess($vo['link'])">
		  <a href="{:U($vo['link'],'','',true)}">
		  <if condition="isset($vo['active']) && $vo['active']">
		  	<h2 class="active">{$vo.title}</h2>
		  <else />
		  	<h2>{$vo.title}</h2>
		  </if>
		  </a>
		  <else />
		  <if condition="isset($vo['active']) && $vo['active']">
		  	<h2 class="active">{$vo.title}</h2>
		  <else />
		  	<h2>{$vo.title}</h2>
		  </if>
		  </if>
		  <ul>
			  <volist name="vo['menus']" id="menuInfo">
				  <if condition="linkGetAccess($menuInfo['link'])">
					  <if condition="isset($menuInfo['active']) && $menuInfo['active']">
						  <li class="active"><a href="{:U($menuInfo['link'],'','',true)}">{$menuInfo.title}</a></li>
						  <else/>
						  <li><a href="{:U($menuInfo['link'],'','',true)}">{$menuInfo.title}</a></li>
					  </if>
				  </if>
			  </volist>
		  </ul>
	  </volist>
<!-- 公用的二级菜单 -->
<elseif condition="isset($commonLeftMenu)" />
    <volist name="commonLeftMenu" id="top_menu">
		<if condition="isset($top_menu['link']) && linkGetAccess($top_menu['link'])">
		  <a href="{:U($top_menu['link'],'','',true)}<if condition='isset($top_menu["isAnchor"])&&($top_menu["isAnchor"]==1)'>#anchor_{$key}</if>" <if condition='isset($top_menu["isAnchor"])&&($top_menu["isAnchor"]==1)'>id="anchor_{$key}"</if>>
		  	<h2 class="{:(empty($top_menu['active']) ? '' : 'active')}">{$top_menu.title}</h2>
		  </a>
		<else />
		  <volist name="top_menu['menus']" id="menu">
		    <php>
		     if(linkGetAccess($menu['link'])) {
		       $hasLeftTopMenu = true;
		       break;
		     }
		    </php>
		  </volist>
		  <if condition="isset($hasLeftTopMenu)">
		    <h2>{$top_menu.title}</h2>
		  </if>
		</if>

		  <if condition="isset($top_menu['menus']) || isset($hasLeftTopMenu)">
			  <ul>
			      <volist name="top_menu['menus']" id="menu">
				      <if condition="linkGetAccess($menu['link'])">
				              <li <if condition="isset($menu['active']) && $menu['active']">class="active"</if>><a <if condition='isset($menu["isAnchor"])&&($menu["isAnchor"]==1)'>id="anchor_{$key}"</if> href="{:U($menu['link'],'','',true)}<if condition='isset($menu["isAnchor"])&&($menu["isAnchor"]==1)'>#anchor_{$key}</if>">{$menu.title}</a></li>
				      </if>
			      </volist>
			  </ul>
		  </if>
	</volist>

<!--订单管理单独-->
<elseif condition="isset($leftMenu10)" />
	  <if condition="isset($leftMenu10['menuOrderManage']) && linkGetAccess($leftMenu10['menuOrderManage']['link'])">
		  <h2>{$leftMenu10['menuOrderManage']['title']}</h2>
		  <ul>
			  <volist name="leftMenu10['menuOrderManage']['menus']" id="menu">
				  <if condition="linkGetAccess($menu['link'])">
					  <if condition="isset($menu['active']) && $menu['active']">
						  <li class="active"><a href="{:U($menu['link'],'','',true)}">{$menu.title}</a></li>
						  <else/>
						  <li ><a href="{:U($menu['link'],'','',true)}">{$menu.title}</a></li>
					  </if>
				  </if>
			  </volist>
		  </ul>
	  </if>
	  <if condition="isset($leftMenu10['findPeople']) && linkGetAccess($leftMenu10['findPeople']['link'])">
		  <h2>{$leftMenu10['findPeople']['title']}</h2>
		  <ul>
			  <volist name="leftMenu10['findPeople']['menus']" id="menu">
				  <if condition="linkGetAccess($menu['link'])">
					  <if condition="isset($menu['active']) && $menu['active']">
						  <li class="active"><a href="{:U($menu['link'],'','',true)}">{$menu.title}</a></li>
						  <else/>
						  <li><a href="{:U($menu['link'],'','',true)}">{$menu.title}</a></li>
					  </if>
				  </if>
			  </volist>
		  </ul>
	  </if>

  <else/>
	<h2 class="js_custom_menu"><a href="javascript:void(0);">{$T->str_custom_vr_user_bind}</a></h2>
	<h2 class="js_custom_menu"><a href="javascript:void(0);">{$T->str_custom_online_ask}</a></h2>
	<h2 class="js_custom_menu"><a href="javascript:void(0);">{$T->str_custom_ask_record}</a></h2>
	<ul class="js_custom_menu">
		<li><i><a href="javascript:void(0);" >{$T->str_custom_replyed}</a></i><em class="js_custom_replyed_icon" style="display:none;">0</em></li>
		<li><i><a href="javascript:void(0);" >{$T->str_custom_not_replyed}</a></i><em class="js_custom_noreplyed_icon"  style="display:none;">0</em></li>
	</ul>
  </if>
</div>
