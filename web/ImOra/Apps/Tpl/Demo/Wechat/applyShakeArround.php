<pre>
<form method="post">
<legend>aaa</legend>
<label for="name">联系人姓名</label>
<input name="name" id="name" type="text" size="100"/>
name 	是 	联系人姓名，不超过20汉字或40个英文字母

<label for="email">联系人邮箱</label>
<input name="email" id="email" type="text" size="100"/>
email 	是 	联系人邮箱

<label for="phone_number">联系人电话</label>
<input name="phone_number" id="phone_number" type="text" size="100"/>
phone_number 	是 	联系人电话

<label for="industry_id">行业代号</label>
<input name="industry_id" id="industry_id" type="text" size="100"/>
industry_id 	是 	平台定义的行业代号，具体请查看链接行业代号

<label for="qualification_cert_urls1">相关资质文件的图片url</label>
<input name="qualification_cert_urls[]" id="qualification_cert_urls1" type="text" size="100"/>
<input name="qualification_cert_urls[]" id="qualification_cert_urls2" type="text" size="100"/>
qualification_cert_urls 	是 	相关资质文件的图片url，图片需先上传至微信侧服务器，用“素材管理-上传图片素材”接口上传图片，返回的图片URL再配置在此处；当不需要资质文件时，数组内可以不填写url

<label for="apply_reason">申请理由</label>
<textarea rows="5" cols="80" name="apply_reason" id="apply_reason" ></textarea>
apply_reason 	否 	申请理由，不超过250汉字或500个英文字母

<input type="submit" value="申请"/>
</form>
</pre>