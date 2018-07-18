<?php
namespace Peak\Tool;

abstract class Arr {

	/**
	 * 获取数组元素
	 * @param $arr
	 * @param $key 支持链式调用 默认null
	 * @param $delimiter 链式调用分隔符
	 * @return mixed array | string
	 * */
	static function array_key_chain (array $arr, $key=null, $delimiter='.')
	{
		if ($key) {
			$key = explode($delimiter, $key);
			foreach ($key as $k) {
				$arr = @$arr[$k];
			}
		}
		return $arr;
	}



	/**
	 *
	 * */
	static function reset_key (array $arr, $type, $recursive=true)
	{
		/*
		switch ($type) {
			case 'UNDERSCORE':
				$func = 'caseUnderscore';
				break;

			case 'CAMEL':
				$func = 'caseCamel';
				break;

			case 'TITLE':
				$func = 'caseTitle';
		}*/
		$func = [
			'UNDERSCORE', 'CAMEL', 'TITLE'
		];
		if (!in_array($type, $func)) {
			throw new\Exception('Can\'t support the given type ('.$type.'). Only '.join(', ',$func). ' are available.');
		}

		$func = 'case'.ucfirst(strtolower($type));
		foreach ($arr as $key=>$val) {
			unset ($arr[$key]);
			$arr[Str::$func($key)] = is_array($val)&&$recursive ? self::{__FUNCTION__}($val, $type, true) : $val;
		}

		return $arr;
	}



	static function convert ($dat, $to='object', $recursive=false)
	{
		if (is_array($dat)||is_object($dat)) {
			$dat = $to=='object' ? (object)$dat : (array)$dat;

			if ($recursive) {
				foreach ($dat as &$val) {
					$val = self::{__FUNCTION__}($val, $to, true);
				}
			}
		}
		return $dat;

	}


}
