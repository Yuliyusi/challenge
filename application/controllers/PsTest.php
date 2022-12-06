<?php
/**
 * @author jules
 */
class PsTest extends CI_Controller
{

    public function __construct()
    {
        // code...
        parent::__construct();
    }
    public function index($value = '')
    {
        // code...

        //provinces
        $psgetrequete = "CALL `getRequete`(?,?,?,?);";
        $bindparams = $this->getBindParms('`PROVINCE_ID`, `PROVINCE_NAME`', 'provinces', '1', '`PROVINCE_NAME` ASC');
        $provinces = $this->ModelPs->getRequete($psgetrequete, $bindparams);
        ######################################################
        //sexes
        $bindparams=$this->getBindParms('*','sexe','1',' SEXE_DESCR ASC');
        $sexe = $this->ModelPs->getRequete($psgetrequete, $bindparams);
        ######################################################
        //hobbies
        $bindparams=$this->getBindParms('*','hobbies','1',' HOBBY ASC');
        $hobbies = $this->ModelPs->getRequete($psgetrequete, $bindparams);
        ######################################################
        //etat_civil
        $bindparams=$this->getBindParms('*','etat_civil','1',' DESCRIPTION ASC');
        $etat_civil = $this->ModelPs->getRequete($psgetrequete, $bindparams);

        $data = array('provinces' => $provinces, 'sexe' => $sexe, 'hobbies' => $hobbies, 'etat_civil' => $etat_civil);

        $this->load->view('PsTest_View', $data);
    }
    public function getLocaliteByParent()
    {
        // code...
        $level = $this->input->post('level');
        $idparrent = $this->input->post('idparrent');
        $idtorender = $this->input->post('idtorender');
        $requete = "CALL `getRequete`(?,?,?,?);";
        $option = "<option value=''>Select</option>";
        if ($level == "2") {
            // code...zone
            $bindparamszone=$this->getBindParms('ZONE_ID id,ZONE_NAME name','zones','COMMUNE_ID='.$idparrent,'ZONE_NAME ASC ');
            $localite = $this->ModelPs->getRequete($requete,$bindparamszone);
        } elseif ($level == "1") {
            // code...commune
            $bindparamscom=$this->getBindParms('COMMUNE_ID id,COMMUNE_NAME name','communes','PROVINCE_ID='.$idparrent,'COMMUNE_NAME ASC ');
            $localite = $this->ModelPs->getRequete($requete,$bindparamscom);
        } else {
            //code...colline
            $bindparamscolline=$this->getBindParms('COLLINE_ID id,COLLINE_NAME name','collines','ZONE_ID='.$idparrent,'COLLINE_NAME ASC ');

            $localite = $this->ModelPs->getRequete($requete,$bindparamscolline);
        }
        foreach ($localite as $key) {
            // code...
            $option .= "<option value='" . $key['id'] . "'>" . $key['name'] . "</option>";
        }
        echo $option;

    }
    public function Add($value = '')
    {
        // code...
        #TODO : Ajout des formvalidation codeigniter

        $insertIntoTable = "identite";
        $IDENTITE_ID = $this->input->post('IDENTITE_ID');
        $ID_HOBBY = $this->input->post('ID_HOBBY');
        $NOM = mysqli_real_escape_string($this->db->conn_id,$this->input->post('NOM'));
        $SEXE_ID = $this->input->post('SEXE_ID');
        $ETAT_CIVIL_ID = $this->input->post('ETAT_CIVIL_ID');
        // $PROVINCE_ID=$this->input->post('PROVINCE_ID');
        // $COMMUNE_ID=$this->input->post('COMMUNE_ID');
        // $ZONE_ID=$this->input->post('ZONE_ID');
        $COLLINE_ID = $this->input->post('COLLINE_ID');
        $insertIntoTable2 = mysqli_real_escape_string($this->db->conn_id,"identite_hobby");
        $critere = mysqli_real_escape_string($this->db->conn_id," IDENTITE_ID =" . $IDENTITE_ID);
        $statut = 0;
        if (empty($IDENTITE_ID)) {
            // code...
            $datatoinsert = '"' . $NOM . '",' . $SEXE_ID . ',' . $ETAT_CIVIL_ID . ',' . $COLLINE_ID;
            $bindparams = array('insertIntoTable' => $insertIntoTable, 'datatoinsert' => $datatoinsert);
            $insertRequete = "CALL `insertLastIdIntoTable`(?,?);";
            $IDENTITE_ID = $this->ModelPs->getRequeteOne($insertRequete, $bindparams);
            $IDENTITE_ID = $IDENTITE_ID['id'];
            $statut = 1;
        } else {

            $bindparams = array('insertIntoTable' => $insertIntoTable2, 'critere' => $critere);
            $deleteRequete = "CALL `deleteData`(?,?);";
            $this->ModelPs->createUpdateDelete($deleteRequete, $bindparams);
            $datatoupdate ='NOM="' . $NOM . '",`SEXE_ID`="' . $SEXE_ID . '",ETAT_CIVIL_ID="' . $ETAT_CIVIL_ID . '",COLLINE_ID="' . $COLLINE_ID . '"';
            $bindparams = array('insertIntoTable' => $insertIntoTable, 'datatoupdate' => $datatoupdate, 'critere' => $critere);
            $updateRequete = "CALL `updateData`(?,?,?);";
            $this->ModelPs->createUpdateDelete($updateRequete, $bindparams);
            $statut = 1;

        }

        foreach ($ID_HOBBY as $key => $ID_HOBBY) {
            // code...
            $datatoinsert =mysqli_real_escape_string($this->db->conn_id, $ID_HOBBY . ',' . $IDENTITE_ID);
            $bindparams = array('insertIntoTable' => $insertIntoTable2, 'datatoinsert' => $datatoinsert);
            $insertRequete = "CALL `insertIntoTable`(?,?);";
            $this->ModelPs->createUpdateDelete($insertRequete, $bindparams);
            $statut = 1;
        }
        echo json_encode(array('statut' => $statut));

    }
    public function deleteData($value = '')
    {
        // code...
        $statut = 0;
        $IDENTITE_ID = $this->input->post('IDENTITE_ID');
        $critere =mysqli_real_escape_string($this->db->conn_id," IDENTITE_ID =" . $IDENTITE_ID);
        $table = mysqli_real_escape_string($this->db->conn_id,"identite");
        $bindparams = array('table' => $table, 'critere' => $critere);
        $deleteRequete = "CALL `deleteData`(?,?);";
        if ($this->ModelPs->createUpdateDelete($deleteRequete, $bindparams)) {
            // code...
            $statut = 1;
        }

        echo $statut;
    }
    public function getOne()
    {
        // code...
        $IDENTITE_ID = $this->input->post('IDENTITE_ID');

        //table pricipales
        $bindparams = $this->getBindParms('*', 'identite', ' IDENTITE_ID=' . $IDENTITE_ID . '', ' IDENTITE_ID DESC');
        $callpsreq = "CALL `getRequete`(?,?,?,?);";
        $identite = $this->ModelPs->getRequeteOne($callpsreq, $bindparams);
        $sqlcoline = "CALL `getProvComZonFromColline`(?);"; #TODO globalisation de cette procedure stockE
        $idProvComZon = $this->ModelPs->getRequeteOne($sqlcoline, array('id_col' => $identite['COLLINE_ID']));

        //province
        $bindparamsprov = $this->getBindParms('`PROVINCE_ID`, `PROVINCE_NAME`', 'provinces', '1', '`PROVINCE_NAME` ASC');
        $Arrayprovinces = $this->ModelPs->getRequete($callpsreq, $bindparamsprov);
        $provinces = '<option value="">Select</option>';
        foreach ($Arrayprovinces as $prov) {
            // code...
            if ($prov['PROVINCE_ID'] == $idProvComZon['PROVINCE_ID']) {
                // code...
                $provinces .= "<option value='" . $prov['PROVINCE_ID'] . "' selected >" . $prov['PROVINCE_NAME'] . "</option>";
            } else {
                // code...
                $provinces .= "<option value='" . $prov['PROVINCE_ID'] . "' >" . $prov['PROVINCE_NAME'] . "</option>";
            }

        }
        //communes
        $bindparamscom = $this->getBindParms('COMMUNE_ID id,COMMUNE_NAME name', 'communes', 'PROVINCE_ID=' . $idProvComZon['PROVINCE_ID'], 'COMMUNE_NAME ASC ');
        $Arraycommunes = $this->ModelPs->getRequete($callpsreq, $bindparamscom);
        $communes = '<option value="">Select</option>';
        foreach ($Arraycommunes as $com) {
            // code...
            if ($com['id'] == $idProvComZon['COMMUNE_ID']) {
                // code...
                $communes .= '<option value="' . $com['id'] . '" selected>' . $com['name'] . '</option>';
            } else {
                // code...
                $communes .= '<option value="' . $com['id'] . '">' . $com['name'] . '</option>';
            }

        }

        //zones
        $bindparamszone = $this->getBindParms('ZONE_ID id,ZONE_NAME name', 'zones', 'COMMUNE_ID=' . $idProvComZon['COMMUNE_ID'], 'ZONE_NAME ASC ');
        $Arrayzones = $this->ModelPs->getRequete($callpsreq, $bindparamszone);
        $zones = '<option value="">Select</option>';
        foreach ($Arrayzones as $zone) {
            // code...
            if ($zone['id'] == $idProvComZon['ZONE_ID']) {
                // code...
                $zones .= '<option value="' . $zone['id'] . '" selected>' . $zone['name'] . '</option>';
            } else {
                // code...
                $zones .= '<option value="' . $zone['id'] . '">' . $zone['name'] . '</option>';
            }

        }

        $bindparamscolline = $this->getBindParms('COLLINE_ID id,COLLINE_NAME name', 'collines', 'ZONE_ID=' . $idProvComZon['ZONE_ID'], 'COLLINE_NAME ASC ');
        $Arraycolline = $this->ModelPs->getRequete($callpsreq, $bindparamscolline);
        $collines = '<option value="">Select</option>';
        foreach ($Arraycolline as $col) {
            // code...
            if ($col['id'] == $identite['COLLINE_ID']) {
                // code...
                $collines .= '<option value="' . $col['id'] . '" selected>' . $col['name'] . '</option>';
            } else {
                // code...
                $collines .= '<option value="' . $col['id'] . '">' . $col['name'] . '</option>';
            }

        }

        $bindparamssexe = $this->getBindParms('*', 'sexe', '1', ' SEXE_DESCR ASC');
        $Arraysexe = $this->ModelPs->getRequete($callpsreq, $bindparamssexe);
        $sexes = '<option value="">Select</option>';
        foreach ($Arraysexe as $sexe) {
            // code...
            if ($sexe['SEXE_ID'] == $identite['SEXE_ID']) {
                // code...
                $sexes .= "<option value='" . $sexe['SEXE_ID'] . "' selected>" . $sexe['SEXE_DESCR'] . "</option>";
            } else {
                // code...
                $sexes .= "<option value='" . $sexe['SEXE_ID'] . "'>" . $sexe['SEXE_DESCR'] . "</option>";
            }

        }
        $bindparamsetatcivil = $this->getBindParms('*', 'etat_civil', '1', ' DESCRIPTION ASC');
        $Arrayetatcivil = $this->ModelPs->getRequete($callpsreq, $bindparamsetatcivil);
        $etacivil = "<option value=''>Select</option>";
        foreach ($Arrayetatcivil as $etaciv) {
            // code...
            if ($etaciv['ETAT_CIVIL_ID'] == $identite['ETAT_CIVIL_ID']) {
                // code...
                $etacivil .= "<option value='" . $etaciv['ETAT_CIVIL_ID'] . "' selected>" . $etaciv['DESCRIPTION'] . "</option>";
            } else {
                // code...
                $etacivil .= "<option value='" . $etaciv['ETAT_CIVIL_ID'] . "'>" . $etaciv['DESCRIPTION'] . "</option>";
            }

        }
        $bindparamseassochoby = $this->getBindParms('ID_HOBBY', 'identite_hobby', 'IDENTITE_ID=' . $identite['IDENTITE_ID'], ' IDENTITE_HOBBY_ID ASC');
        $Arrayassochoby = $this->ModelPs->getRequete($callpsreq, $bindparamseassochoby);
        $ID_HOBBY = array();
        foreach ($Arrayassochoby as $assochoby) {
            // code...
            $ID_HOBBY[] = $assochoby['ID_HOBBY'];

        }
        $bindparamshoby = $this->getBindParms('*', 'hobbies', '1', ' HOBBY ASC');
        $Arrayhoby = $this->ModelPs->getRequete($callpsreq, $bindparamshoby);
        $hobbies = '<option value="">Select</option>';
        foreach ($Arrayhoby as $hoby) {
            // code...
            if (in_array($hoby['ID_HOBBY'], $ID_HOBBY)) {
                // code...
                $hobbies .= "<option value='" . $hoby['ID_HOBBY'] . "' selected>" . $hoby['HOBBY'] . "</option>";

            } else {
                // code...
                $hobbies .= "<option value='" . $hoby['ID_HOBBY'] . "'>" . $hoby['HOBBY'] . "</option>";

            }

        }

        echo json_encode(array('identite' => $identite, 'provinces' => $provinces, 'communes' => $communes, 'zones' => $zones, 'collines' => $collines, 'sexes' => $sexes, 'etacivil' => $etacivil, 'hobbies' => $hobbies, 'ID_HOBBY' => $ID_HOBBY));

    }
    /**
     * fonction pour retourner le tableau des parametre pour le PS pour les selection
     * @param string  $columnselect //colone A selectionner
     * @param string  $table        //table utilisE
     * @param string  $where        //condition dans la clause where
     * @param string  $orderby      //order by
     * @return  mixed
     */
    public function getBindParms($columnselect, $table, $where, $orderby)
    {
        // code...
        $bindparams = array(
            'columnselect' => mysqli_real_escape_string($this->db->conn_id,$columnselect),
            'table' => mysqli_real_escape_string($this->db->conn_id,$table) ,
            'where' => mysqli_real_escape_string($this->db->conn_id,$where) ,
            'orderby' => mysqli_real_escape_string($this->db->conn_id,$orderby) ,
        );
        return $bindparams;
    }
    public function listing($value = 0)
    {

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search = str_replace("'", "\'", $var_search);
        $group = "";
        $critaire = "";
        $limit = 'LIMIT 0,1000';
        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by = '';
        $order_column = array('IDENTITE_ID', 'NOM', 'SEXE_DESCR', 'DESCRIPTION', 'COLLINE_NAME');
        if ($_POST['order']['0']['column'] != 0) {
            $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY IDENTITE_ID DESC';
        }

        $search = !empty($_POST['search']['value']) ? (' AND (NOM LIKE "%' . $var_search . '%" OR SEXE_DESCR LIKE "%' . $var_search . '%" OR COLLINE_NAME LIKE "%' . $var_search . '%" OR DESCRIPTION LIKE "%' . $var_search . '%")') : '';

        //condition pour le query principale
        $conditions = $critaire . ' ' . $search . ' ' . $group . ' ' . $order_by . '   ' . $limit;
        // condition pour le query filter
        $conditionsfilter = $critaire . ' ' . $search . ' ' . $group;

        $query_secondaire = "CALL `getTable`('" . $conditions . "');";
        // echo $query_secondaire;
        $fetch_intrants = $this->ModelPs->datatable($query_secondaire);
        $u = 0;
        $data = array();

        $QUANTITE_STOCK_DISPO_TOTAL = 0;
        foreach ($fetch_intrants as $row) {

            $u++;
            $sub_array = array();
            $sub_array[] = $row->IDENTITE_ID;
            $sub_array[] = $row->NOM;
            $sub_array[] = $row->SEXE_DESCR;
            $sub_array[] = $row->DESCRIPTION;
            $sub_array[] = $row->COLLINE_NAME;
            $sub_array[] = "<center><i style='cursor: pointer;' class='fa fa-pencil' onclick='getOne($row->IDENTITE_ID)'></i>|<i  onclick='deleteData($row->IDENTITE_ID)' style='cursor: pointer;' class='fa fa-trash'></i></center>";
            $data[] = $sub_array;

        }

        $recordsTotal = $this->ModelPs->filtrer('CALL `recordsTotal`()');
        $recordsFiltered = $this->ModelPs->filtrer(" CALL `recordsFiltered`('" . $conditionsfilter . "')");
        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => $recordsTotal['recordsTotal'],
            "recordsFiltered" => $recordsFiltered['recordsFiltered'],
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function listingN($value = 0)
    {

        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search = str_replace("'", "\'", $var_search);
        $query_principal = 'SELECT `IDENTITE_ID`, `NOM`,s.SEXE_DESCR,e.DESCRIPTION,col.COLLINE_NAME FROM `identite` i JOIN sexe s ON i.`SEXE_ID`=s.SEXE_ID JOIN etat_civil e ON i.`ETAT_CIVIL_ID`=e.ETAT_CIVIL_ID JOIN collines col ON i.`COLLINE_ID`=col.COLLINE_ID WHERE 1  ';

        $group = "";
        $critaire = "";

        $limit = 'LIMIT 0,1000';
        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by = '';
        $order_column = array('IDENTITE_ID', 'NOM', 'SEXE_DESCR', 'DESCRIPTION', 'COLLINE_NAME');
        if ($_POST['order']['0']['column'] != 0) {
            $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY IDENTITE_ID DESC';
        }

        $search = !empty($_POST['search']['value']) ? (" AND (NOM LIKE '%$var_search%' OR SEXE_DESCR LIKE '%$var_search%' OR COLLINE_NAME LIKE '%$var_search%' OR DESCRIPTION LIKE '%$var_search%')") : '';

        $query_secondaire = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group . ' ' . $order_by . '   ' . $limit;

        // echo  $query_secondaire;
        $query_filter = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group;

        // echo $query_filter."<br>";
        // echo $query_principal;

        // $s='SELECT `IDENTITE_ID`, `NOM`,s.SEXE_DESCR,e.DESCRIPTION,col.COLLINE_NAME FROM `identite` i JOIN sexe s ON i.`SEXE_ID`=s.SEXE_ID JOIN etat_civil e ON i.`ETAT_CIVIL_ID`=e.ETAT_CIVIL_ID JOIN collines col ON i.`COLLINE_ID`=col.COLLINE_ID WHERE 1';
        //  echo $query_principal;
        // 'SELECT `IDENTITE_ID`, `NOM`,s.SEXE_DESCR,e.DESCRIPTION,col.COLLINE_NAME FROM `identite` i JOIN sexe s ON i.`SEXE_ID`=s.SEXE_ID JOIN etat_civil e ON i.`ETAT_CIVIL_ID`=e.ETAT_CIVIL_ID JOIN collines col ON i.`COLLINE_ID`=col.COLLINE_ID WHERE 1 AND (NOM LIKE '%ju%' OR SEXE_DESCR LIKE '%ju%' OR COLLINE_NAME LIKE '%ju%' OR DESCRIPTION LIKE '%ju%')'

        $fetch_intrants = $this->Model->datatable($query_secondaire);
        $u = 0;
        $data = array();

        $QUANTITE_STOCK_DISPO_TOTAL = 0;
        foreach ($fetch_intrants as $row) {

            $u++;
            $sub_array = array();
            $sub_array[] = $row->IDENTITE_ID;
            $sub_array[] = $row->NOM;
            $sub_array[] = $row->SEXE_DESCR;
            $sub_array[] = $row->DESCRIPTION;
            $sub_array[] = $row->COLLINE_NAME;
            $data[] = $sub_array;

        }

        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => $this->Model->all_data($query_principal),
            "recordsFiltered" => $this->Model->filtrer($query_filter),
            "data" => $data,
        );
        echo json_encode($output);
    }
}