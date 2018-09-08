<script type="text/javascript" src="{!! $url !!}"></script>
 <div class="g-recaptcha"
	data-sitekey="{{ config('captcha.public_key') }}"
	data-size="invisible"
	data-badge="{{ $badge }}">
</div>
<script type="text/javascript">

	function onLoadCaptcha(){
		grecaptcha.execute();
	}
</script>