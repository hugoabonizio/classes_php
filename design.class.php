<?php
class Layout extends DB {

	private $layout = '';
	private $vars = array();
	
	function setTemplate($file) {
		$content = file_get_contents($file);
            	$this->layout = $content;
	}
		
	function setContent($page, $dir='') {
		if ($content = @file_get_contents($dir . 'pags/' . $page . '.pag.php', false, $context)) {
			$page_vars = array('___content___');
			$vars_values = array($content);
			
			$selectVars = DB::iterate('page_vars', "page='" . $page . "'");
			foreach ($selectVars as $var) {
				$page_vars[] = '___' . $var['varname'] . '___';
				$vars_values[] = nl2br($var['value']);
			}
			
			//print_r($vars_values);
			$this->layout = str_replace($page_vars, $vars_values, $this->layout);
		}
	}

	
	function addVariables($vars) {
		foreach ($vars as $var=>$value) {
			$this->vars[$var] = $value;
		}
	}
	
	function render() {
		foreach ($this->vars as $var=>$value) {
			$this->layout = str_replace('___' . $var . '___', $value, $this->layout);
		}
                //$this->layout = mb_convert_encoding($this->layout, 'UTF-8', mb_detect_encoding($this->layout, 'UTF-8, ISO-8859-1', true));
		
                $this->layout = str_replace(array('รฃ', 'รง', 'รก'), array('ใ', '็', 'แ'), $this->layout);

                return $this->layout;
	}
}