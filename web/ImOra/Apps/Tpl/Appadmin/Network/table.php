<if  condition="$sleName_re">
    <div class="Data_c_name">
      <span class="span_c_1">{$T->stat_date}</span>
      <span class="span_c_1">{$T->stat_sys_platform}</span>
      <span class="span_c_1">{$sleName_re}</span>
      <span class="span_c_2">{$sleName}</span>
    </div>
<else />
    <if condition="$sle_type eq 8">
      <div class="Data_c_name">
        <span class="span_c_1">{$T->stat_date}</span>
        <span class="span_c_1">{$T->stat_sys_platform}</span>
        <span class="span_c_1">{$T->str_record_sum}</span>
        <span class="span_c_2">{$T->str_record_avg}</span>
      </div>
    <elseif condition="$sle_type eq 6" />
      <div class="Data_c_name">
        <span class="span_c_5">{$T->stat_date}</span>
        <span class="span_c_5">{$T->stat_sys_platform}</span>
        <span class="span_c_5">{$sleName}</span>
        <span class="span_c_5">{$T->str_im_sum}</span>
        <span class="span_c_6">{$T->str_im_avg}</span>
      </div>
    <else />
      <div class="Data_c_name">
        <span class="span_c_3">{$T->stat_date}</span>
        <span class="span_c_3">{$T->stat_sys_platform}</span>
        <span class="span_c_4">{$sleName}</span>
      </div>
    </if>
</if>
<div class="content_list">
  <if condition="count($dataArr) gt 0">
        <volist name="dataArr" id="_userStat" key="k">
          <div class="Data_c_list">
            <if condition="$sle_type eq 8">
              <span class="span_c_1">{$_userStat.t_time}</span>
              <span class="span_c_1">{$_userStat.sys_platform}</span>
              <span class="span_c_1">{$_userStat.sum}</span>
              <span class="span_c_2">{$_userStat.avg}</span>
            <elseif condition="$sle_type eq 6" />
              <span class="span_c_5">{$_userStat.t_time}</span>
              <span class="span_c_5">{$_userStat.sys_platform}</span>
              <span class="span_c_5">{$_userStat.num}</span>
              <span class="span_c_5">{$_userStat.sum}</span>
              <span class="span_c_6">{$_userStat.avg}</span>
            <elseif condition="$sleName_re" />
              <span class="span_c_1">{$_userStat.t_time}</span>
              <span class="span_c_1">{$_userStat.sys_platform}</span>
              <span class="span_c_1">{$_userStat.num_re}</span>
              <span class="span_c_2">{$_userStat.num}</span>
            <else />
              <span class="span_c_3">{$_userStat.t_time}</span>
              <span class="span_c_3">{$_userStat.sys_platform}</span>
              <span class="span_c_4">{$_userStat.num}</span>
            </if>
          </div>
        </volist>
  <else/>
       <p class="no_data">No Data</p>
  </if>
</div>