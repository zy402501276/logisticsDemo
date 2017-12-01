<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<div class="template-upload galleryList">
    {% if (file.error) { %}
    <div class="error">{%=file.error%}</div>
    {% } else { %}
	<div class="preview"></div>
	<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
	{% } %}
	<div class="button">
		{% if (!file.error) { %}
		{% if (!o.options.autoUpload) { %}
			<button class="btn btn-primary start" disabled>
				<span>{%=locale.fileupload.start%}</span>
			</button>
		{% } %}
		{% } %}
		<button class="btn btn-warning cancel">
			<span>{%=locale.fileupload.cancel%}</span>
		</button>
	</div>
</div>
{% } %}
</script>