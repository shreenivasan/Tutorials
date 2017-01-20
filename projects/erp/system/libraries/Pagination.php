<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/pagination.html
 */
class CI_Pagination {

	/**
	 * Base URL
	 *
	 * The page that we're linking to
	 *
	 * @var	string
	 */
	protected $base_url		= '';

	/**
	 * Prefix
	 *
	 * @var	string
	 */
	protected $prefix = '';

	/**
	 * Suffix
	 *
	 * @var	string
	 */
	protected $suffix = '';

	/**
	 * Total number of items
	 *
	 * @var	int
	 */
	protected $total_rows = 0;

	/**
	 * Number of links to show
	 *
	 * Relates to "digit" type links shown before/after
	 * the currently viewed page.
	 *
	 * @var	int
	 */
	protected $num_links = 2;

	/**
	 * Items per page
	 *
	 * @var	int
	 */
	public $per_page = 10;

	/**
	 * Current page
	 *
	 * @var	int
	 */
	public $cur_page = 0;

	/**
	 * Use page numbers flag
	 *
	 * Whether to use actual page numbers instead of an offset
	 *
	 * @var	bool
	 */
	protected $use_page_numbers = FALSE;

	/**
	 * First link
	 *
	 * @var	string
	 */
	protected $first_link = '&lsaquo; First';

	/**
	 * Next link
	 *
	 * @var	string
	 */
	protected $next_link = '&gt;';

	/**
	 * Previous link
	 *
	 * @var	string
	 */
	protected $prev_link = '&lt;';

	/**
	 * Last link
	 *
	 * @var	string
	 */
	protected $last_link = 'Last &rsaquo;';

	/**
	 * URI Segment
	 *
	 * @var	int
	 */
	protected $uri_segment = 0;

	/**
	 * Full tag open
	 *
	 * @var	string
	 */
	protected $full_tag_open = '';

	/**
	 * Full tag close
	 *
	 * @var	string
	 */
	protected $full_tag_close = '';

	/**
	 * First tag open
	 *
	 * @var	string
	 */
	protected $first_tag_open = '';

	/**
	 * First tag close
	 *
	 * @var	string
	 */
	protected $first_tag_close = '';

	/**
	 * Last tag open
	 *
	 * @var	string
	 */
	protected $last_tag_open = '';

	/**
	 * Last tag close
	 *
	 * @var	string
	 */
	protected $last_tag_close = '';

	/**
	 * First URL
	 *
	 * An alternative URL for the first page
	 *
	 * @var	string
	 */
	protected $first_url = '';

	/**
	 * Current tag open
	 *
	 * @var	string
	 */
	protected $cur_tag_open = '<strong>';

	/**
	 * Current tag close
	 *
	 * @var	string
	 */
	protected $cur_tag_close = '</strong>';

	/**
	 * Next tag open
	 *
	 * @var	string
	 */
	protected $next_tag_open = '';

	/**
	 * Next tag close
	 *
	 * @var	string
	 */
	protected $next_tag_close = '';

	/**
	 * Previous tag open
	 *
	 * @var	string
	 */
	protected $prev_tag_open = '';

	/**
	 * Previous tag close
	 *
	 * @var	string
	 */
	protected $prev_tag_close = '';

	/**
	 * Number tag open
	 *
	 * @var	string
	 */
	protected $num_tag_open = '';

	/**
	 * Number tag close
	 *
	 * @var	string
	 */
	protected $num_tag_close = '';

	/**
	 * Page query string flag
	 *
	 * @var	bool
	 */
	protected $page_query_string = FALSE;

	/**
	 * Query string segment
	 *
	 * @var	string
	 */
	protected $query_string_segment = 'per_page';

	/**
	 * Display pages flag
	 *
	 * @var	bool
	 */
	protected $display_pages = TRUE;

	/**
	 * Attributes
	 *
	 * @var	string
	 */
	protected $_attributes = '';

	/**
	 * Link types
	 *
	 * "rel" attribute
	 *
	 * @see	CI_Pagination::_attr_rel()
	 * @var	array
	 */
	protected $_link_types = array();

	/**
	 * Reuse query string flag
	 *
	 * @var	bool
	 */
	protected $reuse_query_string = FALSE;

	/**
	 * Use global URL suffix flag
	 *
	 * @var	bool
	 */
	protected $use_global_url_suffix = FALSE;

	/**
	 * Data page attribute
	 *
	 * @var	string
	 */
	protected $data_page_attr = 'data-ci-pagination-page';

	/**
	 * CI Singleton
	 *
	 * @var	object
	 */
	protected $CI;
        protected $anchor_class='';

