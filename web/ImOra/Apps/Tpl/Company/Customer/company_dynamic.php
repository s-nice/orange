<if condition="$result['status'] eq 0 && $result['data']['numfound'] neq 0 ">
    <volist name="result['data']['list']" id="vo">
        <div class="card_info js_content_warmp"  data-menu-key="company_dynamic">
            <div class="undergo_div">
                <span>{$vo.title}</span>
                <span>{:date('Y-m-d',$vo['createtime'])}</span>
            </div>
            <div class="under_summer">
              {$vo.content}
            </div>
        </div>
    </volist>
    <else/>
        NO DATA
</if>
