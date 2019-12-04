<?php

namespace Xanax\Implement;

interface ClientURLInterface
{
	public function getSession();
	
	public function Option();
	
	public function Information();
	
	public function setOption( $option, $value );
	
	public function Close();
	
	public function Execute();
	
}
