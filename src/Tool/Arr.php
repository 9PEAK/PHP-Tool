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
	static function reset_key (array $arr, $type, $recursive=true, $glue='_')
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
			$arr[Str::$func($key, $glue)] = is_array($val)&&$recursive ? self::{__FUNCTION__}($val, $type, true, $glue) : $val;
		}

		return $arr;
	}



	/**
	 * array to object or object to array (数组和对象类型转换)
	 * @param $dat
	 * @param $to string, object or array, the result type
	 * @param $recursive boolean, if convert data recursively
	 * */
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


	/**
	 * 将数组里的元素转化为utf8
	 * 深度转化，递归至最深层次的数组元素
	 * */
	static function utf8 (array &$arr) {
		foreach ( $arr as &$v ) {
			if (is_array($v)) {
				$func = __FUNCTION__;
				self::$func($v);
			} else {
				$v = mb_convert_encoding($v, 'UTF-8', 'Windows-1252');
			}
		}
		return $arr;
	}

	/**
	 * flip array, and set each item as a default value（翻转数组，并给每个元素设置初始值。）
	 *
	 * */
	static function flip (array $arr, $default=null)
	{
		$arr = array_flip($arr);
		foreach ($arr as &$val ) {
			$val = $default;
		}
		return $arr;
	}


}
