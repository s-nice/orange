<style>
	.nav{width:100%;height:40px;background:#ccc;display:flex;display:-webkit-flex;display:-moz-flex;display:-o-flex;position:fixed;z-index:99999;}
    .nav_block{width:100%;height:40px;background:#ccc;z-index:1;display:block;}
	.nav a:hover{text-decoration:none!important;}
	.nav a{white-space:nowrap;  display:block;width:33.33%;line-height:40px;font-size:16px;font-family:"Microsoft YaHei";text-align:center;color:#333;text-decoration:none;}
	.nav a.on{border-bottom:2px solid #1aad19;color:#1aad19;}
</style>
<nav class="nav">
    <a <if condition="$type eq 'map'">class="on"</if> href="{:U('Demo/Page/map')}">{$T->str_360_map}</a>
    <if condition="$relation"><a <if condition="$type eq 'relation'">class="on"</if> href="{:U('Demo/Page/relation')}">{$T->str_360_relation}</a></if>
    <a <if condition="$type eq 'grid'">class="on"</if> href="{:U('Demo/Page/grid')}">{$T->str_360_statistic}</a>
    <a <if condition="$type eq 'timeline'">class="on"</if> href="{:U('Demo/Page/timeline')}">{$T->str_360_timeline}</a>
</nav>
<nav class="nav_block"></nav>