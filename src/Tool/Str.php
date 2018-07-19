<?php
namespace Peak\Tool;

abstract class Str {

	const LETTER = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	const INTEGER = '1234567890';

	/**
	 *
	 * @param $type string, 1 upper letter, -1 lower letter, 0 integer.
	 * */
	private static function set_material($type)
	{
		$type = (string)$type;
		$material = [
			-1 => strtolower(self::LETTER),
			0 => self::INTEGER,
			1 => self::LETTER,
		];
		foreach ( $material as $i=>$unit ) {
			if (stripos($type, (string)$i)===false) {
				unset ($material[$i]);
			} else {
				$type = str_replace($i, '', $type);
			}
		}

		return join('', $material);
	}

	static function random ($size=4, $type='-101') {
		$code = self::set_material($type);
		$code = str_shuffle($code);
		return substr($code, 0, $size);
	}


	static function caseCamel ($str, $separator='_')
	{
		$str = $separator. str_replace($separator, ' ', strtolower($str));
		return ltrim(str_replace(' ', '', ucwords($str)), $separator );
	}

	static function caseTitle ($str, $separator='_')
	{
		return ucfirst(self::caseCamel($str, $separator));
	}


	static function caseUnderscore($str, $separator='_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $str));
    }

}
