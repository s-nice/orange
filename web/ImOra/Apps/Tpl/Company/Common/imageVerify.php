<!-- 图片滑动验证公共代码部分 -->
<!--
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/jquery.event.ue.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/jquery.udraggable.js"></script>
 -->
<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery-ui.min.js"></script>

<script src="__PUBLIC__/js/oradt/Company/imageVerify.js"></script><!-- 滑动验证功能js -->
<script type="text/javascript">
//图片验证码相关的变量
var gStrVerifyImgSucc = "{$T->str_verify_img_succ}";/*图片匹配成功*/
var gStrVerifyImgFail = "{$T->str_verify_img_fail}";/*图片匹配失败*/
var gStrLoginVerifyError = "{$T->str_login_verify_error}";/*验证码错误*/
var checkVerify = "{:U(MODULE_NAME . '/Login/checkVerifyCode',array('key'=>$THINK.ACTION_NAME))}"; //验证验证码地址
var gBtnWidth = $('#td').width();//获取滑条的宽度
var gBgUrl = "{:U(MODULE_NAME . '/Login/getVerifyCode',array('key'=>$THINK.ACTION_NAME))}";//验证码--生产图片
	gBgUrl = gBgUrl.replace('.html','');
	gBgUrl += '/w/'+gBtnWidth;
var t = {$top}; //验证码坐标位置变量
</script>
