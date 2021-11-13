<?php

declare(strict_types=1);

namespace Xanax\Classes\Pagination;

class Statics
{
	private $page_start;
	private $page_count;
	private $list_count;
	private $document_count;
	private $remainder_count;

	private $needFirstPage = false;
	
	private $first_page;
	private $last_page;
	
	private $point = 1;
	
	public function __construct($page_start, $document_count, $page_count, $list_count) 
	{
		$this->page_start = $page_start;
		$this->page_count = $page_count;
		$this->list_count = $list_count;
		$this->document_count = $document_count;
		
		// Reminder of document count
		$this->remainder_count = ($this->document_count % $this->page_count);
		
		$this->first_page = $this->page_start - ($this->page_start % $this->list_count);
		
		// Remove list count when last page
		if ($this->page_start % $page_count == 0) 
		{
			$this->first_page -= $page_count;
		}
		
		$this->last_page = ($this->document_count - $this->remainder_count) / $page_count;
		
		// Check that needs go to first page
		if ($this->page_start > $this->list_count) 
		{
			$this->needFirstPage = true;
		}
	}
	
	public function needFirstPage() 
	{
		return $this->needFirstPage;
	}
	
	public function getLastPage() 
	{
		return $this->last_page + 1;
	}
	
	public function getPreviousPage() 
	{
		return $this->page_start - 1;
	}
	
	public function getNextPage() 
	{
		return $this->page_start + 1;
	}
	
	public function getCurrentPage() 
	{
		return $this->first_page + ($this->point - 1);
	}
	
	public function hasNextPage() 
	{
		$page = $this->first_page + (++$this->point);
		
		if ($this->point < $this->list_count + 2 && $page - 3 < $this->last_page) 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}
		
}
