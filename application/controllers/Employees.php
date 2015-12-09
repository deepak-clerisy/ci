<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','url','security'));
        $this->load->library(array('session','form_validation','pagination','auth'));
        $this->load->database();
        $this->load->model('Employee');
        
    }
	public function index()
	{
		$data['title']="Home";
		$data['content']=$this->load->view('home','',true);
		$this->load->view('template',$data);
	}
	
	function add()
    {
		if($this->auth->logged_in())
		{
			if($this->auth->get_userrole() != 1)
			{
			
				$this->session->set_userdata("not_admin",true);
				redirect('user/home');
			}
			else 
			{
		
				$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|callback_alpha_space_only');
				$this->form_validation->set_rules('email', 'Emaid ID', 'trim|required|valid_email');
				$this->form_validation->set_rules('mobile', 'Subject', 'trim|required|xss_clean');
			  
				if ($this->form_validation->run() == FALSE)
				{        
					$data['title']="Register Employee";      
					$data['content']=$this->load->view('employee/add_employee','',true);
					$this->load->view('template',$data);
				}
				else
				{
					
					$data = array(
						'name' => $this->input->post('name'),
						'email' => $this->input->post('email'),
						'mobile' => $this->input->post('mobile'),
						'status' => '1'
					);
							   
					$count = count($_FILES['images']['size']);
					//$image_path = realpath(APPPATH . 'uploads'); 
					$image_path = dirname($_SERVER["SCRIPT_FILENAME"])."/uploads/";  			
					$name_array = array(); 
					$img_error = array();
					foreach($_FILES as $key=>$value)
					{
					
						for($s=0; $s<=$count-1; $s++)
						{ 
							$img_name = $_FILES['images']['name']=$value['name'][$s];
							$_FILES['images']['type']    = $value['type'][$s];
							$_FILES['images']['tmp_name'] = $value['tmp_name'][$s];
							$_FILES['images']['error']       = $value['error'][$s];
							$img_size =	$_FILES['images']['size']    = $value['size'][$s]; 						
							$allowed_type=array('jpg','jpeg','png','gif');
							$ext = pathinfo($img_name, PATHINFO_EXTENSION);
							$config['upload_path'] = $image_path;	
							$max_size =	$config['max_size']  = 5*1024*1024;	
							if($max_size > $img_size)
							{	
								if(in_array($ext,$allowed_type))
								{	
									$config['allowed_types'] = 'gif|jpg|png|jpeg';								
									$this->load->library('upload', $config);
									if($this->upload->do_upload('images'))
									{
										$img_data = $this->upload->data();	
										$name_array[] = $img_data['file_name'];
									}
								}
								else
								{
									$img_error[]=$img_name . " File type Not Supported";
								}
								
							}					
							else
							{
								$img_error[]=$img_name . " File Size too Big";
							}
						}
							
					}
					if(empty($name_array[0]))
					{
						$name_array=null;
					}			 
					if ($this->Employee->add_employee($data,$name_array))
					{
						// success
						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Employe Added Successfully!!!</div>');
						if(count($img_error))
						{
							$this->session->set_flashdata('image_error',$img_error);
						}
						redirect('employees/add');
					}
					else
					{
						// error
						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Some Error.  Please try again later!!!</div>');
						redirect('employees/add');
					}
				}
			}
        }
		else
		{
			redirect('user/login');
		}
    }
    
    
    function add_emp()
    {
		
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|callback_alpha_space_only');
        $this->form_validation->set_rules('email', 'Emaid ID', 'trim|required|valid_email');
        $this->form_validation->set_rules('mobile', 'Subject', 'trim|required|xss_clean');
      
        if ($this->form_validation->run() == FALSE)
        {    
			$data['title']="Register Employee";           
			$data['content']=$this->load->view('employee/add_emp','',true);
			$this->load->view('template',$data);
        }
        else
        {
            
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'mobile' => $this->input->post('mobile'),
                'status' => '1'
            );                       
				//$image_path = realpath(APPPATH . 'uploads'); 
			//$image_path = dirname($_SERVER["SCRIPT_FILENAME"])."/uploads/";  			
			$image_path = "./uploads/";  			
			$img_error = array();
				if(isset($_FILES))
				{
					$img_name = $_FILES['image_file']['name'];
					$_FILES['image_file']['type'] ;
					$_FILES['image_file']['tmp_name'];
					$_FILES['image_file']['error'];
					$img_size =	$_FILES['image_file']['size']; 						
					$allowed_type=array('jpg','jpeg','png','gif');
					$ext = pathinfo($img_name, PATHINFO_EXTENSION);
					$config['upload_path'] = $image_path;	
					$max_size =	$config['max_size']  = 5*1024*1024;	
					$image_name='';
					if($max_size > $img_size)
					{	
						if(in_array($ext,$allowed_type))
						{	
							$iWidth = $iHeight = 200; // desired image result dimensions
							$iJpgQuality = 100;
							$short = md5(time().rand()); 
							$sTempFileName = $image_path.$short; 
							move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);
							@chmod($sTempFileName, 0644);

							if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
								$aSize = getimagesize($sTempFileName); // try to obtain image info
								if (!$aSize) {
									@unlink($sTempFileName);
									return;
								}
								switch($aSize[2]) {
									
									case IMAGETYPE_JPEG:
										$sExt = '.jpg';

										// create a new image from file 
										$vImg = @imagecreatefromjpeg($sTempFileName);
										break;
									case IMAGETYPE_PNG:
										$sExt = '.png';

										// create a new image from file 
										$vImg = @imagecreatefrompng($sTempFileName);
										break;
									default:
										@unlink($sTempFileName);
										return;
								}
								$vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );
								imagecopyresampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $iWidth, $iHeight, (int)$_POST['w'], (int)$_POST['h']);
								$sResultFileName = $sTempFileName . $sExt;
								imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);								
								@unlink($sTempFileName);
								
							}
						}
						else
						{
							$img_error[]=$img_name . " File type Not Supported";
						}
						
					}					
					else
					{
						$img_error[]=$img_name . " File Size too Big";
					}
				}
					 
	        if ($this->Employee->add_emp($data,$short.$sExt))
            {
                // success
                $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Employe Added Successfully!!!</div>');
                if(count($img_error))
                {
					$this->session->set_flashdata('image_error',$img_error);
				}
                redirect('employees/add_emp');
            }
            else
            {
                // error
                $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Some Error.  Please try again later!!!</div>');
                redirect('employees/add_emp');
            }
        }
    }
    
    //custom callback to accept only alphabets and space input
    function alpha_space_only($str)
    {
        if (!preg_match("/^[a-zA-Z ]+$/",$str))
        {
            $this->form_validation->set_message('alpha_space_only', 'The %s field must contain only alphabets and space');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    
    function view_list($sortfield='id',$order='asc',$page_num=1)
    {
		if($this->auth->logged_in())
		{
			if($this->auth->get_userrole() != 1)
			{
			
				$this->session->set_userdata("not_admin",true);
				redirect('user/home');
			}
			else 
			{
				$this->session->unset_userdata("not_admin");
				$this->session->unset_userdata('email');
				$this->session->unset_userdata('name');
				$this->session->unset_userdata('jd');
				$data['name']='';
				$data['email']='';
				$data['jd']='';
				$config = array();
				$config['full_tag_open'] = '<div class=" col-md-4 col-md-offset-5"><ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
				$config['full_tag_close'] = '</ul></div>';
				$config['prev_link'] = '&lt;';
				$config['prev_tag_open'] = '<li>';
				$config['prev_tag_close'] = '</li>';
				$config['next_link'] = '&gt;';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="current"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['first_link'] = '&lt;&lt;';
				$config['last_link'] = '&gt;&gt;';		 
				$config["base_url"] = base_url() . "employees/view_list/".$sortfield.'/'.$order.'/';         
				$config["per_page"] = 5;
				$config["uri_segment"] = 5;
				$config["use_page_numbers"] = TRUE; 
				$config["reuse_query_string"] = TRUE; 
				$page_number = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
				if(empty($page_number)) $page_number = 1;        
				$offset = ($page_number-1) * $config['per_page'];		
				$config["total_rows"] = $this->Employee->record_employees();
				$data ["emp_data"]=$this->Employee->all_employees($config["per_page"], $offset,$sortfield,$order);
				$this->pagination->cur_page = $offset;
				$this->pagination->initialize($config);
				$data["links"] = $this->pagination->create_links();
				$data['content']=$this->load->view('employee/view_employees',$data,true);
				$data['title']="View Employees"; 
				$this->load->view('template',$data);
			}
		}
		else
		{
			redirect('user/login');
		}
       
    }
    function search($sortfield='id',$order='asc',$page_num=1)
    {
		$config = array();
		$config['full_tag_open'] = '<div class=" col-md-4 col-md-offset-5"><ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
		$config['full_tag_close'] = '</ul></div>';
		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="current"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['first_link'] = '&lt;&lt;';
		$config['last_link'] = '&gt;&gt;';		 
        $config["base_url"] = base_url() . "employees/search/".$sortfield.'/'.$order.'/';         
        $config["per_page"] = 5;
        $config["uri_segment"] = 5;
        $config["use_page_numbers"] = TRUE; 
        $config["reuse_query_string"] = TRUE; 
        $page_number = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        if(empty($page_number)) $page_number = 1;        
		$offset = ($page_number-1) * $config['per_page'];	
		$where=array();
		$email = $this->Employee->set_data($this->input->post('email', TRUE),'email');
		$name = $this->Employee->set_data($this->input->post('name', TRUE),'name');
		$jd = $this->Employee->set_data($this->input->post('jd', TRUE),'jd');		
		$data['email'] = $email;
		$data['name'] = $name;
		$data['jd'] = $jd;
		if(!empty($email)) 
		{
			$where['email']=$email;
		} 
		if(!empty($name))
		{
			$where['name']=$name;
		} 
		if(!empty($jd)) 
		{
			$where['create_date']=$jd;
		}
		$config["total_rows"] = count($this->Employee->record_search_employees($where));
		$data ["emp_data"]=$this->Employee->all_employees($config["per_page"], $offset,$sortfield,$order,$where);
		$this->pagination->cur_page = $offset;
		$this->pagination->initialize($config);
		$data["links"] = $this->pagination->create_links();
		$data['content']=$this->load->view('employee/search_employees',$data,true);
		$this->load->view('template',$data);
	}
	
	function ajax_search($sortfield='id',$order='asc',$page_num=1)
    {
		$config = array();
		$config['full_tag_open'] = '<div class=" col-md-4 col-md-offset-5"><ul class="tsc_pagination tsc_paginationA tsc_paginationA01 ajax">';
		$config['full_tag_close'] = '</ul></div>';
		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="current"><a href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['first_link'] = '&lt;&lt;';
		$config['last_link'] = '&gt;&gt;';		 
        $config["base_url"] = base_url() . "employees/ajax_search/".$sortfield.'/'.$order.'/';         
        $config["per_page"] = 5;
        $config["uri_segment"] = 5;
        $config["use_page_numbers"] = TRUE; 
        $config["reuse_query_string"] = TRUE; 
        $page_number = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        if(empty($page_number)) $page_number = 1;        
		$offset = ($page_number-1) * $config['per_page'];	
		$where=array();
		$email = $this->Employee->set_data($this->input->post('email', TRUE),'email');
		$name = $this->Employee->set_data($this->input->post('name', TRUE),'name');
		$jd = $this->Employee->set_data($this->input->post('jd', TRUE),'jd');		
		$data['email'] = $email;
		$data['name'] = $name;
		$data['jd'] = $jd;
		if(!empty($email)) 
		{
			$where['email']=$email;
		} 
		if(!empty($name))
		{
			$where['name']=$name;
		} 
		if(!empty($jd)) 
		{
			$where['create_date']=$jd;
		}
		$config["total_rows"] = count($this->Employee->record_search_employees($where));
		$data ["emp_data"]=$this->Employee->all_employees($config["per_page"], $offset,$sortfield,$order,$where);
		$this->pagination->cur_page = $offset;
		$this->pagination->initialize($config);
		$data["links"] = $this->pagination->create_links();
		$this->load->view('employee/ajax_view',$data);		
	}
    function delete($id='')
    {
		if($this->auth->logged_in())
		{
			if($this->auth->get_userrole() != 1)
			{
			
				$this->session->set_userdata("not_admin",true);
				redirect('user/home');
			}
			else 
			{
				if(!empty($id))
				{
					if($this->Employee->delete_employee($id))
					{
						$this->session->set_flashdata('delete','<div class="alert alert-success text-center">Deleted Successfully!!!</div>');
						redirect('employees/view_list');
						
					}
					else
					{
						$this->session->set_flashdata('delete','<div class="alert alert-danger text-center">Oops! Some Error.  Please try again later!!!</div>');
						redirect('employees/view_list');
					}
				}
				else
				{
					$this->session->set_flashdata('delete','<div class="alert alert-danger text-center">Oops! Some Error.  Employee Does Not Exists!!!</div>');
					redirect('employees/view_list');
				}
			}	
		}
		else
		{
			redirect('user/login');
		}
	}
	function delete_image($id='',$user_id='')
    {
		if($this->auth->logged_in())
		{
			if($this->auth->get_userrole() != 1)
			{
			
				$this->session->set_userdata("not_admin",true);
				redirect('user/home');
			}
			else 
			{
		
				if(!empty($id))
				{
					if($this->Employee->delete_image($id))
					{
						$this->session->set_flashdata('delete_image','<div class="alert alert-success text-center">Image Deleted Successfully!!!</div>');
						redirect('employees/view/'.$user_id);
						
					}
					else
					{
						$this->session->set_flashdata('delete_image','<div class="alert alert-danger text-center">Oops! Some Error.  Please try again later!!!</div>');
						redirect('employees/view/'.$user_id);
					}
				}
				else
				{
					$this->session->set_flashdata('delete_image','<div class="alert alert-danger text-center">Oops! Some Error.  Image Does Not Exists!!!</div>');
					redirect('employees/view/'.$user_id);
				}
			}
		}
		else
		{
			redirect('user/login');
		}
	}
	
	
	function view($id='')
	{
		if($this->auth->logged_in())
		{
			if($this->auth->get_userrole() != 1)
			{
			
				$this->session->set_userdata("not_admin",true);
				redirect('user/home');
			}
			else 
			{
				if(!empty($id))
				{
					$data['employee']=$this->Employee->get_employee($id);				
					
					$data['content']=$this->load->view('employee/view_employee',$data,true);
					$data['title']="View Employee"; 
					$this->load->view('template',$data);
				}
				else
				{
					$this->session->set_flashdata('delete','<div class="alert alert-danger text-center">Oops! Some Error.  Employee Does Not Exists!!!</div>');
					redirect('employees/view_list');
				}
			}
		}
		else
		{
			redirect('user/login');
		}
		
	}
	function edit($id='')
	{
		if($this->auth->logged_in())
		{
			if($this->auth->get_userrole() != 1)
			{
			
				$this->session->set_userdata("not_admin",true);
				redirect('user/home');
			}
			else 
			{
				if(!empty($id))
				{
					$data['employee']=$this->Employee->get_employee($id);
						
					
					$data['content']=$this->load->view('employee/edit_employee',$data,true);
					$data['title']="Edit Employee"; 
					$this->load->view('template',$data);
				}
				else
				{
					$this->session->set_flashdata('delete','<div class="alert alert-danger text-center">Oops! Some Error.  Employee Does Not Exists!!!</div>');
					redirect('employees/view_list');
				}
			}
		}
		else
		{
			redirect('user/login');
		}
	}
	
	
	function update()
    {
		if($this->auth->logged_in())
		{
			if($this->auth->get_userrole() != 1)
			{
			
				$this->session->set_userdata("not_admin",true);
				redirect('user/home');
			}
			else 
			{
				$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('email', 'Emaid ID', 'trim|required|valid_email');
				$this->form_validation->set_rules('mobile', 'Subject', 'trim|required|xss_clean');
				$id=$this->input->post('e_id');
				if ($this->form_validation->run() == FALSE)
				{   
					
					$data['employee']=$this->Employee->get_employee($id);
					$data['content']=$this->load->view('employee/edit_employee',$data,true);
					$data['title']="Edit Employee"; 
					$this->load->view('template',$data);
				}
				else
				{
					
					$data = array(
						'name' => $this->input->post('name'),
						'email' => $this->input->post('email'),
						'mobile' => $this->input->post('mobile'),
						'status' => '1'
					);
					
					if ($this->Employee->update_employee($id,$data))
					{
						// success
						$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Updated Successfully!!!</div>');
						redirect('employees/edit/'.$id);
					}
					else
					{
						// error
						$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Some Error.  Please try again later!!!</div>');
						redirect('employees/edit/'.$id);
					}
				}
			}
		}
		else
		{
			redirect('user/login');
		}
		
	}
}
