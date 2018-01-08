<div class="section_top_navigation">
  <span>当前位置：</span>
  <if condition="isset($breadcrumbs)">
    <volist name="breadcrumbs" id="menuInfo">
      <if condition="$i neq 1 && isset($menuInfo['title'])">
      <i>&gt;</i>
      </if>
    <if condition="$i neq count($breadcrumbs) && linkGetAccess($menuInfo['link']) && isset($menuInfo['link'])">
          <a href="{:U($menuInfo['link'],'','',true)}"><span>{$menuInfo['title']}</span></a>
    <else />
          <span>{$menuInfo['title']}</span>
    </if>
    </volist>
  <else/>
    <span>内容管理</span>
    <i>></i>
    <span>待发布资讯</span>
  </if>
</div>