        // --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @param	array	$params	Initialization parameters
	 * @return	void
	 */
	public function __construct($params = array())
	{
		$this->CI =& get_instance();
		$this->CI->load->language('pagination');
		foreach (array('first_link', 'next_link', 'prev_link', 'last_link') as $key)
		{
			if (($val = $this->CI->lang->line('pagination_'.$key)) !== FALSE)
			{
				$this->$key = $val;
			}
		}

		$this->initialize($params);
		log_message('info', 'Pagination Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @param	array	$params	Initialization parameters
	 * @return	CI_Pagination
	 */
	public function initialize(array $params = array())
	{
		isset($params['attributes']) OR $params['attributes'] = array();
		if (is_array($params['attributes']))
		{
			$this->_parse_attributes($params['attributes']);
			unset($params['attributes']);
		}

		// Deprecated legacy support for the anchor_class option
		// Should be removed in CI 3.1+
		if (isset($params['anchor_class']))
		{
			empty($params['anchor_class']) OR $attributes['class'] = $params['anchor_class'];
			unset($params['anchor_class']);
		}

		foreach ($params as $key => $val)
		{
			if (property_exists($this, $key))
			{
				$this->$key = $val;
			}
		}

		if ($this->CI->config->item('enable_query_strings') === TRUE)
		{
			$this->page_query_string = TRUE;
		}

		if ($this->use_global_url_suffix === TRUE)
		{
			$this->suffix = $this->CI->config->item('url_suffix');
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Generate the pagination links
	 *
	 * @return	string
	 */
	function create_links()
	{
                $max_entries_per_page=MAX_ENTRIES_PER_PAGE;
		// If our item count or per-page total is zero there is no need to continue.
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
			return '';
		}

		// Calculate the total number of pages
		$num_pages = ceil($this->total_rows / $this->per_page);

		// Is there only one page? Hm... nothing more to do here then.
		if ($num_pages == 1)
		{
                    $output="";
                    $pageStr="Showing 1-".$this->total_rows." of ".$this->total_rows." entries";
                    $paginationdata['records']="<div id='info' class='dataTables_info'>".$pageStr."</div>";
                    $paginationdata['navigation']="<ul class='pagination inlineblockp'>".$output."</ul>";
			return $paginationdata;
		}

		// Set the base page index for starting page number
		if ($this->use_page_numbers)
		{
			$base_page = 1;
		}
		else
		{
			$base_page = 0;
		}

		// Determine the current page number.
		$CI =& get_instance();

		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			if ($CI->input->get($this->query_string_segment) != $base_page)
			{
				$this->cur_page = $CI->input->get($this->query_string_segment);

				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}
		else
		{
			if ($CI->uri->segment($this->uri_segment) != $base_page)
			{
				$this->cur_page = $CI->uri->segment($this->uri_segment);

				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}
		
		// Set current page to 1 if using page numbers instead of offset
		if ($this->use_page_numbers AND $this->cur_page == 0)
		{
			$this->cur_page = $base_page;
		}

		$this->num_links = (int)$this->num_links;

		if ($this->num_links < 1)
		{
			show_error('Your number of links must be a positive number.');
		}

		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = $base_page;
		}

		// Is the page number beyond the result range?
		// If so we show the last page
		if ($this->use_page_numbers)
		{
			if ($this->cur_page > $num_pages)
			{
				$this->cur_page = $num_pages;
			}
		}
		else
		{
			if ($this->cur_page > $this->total_rows)
			{
				$this->cur_page = ($num_pages - 1) * $this->per_page;
			}
		}

		$uri_page_number = $this->cur_page;
		
		if ( ! $this->use_page_numbers)
		{
			$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);
		}

		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;

		// Is pagination being used over GET or POST?  If get, add a per_page query
		// string. If post, add a trailing slash to the base URL if needed
		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			$this->base_url = rtrim($this->base_url).'&amp;'.$this->query_string_segment.'=';
		}
		else
		{
			$this->base_url = rtrim($this->base_url, '/') .'/';
		}

		// And here we go...
		$output = '';

		// Render the "First" link
		if  ($this->first_link !== FALSE AND $this->cur_page > ($this->num_links + 1))
		{
			$first_url = ($this->first_url == '') ? $this->base_url : $this->first_url;
			$output .= $this->first_tag_open.'<li><a '.$this->anchor_class.'href="'.$first_url.'">'.$this->first_link.'</a></li>'.$this->first_tag_close;
		}

		// Render the "previous" link
		if  ($this->prev_link !== FALSE AND $this->cur_page != 1)
		{
			if ($this->use_page_numbers)
			{
				$i = $uri_page_number - 1;
			}
			else
			{
				$i = $uri_page_number - $this->per_page;
			}

			if ($i == 0 && $this->first_url != '')
			{
				$output .= $this->prev_tag_open.'<li><a '.$this->anchor_class.'href="'.$this->first_url.'">'.$this->prev_link.'</a></li>'.$this->prev_tag_close;
			}
			else
			{
				$i = ($i == 0) ? '' : $this->prefix.$i.$this->suffix;
				$output .= $this->prev_tag_open.'<li><a '.$this->anchor_class.'href="'.$this->base_url.$i.'">'.$this->prev_link.'</a></li>'.$this->prev_tag_close;
			}
		}

		// Render the pages
		if ($this->display_pages !== FALSE)
		{
			// Write the digit links
			for ($loop = $start -1; $loop <= $end; $loop++)
			{
				if ($this->use_page_numbers)
				{
					$i = $loop;
				}
				else
				{
					$i = ($loop * $this->per_page) - $this->per_page;
				}

				if ($i >= $base_page)
				{
					if ($this->cur_page == $loop)
					{
						//$output .= "<li class='active'>".$this->cur_tag_open.$loop.$this->cur_tag_close."</li>"; // Current page
                                                $output .= "<li class='paginate_button active'><a href='#'>".$loop."</a></li>"; // Current page
					}
					else
					{
						$n = ($i == $base_page) ? '' : $i;

						if ($n == '' && $this->first_url != '')
						{
							$output .= $this->num_tag_open.'<li class="paginate_button"><a '.$this->anchor_class.'href="'.$this->first_url.'">'.$loop.'</a></li>'.$this->num_tag_close;
						}
						else
						{
							$n = ($n == '') ? '' : $this->prefix.$n.$this->suffix;

							$output .= $this->num_tag_open.'<li class="paginate_button"><a '.$this->anchor_class.'href="'.$this->base_url.$n.'">'.$loop.'</a></li>'.$this->num_tag_close;
						}
					}
			}
		}
		}

		// Render the "next" link
		if ($this->next_link !== FALSE AND $this->cur_page < $num_pages)
		{
			if ($this->use_page_numbers)
			{
				$i = $this->cur_page + 1;
			}
			else
			{
				$i = ($this->cur_page * $this->per_page);
			}

			$output .= $this->next_tag_open.'<li class="paginate_button"><a '.$this->anchor_class.'href="'.$this->base_url.$this->prefix.$i.$this->suffix.'">'.$this->next_link.'</a></li>'.$this->next_tag_close;
		}

		// Render the "Last" link
		if ($this->last_link !== FALSE AND ($this->cur_page + $this->num_links) < $num_pages)
		{
			if ($this->use_page_numbers)
			{
				$i = $num_pages;
			}
			else
			{
				$i = (($num_pages * $this->per_page) - $this->per_page);
			}
			$output .= $this->last_tag_open.'<li class="paginate_button"><a '.$this->anchor_class.'href="'.$this->base_url.$this->prefix.$i.$this->suffix.'">'.$this->last_link.'</a></li>'.$this->last_tag_close;
		}

		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);
                
                $curr_page_start=(floor($max_entries_per_page*($this->cur_page-1)))+1;
                $curr_page_end=($curr_page_start+$max_entries_per_page-1);               
                $diff=$curr_page_end-$this->total_rows;
                
                if($diff!=0 && $curr_page_end>$this->total_rows)
                    $curr_page_end=$this->total_rows;

                $pageStr="Showing ".$curr_page_start."-".$curr_page_end." of ".$this->total_rows." entries";
                
		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;
                $paginationdata['records']="<div id='info' class='dataTables_info'>".$pageStr."</div>";
                $paginationdata['navigation']="<ul class='pagination inlineblockp'>".$output."</ul>";
               // $output="<div id='info' class='dataTables_info'>".$pageStr."</div>&nbsp;<ul class='pagination inlineblockp'>".$output."</ul>";  
                return $paginationdata;
	}

	// --------------------------------------------------------------------

	/**
	 * Parse attributes
	 *
	 * @param	array	$attributes
	 * @return	void
	 */
	protected function _parse_attributes($attributes)
	{
		isset($attributes['rel']) OR $attributes['rel'] = TRUE;
		$this->_link_types = ($attributes['rel'])
			? array('start' => 'start', 'prev' => 'prev', 'next' => 'next')
			: array();
		unset($attributes['rel']);

		$this->_attributes = '';
		foreach ($attributes as $key => $value)
		{
			$this->_attributes .= ' '.$key.'="'.$value.'"';
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Add "rel" attribute
	 *
	 * @link	http://www.w3.org/TR/html5/links.html#linkTypes
	 * @param	string	$type
	 * @return	string
	 */
	protected function _attr_rel($type)
	{
		if (isset($this->_link_types[$type]))
		{
			unset($this->_link_types[$type]);
			return ' rel="'.$type.'"';
		}

		return '';
	}

}
