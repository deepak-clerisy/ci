<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Model{
	
	public function add_employee($data,$names)
	{
		if($this->db->insert('employee', $data))
		{
			$emp_id=$this->db->insert_id();
			
			if(count($names))
			{
				foreach($names as $name)
				{
					
					$user_data=array();
					$user_data['emp_id']=$emp_id;
					$user_data['image']=$name; 
					$this->db->insert('employee_images', $user_data);
				}
			}
			
			return true;
			
		}
		else
		{
			return false;
		}
	}
	public function add_emp($data,$names)
	{
		if($this->db->insert('employee', $data))
		{
			$emp_id=$this->db->insert_id();
			
			if(!empty($names))
			{		
				$user_data=array();
				$user_data['emp_id']=$emp_id;
				$user_data['image']=$names; 
				$this->db->insert('employee_images', $user_data);
				
			}
			
			return true;
			
		}
		else
		{
			return false;
		}
	}
	
	public function all_employees($per_page,$offset,$sortfield,$order,$where ='')
	{
		
		$this->db->select('id,name,email,mobile,create_date,modify_date')->from('employee');
		if(!empty($where))
		{
			foreach($where as $key => $value)
			{
				if($key == 'create_date')
				{
					$where = "date(`create_date`)=date('$value')";
					$this->db->where($where);
				}
				else
				{
					$this->db->like($key, $value); 
				}
				
			}
		
		}
		$this->db->order_by("$sortfield", "$order");
		$this->db->limit($per_page,$offset);
		$query_result = $this->db->get();	
		
		if($query_result->num_rows() > 0) 
		{
			foreach ($query_result->result_array() as $row)
			{
				$sdata[] = array('name' => $row['name'],'email' => $row['email'],'mobile' => $row['mobile'],'id' => $row['id'],'create_date' => $row['create_date']);
			}	
				
			return $sdata;
		} 
		else 
		{
				return false;	
		}	
		
	}
	
	public function record_employees() 
	{
        return $this->db->count_all("employee");
    }
    
    public function record_search_employees($where)
    {
		
		$this->db->select('id')->from('employee');
		foreach($where as $key => $value)
			{
				if($key=='create_date')
				{
					$where = "date(`create_date`)=date('$value')";
					$this->db->where($where);
				}
				else
				{
					$this->db->like($key, $value); 
				}
				
			}
			
			return $query_result = $this->db->get()->result();
			
	}
    
	
	public function delete_employee($id)
	{
		return $this->db->delete('employee', array('id' => $id));
	}
	
	public function update_employee($id,$data)
	{
		$this->db->where('id', $id);		
		return $this->db->update('employee', $data);
	}
	
	public function delete_image($id)
	{
		return $this->db->delete('employee_images', array('id' => $id));
	}
	
	public function get_employee($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('employee');		
		$res= $query->row(); 
		$this->db->where('emp_id', $id);
		$img_query = $this->db->get('employee_images');
		$images=array();
		foreach($img_query->result_array() as $img)
		{
			$images[]=$img;
		}
				
		return array('emp'=>$res,'images'=>$images);
	}
	
	public function set_data($searchterm,$s_name)
	{
		if($searchterm)
		{
			$this->session->set_userdata($s_name, $searchterm);
			return $searchterm;
		}
		elseif($this->session->userdata($s_name))
		{
			$searchterm = $this->session->userdata($s_name);
			return $searchterm;
		}
		else
		{
			$searchterm ="";
			return $searchterm;
		}
	}
	

}
