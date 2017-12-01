<script id="template-download" type="text/x-tmpl">
{%  for (var i=0, file; file=o.files[i]; i++) { %}
<div class="template-download galleryList">
	{% if (file.error) { %}
	<div class="error"><span class="label label-danger">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</div>
	{% } else { %}
	<div class="preview">
		{% if (file.publicThumb) { %}
			<a href="{%=file.publicUrl%}" title="{%=file.name%}" download="{%=file.name%}" data-lightbox="preview"><img src="{%=file.publicThumb%}"></a>
		{% }else{ %}
			<a href="{%=file.publicUrl%}" title="{%=file.name%}" download="{%=file.name%}" data-lightbox="preview"><img src="{%=file.publicUrl%}"></a>
		{% } %}
		<input type="hidden" name="Gallery[{%=file.filename%}][url]" value="{%=file.url%}" class="galleryBatchFileUrl"/>
		<input type="hidden" name="Gallery[{%=file.filename%}][thumb]" value="{%=file.thumb%}" class="galleryBatchFileThumb"/>
	</div>
	{% } %}
	<div class="button">
        {% if (file.setcoverUrl) { %}
                <button class="btn btn-warning setcover cover" data-type="{%=file.setcoverType%}" data-url="{%=file.setcoverUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                        <span>设为封面</span>
                </button>
        {% } %}
	{% if (file.deleteUrl) { %}
		<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
			<span>{%=locale.fileupload.destroy%}</span>
		</button>
                <!--
		<?php if ($this->multiple) : ?><input type="checkbox" name="delete" value="1" class="toggle">
		<?php else: ?><input type="hidden" name="delete" value="1">
		<?php endif; ?>
                -->
	{% } else { %}
		<button class="btn btn-warning cancel">
			<span>{%=locale.fileupload.cancel%}</span>
		</button>
	{% } %}
	</div>
</div>
{% } %}
</script>