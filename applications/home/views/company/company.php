<div class="right-side fr details">
	<div class="right-first fs14">
		<div class="goods-name fl">
			<span class="important">*</span>
			<span class="goods-text fs14">公司名称 :</span>
			<span><?php echo $data['companyName']?></span>

		</div>
	</div>

	<div class="right-first fs14">
		<div class="goods-name fl">
			<span class="important">*</span>
			<span class="goods-text fs14">公司简称 : </span>
			<span><?php echo $data['companyShortName']?></span>

		</div>
		<div class="goods-name fl">
			<span class="important">*</span>
			<span class="goods-text fs14">公司电话 :</span>
			<span><?php echo $data['contactPhone']?></span>
		</div>
		<div class="goods-name fl">
			<span class="important">*</span>
			<span class="goods-text fs14">公司联系人 :</span>
			<span><?php echo $data['contactName']?></span>
		</div>
	</div>
	<div class="right-first fs14">
		<div class="goods-name fl">
			<span class="important">*</span>
			<span class="goods-text fs14">公司地址 :</span>
			<span><?php echo Areas::model()->getAreaName($data['provinceId'],$data['cityId'],$data['areaId']).' '.$data['adress']?></span>
		</div>
	</div>
	<div class="foot">
        <a href="<?php echo url('/company/companyInfo',array('type'=>1))?>"><button class="btn fs14">修改</button></a>
	</div>

</div>