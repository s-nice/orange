<foreach name="data" item="vals">
    <div class="user_block" data_val="{$vals['empid']}" data-cid="{$vals['userid']}" data-departid="{$vals['groupid']}">
        <p class="js_user_name">{$vals['name']}</p>
        <p>{$vals['title']}</p>
        <p>{$vals['department']}</p>
        <p>手机：{$vals['mobile']}</p>
        <p>{$vals['email']}</p>
    </div>
</foreach>