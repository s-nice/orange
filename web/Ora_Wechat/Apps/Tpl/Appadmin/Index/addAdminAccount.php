<layout name="../Layout/Appadmin/Layout" />
<div class="content_global">
    <div class="modifyinfo_namepass"><span>{$T->username}{$T->Email}:</span>
        <input type='text' name='email'  <if condition="isset($info)">value="{$info['email']}"</if>/><em id='tx_email'></em>
    </div>
    <div class="modifyinfo_namepass"><span>密码：</span>
        <input type='password'  name='password' placeholder="不修改密码则不填" /><em id='tx_password'></em>
    </div>
    <div class="modifyinfo_namepass"><span>确认密码：</span>
        <input type='password' name='password2' placeholder="不修改密码则不填" />
        <em id='tx_password2' ></em></div>
    <div class="modifyinfo_password"><span>真实姓名：</span>
        <input type='text' name='realname' <if condition="isset($info)">value="{$info['realname']}"</if> />
        <em id='tx_realname'></em></div>
    <div class="modifyinfo_buttonpass"><span></span>
        <button id='js_submit_add' class="big_button" <if condition="isset($info)">data-id="{$info['adminid']}"></if>{$T->modify_info_submit}</button>
    </div>
</div>
<script>
    var subUrl="{:U('Appadmin/Index/doAddEditAccount','','','',true)}";
    $(function(){
        $.adminAccount.addInit();
    })
</script>