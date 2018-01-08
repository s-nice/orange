<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
		<div class="rule_list_item rule_item_font">
            <span class="span_span1 hand">系统模板/卡类型</span>
            <span class="span_span2">推荐策略优先级</span>
            <span class="span_span5"><em class="hand">操作</em></span>
        </div>
        <if condition="false AND isset($rulesList['default'])">
        <div class="rule_item">
            <div class="rule_title">默认相关推荐规则</div>
            <volist name="rulesList['default']" id="ruleTypes">
                <if condition="count($ruleTypes) gt 1">
                <div class="rule_pay_item">
                    <div class="pay_card_l">{$ruleTypes[0]['firstlevelname']}</div>
                    <div class="pay_card_r">
                     <volist name="ruleTypes" id="ruleInfo">
                      <div class="pay_card_list rule_list_color">
                        <span class=span_span1>{$ruleInfo['secondlevelname']}</span>
                        <span class="span_span2" title="<volist name="ruleInfo['rulevals']" id="ruleval">
                              {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}  &nbsp;</volist>">
                            <if condition="count($ruleInfo['rulevals']) eq 0">
                            ----
                            <else/>
                            <volist name="ruleInfo['rulevals']" id="ruleval">
                              {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}
                              &nbsp;
                            </volist>
                            </if>
                        </span>
                        <span class="span_span5">
                          <a  class="hand" href="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/showinfo', array('id'=>$ruleInfo['id']))}">
                            <em>编辑</em>
                          </a>
                        </span>
                      </div>
                     </volist>
                    </div>
                </div>
                <else />
                  <volist name="ruleTypes" id="ruleInfo">
                    <div class="rule_list_item rule_list_color list_hover">
                        <span class="span_span1">{$ruleInfo['firstlevelname']}</span>
                        <span class="span_span2" title="<volist name="ruleInfo['rulevals']" id="ruleval">
                          {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}  &nbsp;
                            </volist>">
                        <if condition="count($ruleInfo['rulevals']) eq 0">
                        ----
                        <else/>
                        <volist name="ruleInfo['rulevals']" id="ruleval">
                          {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}
                          &nbsp;
                            </volist>
                        </if>
                        </span>
                        <span class="span_span5">
                          <a  class="hand" href="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/showinfo', array('id'=>$ruleInfo['id']))}">
                            <em>编辑</em>
                          </a>
                        </span>
                    </div>
                  </volist>
                </if>
            </volist>
        </div>
        </if>
        <if condition="isset($rulesList['system'])">
        <div class="rule_item">
            <div class="rule_title">系统模块</div>
            <volist name="rulesList['system']" id="ruleTypes">
                <if condition="count($ruleTypes) gt 1">
                <div class="rule_pay_item">
                    <div class="pay_card_l">{$ruleTypes[0]['firstlevelname']}</div>
                    <div class="pay_card_r">
                     <volist name="ruleTypes" id="ruleInfo">
                      <div class="pay_card_list rule_list_color">
                        <span class=span_span1>{$ruleInfo['secondlevelname']}</span>
                        <span class="span_span2" title="<volist name="ruleInfo['rulevals']" id="ruleval">
                              {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}  &nbsp;
                            </volist>">
                            <if condition="count($ruleInfo['rulevals']) eq 0">
                            ----
                            <else/>
                            <volist name="ruleInfo['rulevals']" id="ruleval">
                              {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}
                              &nbsp;
                            </volist>
                            </if>
                        </span>
                        <span class="span_span5">
                          <a  class="hand" href="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/showinfo', array('id'=>$ruleInfo['id']))}">
                            <em>编辑</em>
                          </a>
                        </span>
                      </div>
                     </volist>
                    </div>
                </div>
                <else />
                  <volist name="ruleTypes" id="ruleInfo">
                    <div class="rule_list_item rule_list_color list_hover">
                        <span class="span_span1">{$ruleInfo['firstlevelname']}</span>
                        <span class="span_span2" title="<volist name="ruleInfo['rulevals']" id="ruleval">
                          {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}  &nbsp;</volist>">
                        <if condition="count($ruleInfo['rulevals']) eq 0">
                        ----
                        <else/>
                        <volist name="ruleInfo['rulevals']" id="ruleval">
                          {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}
                          &nbsp;
                            </volist>
                        </if>
                        </span>
                        <span class="span_span5">
                          <a  class="hand" href="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/showinfo', array('id'=>$ruleInfo['id']))}">
                            <em>编辑</em>
                          </a>
                        </span>
                    </div>
                  </volist>
                </if>
            </volist>
        </div>
        </if>

        <if condition="isset($rulesList['infocard'])">
        <div class="rule_item">
            <div class="rule_title">信息卡</div>
            <volist name="rulesList['infocard']" id="ruleTypes">
                <if condition="count($ruleTypes) gt 1">
                <div class="rule_pay_item">
                    <div class="pay_card_l">{$ruleTypes[0]['firstlevelname']}</div>
                    <div class="pay_card_r">
                     <volist name="ruleTypes" id="ruleInfo">
                      <div class="pay_card_list rule_list_color">
                        <span class=span_span1>{$ruleInfo['secondlevelname']}</span>
                        <span class="span_span2" title="<volist name="ruleInfo['rulevals']" id="ruleval">
                              {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}  &nbsp;
                            </volist>">
                            <if condition="count($ruleInfo['rulevals']) eq 0">
                            ----
                            <else/>
                            <volist name="ruleInfo['rulevals']" id="ruleval">
                              {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}
                              &nbsp;
                            </volist>
                            </if>
                        </span>
                        <span class="span_span5">
                          <a  class="hand" href="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/showinfo', array('id'=>$ruleInfo['id']))}">
                            <em>编辑</em>
                          </a>
                        </span>
                      </div>
                     </volist>
                    </div>
                </div>
                <else />
                  <volist name="ruleTypes" id="ruleInfo">
                    <div class="rule_list_item rule_list_color list_hover">
                        <span class="span_span1">{$ruleInfo['firstlevelname']}</span>
                        <span class="span_span2" title="<volist name="ruleInfo['rulevals']" id="ruleval">
                          {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}  &nbsp;
                            </volist>">
                        <if condition="count($ruleInfo['rulevals']) eq 0">
                        ----
                        <else/>
                        <volist name="ruleInfo['rulevals']" id="ruleval">
                          {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}
                          &nbsp;
                            </volist>
                        </if>
                        </span>
                        <span class="span_span5">
                          <a  class="hand" href="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/showinfo', array('id'=>$ruleInfo['id']))}">
                            <em>编辑</em>
                          </a>
                        </span>
                    </div>
                  </volist>
                </if>
            </volist>
        </div>
        </if>

        <if condition="isset($rulesList['cardtype'])">
        <div class="rule_item">
            <div class="rule_title">卡类型</div>
            <volist name="rulesList['cardtype']" id="ruleTypes">
                <if condition="count($ruleTypes) gt 1">
                <div class="rule_pay_item">
                    <div class="pay_card_l">{$ruleTypes[0]['firstlevelname']}</div>
                    <div class="pay_card_r">
                     <volist name="ruleTypes" id="ruleInfo">
                      <div class="pay_card_list rule_list_color">
                        <span class=span_span1>{$ruleInfo['secondlevelname']}</span>
                        <span class="span_span2" title="<volist name="ruleInfo['rulevals']" id="ruleval">
                              {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}  &nbsp; 
                            </volist>">
                            <if condition="count($ruleInfo['rulevals']) eq 0">
                            ----
                            <else/>
                            <volist name="ruleInfo['rulevals']" id="ruleval">
                              {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}
                              &nbsp;
                            </volist>
                            </if>
                        </span>
                        <span class="span_span5">
                          <a  class="hand" href="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/showinfo', array('id'=>$ruleInfo['id']))}">
                            <em>编辑</em>
                          </a>
                        </span>
                      </div>
                     </volist>
                    </div>
                </div>
                <else />
                  <volist name="ruleTypes" id="ruleInfo">
                    <div class="rule_list_item rule_list_color list_hover">
                        <span class="span_span1">{$ruleInfo['firstlevelname']}</span>
                        <span class="span_span2" title="<volist name="ruleInfo['rulevals']" id="ruleval">
                          {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}  &nbsp;
                            </volist>">
                        <if condition="count($ruleInfo['rulevals']) eq 0">
                        ----
                        <else/>
                        <volist name="ruleInfo['rulevals']" id="ruleval">
                          {$i}.{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}
                          &nbsp;
                            </volist>
                        </if>
                        </span>
                        <span class="span_span5">
                          <a  class="hand" href="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/showinfo', array('id'=>$ruleInfo['id']))}">
                            <em>编辑</em>
                          </a>
                        </span>
                    </div>
                  </volist>
                </if>
            </volist>
        </div>
        </if>
        <div class="warning_font clear">
            <h5>推荐策略说明：</h5>
            <p>1、标签：推荐包含某些标签的卡。</p>
            <p>2、日历事件：从最近日历中拿取；若无，则不显示；<br><em>2.1设置在里程卡、航程卡下，推荐包含行程的日历信息。</em></p>
            <p>3、相关地点：当前位置直径1公里的商户会员卡。<br><em>3.1设置在日历卡下，则是基于日历描述中的位置直径1公里的商户会员卡。</em><br><em>3.2设置在航程卡下，则推荐包含起落机场的商户会员卡。</em></p>
        </div>
	</div>
</div>
<script>
    $(function(){
        $.dataTimeLoad.init({minDate:{start:false,end:false},maxDate:{start:false,end:false}});
    });
</script>
