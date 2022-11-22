<?php

declare(strict_types=1);

namespace Xanax\Classes\Protocol;
class PHP {

	public const _STANDARD_ERROR_ = "php://stderr";

	public const _STANDARD_OUTPUT_ = "php://stdout";

	public const _STANDARD_INPUT_ = "php://stdin";

	public const _FILTER_ = "php://filter";

	public const _TEMPORARY_ = "php://temp";

	public const _MEMORY_ = "php://memory";

	public const _INPUT_ = "php://input";

	public const _OUTPUT_ = "php://output";

	public function getStandardError() {
		return _STANDARD_ERROR_;
	}

	public function getStandardOutput() {
		return _STANDARD_OUTPUT_;
	}

	public function getStandardInput() {
		return _STANDARD_INPUT_;
	}

	public function getFilter() {
		return _FILTER_;
	}

	public function getTemporary() {
		return _TEMPORARY_;
	}

	public function getMemory() {
		return _MEMORY_;
	}

	public function getInput() {
		return _INPUT_;
	}

	public function getOutput() {
		return _OUTPUT_;
	}

}
