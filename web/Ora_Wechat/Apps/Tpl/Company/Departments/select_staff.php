<foreach name="list" item="val">
    <li class="" data-sid="{$val['id']}">
        <label for=""><input val="{$val['id']}" type="checkbox" /></label>
        <em>{$val['name']}</em>
    </li>
</foreach>
