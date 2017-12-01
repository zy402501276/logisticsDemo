<?php
/**
 * auto complete select
 * document: http://api.jqueryui.com/autocomplete/
 * @descript 额外绑定事件:
 * 		select事件: $("select").next().find(".ui-autocomplete-input").on("autocompleteselect", function(event,ui){console.log(ui.item)});
 * 		change事件: $("select").next().find(".ui-autocomplete-input").on("autocompletechange", function(event,ui){console.log(ui.item)});
 * @author shezz
 */
class Combobox {

	/**
	 * 对应model类, 如果与model绑定, 则下拉列表自动与attribute进行值绑定
	 */
	public $model = null;
	/**
	 * 对应属性 
	 */
	public $attribute = '';
	/**
	 * 下拉列表数据
	 */
	public $data = array();
	/**
	 * 下拉列表名称,如果model为null, 则使用name
	 */
	public $name = 'selectName';
	/**
	 * 下拉列表值, 如果model为null, 则使用这值 
	 */
	public $value = '';
	/**
	 * 需要过滤的某些下拉列表key
	 */
	public $filterData = array();
	/**
	 * 默认值, 如果attribute或者value均为空值时,可指定这个指为默认值
	 */
	public $defaultValue = '';
	/**
	 * 下拉列表默认显示文案, 当值为false或者null时, 则去掉缺省选项
	 */
	public $defaultText = '选择全部';
	/**
	 * 是否只输出初始化script, 用于ajax动态生成使用
	 */
	public $onlyInitScript = false;
	/**
	 * 文本框name属性
	 */
	public $inputName = '';
	/**
	 * 文本框value值,如果指定了这个值,则强制使用这个值忽略select中的选项
	 */
	public $inputValue = '';
	/**
	 * 是否检查输入值有效
	 */
	public $checkValue = true;
	/**
	 * 额外class样式
	 */
	public $extClass = '';
	/**
	 * 下拉列表的css显示层级
	 */
	public $zindex = '99';
	
	public function init() {
		if ($this->filterData) {
			foreach ($this->filterData as $f) {
				if (isset($this->data[$f])) {
					unset($this->data[$f]);
				}
			}
		}
		if (empty($this->value)) {
			$this->value = $this->defaultValue;
		}
		if (!is_null($this->model) && property_exists(get_class($this->model), $this->attribute) && is_null($this->model->{$this->attribute})) {
			$this->model->{$this->attribute} = $this->defaultValue;
		}
		if (is_null($this->defaultText) || (is_bool($this->defaultText) && !$this->defaultText)) {
			$this->defaultText = 'NULL';
		}
	}
	
	public function run() {
		$selectId = '';
		if (is_null($this->model)) {
			echo CHtml::dropDownList($this->name, $this->value, $this->data);
			$selectId = $this->name;
		} else {
			echo CHtml::activeDropDownList($this->model, $this->attribute, $this->data);
			$selectId = CHtml::activeId($this->model, $this->attribute);
		}
		
		if (!$this->onlyInitScript) {
			$assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.webwidget.select.assets')); 
			Yii::app()->getClientScript()->registerCssFile($assetsUrl.'/css/combobox-ui.css');
			Yii::app()->getClientScript()->registerCssFile($assetsUrl.'/css/combobox.css');
			
			Yii::app()->getClientScript()->registerScriptFile($assetsUrl.'/js/jquery-ui.js', CClientScript::POS_END);
			Yii::app()->getClientScript()->registerScriptFile($assetsUrl.'/js/combobox.js', CClientScript::POS_END);
		}
		$script = '$("#'.$selectId.'").combobox({
			options:{
				defaultText:"'.strtolower($this->defaultText).'", 
				inputName:"'.$this->inputName.'", 
				checkValue:"'.$this->checkValue.'", 
				inputValue:"'.$this->inputValue.'",
				zindex: '.$this->zindex.',
				extClass: "'.$this->extClass.'"
			}
		});';
		Yii::app()->getClientScript()->registerScript($selectId.'Script', $script, CClientScript::POS_END);
	}
	
}