<layout name="../Layout/Layout" />
<style>
    .js_list_select ul{
        max-height: 200px;
    }

</style>
<div class="content_global">
    <div class="content_hieght">
               <div class="dai-menu-list js_select clear">
                <span>发卡单位:</span>
                <div class="list-card">
                    <input type="text" id="js_unit_input"
                           <if condition="isset($info)">value="{$info['unitname']}" val="{$info['unitid']}"
                               <else/>value="{$units[0]['lssuername']}" val="{$units[0]['id']}"</if>
                    readonly="readonly" />
                    <img class="dia-xia" src="__PUBLIC__/images/icons/appadmin_xiala_icon.png" alt="">
                    <ul style="max-height: 300px">
                        <volist name="units" id="vo">
                            <li data-id="{$vo.id}">{$vo.lssuername}</li>
                        </volist>
                    </ul>
                </div>
            </div>
            <div class="dai-menu-list clear">
                <span>酒店名称:</span>
                <div class="list-card">
                    <input type="text" name="name" class="js_name_input"
                    <if condition="isset($info)">value="{$info['name']}" </if>
                    />
                </div>
            </div>
            <div class="city-dia-menu clear">
                <div class="dai-menu-list js_select">
                    <span>城市:</span>
                    <div class="list-card">
                        <input type="text" id="js_province_input"
                        <if condition="isset($info)"> value="{$info['province']}" val="{$info['provincecode']}
                            <else/>value="{$provinces[0]['province']}" val="{$provinces[0]['provincecode']}"</if>

                      readonly="readonly" />
                        <img class="dia-xia" src="__PUBLIC__/images/icons/appadmin_xiala_icon.png" alt="">
                        <ul style="max-height: 300px">
                            <volist name="provinces" id="vo">
                                <li data-id="{$vo.provincecode}">{$vo.province}</li>
                            </volist>
                        </ul>
                    </div>
                </div>
                <div class="dai-menu-list js_select">
                    <div class="list-card list-card-right">
                        <input type="text" id="js_city_input"
                        <if condition="isset($info)"> value="{$info['city']}"
                            <else/>value="{$provinces[0]['province']}" val=""</if>
                      readonly="readonly" />
                        <img class="dia-xia" src="__PUBLIC__/images/icons/appadmin_xiala_icon.png" alt="">
                        <ul style="max-height: 300px">
                            <if condition="isset($info)">
                                <volist name="info['citys']" id="vocity">
                                    <li>{$vocity.city}</li>
                                </volist>
                            </if>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="dai-menu-list clear">
                <span>门禁卡加密类型:</span>
                <div class="list-card js_select" >
                    <input type="text"  readonly="readonly" id="js_encryption_type_input"
                    <if condition="isset($info)">value="{$info['encryptname']}" val="{$info['encryptid']}"
                        <else/> value="{$EncryptionTypes[0]['name']}" val="{$EncryptionTypes[0]['id']}"</if>

                 />
                    <img class="dia-xia" src="__PUBLIC__/images/icons/appadmin_xiala_icon.png" alt="">
                    <ul style="max-height: 300px">
                        <volist name="EncryptionTypes" id="vo2">
                            <li data-id="{$vo2.id}">{$vo2.name}</li>
                        </volist>
                    </ul>
                </div>
            </div>
            <div class="jiu-logo clear js_img_parent">
                <div class="dai-menu-list">
                    <span>选择酒店LOGO:</span>
                    <div class="list-card js_select" >
                        <input type="text"  readonly="readonly" id="js_logos_input"
                        <if condition="isset($info)">value="{$logos[$info['logo']]['name']}" val="{$info['logo']}"
                            <else/>  value="{$logos[0]['name']}" val="{$logos[0]['id']}"</if>

                     />

                        <img class="dia-xia" src="__PUBLIC__/images/icons/appadmin_xiala_icon.png" alt="">
                        <ul style="max-height: 300px">
                            <volist name="logos" id="vologo">
                                <li data-id="{$vologo.id}" data-src="{$vologo.path}">{$vologo.name}</li>
                            </volist>
                        </ul>
                    </div>
                </div>
                <img  <if condition="isset($info)"> src="{$logos[$info['logo']]['path']}"<else/>  src="{$logos[0]['path']}"</if> alt="" class="logo-q js_img_show" >
            </div>
            <div class="jiu-logo clear js_img_parent">
                <div class="dai-menu-list">
                    <span>选择门禁卡面:</span>
                    <div class="list-card js_select" >
                        <input type="text"  readonly="readonly" id="js_imgs_input"
                        <if condition="isset($info)">value="{$imgs[$info['path']]['name']}" val="{$info['path']}"
                            <else/>   value="{$imgs[0]['name']}" val="{$imgs[0]['id']}"</if>

                     />

                        <img class="dia-xia" src="__PUBLIC__/images/icons/appadmin_xiala_icon.png" alt="">
                        <ul style="max-height: 300px">
                            <volist name="imgs" id="voimg">
                                <li data-id="{$voimg.id}" data-src="{$voimg.path}">{$voimg.name}</li>
                            </volist>
                        </ul>
                    </div>
                </div>
                <img  <if condition="isset($info)"> src="{$imgs[$info['path']]['path']}"<else/>  src="{$imgs[0]['path']}"</if>
                     alt="" class="card-q js_img_show"  >
            </div>
            <div class="q-btn clear">
                <button class="middle_button" type="button" id="js_add_confirm" <if condition="isset($info)">data-id="{$_GET['id']}"</if> >确定</button>
                <button class="middle_button" type="button" id="js_add_cancel">取消</button>
            </div> 
    </div>
</div>
<script>
    var  gUrl="{:U('Appadmin/HotelAccessCard/addHotel','','','',true)}";
    var  doUrl ="{:U('Appadmin/HotelAccessCard/doOneHotel','','','',true)}";
    $(function(){
        $.hotelCard.hotelInit();

    })
</script>