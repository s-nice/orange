<layout name="../Layout/H5Layout" />
<header class="head_box" style='display:none;'>
	<div class="faqsearch_box"><span class="name_top">{$data.question}</span></div>
</header>
<section class="content">
	<div class="faq_c">
		<div class="content_manual_text">
			<span>{$data.content}</span>
			<pre>{$data.content}</pre>
		</div>
	</div>
</section>
<include file="../Layout/replaceAudio" />