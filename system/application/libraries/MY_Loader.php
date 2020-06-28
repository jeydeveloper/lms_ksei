<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
	
/**
 * Modular Separation - PHP5
 *
 * Adapted from the CodeIgniter Core Classes
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @link		http://codeigniter.com
 *
 * Description:
 * This library extends the CodeIgniter Loader class
 * and adds features allowing use of modules within an application.
 *
 * Install this file as application/libraries/MY_Loader.php
 *
 * @copyright 	Copyright (c) Wiredesignz 2010-01-18
 * @version 	1.10
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
 **/
class MY_Loader extends CI_Loader
{	
	/**
     * Database Loader extension, to load our version of the caching engine
     *
     * @access    public
     * @param    string    the DB credentials
     * @param    bool    whether to return the DB object
     * @param    bool    whether to enable active record (this allows us to override the config setting)
     * @return    object
     */
    function database($params = '', $return = FALSE, $active_record = FALSE)
    {
    	 // Do we even need to load the database class?
            if (class_exists('CI_DB') AND $return == FALSE AND $active_record == FALSE)
            {
            return FALSE;
            }

            require_once(BASEPATH.'database/DB'.EXT);

            // Load the DB class
            $db =& DB($params, $active_record);

            $my_driver = config_item('subclass_prefix').'DB_'.$db->dbdriver.'_driver';
            $my_driver_file = APPPATH.'libraries/'.$my_driver.EXT;

            if (file_exists($my_driver_file))
            {
                require_once($my_driver_file);
                $db = new $my_driver(get_object_vars($db));
            }
        
            if ($return === TRUE)
            {
                return $db;
            }
            // Grab the super object
            $CI =& get_instance();
 		
            // Initialize the db variable.  Needed to prevent
            // reference errors with some configurations
            $CI->db = '';
            $CI->db = $db;
            // Assign the DB object to any existing models
            $this->_ci_assign_to_models();
        
    }
}
