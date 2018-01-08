<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>{$T->str_360_title}</title>
		<link rel="stylesheet" href="__PUBLIC__/css/wePage.css" />
		<script src="__PUBLIC__/js/oradt/H5/fontSize.js"></script>
		<script src="/static/common/jquery-1.11.0.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
	</head>
	<body>
		<nav class="nav_height"></nav>
		<nav class="navs">
			<span>{$T->str_360_map}</span>
			<span>{$T->str_360_relation}</span>
			<span>{$T->str_360_statistic}</span>
			<span class="on">{$T->str_360_timeline}</span>
		</nav>
		<div id='tpl' class="time_item" style='display:none;'>
			<div class="join_time"><span><em></em></span>2017年8月01日</div>
			<div class="t_card_info">
				<h5>琳琳加入到了我的朋友圈</h5>
				<img src="__PUBLIC__/images/wei/2.png" alt="" />
				<ul>
					<li><b>{$T->str_360_company}：</b><small>联想集团</small></li>
					<li><b>{$T->str_360_job}：</b><small>总经理</small></li>
					<li><b>{$T->str_360_phone}：</b><small>+8618910869172</small></li>
				</ul>
			</div>
		</div>
		<section class="time_card">
			<div class="time_list">
				
			</div>
		</section>
	</body>
	<script type="text/javascript">
	var str_360_join_to='{$T->str_360_join_to}';
    $(function(){
    	var dataJson = JSON.parse('{$json}');
    	load(dataJson['sequential']);

    	var isLoading=false;
        var p=1;
        window.onscroll = function(){
            if (isLoading) return;
            if ($(window).height()+$(document).scrollTop()>$(document).height()-30){
            	isLoading=true;
            	//$('.load_more').css('opacity', 1);
            	$.get("{:U('Demo/Page/timelineLoad')}",{p:++p},function(rst){
            		$('.load_more').css('opacity', 0);
            		rst = JSON.parse(rst);
            		if (rst.status!=0){
                		return;
            		}
            		if (!rst.data.sequential || rst.data.sequential.length==0){
                		return;
                	}
            		load(rst.data['sequential']);
                	isLoading=false;
                });
            }
        }
    	
        function load(list){
            for(var i=0;i<list.length;i++){
                var date=list[i]['date'];
                for(var j=0;j<list[i]['cards'].length;j++){
                    var tmp=list[i]['cards'][j];
                    var $obj=$('#tpl').clone(true);
                    if (j==0){
                    	$obj.addClass('date');
                    	$obj.find('.join_time').html('<span><em></em></span>'+date);
                    } else {
                    	$obj.find('.join_time').remove();
                    }
                    $obj.find('h5').html(tmp['name']+' '+str_360_join_to);
                    $obj.find('small:eq(0)').html(tmp['company']);
                    $obj.find('small:eq(1)').html(tmp['position']);
                    $obj.find('small:eq(2)').html(tmp['mobile']);
                    $obj.find('img').attr('src', tmp['picture']);
                    $('.time_list').append($obj.show());
                }
            }
        }
    });
	</script>
</html>
