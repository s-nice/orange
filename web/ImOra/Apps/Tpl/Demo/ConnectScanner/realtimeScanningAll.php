<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <title>卡分类</title>
  <link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
  <link rel="stylesheet" href="__PUBLIC__/css/weui.min.css?v={:C('WECHAT_APP_VERSION')}">
</head>
<body>
  <div class="classify" id="js_tags">

  </div>
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script src="__PUBLIC__/js/jquery/jquery.wechat.js?v={:C('WECHAT_APP_VERSION')}"></script>
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
         var data = {openid:gOpenid,batchid:batchid};

     $.get(gVcardTimeUrl,data,function(rst){
      console.log(rst);
      if(rst.status == 0){
          if(rst.data.numfound>0){
              totalReqTimes = 0;

              var list = rst.data.list;
              var htmlStr = '';
              for(var i in list){
                var tag= list[i].tag;
                var num= list[i].numfound;
                var url = list[i].url;
                //var pica = list[i].picturea;
                htmlStr +='<a href="'+url+'"><div class="fy_item">'+tag+'<b>'+num+'</b></div></a>';
              }
              $('#js_tags').html(htmlStr);
              setTimeout(timelyShow,500);
            //}
          }else{
            totalReqTimes++;
            setTimeout(timelyShow,1000);
          }
      }else{
          $.wechat.alert('获取分类失败');
          totalReqTimes++;
      }
    },'json');
     }


</script>
</body>
</html>