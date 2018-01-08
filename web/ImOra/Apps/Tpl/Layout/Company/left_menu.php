      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">{: session(MODULE_NAME)['bizname']}</li>
        <if condition="isset($leftMenu)">
		<foreach name="leftMenu" item="menuInfo" key="key">
			<li class="treeview <if condition="$breadcrumbs['key'] == $key"> {: ' active'}</if>">
	          <a href='<if condition="isset($menuInfo['url'])">{$menuInfo['url']}<else />#</if>'>
	            <i class="fa {$menuInfo['icon']}"></i><span>{$T->$menuInfo['text']}</span>
	            <span class="pull-right-container">
	              <i class="fa fa-angle-left pull-right"></i>
	            </span>
	          </a>
	          <ul class="treeview-menu">
	          	<foreach name="menuInfo['children']" item="menu" key="ikey">
				<li class="<if condition="$breadcrumbs['key'] == $key && $breadcrumbs['info'] == $ikey"> {: ' active'}</if>"><a href="{:U($menu['ctl'].'/'.$menu['act'],'','',true)}"><i class="fa fa-circle-o"></i>{$T->$menu['text']}</a></li>
				</foreach>
	          </ul>
	        </li>
        </foreach>
		</if>