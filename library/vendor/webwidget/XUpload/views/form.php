<!-- The file upload form used as target for the file upload widget -->
<?php
	if($this->showForm){
		echo CHtml::beginForm($this->url, 'post', $this->htmlOptions);
	}else{
		echo '<div id="' . $this->htmlOptions['id'] . '">';
	}
?>
<div class="fileupload-buttonbar">
	<div class="fileupload-buttons">
		<!-- The fileinput-button span is used to style the file input field as button -->
		<span class="btn btn-success fileinput-button">
            <span>选择图片</span>
			<?php
			if($this->hasModel()) :
				echo CHtml::activeFileField($this->model, $this->attribute, $htmlOptions) . "\n";
			else :
				echo CHtml::fileField($name, $this->value, $htmlOptions) . "\n";
			endif;
			?>
		</span>
		<?php if($this->multiple){ ?>
		<button type="submit" class="btn btn-primary start">
			<span>开始上传</span>
		</button>
<!--		<button type="reset" class="btn btn-warning cancel">
			<span>取消上传</span>
		</button>
		<button type="button" class="btn btn-danger delete">
			<span>删除选中图片</span>
		</button>
		<input type="checkbox" class="toggle">-->
		<?php } ?>
		<span class="fileupload-process"></span>
	</div>

	<div class="fileupload-progress fade">
		<!-- The global progress bar -->
		<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
			<div class="progress-bar progress-bar-success" style="width:0%;"></div>
		</div>
		<!-- The extended global progress state -->
		<div class="progress-extended"></div>
	</div>
</div>

<div class="clear"></div>

<?php if(isset($this->htmlOptions['notice'])){ ?>
<div class="notice"><?php echo $this->htmlOptions['notice']; ?></div>
<?php } ?>

<div class="files"></div>

<div class="clear"></div>

<?php
	if($this->showForm){
		echo CHtml::endForm();
	}else{
		echo '</div>';
	}
?>
