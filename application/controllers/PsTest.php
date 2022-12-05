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
    $provColumnselect="`PROVINCE_ID`, `PROVINCE_NAME`";//colone a selectionner
    $provTable="`provinces`";//table
    $provWhere="1";//condition dans la clause where
    $provOrderby="`PROVINCE_NAME` ASC";//order by
    $bindparams = array('provColumnselect' => $provColumnselect,'provTable'=>$provTable,'provWhere'=>$provWhere,'provOrderby'=>$provOrderby );
    $provrequete="CALL `getRequete`(?,?,?,?);";
    $provinces = $this->ModelPs->getRequete($provrequete,$bindparams);
    
    ######################################################
    $sexeColumnselect="*";//colone a selectionner
    $sexeTable="`sexe`";//table
    $sexeWhere="1";//condition dans la clause where
    $sexeOrderby="`SEXE_DESCR` ASC";//order by
    $bindparams = array('sexeColumnselect' =>$sexeColumnselect ,'sexeTable'=>$sexeTable,'sexeWhere'=>$sexeWhere,'sexeOrderby'=>$sexeOrderby);

    $sexerequete="CALL `getRequete`(?,?,?,?);";
    $sexe = $this->ModelPs->getRequete($sexerequete,$bindparams);
    ######################################################
    $hobyColumnselect="*";//colone a selectionner
    $hobyTable="`hobbies`";//table
    $hobyWhere="1";//condition dans la clause where
    $hobyOrderby="`HOBBY` ASC";//order by
    $bindparams = array('hobyColumnselect' => $hobyColumnselect,'hobyTable'=>$hobyTable,'hobyWhere'=>$hobyWhere,'hobyOrderby'=>$hobyOrderby );
    $hobyrequete="CALL `getRequete`(?,?,?,?);";
    $hobbies = $this->ModelPs->getRequete($hobyrequete,$bindparams);
    ######################################################
    $etatcivilColumnselect="*";//colone a selectionner
    $etatcivilTable="`etat_civil`";//table
    $etatcivilWhere="1";//condition dans la clause where
    $etatcivilOrderby="`DESCRIPTION` ASC";//order by
    $bindparams = array('etatcivilColumnselect' =>$etatcivilColumnselect ,'etatcivilTable'=>$etatcivilTable,'etatcivilWhere'=>$etatcivilWhere,'etatcivilOrderby'=>$etatcivilOrderby );
    $etatcivilrequete="CALL `getRequete`(?,?,?,?);";
    $etat_civil = $this->ModelPs->getRequete($etatcivilrequete,$bindparams);            
    $data=array('provinces'=>$provinces,'sexe'=>$sexe,'hobbies'=>$hobbies,'etat_civil'=>$etat_civil);

		$this->load->view('PsTest_View',$data);
	}
  public function getLocaliteByParent()
  {
    // code...
    $level=$this->input->post('level');
    $idparrent=$this->input->post('idparrent');
    $idtorender=$this->input->post('idtorender');
    $option="<option value=''>Select</option>";
    if ($level=="2") {
      // code...zone
      $collone="ZONE_ID id,ZONE_NAME name";
      $table="zones";
      $where="COMMUNE_ID=".$idparrent;
      $orderby="ZONE_NAME ASC ";
      $requete="CALL `getRequete`('$collone','$table','$where','$orderby');";
      $localite=$this->ModelPs->getRequete($requete);
    }elseif ($level=="1") {
      // code...commune
      $collone="COMMUNE_ID id,COMMUNE_NAME name";
      $table="communes";
      $where="PROVINCE_ID=".$idparrent;
      $orderby="COMMUNE_NAME ASC ";
      $requete="CALL `getRequete`('$collone','$table','$where','$orderby');";
      $localite=$this->ModelPs->getRequete($requete);
    }else{
      //code...colline
      $collone="COLLINE_ID id,COLLINE_NAME name";
      $table="collines";
      $where="ZONE_ID=".$idparrent;
      $orderby="COLLINE_NAME ASC ";
      $requete="CALL `getRequete`('$collone','$table','$where','$orderby');";
      $localite=$this->ModelPs->getRequete($requete);
    }
    foreach ($localite as $key ) {
      // code...
      $option.="<option value='".$key['id']."'>".$key['name']."</option>";
    }
    echo $option;

  }
  public function Add($value='')
  {
      // code...
      $insertIntoTable="identite";
      $ID_HOBBY=$this->input->post('ID_HOBBY');
      $NOM=$this->input->post('NOM');
      $ID_HOBBY=$this->input->post('ID_HOBBY');
      $SEXE_ID=$this->input->post('SEXE_ID');
      $ETAT_CIVIL_ID=$this->input->post('ETAT_CIVIL_ID');
      // $PROVINCE_ID=$this->input->post('PROVINCE_ID');
      // $COMMUNE_ID=$this->input->post('COMMUNE_ID');
      // $ZONE_ID=$this->input->post('ZONE_ID');
      $COLLINE_ID=$this->input->post('COLLINE_ID');

      $datatoinsert='"'.$NOM.'",'.$SEXE_ID.','.$ETAT_CIVIL_ID.','.$COLLINE_ID;
      $bindparams = array('insertIntoTable' =>$insertIntoTable ,'datatoinsert'=>$datatoinsert );
      $insertRequete="CALL `insertLastIdIntoTable`(?,?);";
      $IDENTITE_ID=$this->ModelPs->getRequeteOne($insertRequete,$bindparams);
      $insertIntoTable="identite_hobby";
        // code...
      foreach ($ID_HOBBY as $key => $ID_HOBBY) {
        // code...
        $datatoinsert=$ID_HOBBY.','.$IDENTITE_ID['id'];
        $bindparams = array('insertIntoTable' =>$insertIntoTable ,'datatoinsert'=>$datatoinsert );
        $insertRequete="CALL `insertIntoTable`(?,?);";
        $this->ModelPs->createUpdateDelete($insertRequete,$bindparams);
      }
    

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