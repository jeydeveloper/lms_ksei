<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Pagination1 Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination1
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/Pagination1.html
 */
class CI_Pagination1 {

	var $base_url			= ''; // The page we are linking to
	var $total_rows  		= ''; // Total number of items (database results)
	var $per_page	 		= 10; // Max number of items you want shown per page
	var $num_links			=  2; // Number of "digit" links to show before/after the currently viewed page
	var $cur_page	 		=  0; // The current page being viewed
	var $first_link   		= '&lsaquo; First';
	var $next_link			= '&gt;';
	var $prev_link			= '&lt;';
	var $last_link			= 'Last &rsaquo;';
	var $uri_segment		= 0;
	var $full_tag_open		= '';
	var $full_tag_close		= '';
	var $first_tag_open		= '';
	var $first_tag_close	= '&nbsp;';
	var $last_tag_open		= '&nbsp;';
	var $last_tag_close		= '';
	var $cur_tag_open		= '&nbsp;<strong>';
	var $cur_tag_close		= '</strong>';
	var $next_tag_open		= '&nbsp;';
	var $next_tag_close		= '&nbsp;';
	var $prev_tag_open		= '&nbsp;';
	var $prev_tag_close		= '';
	var $num_tag_open		= '&nbsp;';
	var $num_tag_close		= '';
	var $page_query_string	= FALSE;
	var $query_string_segment = 'per_page';
	var $ref = "page";

	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
	function CI_Pagination1($params = array())
	{
		if (count($params) > 0)
		{
			$this->initialize($params);		
		}
		
		log_message('debug', "Pagination1 Class Initialized");
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	function initialize($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate the Pagination1 links
	 *
	 * @access	public
	 * @return	string
	 */	
	function create_links()
	{
		// If our item count or per-page total is zero there is no need to continue.
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
		   //return '';
		}

		// Calculate the total number of pages
		if ($this->per_page)
		{
			$num_pages = ceil($this->total_rows / $this->per_page);
		}
		else
		{
			$num_pages = 1;
		}

		// Is there only one page? Hm... nothing more to do here then.
		if ($num_pages == 1)
		{
			//return '';
		}

		// Determine the current page number.		
		$CI =& get_instance();
		
		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			if ($CI->input->get($this->query_string_segment) != 0)
			{
				$this->cur_page = $CI->input->get($this->query_string_segment);
				
				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}
		else
		{
			if ($CI->uri->segment($this->uri_segment) != 0)
			{
				$this->cur_page = $CI->uri->segment($this->uri_segment);
				
				// Prep the current page - no funny business!
				$this->cur_page = (int) $this->cur_page;
			}
		}

		$this->num_links = (int)$this->num_links;
		
		if ($this->num_links < 1)
		{
			show_error('Your number of links must be a positive number.');
		}
				
		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = 0;
		}
		
		// Is the page number beyond the result range?
		// If so we show the last page
		if ($this->cur_page > $this->total_rows)
		{
			$this->cur_page = ($num_pages - 1) * $this->per_page;
		}
		
		$uri_page_number = $this->cur_page;
		if ($this->per_page)
		{			
			$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);
		}
		else
		{
			$this->cur_page = 1;
		}

		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;

		// Is Pagination1 being used over GET or POST?  If get, add a per_page query
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
		if  ($this->cur_page > ($this->num_links + 1))
		{
			$output .= '<td style="width: 16px; border: 0px;"><a href="javascript:'.$this->ref.'()">'.$this->first_link.'</a></td>';
		}

		// Render the "previous" link
		if  ($this->cur_page != 1)
		{
			$i = $uri_page_number - $this->per_page;
			if ($i == 0) $i = '';
			$output .= '<td style="width: 16px; border: 0px;"><a href="javascript:'.$this->ref.'('.$i.')">'.$this->prev_link.'</a></td>';
		}

		// Write the digit links
		
		$first = true;
		for ($loop = $start -1; $loop <= $end; $loop++)
		{
			$i = ($loop * $this->per_page) - $this->per_page;
			if ($i >= 0)
			{
				if ($first)
				{
					$output .= "<td style='border: 0px;'>Page ";
					$first = false;
				}
				
				if ($loop == 0) continue;
				
				if ($i > 0)
				{
					$output .= " | ";
				}
				
				if ($this->cur_page == $loop)
				{
					$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
				}
				else
				{
					$n = ($i == 0) ? '' : $i;
					$output .= $this->num_tag_open.'<a href="javascript:'.$this->ref.'('.$n.')">'.$loop.'</a>'.$this->num_tag_close;
				}
			}
		}
		
		if (! $first)
		{
			$output .= "</td>";
		}

		// Render the "next" link
		if ($this->cur_page < $num_pages)
		{
			$output .= '<td style="width: 16px; border: 0px;"><a href="javascript:'.$this->ref.'('.($this->cur_page * $this->per_page).')">'.$this->next_link.'</a></td>';
		}

		// Render the "Last" link
		if (($this->cur_page + $this->num_links) < $num_pages)
		{
			$i = (($num_pages * $this->per_page) - $this->per_page);
			$output .= '<td style="width: 16px; border: 0px;"><a href="javascript:'.$this->ref.'('.$i.')">'.$this->last_link.'</a></td>';
		}

		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;
		
		$options = "";
		if (isset($this->limits) && is_array($this->limits))
		{
			$options = ', '.$CI->config->item('lshow').'
                			<select name="limit" onchange="javascript:changelimit(this)">
                		';
            
            $selected = 0;
            foreach($this->limits as $key=>$show)
            {
				if ($key == $this->per_page)
				{
					$selected = $key;
				}
			}
			
			foreach($this->limits as $key=>$show)
			{
				$options .= "<option value='".$key."'".( ($key == $selected) ? " selected": "").">".$show."</option>";
			}
			
			$options = sprintf('%s</select>
              %s(s) %s', $options, strtolower($this->lang_title), $this->lang_per_page
              		);
		}
		
		if ($this->total_rows == 0)
		{
			return "";
		} 
		
		$pend = $this->cur_page*$this->per_page;
		if ($pend > $this->total_rows) $pend = $this->total_rows;
		
		return sprintf('
<form><span class="left"> %s <strong>%d-%d</strong> %s <strong>%d</strong> %s</span></form>              
            		<table border="0" align="right" cellpadding="0" cellspacing="0">
                		<tr>       
                			%s
                		</tr>
              		</table>              </form>
              ', $this->lang_title, ($this->cur_page-1)*$this->per_page+1, $pend, $this->lang_of, $this->total_rows, $options, $output);
		
		
		//return $output;		
	}
}
// END Pagination1 Class

/* End of file Pagination1.php */
/* Location: ./system/libraries/Pagination1.php */
