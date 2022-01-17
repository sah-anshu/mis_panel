<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
 
class Password extends CI_Controller {
 
 
public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(array('session'));
        $this->load->model('Password_model');

        if ($this->session->userdata['logged_in'] == TRUE)
        {
            //do validate something
        }
        else
        {
            redirect('login'); //if session is not there, redirect to login page
        }   

    }
 
 
    public function index()
    {
        $data['passwords']=$this->Password_model->get_all_Passwords();
        $this->load->view('header');
        $this->load->view('password_list',$data);
    }
 
    public function get_password_by_id()
    {
        $id = $this->input->post('id');
         
        $data = $this->Password_model->get_by_id($id);
          
        $arr = array('success' => false, 'data' => '');
        if($data){
        $arr = array('success' => true, 'data' => $data);
        }
        echo json_encode($arr);
    }
 
    public function store()
    {
        $is_admin = ($this->session->userdata('is_admin'))?$this->session->userdata('is_admin'):0;

        $data = array(
                'Application' => $this->input->post('Application'),
                'SAPSID' => strtoupper($this->input->post('SAPSID')),
                'SAPClient' => ($this->input->post('SAPClient')==0)?null:$this->input->post('SAPClient'),
                'URL' => $this->input->post('URL'),
                'UserName' => $this->input->post('UserName'),
                'Password' => $this->input->post('Password'),
                'Notes' => $this->input->post('Notes'),
                'last_updated_by' => ($this->session->userdata('user_id'))?(int) $this->session->userdata('user_id'):null,
                'last_updated_timestamp' => date('Y-m-d H:i:s'),
            );
         
        $status = false;

        if($is_admin == 1) 
        {
            $id = $this->input->post('password_id');
     
            if($id){
               $update = $this->Password_model->update($data);
               $status = true;
            }else{
               $id = $this->Password_model->create($data);
               $status = true;
            }

            $data = $this->Password_model->get_by_id($id);
        }
           
        echo json_encode(array("status" => $status , 'data' => $data));
    }
 
    public function delete()
    {
        $is_admin = $this->session->userdata('is_admin');
        if($is_admin == 1)
        {   
            $this->Password_model->delete();
            echo json_encode(array("status" => TRUE));
        }
        else
            echo json_encode(array("status" => FALSE));
    }
 
    public function getLists(){
             $this->load->model('User_model');

            $data = $row = array();
            $is_admin = ($this->session->userdata('is_admin'))?(int)$this->session->userdata('is_admin'):0;

            // Fetch password's records
            $memData = $this->Password_model->getRows($_POST);
            
            $i = $_POST['start'];
            foreach($memData as $password) {
                $i++;
                

                $last_updated_timestamp = date( 'M d, Y H:i', strtotime($password->last_updated_timestamp));
                if($password->last_updated_by != '')
                     $last_updated_timestamp =  $last_updated_timestamp. " by ". $this->User_model->get_username_from_user_id($password->last_updated_by);
                 
                //$status = ($password->status == 1)?'Active':'Inactive';

                if($password->Password!="")
                    $password_column = "<a href='javascript:void(0)' class='ency_password' data-txt='".base64_encode($password->Password)."'>******</a>";
                else
                    $password_column = "";

                $action_buttons = '<div class="btn-group" role="group"> <a href="javascript:void(0)" data-id="'.$password->id.'" class="btn btn-info edit-password">Edit</a>
                  <a href="javascript:void(0)" data-id="'.$password->id.'" data-app="'.$password->Application.'" class="btn btn-danger delete-user delete-password">Delete</a></div>';
                
                if($is_admin == 1)
                    $data[] = array($password->Application, $password->SAPSID, $password->SAPClient, $password->URL, $password->UserName, $password_column, $password->Notes, $last_updated_timestamp,  $action_buttons);
                else
                    $data[] = array($password->Application, $password->SAPSID, $password->SAPClient, $password->URL, $password->UserName, $password_column, $password->Notes, $last_updated_timestamp);

             }
            
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Password_model->countAll(),
                "recordsFiltered" => $this->Password_model->countFiltered($_POST),
                "data" => $data,
            );
            
            // Output to JSON format
            echo json_encode($output);
        }
     
 
}