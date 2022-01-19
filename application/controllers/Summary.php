<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
 
class Summary extends CI_Controller {
 
 
public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(array('session'));
        $this->load->model('Summary_model');

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
        $data['summary']=$this->Summary_model->get_all_summary();
        $this->load->view('header');
        $this->load->view('summary_list',$data);
    }
 
    public function get_password_by_id()
    {
        $id = $this->input->post('id');
         
        $data = $this->Summary_model->get_by_id($id);
          
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
               $update = $this->Summary_model->update($data);
               $status = true;
            }else{
               $id = $this->Summary_model->create($data);
               $status = true;
            }

            $data = $this->Summary_model->get_by_id($id);
        }
           
        echo json_encode(array("status" => $status , 'data' => $data));
    }
 
    public function delete()
    {
        $is_admin = $this->session->userdata('is_admin');
        if($is_admin == 1)
        {   
            $this->Summary_model->delete();
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
            $memData = $this->Summary_model->getRows($_POST);
            
            $i = $_POST['start'];
            foreach($memData as $password) {
                $i++;
                
                if($password->sendondate != '')
                    $sendondate = date( 'M d, Y', strtotime($password->sendondate));
                else
                    $sendondate = '';

                $action_buttons = '<div class="btn-group" role="group"> <a href="javascript:void(0)" data-id="'.$password->id.'" class="btn btn-info edit-password">Edit</a>
                  <a href="javascript:void(0)" data-id="'.$password->id.'" class="btn btn-danger delete-user delete-password">Delete</a></div>';
                
                if($is_admin == 1)
                    $data[] = array($sendondate, $password->user_id, $password->status, $password->totalcredits, $password->billcredits, $action_buttons);
                else
                    $data[] = array($sendondate, $password->user_id, $password->status, $password->totalcredits, $password->billcredits, );

             }
            
            $output = array(
                "draw" => isset($_POST['draw'])?$_POST['draw']:'',
                "recordsTotal" => $this->Summary_model->countAll(),
                "recordsFiltered" => $this->Summary_model->countFiltered($_POST),
                "data" => $data,
            );
            
            // Output to JSON format
            echo json_encode($output);
        }
     
 
}