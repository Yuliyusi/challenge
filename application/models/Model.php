<?php
/**
 * @author jules
 * Model pour active record
 */
class Model extends CI_Model
{   
	//make query
    public function maker($requete)
    {
      return $this->db->query($requete);
    }
    //make_datatables : requete avec Condition,LIMIT start,length
    public function datatable($requete)
    { 
        $query =$this->maker($requete);//call function make query
        return $query->result();
    }
    //count_all_data : requete sans Condition sans LIMIT start,length
    public function all_data($requete)
    {
       $query =$this->maker($requete); //call function make query
       return $query->num_rows();
    }
     //get_filtered_data : requete avec Condition sans LIMIT start,length
     public function filtrer($requete)
     {
         $query =$this->maker($requete);//call function make query
         return $query->num_rows();

     }	

}
?>