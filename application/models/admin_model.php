<?php

class Admin_model extends CI_Model 
{
	
	function get_details($table,$fieldname,$id,$fieldname2=0,$id2=0)
    {
		$sessionData=get_session_details();
		$adminDetails= $sessionData->admindetails;
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($fieldname, $id);
		$this->db->where('user_id', $adminDetails['adminid']);
        if($id2!=0){
          $this->db->where($fieldname2, $id2);
        }
        $result = $this->db->get();
        return $result->row();
    }

	function update_details($table,$fieldname,$id,$details)
    {
			$this->db->where($fieldname, $id);
            if($this->db->update($table, $details))
            {
                return true;
            }
            else
            {
                return false;
            }
    }
	       function deleterecord($tablename='', $fieldname='', $indexid=0)
        {
            $this->db->where($fieldname, $indexid);
            $this->db->delete($tablename);
            return true;
        }
	
	
		function username_exists($username)
	    {
	        $this->db->where('username',$username);
	        $query = $this->db->get('users');
	        if ($query->num_rows() > 0)
	        {
	            return true;
	        }
	        else
	        {
	            return false;
	        }
	    }

        function field_exist($field_name,$field_value,$table)
        {
			$this->db->where($field_name,$field_value);
			$query = $this->db->get($table);
			if ($query->num_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
        }

        function insert($table, $data=array())
        {
			$sessionData=get_session_details();
			$adminDetails= $sessionData->admindetails;
			$userId=$adminDetails['adminid'];
			$data['user_id']=$userId;
        	$this->db->insert($table, $data);
        	if($this->db->affected_rows() > 0)
        	{
        		return true;
        	}
        	else
        	{
        		return false;
        	}
        }
		function add_stores_products_mapping($details)
		{
		
			foreach($details['product_store_id'] as $row){
				$mapping_data=array();
				$mapping_data['products_product_id']=$details['product_id'];
				$mapping_data['stores_store_id']=$row;
				$this->db->insert('stores_product_mapping', $mapping_data);
			}
			
			
		}
		function update_stores_products_mapping($details){
					
			$this->deleterecord('stores_product_mapping','products_product_id',$details['product_id']);

			foreach($details['product_store_id'] as $row){
				$mapping_data=array();
				$mapping_data['products_product_id']=$details['product_id'];
				$mapping_data['stores_store_id']=$row;
				$this->db->insert('stores_product_mapping', $mapping_data);
			}
		}
		
		
		function check_sku_exist($sku,$details){
			$receivedData=array();
		
			foreach($details['product_store_id'] as $row){
				$receivedData=0;
				$this->db->select('*');
				$this->db->where('stores_store_id', $row);
				$this->db->from('stores_product_mapping');
				$result = $this->db->get();
			
				foreach ($result->result_array() as $key => $store_mapping_data) {
				
					if($store_mapping_data['products_product_id'] !== @$details['product_id']){
						
						$this->db->select('*');
						$this->db->where('product_id', $store_mapping_data['products_product_id']);
						$this->db->where('product_sku', $sku);
						$this->db->from('products');
						$product_result = $this->db->get();
						
						if($product_result->num_rows() > 0){
							$receivedData=$product_result->num_rows();
							break;
						
						}else{
							$receivedData=0;
						}
					}else{
						$receivedData=0;
						
					}
						
						
					}
						
			}

			if($receivedData > 0){
				return true;
			}
				
			
		}
		   
		
		
        function login($username, $password)
        {
			
        	$this->db->select('*');
        	$this->db->where('email', $username);
        	$this->db->where('password', $password);
			$this->db->where('adminstatus', 1);
        	$this->db->from('administrators');
        	$result = $this->db->get();
			//
        	if($result->num_rows() > 0)
        	{
            $admindetails = $result->row();
            $admindata['admindetails'] = array('adminemail' =>$admindetails->email,
                                  'adminid' =>$admindetails->adminid,
								  'firstname' =>$admindetails->firstname,
								   'lastname' =>$admindetails->lastname
                                 );
            $this->session->set_userdata($admindata);
        	return true;

        	}
        	else
        	{
				
        	return false;
        	}
        }

        function dbselect ($tablename)
        {
			$sessionData=get_session_details();
			$adminDetails= $sessionData->admindetails;
			$userId=$adminDetails['adminid'];
            $query = $this->db->query("SELECT * FROM $tablename where user_id=$userId"); 
            return $query->result_array();
        }
		
        function dbmultiselect ($tablename,$field_name,$products_product_id)
        {
            $query = $this->db->query("SELECT * FROM $tablename where $field_name = $products_product_id"); 
            return $query->result_array();
        }
		
        function edituserprofile($userdetails, $indexid)
        {
            $this->db->where('user_id', $indexid);
            if($this->db->update('users', $userdetails))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        function editadminprofile($admindetails, $indexid)
        {
            $this->db->where('adminid', $indexid);
            if($this->db->update('administrators', $admindetails))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        function userprofile($userid)
        {
           $this->db->select('*'); 
           $this->db->from('users');
           $this->db->where('user_id', $userid);
           $userdetails = $this->db->get()->row();
            return $userdetails;
        }
        function adminprofile($adminid)
        {
           $this->db->select('*'); 
           $this->db->from('administrators');
           $this->db->where('adminid', $adminid);
           $admindetails = $this->db->get()->row();
            return $admindetails;
        }
 
        function getcategory($catid)
        {
           $this->db->select('*'); 
           $this->db->from('exam_category');
           $this->db->where('catid', $catid);
           $categorydetails = $this->db->get()->row();
           return $categorydetails;
        }
        function createcategory($categorydetails)
        {
            if($this->db->insert('exam_category', $categorydetails))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        function editcategory($catdetails, $indexid)
        {
            $this->db->where('catid', $indexid);
            if($this->db->update('exam_category', $catdetails))
            {
                return true;
            }
            else
            {
                return false;
            }
        }

    

		function dbselectWhere ($tablename,$fieldname, $fieldvalue)
        {
			
            $query = $this->db->query("SELECT * FROM $tablename where $fieldname=$fieldvalue"); 
            return $query->result_array();
        }
        function get_select_option_json($table,$id,$name, $selected=0){
            $query = $this->db->get($table);
           
          return $query->result_array();
        }
		
		function insert_front_data($table, $data=array())
        {
        	$this->db->insert($table, $data);
        	if($this->db->affected_rows() > 0)
        	{
        		return true;
        	}
        	else
        	{
        		return false;
        	}
        }
		function getUserImages($id){
		    $this->db->select('*');
            $this->db->from('userimages');
            $this->db->where('UserId', $id);
            return $this->db->get();
		}
       
}
?>