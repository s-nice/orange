<!DOCTYPE html>
<html lang="en" style="background:#111;width:100%;height:100%;">
<head>
	<meta charset="UTF-8">
	<!-- uc强制竖屏 -->
	<meta name="screen-orientation" content="portrait">
	<!-- QQ强制竖屏  -->
	<meta name="x5-orientation" content="portrait">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>最新名片</title>
  <link rel="stylesheet" href="__PUBLIC__/css/weui.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
</head>
<body  style="background:#111;width:100%;height:100%;position:relative;">
    <section class="container">
      <header class="file_head">
          <div class="num-head">
              <button class="weui-btn weui-btn_primary js_list_no_data">正在加载...</button>
          </div>
      </header>
      <div class="img_main">
        <div class="img_list js_scanner_data">
          <div class="file_img js_scanner_single" style="display: none;" data-cardid=''>
              <img src="__PUBLIC__/images/appadmin_icon_card.png" alt="">
          </div>
        </div>
      </div>
      <footer class="find_foot">
           <div class="find_btn">
              <button class="weui-btn weui-btn_primary js_list_has_data">已识别<em class="js_curr_card_num">0</em>张</button>
              <button class="weui-btn weui-btn_primary js_redirect_list" type="button">查看结果</button>
           </div>
      </footer>
    </section>
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script>
    var gVcardTimeUrl = "{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/realtimeScanningAll','','',true)}";
    var turnUrl = "{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/showScanAll',array('batchid'=>$batchid,'openid'=>$openid),'',true)}";
   // var gDetailUrl = "{:U(MODULE_NAME.'/Wechat/wDetailZp')}";
    var gOpenid = "{$openid}";  //微信id
    var gCardid = "{$cardid}";  //名片id
    var batchid = "{$batchid}";  //批次id
    var totalPage = 1;

    $(function(){
    	timelyShow();

        if(parseInt($('.js_curr_card_num').html()) == 0){
			$('.js_list_has_data').hide();
			$('.js_list_no_data').show();
        }
        $('.js_redirect_list').on('click',function(){
        	window.location.href = turnUrl;
        })
     });

/*     $('.js_scanner_data').on('click','.js_scanner_single',function(){
			var cardid = $(this).attr('data-cardid');
			gDetailUrl = gDetailUrl.replace('.html','');
			window.location.href = gDetailUrl+'/cardid/'+cardid;		
     }); */
	var totalReqTimes = 0;
     //异步实时显示正在扫描的名片
     function timelyShow(){
          if(totalReqTimes>1200){
			return ;
          } 
         var cardid = $('.js_scanner_data>.js_scanner_single:first').attr('data-cardid');
         if(!cardid){
        	 cardid = gCardid;
          }
         //if(totalPage>1){
        	// cardid = parseInt(cardid);
        	 cardid++;
         // }
         var data = {openid:gOpenid, cardid:cardid,page:totalPage,batchid:batchid};
		 $.get(gVcardTimeUrl,data,function(rst){
			if(rst.status == 0){
				if(rst.data.numfound>0){
			/* 		if(rst.data.querycardid == rst.data.cardid){
						return;
					}else{  */
					    totalReqTimes = 0;
						totalPage++;
						var list = rst.data.list;
						var htmlStr = '';
						for(var i in list){
							var cardid= list[i].id;
							var pica = list[i].picturea;
							htmlStr +='<div class="file_img js_scanner_single" data-cardid="'+cardid+'">'+
						          '<img src="'+pica+'" alt="">'+
						      '</div>';
						}
						$('.js_scanner_data>.js_scanner_single:first').before(htmlStr);
						var totalNum = parseInt($('.js_curr_card_num').html());
						$('.js_curr_card_num').html(rst.data.numfound+totalNum);
						$('.js_list_has_data').show();
						$('.js_list_no_data').hide();
						setTimeout(timelyShow,500);
					//}
				}else{
					totalReqTimes++;
					cardid--;
					setTimeout(timelyShow,500);
				}
			}else{
				alert('显示名片失败');
				totalReqTimes++;
			}
		},'json');
     }


</script>
</body>
</html>