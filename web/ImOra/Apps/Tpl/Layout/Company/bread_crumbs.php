<h1>
{$title}
</h1>
<if condition="isset($subtitle) && !empty($subtitle)">
<span>{$subtitle}</span>
</if>
<ol class="breadcrumb">
	<if condition="isset($keyBreadcrumbs['text'])">
	<li class="treeview">
		<i class="fa {$keyBreadcrumbs['icon']}"></i>
	    <if condition="isset($keyBreadcrumbs['ctl']) && isAbleAccess($keyBreadcrumbs['ctl'],$keyBreadcrumbs['act'])">
	          <a href="{:U($keyBreadcrumbs['ctl'].'/'.$keyBreadcrumbs['act'],'','',true)}"><i class="fa"></i>{$T->$keyBreadcrumbs['text']}</a>
	    <else />
	          <i class="fa"></i>{$T->$keyBreadcrumbs['text']}
	    </if>
	</li>
    </if>
    <if condition="isset($infoBreadcrumbs['text'])">
    <li>
	    <if condition="isset($infoBreadcrumbs['ctl']) && isAbleAccess($infoBreadcrumbs['ctl'],$infoBreadcrumbs['act'])">
	          <a href="{:U($infoBreadcrumbs['ctl'].'/'.$infoBreadcrumbs['act'],'','',true)}"><i class="fa"></i>{$T->$infoBreadcrumbs['text']}</a>
	    <else />
	          <i class="fa"></i>{$T->$infoBreadcrumbs['text']}
	    </if>
	</li>
	</if>
	<if condition="isset($breadcrumbs['show']) && !empty($breadcrumbs['show'])">
		<if condition="is_array($breadcrumbs['show'])">
			<foreach name="breadcrumbs['show']" item="breadcrumbV">
				<if condition="isset($breadcrumbV['ctl']) && isAbleAccess($breadcrumbV['ctl'],$breadcrumbV['act'])">
		        	<li class="active"><a href="{:U($breadcrumbV['ctl'].'/'.$breadcrumbV['act'],'','',true)}"><i class="fa"></i>{$T->$breadcrumbV['text']}</a></li>
			    <else />
			         <li class="active"><i class="fa"></i>{$T->$breadcrumbV['text']}</li>
			    </if>
			</foreach>
		<else />
			<li class="active"><i class="fa"></i>{$T->$breadcrumbs['show']}</li>
		</if>
	</if>
</ol>
<!-- 
$breadcrumbs = array(
'key'=>string or array,  //左侧菜单配置文件中
							已经存在的:把左侧菜单配置文件中的对应的key赋值,
							不存在的:根据不同场景编写
							array('text'=>显示文字的翻译，
								'ctl'=>'链接的ctl值', // 没有链接就为空或不存在就好
								'act'=>'链接的act值') // 没有链接就为空或不存在就好
'info'=>string or array, // 同上面的key字段一样
'show'=>string or array // 小标题内容展示
 --> 