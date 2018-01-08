<layout name="../Layout/Company/AdminLTE_layout" />
<div class="row_title">{$T->str_index_can_do}</div>
 <div class="row">
   <a href="{:U(MODULE_NAME.'/Customer/index')}">
    <div class="col-md-3 col-sm-6 col-xs-12">
     <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="ion guanli"></i></span>
      <div class="info-box-content">
       <span class="info-box-text">{$T->str_index_customer_manage}</span>
      </div>
      <!-- /.info-box-content -->
     </div>
     <!-- /.info-box -->
    </div>
    </a>
   <!-- /.col -->
   <a href="{:U(MODULE_NAME.'/Staff/index')}">
    <div class="col-md-3 col-sm-6 col-xs-12">
     <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa infoper"></i></span>
      <div class="info-box-content">
       <span class="info-box-text">{$T->str_index_staff_manage}</span>
      </div>
      <!-- /.info-box-content -->
     </div>
     <!-- /.info-box -->
    </div>
   </a>
   <!-- /.col -->
   <!-- fix for small devices only -->
   <div class="clearfix visible-sm-block"></div>
   <a href="{:U(MODULE_NAME.'/CompanyInfo/newsList')}">
    <div class="col-md-3 col-sm-6 col-xs-12">
     <div class="info-box">
      <span class="info-box-icon bg-green"><i class="ion dongtai"></i></span>
      <div class="info-box-content">
       <span class="info-box-text">{$T->str_publish_company_news}</span>
      </div>
      <!-- /.info-box-content -->
     </div>
     <!-- /.info-box -->
    </div>
   </a>
   <!-- /.col -->
   <a href="{:U(MODULE_NAME.'/DataStatistics/index')}">
    <div class="col-md-3 col-sm-6 col-xs-12">
     <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="ion ionoutline"></i></span>
      <div class="info-box-content">
       <span class="info-box-text">{$T->str_show_data_statistics}</span>
      </div>
      <!-- /.info-box-content -->
     </div>
     <!-- /.info-box -->
    </div>
   </a>
  <!-- /.col -->
  </div>
  <!-- /.row -->
 <div class="row">&nbsp;</div>
  <!-- /.row -->
 <div class="row">
   <div class="col-lg-4 col-xs-4">
    <!-- small box -->
    <div class="small-box bg-aqua bg_white">
     <div class="inner">
      <h3 class="title_h3">{$T->str_company_certification}</h3>
      <p>{$T->str_index_certification}<i>
        <span class="fa fa-fw fa-spinner lodding_icon round js_loding" id="js_certification_status"></span>
       </i></p>
     </div>
     <a class="small-box-footer" href="{:U(MODULE_NAME.'/Index/certification')}">{$T->str_index_certification} <i class="fa fa-angle-right"></i></a>
    </div>
   </div>
   <!-- ./col -->
   <div class="col-lg-4 col-xs-4">
    <!-- small box -->
    <div class="small-box bg-green bg_white">
     <div class="inner">
      <h3 class="title_h3">{$T->str_user_authority}</h3>
      <p>{$T->str_has_opened}<span class="fa fa-fw fa-spinner lodding_icon round js_loding" id="js_accreditNum" ></span>{$T->str_index_int}</p>
     </div>
     <a class="small-box-footer" href="{:U(MODULE_NAME.'/Index/accredit')}">{$T->str_index_manage}  <i class="fa fa-angle-right"></i></a>
    </div>
   </div>
   <!-- ./col -->
   <div class="col-lg-4 col-xs-4">
    <!-- small box -->
    <div class="small-box bg-yellow bg_white">
     <div class="inner">
      <h3 class="title_h3">{$T->str_consumer_account}</h3>
      <p>{$T->str_index_balance}<span id="js_money" class="fa fa-fw fa-spinner lodding_icon round js_loding"></if>
       </span></p>
     </div>
     <a class="small-box-footer" href="{:U(MODULE_NAME.'/Pay/payList','','',true)}">{$T->str_index_pay}  <i class="fa fa-angle-right"></i></a>
    </div>
   </div>
   <!-- ./col -->
  </div>
  <div class="row">
   <div class="col-lg-6 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua bg_white">
     <div class="inner">
      <h3 class="title_h3">{$T->str_current_card_num} <span class="fa fa-fw fa-spinner lodding_icon round js_loding" id="js_card_all"></span> {$T->str_index_piece}</h3>
     </div>
     <div class="row">
      <div class="col-lg-4 col-xs-6">
       <!-- small box -->
       <div class="small-box bg-aqua bg_white inner_h3">
        <div class="inner">
         <h3><span class=" fa fa-fw fa-spinner lodding_icon round js_loding js_card_num" id="js_card_day"></span></h3>
         <p class="padding_none">{$T->str_index_add_day}</p>
        </div>
       </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-xs-6">
       <!-- small box -->
       <div class="small-box bg-green bg_white inner_h3">
        <div class="inner">
         <h3><span class=" fa fa-fw fa-spinner lodding_icon round js_loding js_card_num" id="js_card_week"></span></h3>
         <p class="padding_none">{$T->str_index_add_week}</p>
        </div>
       </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-xs-6">
       <!-- small box -->
       <div class="small-box bg-yellow bg_white inner_h3 cbg_white">
        <div class="inner">
         <h3><span class="fa fa-fw fa-spinner lodding_icon round js_loding" id="js_card_month"></span></h3>
         <p class="padding_none">{$T->str_index_add_month}</p>
        </div>
       </div>
      </div>
      <!-- ./col -->
     </div>
     <a class="small-box-footer" href="{:U(MODULE_NAME.'/Customer/index')}">{$T->str_index_show} <i class="fa fa-angle-right"></i></a>
    </div>
   </div>
   <!-- ./col -->
   <div class="col-lg-6 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green bg_white">
     <div class="inner">
      <h3 class="title_h3">{$T->str_card_scanner}<span  class="fa fa-fw fa-spinner lodding_icon round js_loding" id="js_scannerNum"></span>{$T->str_index_one}</h3>
     </div>
     <div class="row">
      <div class="col-lg-4 col-xs-6">
       <!-- small box -->
       <div class="small-box bg-aqua bg_white inner_h3">
        <div class="inner">
         <h3><span  class=" fa fa-fw fa-spinner lodding_icon round js_loding js_scan_num" id="js_scan_day"></span></h3>
         <p class="padding_none">{$T->str_index_scan_day}</p>
        </div>
       </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-xs-6">
       <!-- small box -->
       <div class="small-box bg-green bg_white inner_h3">
        <div class="inner">
         <h3><span class=" fa fa-fw fa-spinner lodding_icon round js_loding js_scan_num" id="js_scan_week"></span></h3>
         <p class="padding_none">{$T->str_index_scan_week}</p>
        </div>
       </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-xs-6">
       <!-- small box -->
       <div class="small-box bg-yellow bg_white inner_h3 cbg_white">
        <div class="inner">
         <h3><span class="fa fa-fw fa-spinner lodding_icon round js_loding  js_scan_num" id="js_scan_month"></span></h3>
         <p class="padding_none">{$T->str_index_scan_month}</p>
        </div>
       </div>
      </div>
      <!-- ./col -->
     </div>
     <a class="small-box-footer" href="{:U(MODULE_NAME.'/Scanner/scannerRecord')}">{$T->str_index_show} <i class="fa fa-angle-right"></i></a>
    </div>
   </div>
   <!-- ./col -->
  </div>
<script>
 var gGetDataUrl="{:U(MODULE_NAME.'/Index/AjaxGetIndexData')}";
 $(function($){
  $.index.AjaxGetIndexData(gGetDataUrl);

 });

</script>