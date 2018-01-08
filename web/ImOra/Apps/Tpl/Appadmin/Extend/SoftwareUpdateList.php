<if condition="$list neq ''">
    <foreach name="list" item="item" key="k">
        <div class='Journalsection_list_c'>
            <span class='span_span11'><i class='js_select' val='id'></i></span>
            <span class='span_span1'>{$k+$start+1}</span>
            <span class='span_span1 toVersion ' title="{$item.toVersion}">{:cutstr($item['toVersion'],6)}</span>
            <span class='span_span1 zipName ' title="{$item.zipName}">{:cutstr($item['zipName'],8)}</span>
                        <span class='span_span1 size' title="{$item.size}"><?php $size= round($item['size']/1024/1024,2);
                            $size ==0 ? $size= '<1KB' : $size=$size ;
                            echo $size.'M'; ?></span>
            <span class='span_span1 desc ' title="{$item.desc}">{:cutstr($item['desc'],7)}</span>
                        <span class='span_span1 addTime ' title="{:date('Y-m-d',$item['addTime'])}">
                            {:date('Y-m-d',$item['addTime'])}</span>
            <span class="span_span1" title="{$item.store}">{:cutstr($item['store'],7)}</span>
            <span class="span_span1" title="{$item.newfn}">{:cutstr($item['newfn'],7)}</span>
        </div>
    </foreach>
</if>