<?php

namespace WePay\Common;

abstract class Enum {

	const __default = null;

	private static $_constList = null;
	private static $_valid = null;

	private $value;

	public function __construct($initial_value = null, $strict = true) {
		$cc = get_called_class();
		if (!isset(self::$_valid[$cc])) {
			self::$_valid[$cc] = array_flip($this->getConstList());
		}
		if ($initial_value === null) {
			$initial_value = static::__default;
		}
		if (isset(self::$_valid[$cc][$initial_value])) {
			$this->value = $initial_value;
		}
		else {
			throw new \UnexpectedValueException("Value not a const in enum ".get_called_class());
		}
	}

	// Because this is written in user-land, there's no good way to do equality
	// checks of switches on the object itself comparing to the constants. This
	// makes for a little syntactic sugar, i.e. if (SomeEnum::FOO === $foo())
	// or switch ($foo()) { case SomeEnum::FOO: ... }
	public function __invoke() {
		return $this->value;
	}


	public static function __callStatic($method, array $args) {
		$val = get_called_class().'::'.$method;
		if (defined($val)) {
			return new static(constant($val));
		}
		throw new \UnexpectedValueException("Value '$val' not a const in enum ".get_called_class());
	}

	private function getCachedConstants() {
		$cc = get_called_class();
		if (!isset(self::$_constList[$cc])) {
			$rc = new \ReflectionClass($this);
			self::$_constList[$cc] = $rc->getConstants();
		}
		return self::$_constList[$cc];
	}

	public function getConstList($include_default = false) {
		$list = $this->getCachedConstants();
		if ($include_default) {
			// Do nothing
		}
		else {
			unset($list['__default']);
		}
		return $list;
	}

	public function getValue() {
		return $this->value;
	}

	public function is($rawValue) {
		return $rawValue === $this->value;
	}

}


