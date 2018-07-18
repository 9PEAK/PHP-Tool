<?php
namespace Peak\Tool;

abstract class Api {


	static function reset ()
	{
		self::$url = '';
		self::$param = [];
	}


	/**
	 * 1 设置url
	 * */
	protected static $url = '';
	static function url ($url='')
	{
		return self::$url .= $url;
	}


	/**
	 * 2 设置请求参数
	 * */
	protected static $param = [];
	static function param ($key, $val=null)
	{
		if ( is_array($key)) {
			foreach ($key as $k=>&$v) {
				self::param($k, $v);
			}
		} else {
			self::$param[$key] = $val;
		}
		return self::$param;
	}



}
