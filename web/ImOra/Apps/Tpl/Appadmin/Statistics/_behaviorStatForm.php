
	            <div class="content_search">
	            	<div class="search_right_c">
	            	  <form method="get" action="{:U(CONTROLLER_NAME.'/'.ACTION_NAME)}">
	            		<div id="select_platform" class="select_sketch js_select_item menu_list">
	            			<input type="text" name="platform" value="{$platform}"/>
	            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul>
	            				<li class="on" title="{$T->stat_sys_platform}">{$T->stat_sys_platform}</li>
	            			  <if condition="$platform=='IOS'">
	            				<li class="on" title="IOS" val="IOS">IOS</li>
	            			  <else />
	            				<li title="IOS" val="IOS">IOS</li>
	            			  </if>
	            			  <if condition="$platform=='Android'">
	            				<li class="on" title="Android" val="Android">Android</li>
	            			  <else />
	            				<li title="Android" val="Android">Android</li>
	            			  </if>
	            			  <if condition="$platform=='Leaf'">
	            				<li class="on" title="Leaf" val="Leaf">Leaf</li>
	            			  <else />
	            				<li title="Leaf" val="Leaf">Leaf</li>
	            			  </if>
	            			</ul>
	            		</div>
	            		<div id="select_channel" class="select_sketch js_select_item js_multi_select menu_list">
	            		  <if condition="count($reqChannels)">
	            			<input type="text" value="{:(join('/', $reqChannelNames))}"/>
	            		   <volist name="reqChannels" id="_channel">
	            			<input type="hidden" name="channel[]" value="{$_channel}"/>
	            		   </volist>
	            		  <else />
	            			<input type="text" value="{$T->stat_channel}"/>
	            			<input type="hidden" name="channel[]" value="{$T->stat_channel}"/>
	            		  </if>
	            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul>
	            				<li class="on" class="js_all_in_one" value="" title="{$T->stat_channel}">{$T->stat_channel}</li>
	            			  <volist name="channels" id="_channel">
	            				<if condition="in_array($_channel['id'], $reqChannels)">
	            				<li class="on" data-link-value=",{$_channel['sys_platforms']}," val="{$_channel['id']}" title="{$_channel['channel']}">{$_channel['channel']}</li>
	            				<else />
	            				<li data-link-value=",{$_channel['sys_platforms']}," val="{$_channel['id']}" title="{$_channel['channel']}">{$_channel['channel']}</li>
	            				</if>
	            			  </volist>
	            			</ul>
	            		</div>
	            		<div id="select_module" class="select_sketch js_select_item js_multi_select menu_list">
	            		  <if condition="count($reqModuleIds)">
	            			<input type="text" value="{:(join('/', $moduleNames))}"/>
	            		   <volist name="reqModuleIds" id="_moduleId">
	            			<input type="hidden" name="moduleId[]" value="{$_moduleId}"/>
	            		   </volist>
	            		  <else />
	            			<input type="text" value="{$T->stat_all_modules}"/>
	            			<input type="hidden" name="moduleId[]" value="{$T->stat_all_modules}"/>
	            		  </if>
	            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul>
	            				<li class="on" class="js_all_in_one" val="" title="{$T->stat_all_modules}">{$T->stat_all_modules}</li>
	            			  <volist name="modules" id="_module">
	            			    <if condition="in_array($_module['page_id'], $reqModuleIds)">
	            				<li class="on" val="{$_module['page_id']}" title="{$_module['page_name']}">{$_module['page_name']}</li>
	            			    <else />
	            			    <li val="{$_module['page_id']}" title="{$_module['page_name']}">{$_module['page_name']}</li>
	            			    </if>
	            			  </volist>
	            			</ul>
	            		</div>
	            		<div id="select_prd_version" class="select_sketch js_select_item js_multi_select menu_list">
	            		  <if condition="count($reqVersions)">
	            			<input type="text" value="{:(join('/', $reqVersions))}"/>
	            		   <volist name="reqVersions" id="_version">
	            			<input type="hidden" name="version[]" value="{$_version}"/>
	            		   </volist>
	            		  <else />
	            			<input type="text" value="{$T->stat_prod_version}"/>
	            			<input type="hidden" name="version[]" value="{$T->stat_prod_version}"/>
	            		  </if>
	            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul>
	            				<li class="on" class="js_all_in_one" value="" title="{$T->stat_prod_version}">{$T->stat_prod_version}</li>
	            			  <volist name="versions" id="_version">
	            			    <if condition="in_array($_version['prd_version'], $reqVersions)">
	            				<li data-link-value=",{$_version['sys_platforms']}," class="on" val="{$_version['prd_version']}" title="{$_version['prd_version']}">{$_version['prd_version']}</li>
	            			    <else />
	            			    <li data-link-value=",{$_version['sys_platforms']}," val="{$_version['prd_version']}" title="{$_version['prd_version']}">{$_version['prd_version']}</li>
	            			    </if>
	            			  </volist>
	            			</ul>
	            		</div>
	            		<div class="select_time_c behavior_select_time_c">
						    <span>{$T->stat_date}</span>
							<div class="time_c behavior_time_c">
								<input class="time_input" value="{$startTime}" type="text" readonly="readonly" name="startTime" id="js_begintime"/>
								<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
							</div>
							<span>--</span>
							<div class="time_c">
								<input class="time_input" value="{$endTime}" type="text" readonly="readonly" name="endTime" id="js_endtime"/>
								<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
							</div>
		            	</div>
		            	  <input type="hidden" name="timeType" value="{$timeType}"/>
		            	  <input class="submit_button behavior_submit_button" type="submit" value="{$T->str_btn_ok}"/>
		              </form>
	            	</div>
	            </div>