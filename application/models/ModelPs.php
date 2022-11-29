<?php
/**
 * @author jules
 */
class ModelPs extends CI_Model
{

    public function datatable($requete)
    { 
        $query =$this->db->query($requete);
        mysqli_next_result($this->db->conn_id);
        return $query->result();
    }

     public function filtrer($requete)
     {
         $query =$this->db->query($requete);
         mysqli_next_result($this->db->conn_id);
         return $query->row_array();

     }    
	/*
       GRANT EXECUTE ON PROCEDURE getTable TO 'jules'@'%'
       GRANT EXECUTE ON PROCEDURE recordsFiltered TO 'jules'@'%';
       GRANT EXECUTE ON PROCEDURE recordsTotal TO 'jules'@'%'



    */

}
?>