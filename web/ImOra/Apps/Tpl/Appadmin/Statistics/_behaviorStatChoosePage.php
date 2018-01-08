            <php>
            $params = array(
                       'platform'  => $platform,
                       'channel'   => $reqChannels,
                       'version'   => $reqVersions,
                       'moduleId'  => $reqModuleIds,
                       'startTime' => $startTime,
                       'endTime'   => $endTime,
                       'timeType'  => $timeType);
            $urlParams = http_build_query($params);
            $lowerActonName = strtolower(ACTION_NAME);
            switch ($lowerActonName) {
                case 'behaviortotalusers':
                    $defaultString = $T->stat_total_visit_users;
                    break;
                case 'behavioravgvisits':
                    $defaultString = $T->stat_avg_visit_times;
                    break;
                case 'behavioruservisitrate':
                    $defaultString = $T->stat_user_visit_rate;
                    break;
                default:
                    $defaultString = $T->stat_avg_visit_duration;
                    break;
            }
            </php>
            <div class="select_xinzeng js_select_item margin_top">
    			<input type="text" name="platform" value="{$defaultString}"/>
    			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
    			<ul>
    			   <if condition="$lowerActonName eq 'behaviortotalusers'">
    				<li title="{$T->stat_total_visit_users}">{$T->stat_total_visit_users}</li>
    			   <else />
    			    <li onclick="window.location.href='{:U(CONTROLLER_NAME.'/behaviorTotalUsers')}?{$urlParams}';" title="{$T->stat_total_visit_users}">{$T->stat_total_visit_users}</li>
    			   </if>
    			   <if condition="$lowerActonName eq 'stat_avg_visit_times'">
    				<li title="{$T->stat_avg_visit_times}">{$T->stat_avg_visit_times}</li>
    			   <else />
    			    <li onclick="window.location.href='{:U(CONTROLLER_NAME.'/behaviorAvgVisits')}?{$urlParams}';" title="{$T->stat_avg_visit_times}">{$T->stat_avg_visit_times}</li>
    			   </if>
    			   <if condition="$lowerActonName eq 'behavioravgduration'">
    				<li title="{$T->stat_avg_visit_duration}">{$T->stat_avg_visit_duration}</li>
    			   <else />
    			    <li onclick="window.location.href='{:U(CONTROLLER_NAME.'/behaviorAvgDuration')}?{$urlParams}';" title="{$T->stat_avg_visit_duration}">{$T->stat_avg_visit_duration}</li>
    			   </if>
    			   <if condition="$lowerActonName eq 'behavioruservisitrate'">
    				<li title="{$T->stat_user_visit_rate}">{$T->stat_user_visit_rate}</li>
    			   <else />
    				<li onclick="window.location.href='{:U(CONTROLLER_NAME.'/behaviorUserVisitRate')}?{$urlParams}';" title="{$T->stat_user_visit_rate}">{$T->stat_user_visit_rate}</li>
    			   </if>

    			</ul>
    		</div>