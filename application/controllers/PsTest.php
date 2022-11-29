<?php
/**
 * @author jules
 */
class PsTest extends CI_Controller
{
	
	function __construct()
	{
		// code...
		parent::__construct();
	}
	public function index($value='')
	{
		// code...
		$this->load->view('PsTest_View');
	}
   public function listing($value=0)
   {


          $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
          $var_search=str_replace("'", "\'", $var_search);  
          $group="";
          $critaire="";
          $limit='LIMIT 0,1000';
          if($_POST['length'] != -1){
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
          }
          $order_by='';
          $order_column=array('IDENTITE_ID','NOM','SEXE_DESCR','DESCRIPTION','COLLINE_NAME');
          if($_POST['order']['0']['column']!=0){
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY IDENTITE_ID DESC';
          }

          $search = !empty($_POST['search']['value']) ? (' AND (NOM LIKE "%'.$var_search.'%" OR SEXE_DESCR LIKE "%'.$var_search.'%" OR COLLINE_NAME LIKE "%'.$var_search.'%" OR DESCRIPTION LIKE "%'.$var_search.'%")') : '';

          //condition pour le query principale
          $conditions=$critaire.' '.$search.' '.$group.' '.$order_by.'   '.$limit;
         // condition pour le query filter
          $conditionsfilter=$critaire.' '.$search.' '.$group;
      
          $query_secondaire="CALL `getTable`('".$conditions."');";
         // echo $query_secondaire;
          $fetch_intrants = $this->ModelPs->datatable($query_secondaire);
          $u=0;
          $data = array();

          $QUANTITE_STOCK_DISPO_TOTAL=0;
          foreach ($fetch_intrants as $row) {

            $u++;
            $sub_array = array();
            $sub_array[] =  $row->IDENTITE_ID;
            $sub_array[]=$row->NOM;
            $sub_array[]=$row->SEXE_DESCR;
            $sub_array[]=$row->DESCRIPTION;
            $sub_array[]=$row->COLLINE_NAME;
            $data[] = $sub_array;

          }
          

        $recordsTotal=$this->ModelPs->filtrer('CALL `recordsTotal`()');
        $recordsFiltered =$this->ModelPs->filtrer(" CALL `recordsFiltered`('".$conditionsfilter."')");
          $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" =>$recordsTotal['recordsTotal'],
            "recordsFiltered" =>$recordsFiltered['recordsFiltered'],
            "data" => $data
          );
          echo json_encode($output);
      }	
   public function listingN($value=0)
   {


          $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
          $var_search=str_replace("'", "\'", $var_search);  
          $query_principal='SELECT `IDENTITE_ID`, `NOM`,s.SEXE_DESCR,e.DESCRIPTION,col.COLLINE_NAME FROM `identite` i JOIN sexe s ON i.`SEXE_ID`=s.SEXE_ID JOIN etat_civil e ON i.`ETAT_CIVIL_ID`=e.ETAT_CIVIL_ID JOIN collines col ON i.`COLLINE_ID`=col.COLLINE_ID WHERE 1  ';

          $group="";
          $critaire="";

          $limit='LIMIT 0,1000';
          if($_POST['length'] != -1){
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
          }
          $order_by='';
          $order_column=array('IDENTITE_ID','NOM','SEXE_DESCR','DESCRIPTION','COLLINE_NAME');
          if($_POST['order']['0']['column']!=0){
            $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY IDENTITE_ID DESC';
          }

          $search = !empty($_POST['search']['value']) ? (" AND (NOM LIKE '%$var_search%' OR SEXE_DESCR LIKE '%$var_search%' OR COLLINE_NAME LIKE '%$var_search%' OR DESCRIPTION LIKE '%$var_search%')") : '';


          
          $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$group.' '.$order_by.'   '.$limit;

         // echo  $query_secondaire;
          $query_filter=$query_principal.'  '.$critaire.' '.$search.' '.$group;

        // echo $query_filter."<br>";
        // echo $query_principal;

         // $s='SELECT `IDENTITE_ID`, `NOM`,s.SEXE_DESCR,e.DESCRIPTION,col.COLLINE_NAME FROM `identite` i JOIN sexe s ON i.`SEXE_ID`=s.SEXE_ID JOIN etat_civil e ON i.`ETAT_CIVIL_ID`=e.ETAT_CIVIL_ID JOIN collines col ON i.`COLLINE_ID`=col.COLLINE_ID WHERE 1';
        //  echo $query_principal;
        // 'SELECT `IDENTITE_ID`, `NOM`,s.SEXE_DESCR,e.DESCRIPTION,col.COLLINE_NAME FROM `identite` i JOIN sexe s ON i.`SEXE_ID`=s.SEXE_ID JOIN etat_civil e ON i.`ETAT_CIVIL_ID`=e.ETAT_CIVIL_ID JOIN collines col ON i.`COLLINE_ID`=col.COLLINE_ID WHERE 1 AND (NOM LIKE '%ju%' OR SEXE_DESCR LIKE '%ju%' OR COLLINE_NAME LIKE '%ju%' OR DESCRIPTION LIKE '%ju%')'

          $fetch_intrants = $this->Model->datatable($query_secondaire);
          $u=0;
          $data = array();

          $QUANTITE_STOCK_DISPO_TOTAL=0;
          foreach ($fetch_intrants as $row) {

            $u++;
            $sub_array = array();
            $sub_array[] =  $row->IDENTITE_ID;
            $sub_array[]=$row->NOM;
            $sub_array[]=$row->SEXE_DESCR;
            $sub_array[]=$row->DESCRIPTION;
            $sub_array[]=$row->COLLINE_NAME;
            $data[] = $sub_array;

          }

          $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" =>$this->Model->all_data($query_principal),
            "recordsFiltered" => $this->Model->filtrer($query_filter),
            "data" => $data
          );
          echo json_encode($output);
      }       
}
?>