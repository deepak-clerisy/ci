<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url','security'));
		$this->load->library(array('session','form_validation','pagination','auth'));
		$this->load->database();
		
	}
	
	public function index()
	{
		if($this->auth->logged_in())
		{
			$data['content']=$this->load->view('home','',true);
			$this->load->view('template',$data);
		}
		else
		{
			redirect('user/login');
		}
	}
	
	public function register()
	{
		$this->form_validation->set_rules('name','Name','trim|required|xss_clean');
		$this->form_validation->set_rules('email','Email','trim|required|xss_clean|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password','Password','trim|required|xss_clean');
		
		
		if($this->form_validation->run() == false)
		{
			$data['content']=$this->load->view('user/add_user','',true);
			$data['title']="Register User"; 
			$this->load->view('template',$data);
		}
		else
		{
			
			if(isset($_FILES))
			{ 
				$image_path = "./uploads/"; 
				$img_name = $_FILES['image_file']['name'];
				$img_size =	$_FILES['image_file']['size']; 						
				$allowed_type=array('jpg','jpeg','png','gif');
				$ext = pathinfo($img_name, PATHINFO_EXTENSION);
				$image_name=time().'_'.$img_name;
				$config['upload_path'] = $image_path;					
				$max_size =	$config['max_size']  = 5*1024*1024;	
				$img_error=array();
				if($max_size > $img_size)
				{
					if(in_array($ext,$allowed_type))
					{ 
						$iWidth = $iHeight = 200; 
						$iJpgQuality = 100;
						$short = md5(time().rand());	
						$sTempFileName2 = $image_path.$short; 					
						$config['file_name'] = $short;	
						$config['allowed_types'] = 'gif|jpg|png|jpeg';								
						$this->load->library('upload', $config);
						if($this->upload->do_upload('image_file'))
						{ 
							$img_data = $this->upload->data();	
							$up_image_name=$img_data['file_name'];
							$sTempFileName = $image_path.$up_image_name; 
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
								$sResultFileName = $sTempFileName2 . $sExt;
								imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);								
								//@unlink($sTempFileName);
								$image_url=$short.$sExt;
								
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
			else
			{
				$image_url='';
			}
			
			
			
			$data=array(
				'name'=>$this->input->post('name'),
				'email'=>$this->input->post('email'),
				'password'=>md5($this->input->post('password')),
				'level'=>'2',
				'status'=>'1',
				'image'=>$image_url
			);
			if ($this->auth->add_user($data))
			{
				// success
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">User Added Successfully!!!</div>');
				if(count($img_error))
				{
					$this->session->set_flashdata('image_error',$img_error);
				}
				redirect('user/register');
			}
			else
			{
				// error
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Some Error.  Please try again later!!!</div>');
				redirect('user/register');
			}
			
		}
		
		
		
	}
	
	public function login()
	{
		if(!$this->auth->logged_in())
		{
	
			$this->form_validation->set_rules('email','Email','trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('password','Password','trim|required|xss_clean');
			
			
			if($this->form_validation->run() == false)
			{
				$data['content']=$this->load->view('user/login','',true);
				$data['title']="User Login"; 
				
				$this->load->view('template',$data);				
			}
			else
			{
				if ($this->auth->login($this->input->post('email'),$this->input->post('password')))
				{
					// success
					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">User Login Successfully!!!</div>');
					redirect('user/home');
				}
				else
				{
					// error
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Some Error.  Please try again later!!!</div>');
					redirect('user/login');
				}
			}
		}
		else
		{
			redirect('user/home');
		}
	}
	
	public function change_password()
	{
		if($this->auth->logged_in())
		{
	
			$this->form_validation->set_rules('password','Password','trim|required|xss_clean');
			$this->form_validation->set_rules('n_password','New Password','trim|required|xss_clean');
			$this->form_validation->set_rules('c_password','Confirm Password','trim|required|xss_clean|matches[n_password]');
			
			
			if($this->form_validation->run() == false)
			{
				$data['content']=$this->load->view('user/change_password','',true);
				$data['title']="Change Password"; 
				
				$this->load->view('template',$data);				
			}
			else
			{
				if ($this->auth->change_password($this->input->post('password'),$this->input->post('n_password')))
				{
					// success
					$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Password Changed Successfully!!!</div>');
					redirect('user/change_password');
				}
				else
				{
					// error
					$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Sorry Your Current Password is Wrong!!!</div>');
					redirect('user/change_password');
				}
			}
		}
		else
		{
			redirect('user/login');
		}
	}
	
	public function home()
	{
	
		if($this->auth->logged_in())
		{
						
			$u_data['user_data']=$this->auth->get_userdata();
			$data['content']=$this->load->view('user/home',$u_data,true);
			$data['title']="User Home"; 
			$this->load->view('template',$data);
			
		}
		else
		{
			redirect('user/login');
		}
		
	}
	
	public function logout()
	{
		if($this->auth->logout())
		{
			redirect('user/login');
			
		}
		
	}


}

?>
