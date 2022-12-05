<?php
/**
 * @author jules
 */
class ModelPs extends CI_Model
{

    //execute tous les requetes  pour insertion update et delete
    public function createUpdateDelete($requete,$bindparameters=array())
    { 
        $query =$this->db->query($requete,$bindparameters);
        if ($query) {
            // code...
            return TRUE;
        }else{
            return FALSE;
        }
        
    }      

    //execute tous les requetes de selection qui retourne une ligne
    public function getRequeteOne($requete,$bindparameters=array())
    { 
        $query =$this->db->query($requete,$bindparameters);
        mysqli_next_result($this->db->conn_id);
        return $query->row_array();
    }    
    //execute tous les requetes de selection qui retourne + d'une ligne
    public function getRequete($requete,$bindparameters=array())
    { 
        $query =$this->db->query($requete,$bindparameters);
        mysqli_next_result($this->db->conn_id);
        return $query->result_array();
    }
    // debut fonction pour datatable
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
   // debut fonction pour datatable
}
?>