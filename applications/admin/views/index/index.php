<div class="right-table">
    <h3>系统首页</h3>
    <div class="system-cont">
        <div class="system-box">
            <div class="system-box-top">
                <div class="img"><img src="<?php echo UtilsHelper::getUploadImages("/admin/img/conmany-btn.png")?>"><span>123</span> </div>
                <b>报价线路报价查看</b>
            </div>
            <div class="system-btn system-btn-3">
                <a href=""  class="">
                    待报价
                </a>
                <a href=""  class="">
                    已报价
                </a>
                <a href=""  class="">
                    所有报价
                </a>
            </div>
        </div>
        <div class="system-box">
            <div class="system-box-top">
                <div class="img"><img src="<?php echo UtilsHelper::getUploadImages("/admin/img/mess-btn.png")?>"><span>112</span> </div>
                <b>订单物流订单查看</b>
            </div>
            <div class="system-btn system-btn-4">
                <a href=""  class="hasSpan">
                    未处理<span>12</span>
                </a>
                <a href=""  class="hasSpan">
                   待配送<span>12</span>
                </a>
                <a href=""  class="hasSpan">
                   运输中<span>12</span>
                </a>
                <a href=""  class="hasSpan">
                   已验收<span>12</span>
                </a>
            </div>
        </div>
        <div class="system-box">
            <div class="system-box-top">
                <div class="img"><img src="<?php echo UtilsHelper::getUploadImages("/admin/img/conmany-btn.png")?>"><span><?php echo $vehicleNum?></span> </div>
                <b>车辆车辆管理情况</b>
            </div>
            <div class="system-btn system-btn-3">
                <a href="<?php echo url("cars/index", array("AdminVehicleInfoForm[deliveryStatus]" => VehicleInfo::DELIVERYSTATUS_IDLE))?>"  class="<?php echo $idleItem > 0 ? "hasSpan" : "";?>">
                    待接单<?php echo $idleItem > 0 ? "<span>$idleItem</span>" : "";?>
                </a>
                <a href="<?php echo url("cars/index", array("AdminVehicleInfoForm[deliveryStatus]" => VehicleInfo::DELIVERYSTATUS_ING))?>"  class="<?php echo $ingNum > 0 ? "hasSpan" : "";?>">
                    运输中<?php echo $ingNum > 0 ? "<span>$ingNum</span>" : "";?>
                </a>
                <a href="<?php echo url("cars/index", array("AdminVehicleInfoForm[deliveryStatus]" => VehicleInfo::DELIVERYSTATUS_ERROR))?>"  class="<?php echo $errorNum > 0 ? "hasSpan" : "";?>">
                    异常<?php echo $errorNum > 0 ? "<span>$errorNum</span>" : "";?>
                </a>
            </div>
        </div>
        <div class="system-box">
            <div class="system-box-top">
                <div class="img"><img src="<?php echo UtilsHelper::getUploadImages("/admin/img/conmany-btn.png")?>"><span><?php echo $companyNum?></span> </div>
                <b>企业企业信息管理</b>
            </div>
            <div class="system-btn system-btn-3">
                <a href="<?php echo url("company/index", array("AdminCompanyForm[isAuth]" => Company::ISAUTH_PASS))?>"  class="<?php echo $passNum > 0 ? "hasSpan" : "";?>">
                    通过<?php echo $passNum > 0 ? "<span>$passNum</span>" : "";?>
                </a>
                <a href="<?php echo url("company/index", array("AdminCompanyForm[isAuth]" => Company::ISAUTH_NOPASS))?>"  class="<?php echo $noPassNum > 0 ? "hasSpan" : "";?>">
                    未通过<?php echo $noPassNum > 0 ? "<span>$noPassNum</span>" : "";?>
                </a>
                 <a href="<?php echo url("company/index")?>"  class="<?php echo $companyNum > 0 ? "hasSpan" : "";?>">
                    所有企业<?php echo $companyNum > 0 ? "<span>$companyNum</span>" : "";?>
                </a>
            </div>
        </div>
        <div class="system-box">
            <div class="system-box-top">
                <div class="img"><img src="<?php echo UtilsHelper::getUploadImages("/admin/img/conmany-btn.png")?>"><span><?php echo $drivesNum?></span> </div>
                <b>司机司机管理查看</b>
            </div>
            <div class="system-btn system-btn-3">
                <a href="<?php echo url("drives/index", array("AdminDrivesForm[dState]" => Drives::DSTATE_VALID))?>"  class="<?php echo $validNum > 0 ? "hasSpan" : "";?>">
                    启用<?php echo $validNum > 0 ? "<span>$validNum</span>" : "";?>
                </a>
                <a href="<?php echo url("drives/index", array("AdminDrivesForm[dState]" => Drives::DSTATE_INVALID))?>"  class="<?php echo $invalidNum > 0 ? "hasSpan" : "";?>">
                    停用<?php echo $invalidNum > 0 ? "<span>$invalidNum</span>" : "";?>
                </a>
                <a href="<?php echo url("drives/index")?>"  class="<?php echo $drivesNum > 0 ? "hasSpan" : "";?>">
                    所有司机<?php echo $drivesNum > 0 ? "<span>$drivesNum</span>" : "";?>
                </a>
            </div>
        </div>
    </div>
</div>