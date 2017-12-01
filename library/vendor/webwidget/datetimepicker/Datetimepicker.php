<?php
/**
 * 日期插件
 * @author shezz
 * document: http://www.bootcss.com/p/bootstrap-datetimepicker/
 * 基于bootstrap.css
 * 
 * @demo 
 * 	$this->widget('ext.webwidget.datetimepicker.Datetimepicker', array(
 * 		'name' => 'dateName',
 * 		'value' => '2014-01-01 11:11:11'
 * 	))
 */
class Datetimepicker {
	
	/**
	 * 对应model类
	 */
	public $model = null;

	/**
	 * model对应属性
	 */
	public $attribute = '';
	
	/**
	 * 如果model为null, 则使用name
	 */
	public $name = '';
	
	/**
	 * 如果model为null, 则使用value 
	 */
	public $value = '';
	
	/**
	 * 额外样式
	 */
	public $class = '';
	
	/**
	 * 插件语言
	 * 支持语言: zh-CN,zh-TW,uk... 详见js/locales/下的js文件
	 */
	public $language = 'zh-CN';
	
	/**
	 * 日期格式, 符合 ISO-8601 格式的日期时间, 具体用法见文档
	 */
	public $dateFormat = 'yyyy-mm-dd hh:ii:ss';
	
	/**
	 * 一周从哪一天开始, 0（星期日）到 6（星期六）
	 */
	public $weekStart = 0;
	
	/**
	 * 此数值被当做步进值用于构建小时视图。对于每个 minuteStep 都会生成一组预设时间（分钟）用于选择
	 */
	public $minuteStep = 60;
	
	/**
	 * 当选择一个日期之后是否立即关闭此日期时间选择器。
	 * Boolean. 默认值：false
	 */
	public $autoclose = true;
	
	/**
	 * 是否允许通过方向键改变日期。
	 * Boolean. 默认值: true
	 */
	public $keyboardNavigation = true;
	
	/**
	 * 当选择器关闭的时候，是否强制解析输入框中的值。也就是说，当用户在输入框中输入了不正确的日期，选择器将会尽量解析输入的值，并将解析后的正确值按照给定的格式format设置到输入框中
	 * Boolean. 默认值: true
	 */
	public $forceParse = true;
	
	/**
	 * 如果此值为true 或 "linked"，则在日期时间选择器组件的底部显示一个 "Today" 按钮用以选择当前日期。如果是true的话，"Today" 按钮仅仅将视图转到当天的日期，如果是"linked"，当天日期将会被选中
	 * Boolean, "linked". 默认值: false
	 */
	public $todayBtn = true;
	
	/**
	 * 如果为true, 高亮当前日期
	 * Boolean. 默认值: false
	 */
	public $todayHighlight = true;
	
	/**
	 * 日期时间选择器所能够提供的最精确的时间选择视图, 次参数需要配合viewSelect参数, 组合使用, 组合不当,可能会导致时间选择之后, input没有时间显示的问题
	 * Number, String. 默认值：0, 'hour'
	 * Accepts: “days” or 1, “months” or 2, and “years” or 3
	 */
	public $minView = 0;
	
	/**
	 * 日期时间选择器最高能展示的选择范围视图。
	 * Number, String. 默认值：4, 'decade'
	 */
	public $maxView = 4;
	
	/**
	 * 日期时间选择器打开之后首先显示的视图。 可接受的值：
	 * Number, String. 默认值：2, 'month'
	 * 0 or 'hour' for the hour view
	 * 1 or 'day' for the day view
	 * 2 or 'month' for month view (the default)
	 * 3 or 'year' for the 12-month overview
	 * 4 or 'decade' for the 10-year overview. Useful for date-of-birth datetimepickers.
	 */
	public $startView = 2;
	
	/**
	 * 时间选择的最后一个视图, 默认插件一直点击到小时视图
	 * With this option you can select the view from which the date will be selected. By default it's the last one, 
	 * however you can choose the first one, so at each click the date will be updated
	 * Number or String. 默认值: same as minView (supported values are: 'decade', 'year', 'month', 'day', 'hour')
	 */
	public $viewSelect = 'hour';
	
	/**
	 * 是否将时间区分成上下午时间段分开展示
	 * Boolean 默认 false
	 */
	public $showMeridian = false;
	
	/**
	 * 额外的html属性 
	 */
	public $htmlOptions = array();
	
	/**
	 * 初始化参数
	 * 
	 * @author shezz
	 * @email shezz@lexiangzuche.com
	 * @date 2015年2月4日
	 */
	public function init() {
		//如果有特殊语种, 则在数组中继续追加追加
		if (!in_array($this->language, array('zh-CN', 'zh-TW', 'en', 'de', 'es'))) {
			$this->language = '';
		}
	}
	
	public function run() {
		//输出html
		$pluginId = '';
		if (is_null($this->model)) {
			echo CHtml::textField($this->name, $this->value, array_merge(array('class' => $this->class), $this->htmlOptions));
			$pluginId = $this->name;
		} else {
			echo CHtml::activeTextField($this->model, $this->attribute, array_merge(array('class' => $this->class), $this->htmlOptions));
			$pluginId = CHtml::activeId($this->model, $this->attribute);
		}
		
		$assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.webwidget.datetimepicker.assets'));
		//输出css
//  		Yii::app()->getClientScript()->registerCssFile('http://cdn.bootcss.com/bootstrap/3.3.2/css/bootstrap.min.css');
		Yii::app()->getClientScript()->registerCssFile($assetsUrl.'/css/bootstrap-datetimepicker.min.css');

		//输出js
		Yii::app()->getClientScript()->registerScriptFile($assetsUrl.'/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
		if ($this->language) {
			Yii::app()->getClientScript()->registerScriptFile($assetsUrl.'/js/locales/bootstrap-datetimepicker.'.$this->language.'.js', CClientScript::POS_END);
		}
		
		$script = <<<js
	$("#{$pluginId}").datetimepicker({
		format: "{$this->dateFormat}",
		language: "{$this->language}",
		autoclose: "{$this->autoclose}",
		minuteStep: {$this->minuteStep},
		weekStart: "{$this->weekStart}",
		forceParse: "{$this->forceParse}",
		keyboardNavigation: "{$this->keyboardNavigation}",
		todayBtn: "{$this->todayBtn}",
		todayHighlight: "{$this->todayHighlight}",
		minView: "{$this->minView}",
		maxView: "{$this->maxView}",
		startView: {$this->startView},
		viewSelect: "{$this->viewSelect}",
		showMeridian: "{$this->showMeridian}"
	});
js;
		Yii::app()->getClientScript()->registerScript($pluginId.'Script', $script, CClientScript::POS_END);
	}
}