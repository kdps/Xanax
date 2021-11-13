<?php

declare(strict_types=1);

namespace Xanax\Classes\Pagination;

class Dynamic
{
	private $current_page;
	private $list_count;
	private $page_count;
	private $point;           // gotten page count
	private $page_margin = 0; // page margin for center align
	private $first_page  = 0;  // first page number
	private $last_page;       // number of total items

	/**
	 * Constructor
	 *
	 * @param int $last_page  : number of total items
	 * @param int $current_page : current page number
	 * @param int $list_count   : number of page links displayed at one time
	 *
	 * @return void
	 */
	public function __construct($current_page = 1, $item_count = 20, $document_count = 10, $list_count = 10)
	{
		$page_margin = 0;
		$first_page  = 0;

		$half_page_count = ceil($list_count / 2);

		$last_page = ceil($document_count / $item_count);
		$last_page = ($last_page < 0) ? 1 : $last_page;

		if ($last_page > $list_count) {
			if ($current_page > $last_page - ($list_count - 1)) {
				$page_margin = $last_page - $list_count;
				$first_page  = $page_margin < $list_count ? 0 : -1;
			} elseif ($current_page > $half_page_count) {
				$page_margin = $current_page - ($half_page_count);
				$first_page  = $page_margin > $list_count ? 0 : -1;
			}

			if ($current_page > $last_page - ($list_count - 1) && $current_page < $last_page - ($half_page_count - 1)) {
				$page_margin = $current_page - $half_page_count;
				$first_page  = $page_margin > $list_count ? 0 : -1;
			}
		}

		$this->page_count   = (int) $last_page;
		$this->page_margin  = (int) $page_margin;
		$this->first_page   = (int) $first_page;
		$this->last_page    = (int) $last_page;
		$this->current_page = (int) $current_page;
		$this->list_count   = (int) $list_count;
	}

	/**
	 * Get a last page.
	 *
	 * @return int
	 */
	public function getLastPage()
	{
		return $this->page_count;
	}

	/**
	 * Get a link of last page.
	 *
	 * @return String
	 */
	public function getLastPageLink()
	{
		return str::getUrl(__MODULEID, $_GET[__MODULEID], 'page', $this->getLastPage(), 'srl', '');
	}

	/**
	 * Get a comment link of last page.
	 *
	 * @return String
	 */
	public function getCommentPageLink()
	{
		return str::getUrl(__MODULEID, $_GET[__MODULEID], 'cpage', $value, 'act', 'getCommentPage');
	}

	/**
	 * Get a page link.
	 *
	 * @return String
	 */
	public function getPageLink()
	{
		return str::getUrl(__MODULEID, $_GET[__MODULEID], 'page', $this->getCurrentPage(), 'srl', '');
	}

	/**
	 * Make sure this page is the same as the current page.
	 *
	 * @return boolean
	 */
	public function isCurrentPage()
	{
		return ($_GET['page'] == $this->getCurrentPage()) ? true : false;
	}

	/**
	 * Make sure this comment page is the same as the current page.
	 *
	 * @return boolean
	 */
	public function isCurrentCPage()
	{
		return ($_GET['cpage'] == $this->getCurrentPage()) ? true : false;
	}

	/**
	 * Make sure has next page.
	 *
	 * @return boolean
	 */
	public function hasNextPage()
	{
		$page = $this->first_page + (++$this->point);

		if ($page > ($this->list_count) || $this->getCurrentPage() > $this->last_page) {
			$this->point = 0;

			return false;
		} else {
			return true;
		}
	}

	/**
	 * Get a current page.
	 *
	 * @return int
	 */
	public function getCurrentPage()
	{
		return ($this->page_margin + $this->first_page + $this->point);
	}
}
