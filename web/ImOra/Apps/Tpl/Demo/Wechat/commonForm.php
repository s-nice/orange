<pre>
<form method="post">
<fieldset>
 <legend>{:(isset($form['legend']) ? $form['legend'] : '')}</legend>
<volist name="form['data']" id="data">
<label >{$data['label']}</label>
<input name="{$data['name']}" type="{:(isset($data['type']) ? $data['type'] : 'text')}"
   size="{:(isset($data['size']) ? $data['size'] : '100')}"/>
{$data['desc']}
<br/>
<br/>
 </volist>
<br/>
<input type="submit" value="提 交"/>
</fieldset>
</form>
</pre>