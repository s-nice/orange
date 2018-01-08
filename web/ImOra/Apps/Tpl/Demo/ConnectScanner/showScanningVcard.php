<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!-- uc强制竖屏 -->
	<meta name="screen-orientation" content="portrait">
	<!-- QQ强制竖屏  -->
	<meta name="x5-orientation" content="portrait">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>{$T->str_result_title}</title>
  <script src="__PUBLIC__/js/oradt/H5/fontSize.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
  <link rel="stylesheet" href="__PUBLIC__/css/weDialog.css?v={:C('WECHAT_APP_VERSION')}">
  <link rel="stylesheet" href="__PUBLIC__/css/wePage.css?v={:C('WECHAT_APP_VERSION')}">
  <style>
    html,body{
      width:100%;
      height:100%;
      background:rgb(29,33,44);
      position:relative;
    }
    .pull_file{z-index: 14000;}
    .dia_error {z-index: 15000;}
    p.no {display: none;}
  </style>
</head>
<body>
    <section class="container_file">
      <!-- <header class="file_head">
          <div class="num-head">
              <button class="weui-btn weui-btn_primary js_list_no_data">正在加载...</button>
          </div>
      </header> -->
      <!--  加载更多提示   -->
      <div class="page__bd js_list_no_data">
        <div class="weui-loadmore">
          <i class="weui-loading"></i>
          <span>{$T->str_company_list_laoding}</span>
        </div>
      </div>
      <!--  导出填写邮箱  -->
      <div class="email_dialog js_dialog js_dialog_email">
          <div class="pull_email">
            <h3>{$T->str_result_my_email}</h3>
            <input type="text" id="js_email">
            <p>{$T->str_result_send_to_email}</p>
            <div class="pull_btn">
              <button class="js_export_cancel" type="button">{$T->str_result_cancel}</button>
              <button act="1" class="btn_color js_export_sure" type="button">{$T->str_result_ok}</button>
            </div>
          </div>
      </div>
      <!--  正在导出弹框  -->
      <div class="pull_file file-line js_dialog js_dialog_loading">
          <div class="dia_w">
            <img src="__PUBLIC__/images/wei/welodoing.gif" alt="">
           {$T->str_result_outputing}
          </div>
      </div>
      <!--  成功弹框  -->
      <div class="pull_file js_dialog js_dialog_succ">
          <div class="dia_w file-top">
            <img src="__PUBLIC__/images/wei/sucess_icon.png" alt="">
            <em>{$T->str_result_output_success}</em>
          </div>
      </div>
      <!-- 失败弹框  -->
      <div class="dia_error js_dialog js_dialog_fail">
          <div class="error_w">
            <img src="__PUBLIC__/images/wei/error_icon.png" alt="">
            <p>{$T->str_result_output_fail}</p>
          </div>
      </div>
      <div class="img_main top-mian">
        <div class="img_list js_scanner_data">
          <div class="file_img js_scanner_single" style="display: none;" data-cardid=''>
              <img src="__PUBLIC__/images/appadmin_icon_card.png" alt="">
          </div>
        </div>
      </div>
    <!--   <footer class="find_foot">
         <div class="find_btn">
            <button class="weui-btn weui-btn_primary js_list_has_data">已识别<em class="js_curr_card_num">0</em>张</button>
            <button class="weui-btn weui-btn_primary js_redirect_list" type="button">名片搜索</button>
         </div>
    </footer> -->
      <footer class="pay_btn pay_btn_bg">
        <p class=" js_list_has_data <if condition='$share neq 0'>no</if>" >{$T->str_result_scan_success}<b class="js_curr_card_num" data-num="0">0</b>{$T->str_360_zhang}</p>
        <if condition="$share eq 0">
        <button class="btn btn_bottom js_export_list" type="button">{$T->str_g_list_export}</button>
        <else />
        <button class="btn btn_bottom js_share" type="button" atc="1">分享到公司</button>
        </if>
      </footer>
    </section>
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script src="__PUBLIC__/js/jquery/zepto.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script>
    var isShare = "{$share}";
    var gVcardTimeUrl = "{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/showScanningVcard','','',true)}";
    var gVcardListUrl = "{:U(MODULE_NAME.'/Wechat/wListZp','','',true)}";
    var gDetailUrl = "{:U(MODULE_NAME.'/Wechat/wDetailZp')}"; //名片正面详情
    var gVcardDetailBackUrl = "{:U(MODULE_NAME.'/Wechat/detailBack','',true)}"; //名片反面url
    var exportPostUrl = "{:U(MODULE_NAME.'/Wechat/oneKeyExport')}";
    var sharePostUrl = "{:U(MODULE_NAME.'/Wechat/shareToCompany')}";
    var gOpenid = "{$openid}";  //微信id
    var batchid = "{$batchid}";  //微信id
    var totalPage = 1;
    var timeoutHandel;
    function exportFailDialog(str){
      $('.pull_file').hide();
      $('.js_dialog_fail').find('p').html(str);
      $('.js_dialog_fail').show();
      clearTimeout(timeoutHandel);
      timeoutHandel = setTimeout(function(){
        $('.js_dialog_fail').hide()
      },2000);
    }

    function exportSuccDialog(str){
      $('.pull_file,.js_dialog_fail').hide();
      $('.js_dialog_succ em').text(str);
      $('.js_dialog_succ').show();
      clearTimeout(timeoutHandel);
      timeoutHandel = setTimeout(function(){
        $('.js_dialog_succ').hide()
      },2000);
    } 
    $(function(){
    	timelyShow();
      //点击导出
  	  $('.js_export_list').click(function(){
        $('.js_dialog').hide();
        $('.js_dialog_email').show();
      });
      //取消导出
      $('.js_export_cancel').click(function(){
        $('.js_dialog').hide();
      });
      //点击提示弹框消失
      $('.container_file').on('click','.js_dialog_succ,.js_dialog_fail',function(){
          $(this).hide();
      })
      //确定导出
      $('.js_export_sure').click(function(){
          var _this = $(this);
          var act = _this.attr('act');
          if(act==0){
            return false;
          }
          var email = $('#js_email').val();
          if(!email){
            exportFailDialog('{$T->str_result_my_email}');
            return false;
          }
          var reg = /^[\.a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
          if(!reg.test(email)){
            exportFailDialog('{$T->str_result_wrong_email}');
            return false;
          }
          _this.attr('act',0);
          $('.js_dialog_loading').show();
          $.post(exportPostUrl,{batchid:batchid,email:email},function(re){
            $('.js_dialog_loading').hide();
            _this.attr('act',1);
            if(re.status==0){
              $('.js_dialog_email').hide();
              exportSuccDialog(re.msg);
            }else{
              exportFailDialog(re.msg);
            }
          });
      });

        if(parseInt($('.js_curr_card_num').attr('data-num')) == 0){
			$('.js_list_has_data').hide();
			$('.js_list_no_data').show();
         }
     });
    //点击名片正面
    $('.js_scanner_data').on('click','.js_scanner_single',function(){
			var cardid = $(this).attr('data-cardid');
			if($(this).hasClass('is_front')){
				gDetailUrl = gDetailUrl.replace('.html','');
				window.location.href = gDetailUrl+'/cardid/'+cardid;	
			}else{
				gVcardDetailBackUrl = gVcardDetailBackUrl.replace('.html','');
				window.location.href = gVcardDetailBackUrl+'/cardid/'+cardid;	
			}		
	
     });
	//向右边滑动,(还原或者翻面)
	$(".js_scanner_data").on("swipeRight",'.js_scanner_single',function(){
		var obj = $(this);
		if(obj.attr('picpathb')){
			if(obj.hasClass('is_front')){
				obj.find('img').attr('src',obj.attr('picpathb'));
				obj.removeClass('is_front').addClass('is_back');
			}else if(obj.hasClass('is_back')){
				obj.find('img').attr('src',obj.attr('picpatha'));
				obj.removeClass('is_back').addClass('is_front');
			}
		}
	});

  //分享到公司
    $('.js_share').click(function(){
        var _this = $(this);
        var act = _this.attr('act');
        if(act==0){
          return false;
        }
        _this.attr('act',0);
        $('.js_dialog_loading').show();
        $.post(sharePostUrl,{openid:gOpenid,batchid:batchid},function(re){
          $('.js_dialog_loading').hide();
          _this.attr('act',1);
          if(re.status==0){
            exportSuccDialog(re.msg);
          }else{
            exportFailDialog(re.msg);
          }
        });
    });
	
	var totalReqTimes = 0;
	//异步实时显示正在扫描的名片
	function timelyShow(){
		if(totalReqTimes>1200){
		    return;
		}
		var cardid = $('.js_scanner_data .js_scanner_single:first').attr('data-cardid');
        cardid = cardid?cardid:0;
        cardid++;
        //alert(cardid);
        var data = {openid:gOpenid, page:totalPage,batchid:batchid,cardid:cardid};
        $.get(gVcardTimeUrl,data,function(rst){
        	if(rst.status == 0){
        		if(rst.data.numfound>0){
        			totalReqTimes = 0;
					totalPage++;
					var list = rst.data.list;
					var htmlStr = '';
					for(var i in list){
						var cardid= list[i].cardid;
						//alert(cardid);
						var pica = list[i].picpatha;
						var picb = list[i].picpathb;
						htmlStr ='<div class="file_img js_scanner_single is_front" data-cardid="'+cardid+'" picpatha="'+pica+'" picpathb="'+picb+'">'+
					          '<img src="'+pica+'" alt="" >'+
					      '</div>'+htmlStr;
					}
					$('.js_scanner_data .js_scanner_single:first').before(htmlStr);
					var totalNum = parseInt($('.js_curr_card_num').attr('data-num'));
					$('.js_curr_card_num').attr('data-num',rst.data.numfound+totalNum);
					$('.js_curr_card_num').html(rst.data.count);
          			if(isShare==0){
					   $('.js_list_has_data').show();
          			}
					$('.js_list_no_data').hide();
        		} else {
        			totalReqTimes++;
            	}
        		setTimeout(timelyShow,2000);
        	} else {
        		alert('{$T->str_result_show_fail}');
				totalReqTimes++;
            }
        }, 'json');
	}
</script>
</body>
</html>