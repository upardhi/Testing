<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
Private common functions
Author: Sam Karanja
*/

	function get_session_details() 
    {
        $CI =& get_instance();
        $data = (object)$CI->session->all_userdata();
        return $data;
    }

    
	function is_adminlogged_in()
    {
    	 $CI =& get_instance();
        $is_logged_in = $CI->session->userdata('admindetails');
        if(!isset($is_logged_in) || $is_logged_in != true)
        {
        	redirect (base_url().'signup');   
        }       
    }
    function is_userlogged_in()
    {
         $CI =& get_instance();
        $is_logged_in = $CI->session->userdata('userdetails');
        if(!isset($is_logged_in) || $is_logged_in != true)
        {
            redirect (base_url());   
        }       
    }
    function timeDiff($starttime, $endtime)
    {
        $timespent = strtotime( $endtime)-strtotime($starttime);
        $days = floor($timespent / (60 * 60 * 24)); 
        $remainder = $timespent % (60 * 60 * 24);
        $hours = floor($remainder / (60 * 60));
        $remainder = $remainder % (60 * 60);
        $minutes = floor($remainder / 60);
        $seconds = $remainder % 60;
        $TimeInterval = '';
        if($hours < 0) $hours=0;
        if($hours != 0)
        {
            $TimeInterval = ($hours == 1) ? $hours.' hour' : $hours.' hours';
        }
        if($minutes < 0) $minutes=0;
        if($seconds < 0) $seconds=0;
        $TimeInterval = $minutes.' minutes '. $seconds.' seconds ';
        

        return $TimeInterval;
    }

    


 
 
