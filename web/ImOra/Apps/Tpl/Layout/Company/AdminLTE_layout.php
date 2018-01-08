<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <php>
    if(is_array($breadcrumbs['key'])){
    	$keyBreadcrumbs = $breadcrumbs['key'];
    	$infoBreadcrumbs = $breadcrumbs['info'];
    }else{
    	$keyBreadcrumbs = $leftMenu[$breadcrumbs['key']];
    	$infoBreadcrumbs = $keyBreadcrumbs['children'][$breadcrumbs['info']];
    }
    if(!isset($title) || empty($title)){
    	if(isset($breadcrumbs['show']) && $breadcrumbs['show'] != ''){
    		if(is_array($breadcrumbs['show'])){
    			$num = (count($breadcrumbs['show'])-1)*1;
    			$title = isset($T->$breadcrumbs['show'][$num]['text'])?$T->$breadcrumbs['show'][$num]['text']:$T->$infoBreadcrumbs['text'];
    		}else{
    			$title = $T->$breadcrumbs['show'];
    		}
    	}else{
    		$title = $T->$infoBreadcrumbs['text'];
    	}
    }
  </php>
  <title>
	<if condition="!empty($title)">
	{$title}-
	</if>
	{$T->str_title_company_system}
	</title>
	<script src="__PUBLIC__/js/jquery/jquery.js"></script>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="__PUBLIC__/images/favicon.ico">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="__PUBLIC__/css/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="__PUBLIC__/css/font-awesome/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="__PUBLIC__/css/font-awesome/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="__PUBLIC__/css/adminlte/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="__PUBLIC__/css/adminlte/css/skins/_all-skins.min.css">
  <include file="@Layout/Company/head" />

  <style type="text/css">
  .bg_black { background-color: #000 !important;}
  .bg_white { background-color: #fff !important; color:#000 !important;}
  .small-box > .small-box-footer {
    background: rgba(0, 0, 0, 0.5) none repeat scroll 0 0;
    color: rgba(255, 255, 255, 1);
    }
.skin-blue .sidebar-menu > li.header {
    color: #fff;
    height: 60px;
    line-height: 40px;
}
.content-header > h1 {font-size: 20px;color: #333;}
.select2-search--dropdown {display: none;}
.select2-container--default .select2-selection--single {border-radius: 0;}
  </style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="__PUBLIC__/js/oradt/html5shiv.min.js"></script>
  <script src="__PUBLIC__/js/oradt/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="{:U('/Company/Index','','',true)}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="__PUBLIC__/images/company_logo.png" alt="Logo"/></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="__PUBLIC__/images/company_logo.png" alt="Logo"/>{$T->str_title_company_system}</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <if condition="CONTROLLER_NAME  eq 'Register' OR CONTROLLER_NAME  eq 'ForgetPwd'">
      		<div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="user user-menu"><a href="">官网首页</a></li>
          <!-- Control Sidebar Toggle Button -->
          <li class="user-tell">客服热线:400-898-7518</li>
          <li><a href="">在线客服</a></li>
        </ul>
      </div>
      <else/>
        <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="user user-menu menu_padd">
              <img src="{:$company_info['headImg']}" class="user-image" alt="headImg">
              <span class="hidden-xs">{:$company_info['username']}</span>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="{:U('Login/logout','','',true)}"><i class="fa">{$T->str_title_logout_system}</i></a>
          </li>
        </ul>
      </div>
      </if>


    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
    <if condition="$_SESSION[MODULE_NAME]['login_succ'] eq false">
    	<include file="@Layout/Company/left_menu_logout" />
    <else/>
   	  <include file="@Layout/Company/left_menu" />
    </if>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <include file="@Layout/Company/bread_crumbs" />
    </section>

    <!-- Main content -->
    <section class="content">
      {__CONTENT__}
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<div class="js_public_mask_pop company_public_mask"></div>
<!-- ./wrapper -->
<!-- Bootstrap 3.3.6 -->
<script src="__PUBLIC__/css/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="__PUBLIC__/js/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="__PUBLIC__/css/adminlte/js/app.min.js"></script>
<!-- Sparkline -->
<script src="__PUBLIC__/js/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="__PUBLIC__/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="__PUBLIC__/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="__PUBLIC__/js/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="__PUBLIC__/js/plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes)
<script src="__PUBLIC__/css/adminlte/js/pages/dashboard2.js"></script>-->
<script src="__PUBLIC__/js/jquery/jquery-ui.min.js"></script>
<script src="__PUBLIC__/js/jsExtend/layer/layer.min.js"></script>
<script src="__PUBLIC__/js/oradt/{:MODULE_NAME}/global.js?v={:C('APP_VERSION')}"></script>
	<if condition="isset($_SESSION[MODULE_NAME])">
		<link href="__PUBLIC__/css/globalPop.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
		<script src="__PUBLIC__/js/oradt/globalPop.js?v={:C('APP_VERSION')}"></script>
		<script src="__PUBLIC__/js/jsExtend/customscroll/jquery.mCustomScrollbar.concat.min.js"></script>
    </if>
	{// 加载自定义的js }
	<if condition="isset($moreScripts)">
	  <volist name="moreScripts" id="_script">
	    <if condition="substr($_script, 0 ,7)=='http://'||substr($_script, 0 ,8)=='https://'">
	        <script src="{$_script}"></script>
	    <else/>
	        <script src="__PUBLIC__/{$_script}.js?v={:C('APP_VERSION')}" charset="utf-8"></script>
	    </if>
	  </volist>
	</if>

	{// 加载本模块js }
	<if condition="is_file(WEB_ROOT_DIR . 'js/oradt/'.MODULE_NAME.'/'.strtolower(CONTROLLER_NAME).'.js')">
	  <script src="__PUBLIC__/js/oradt/{: MODULE_NAME}/{:strtolower(CONTROLLER_NAME)}.js?v={:C('APP_VERSION')}" charset="utf-8"></script>
	</if>
<script type="text/javascript">
	var gMessageTitle = '{$T->str_g_message_title}';
	var gMessageSubmit1 = '{$T->str_g_message_submit1}';
	var gMessageSubmit2 = '{$T->str_g_message_submit1}';
	var gPublic = "{:U('/','','','', true)}";
  var gTextUser = gPublic+'js/jsExtend/ueditor/themes/comiframe.css';
	var codeLoginOther = "{$code}";//用户在其他地方登录code
  var checkMsgUrl = "{:U(MODULE_NAME.'/Common/checkMessage')}";
</script>
</body>
</html>
