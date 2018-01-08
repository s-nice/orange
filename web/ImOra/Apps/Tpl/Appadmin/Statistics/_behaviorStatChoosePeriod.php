            <div class="js_stat_date_type">
            <php>
            $params = array(
                       'platform'  => $platform,
                       'channel'   => $reqChannels,
                       'version'   => $reqVersions,
                       'moduleId'  => $reqModuleIds,
                       'startTime' => $startTime,
                       'endTime'   => $endTime);
            $currentUrlParams = http_build_query($params);
            unset($params['startTime'], $params['endTime']);
            $urlParams = http_build_query($params);
            </php>
              <a style="color:#000;" class="{:($timeType=='day'?'on':'')}"
                href="{:(U(CONTROLLER_NAME.'/'.ACTION_NAME).'?timeType=day&'.($timeType=='day'?$currentUrlParams : $urlParams))}">日</a>
              <a style="color:#000;" class="{:($timeType=='week'?'on':'')}"
                href="{:(U(CONTROLLER_NAME.'/'.ACTION_NAME).'?timeType=week&'.($timeType=='week'?$currentUrlParams : $urlParams))}">周</a>
              <a style="color:#000;" class="{:($timeType=='month'?'on':'')}"
                href="{:(U(CONTROLLER_NAME.'/'.ACTION_NAME).'?timeType=month&'.($timeType=='month'?$currentUrlParams : $urlParams))}">月</a>
              <!-- <a style="color:#000;" class="{:($timeType=='year'?'on':'')}"
                href="{:(U(CONTROLLER_NAME.'/'.ACTION_NAME).'?timeType=year&'.($timeType=='year'?$currentUrlParams : $urlParams))}">年</a> -->
            </div>