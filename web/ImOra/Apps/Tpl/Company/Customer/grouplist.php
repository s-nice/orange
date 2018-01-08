<foreach name="grouplist" key="k" item="group">
<!-- 每一个部门  -->
<div class="js_group div_department" data="{$group['departid']}">
	<div class="div_department_title">
		<span class="span_title">{$group['name']}</span>
		<label><input class="minimal" type="checkbox" name="groupid[]" value="{$group['departid']}_{$group['name']}" />全选</label>
		<span class="js_showgroup span_tab <if condition="$k eq 0">arrow_up</if>"></span>
	</div>
	<div class="js_user_div div_department_content" style="max-height: 120px;<if condition="$k neq 0">display:none;</if>">
	<if condition="isset($group['user'])">
	<assign name="user" value="$group['user']" />
		<include file="showUser" />
	</if>
	</div>
</div>
<!-- 每一个部门 end -->
</foreach>