<div class="right-table">
            <h3>广告管理</h3>
            <div class="right-table-title">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'action' => Yii::app()->createUrl($this->route),
                        'method' => 'GET'
                    ));
                    ?>
                    <ul>
                            <li>
                                    <div>
                                            <span>广告位置:</span>
                                             <?php echo $form->dropdownList($model, 'pos',Slides::getStateAll(),array("empty" => "请选择","class" => "demo-select")); ?>
                                    </div>
                                    <div>
                                        <button type="submit" class="submit">搜索</button>
                                    </div>
                            </li>
                    </ul>
                    <?php $this->endWidget(); ?>


            </div>
            <table cellspacing="0" cellpadding="0">
                    <tr>
                                    <th>ID</th>
                                    <th>图片</th>
                                    <th>图片地址</th>
                                    <th>广告位置</th>
                                    <th>操作</th>

                    </tr>

                    <?php if($datas) { foreach($datas as $val) { 
                        ?>
                    <tr>
                            <td><?php echo $val["id"];?></td>
                            <td><img src="<?php echo UtilsHelper::getUploadImages($val["url"]);?>" id="showLogo" style="max-width: 200px;max-height: 150px;"/></td>
                            <td><?php echo $val["linkUrl"];?></td>
                            <td><?php echo Slides::getStateAll($val["pos"]);?></td>
                            <td>
                                <a href="<?php echo url("slides/edit",array('id'=>$val["id"]))?>">编辑</a>  
                    </tr>
                    <?php }}?>
            </table>
            <div class="right-bottom">
                <div class="link">
                    <!--<a href="<?php echo url("slides/edit")?>">新增</a>-->
                </div>
                <?php echo $this->renderPartial("/layouts/_pager", array("pager" => $pager));?>
                <div class="clearfix"></div>
            </div>

</div>

