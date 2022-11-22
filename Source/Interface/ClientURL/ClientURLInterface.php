<?php

namespace Xanax\Implement;

interface ClientURLInterface {
	
	public function Reset();
	
	public function getLastErrorNumber();
	
	public function getLastErrorMessage();
	
	public function Initialize($instance = '');
	
	public function getSession();
	
	public function Option();
	
	public function Information();
	
	public function setOption(int $option, $value );
	
	public function Close();
	
	public function Execute();
	
}
