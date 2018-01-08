
<foreach name="versionlist['datalist']" item="val" key="keys">
    <div class="js_version_li_container_{$keys}" mark_type="{$keys}" >
        <li class='js_version js_all_in_one' marks="mark" title="{$T->str_exchange_version}" data-val="">{$T->str_exchange_version}</li>
        <foreach name="val" item="vals">
            <li class="js_version" title="{$vals}" marks="mark" data-val="{$vals}">{$vals}</li>
        </foreach>
    </div>
</foreach>