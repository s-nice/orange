<foreach name="list" item="val" >
    <dl>
        <dt><img src="{$val['logo']}" alt=""></dt>
        <dd>
            <h6>{$val['name']}</h6>
            <span>{:$val['debitcard']==2?'借记卡':'';}{:($val['creditcard']==2 && $val['debitcard']==2)?'/':'';}{:$val['creditcard']==2?'信用卡':'';}</span>
        </dd>
    </dl>
</foreach>