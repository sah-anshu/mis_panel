<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
class Summary_model extends CI_Model
{
  
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        // Set table name
        $this->table = 'mt_summary';

        // Set orderable column fields
        $this->column_order = array('crm_id','user_id','sendondate','status','totalcredits','billcredits');

        // Set searchable column fields
        $this->column_search = array('user_id','status');

        // Set default order
        $this->order = array('id' => 'desc');
    }
  
  
    public function get_all_summary()
    {
        $this->db->from($this->table);
        $query=$this->db->get();
        return $query->result();
    }
      
  
    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
  
        return $query->row();
    }
  
       public function create($data){
         
           $this->db->insert($this->table, $data);
        return $this->db->insert_id();
       }
 
    public function update($data)
    {
        $where = array('id' => $this->input->post('summary_id'));
         $this->db->update($this->table, $data, $where);
         return $this->db->affected_rows();
 
    }
  
    public function delete()
    {
        $id = $this->input->post('summary_id');
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }
  



    /*
     * Fetch members data from the database
     * @param $_POST filter data based on the posted parameters
     */
    public function getRows($postData){
        $this->_get_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * Count all records
     */
    public function countAll(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    /*
     * Count records based on the filter params
     * @param $_POST filter data based on the posted parameters
     */
    public function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /*
     * Perform the SQL queries needed for an server-side processing requested
     * @param $_POST filter data based on the posted parameters
     */
    private function _get_datatables_query($postData){
         
        $this->db->from($this->table);
 
        $i = 0;
        // loop searchable columns 
        foreach($this->column_search as $item){
            // if datatable send POST for search
            if(isset($postData) && is_array($postData['search']) && $postData['search']['value']){
                // first loop
                if($i===0){
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }
                
                // last loop
                if(count($this->column_search) - 1 == $i){
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
         
        if(isset($postData['order'])){
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
  
}