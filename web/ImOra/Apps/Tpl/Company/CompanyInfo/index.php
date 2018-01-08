<layout name="../Layout/Company/Layout" />
<div class="CompanyInfoWrap">
    <p><span>企业名称：</span><span>{$Info['name']}</span></p>
    <p><span>联系人:</span><span>{$Info['contact']}</span></p>
    <p><span>联系电话：</span><span>{$Info['phone']}</span></p>
    <p><span>行业：</span><span>{$Info['type']}</span></p>
    <p><span>规模：</span><span>{$Info['size']}</span></p>
    <p><span>网址：</span><span>{$Info['website']}</span></p>
    <p><span>规模：</span><span>{$Info['size']}</span></p>
    <p><span>详细地址：</span><span>{$Info['address']}</span></p>
    <a href="{:U('Company/CompanyInfo/edit','',false)}"><button>修改</button></a>
</div>
