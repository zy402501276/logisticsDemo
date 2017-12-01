<?php
class Excel {

	private $excel = null;
	public function __construct() {
		Yii::$enableIncludePath = false;
		Yii::import('ext.utils.phpexcel.PHPExcel');
		$this->excel = new PHPExcel();
	}
	
	public function exportDemo() {
		$this->excel->getProperties()->setCreator("Maarten Balliauw")
		->setLastModifiedBy("Maarten Balliauw")
		->setTitle("Office 2007 XLSX Test Document")
		->setSubject("Office 2007 XLSX Test Document")
		->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
		->setKeywords("office 2007 openxml php")
		->setCategory("Test result file");
		
		
		// Add some data
		$this->excel->setActiveSheetIndex(0)
		->setCellValue('A1', 'Hello')
		->setCellValue('B2', 'world!')
		->setCellValue('C1', 'Hello')
		->setCellValue('D2', 'world!');
		
		// Miscellaneous glyphs, UTF-8
		$this->excel->setActiveSheetIndex(0)
		->setCellValue('A4', 'Miscellaneous glyphs')
		->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
		
		// Rename worksheet
		$this->excel->getActiveSheet()->setTitle('Simple');
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$this->excel->setActiveSheetIndex(0);
		
		$this->output('test');
	}
	
	/**
	 * 输出文件
	 * @param unknown $fileName
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月24日
	 */
	public function output($fileName) {
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$fileName.'.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$objWriter->save('php://output');
	}
}