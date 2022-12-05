<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>bootstrap-5.0.2-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>bootstrap-5.0.2-dist/css/jquery.dataTables.min.css">
  <!-- <link rel="stylesheet" type="text/css" href="<?= base_url()?>bootstrap-5.0.2-dist/css/bootstrap-multiselect.css"> -->
<link rel="stylesheet" href="<?= base_url()?>font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?= base_url()?>sweetalert2-11.6.15/package/dist/sweetalert2.min.css">
	<title>PROCEDURE STOCKE</title>
</head>
<body style="padding: 10px;">
<div class="row">
  <!-- Button trigger modal -->
<div class="col-2">
  <button onclick="$('#formidentite').get(0).reset();$('select option').removeAttr('selected');$('#btnenregistr').html('Enregistrer')" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nouveauidentite">
  Nouveaux
</button>
</div>

<!-- Modal -->
<div class="modal fade modal-xl" id="nouveauidentite" tabindex="-1" aria-labelledby="nouveauidentiteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nouveauidentiteLabel">Identification</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formidentite" onsubmit="">
        <div class="row">
          <input type="hidden" name="IDENTITE_ID" id="IDENTITE_ID">
          <div class="col-6">
            <label>Nom<span class="text-danger">*</span></label>
            <input type="text" name="NOM" id="NOM" class="form-control">
            <span id="errorNOM" class="text-danger"></span>
          </div>
          <div class="col-6">
            <label>Sexe<span class="text-danger">*</span></label>
            <select class="form-control" id="SEXE_ID" name="SEXE_ID" >
              <option value="">Select</option>
              <?php foreach ($sexe as $keysexe) {
                // code...
               ?>
              <option value="<?= $keysexe['SEXE_ID'] ?>"><?= $keysexe['SEXE_DESCR'] ?></option>
              <?php } ?>
              
            </select>
            <span id="errorSEXE_ID" class="text-danger"></span>
          </div>
          <div class="col-6">
            <label>Etat civil<span class="text-danger">*</span></label>
            <select class="form-control" id="ETAT_CIVIL_ID" name="ETAT_CIVIL_ID">
              <option value="">Select</option>
              <?php foreach ($etat_civil as $keyetat_civil) {
                // code...
               ?>
              <option value="<?= $keyetat_civil['ETAT_CIVIL_ID'] ?>"><?= $keyetat_civil['DESCRIPTION'] ?></option>
              <?php } ?>              
            </select>
            <span id="errorETAT_CIVIL_ID" class="text-danger"></span>           
          </div>
          <div class="col-6">
            <label>Province<span class="text-danger">*</span></label>
            <select class="form-control" id="PROVINCE_ID" name="PROVINCE_ID" onchange="getLocaliteByParent(this.value,'COMMUNE_ID',1)">
              <option value="">Select</option>
              <?php foreach ($provinces as $keyprovinces) {
                // code...
               ?>
              <option value="<?= $keyprovinces['PROVINCE_ID'] ?>"><?= $keyprovinces['PROVINCE_NAME'] ?></option>
              <?php } ?>               
            </select>
            <span id="errorPROVINCE_ID" class="text-danger"></span>              
          </div>
          <div class="col-6">
            <label>Commune<span class="text-danger">*</span></label>
            <select class="form-control" id="COMMUNE_ID" name="COMMUNE_ID" onchange="getLocaliteByParent(this.value,'ZONE_ID',2)">
              <option value="">Select</option>
              
            </select>
             <span id="errorCOMMUNE_ID" class="text-danger"></span>           
          </div>
          <div class="col-6">
            <label>Zone<span class="text-danger">*</span></label>
            <select class="form-control" id="ZONE_ID" name="ZONE_ID" onchange="getLocaliteByParent(this.value,'COLLINE_ID',3)">
              <option value="">Select</option>
              
            </select>
            <span id="errorZONE_ID" class="text-danger"></span>  
                      
          </div>
          <div class="col-6">
            <label>Colline<span class="text-danger">*</span></label>
            <select class="form-control" id="COLLINE_ID" name="COLLINE_ID">
              <option value="">Select</option>
              
            </select>
            <span id="errorCOLLINE_ID" class="text-danger"></span>             
          </div>
          <div class="col-6">
            <label>Hobby<span class="text-danger">*</span></label>
            <select class="form-control selectpicker" id="ID_HOBBY" name="ID_HOBBY[]" multiple>
              <option value="">Select</option>
              <?php foreach ($hobbies as $keyhobbies) {
                // code...
               ?>
              <option value="<?= $keyhobbies['ID_HOBBY'] ?>"><?= $keyhobbies['HOBBY'] ?></option>
              <?php } ?>                 
            </select>
            <span id="errorID_HOBBY" class="text-danger"></span>            
          </div> 
         
        </div>
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button id="btnenregistr" type="button" class="btn btn-primary" onclick="addData()">Enregistrer</button>
      </div>
    </div>
  </div>
</div>
</div>
<div class="row">
  <div class="col-6">
<h1>PS-MYSQL</h1>
<table id="identitetable" class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">NOM</th>
      <th scope="col">SEXE</th>
      <th scope="col">ETAT CIVIL</th>
      <th scope="col">COLLINE</th>
      <th scope="col">OPTIONS</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>    
  </div>
  <div class="col-6">
<h1>SANS PS-MYSQL</h1>
<table id="identitetableN" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">NOM</th>
      <th scope="col">SEXE</th>
      <th scope="col">ETAT CIVIL</th>
      <th scope="col">COLLINE</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>    
 </div>
</div>
</body>
<script  src="<?= base_url()?>sweetalert2-11.6.15/package/dist/sweetalert2.min.js"></script>
<script  src="<?= base_url()?>bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
<script  src="<?= base_url()?>bootstrap-5.0.2-dist/js/jquery-3.6.1.min.js"></script>
<script  src="<?= base_url()?>bootstrap-5.0.2-dist/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
 function getLocaliteByParent(idparrent,idtorender,level) {
   // body...
   let url="<?= base_url('PsTest/getLocaliteByParent')?>"
   $.post(
    url,
    {
     idparrent:idparrent,
     idtorender:idtorender,
     level:level
    },
    function(data) {
     // body...
     document.getElementById(idtorender).innerHTML=data
   })

 }
 function validateForm() {
   // body...
  let NOM = document.forms["formidentite"]["NOM"].value;
  let SEXE_ID = document.forms["formidentite"]["SEXE_ID"].value;
  let ETAT_CIVIL_ID = document.forms["formidentite"]["ETAT_CIVIL_ID"].value;
  let PROVINCE_ID = document.forms["formidentite"]["PROVINCE_ID"].value;
  let COMMUNE_ID = document.forms["formidentite"]["COMMUNE_ID"].value;
  let ZONE_ID = document.forms["formidentite"]["ZONE_ID"].value; 
  let COLLINE_ID = document.forms["formidentite"]["COLLINE_ID"].value; 
  let ID_HOBBY = document.forms["formidentite"]["ID_HOBBY"].value; 
  if (NOM=="") {
    document.getElementById('errorNOM').innerHTML="Required";
    return false;
  }else{
    document.getElementById('errorNOM').innerHTML="";
  }
  if (SEXE_ID=="") {
    document.getElementById('errorSEXE_ID').innerHTML="Required";
    return false;
  }else{
    document.getElementById('errorSEXE_ID').innerHTML="";
  }
  if (ETAT_CIVIL_ID=="") {
    document.getElementById('errorETAT_CIVIL_ID').innerHTML="Required";
    return false;
  }else{
    document.getElementById('errorETAT_CIVIL_ID').innerHTML="";
  } 
  if (PROVINCE_ID=="") {
    document.getElementById('errorPROVINCE_ID').innerHTML="Required";
    return false;
  }else{
    document.getElementById('errorPROVINCE_ID').innerHTML="";
  }
  if (COMMUNE_ID=="") {
    document.getElementById('errorCOMMUNE_ID').innerHTML="Required";
    return false;
  }else{
    document.getElementById('errorCOMMUNE_ID').innerHTML="";
  } 
  if (ZONE_ID=="") {
    document.getElementById('errorZONE_ID').innerHTML="Required";
    return false;
  }else{
    document.getElementById('errorZONE_ID').innerHTML="";
  }
  if (COLLINE_ID=="") {
    document.getElementById('errorCOLLINE_ID').innerHTML="Required";
    return false;
  }else{
    document.getElementById('errorCOLLINE_ID').innerHTML="";
  } 
  if (ID_HOBBY=="") {
    document.getElementById('errorID_HOBBY').innerHTML="Required";
    return false;
  }else{
    document.getElementById('errorID_HOBBY').innerHTML="";
  }             
 }

function addData() {
  // body...
  if (validateForm()!==false) {

      Swal.fire({
        title: 'Are you sure?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
          if (result.isConfirmed) {
              // Assign handlers immediately after making the request,
              // and remember the jqxhr object for this request
            const formData=$( "#formidentite" ).serialize();
            const url="<?= base_url('PsTest/Add')?>"
            var jqxhr = $.post( url,formData, function(data) {
              if (JSON.parse(data)==1) {
                  get_list()//avec procedure stocke
                  get_listN()//sans ps
                  Swal.fire(
                    'Fait!',
                    'Operation faite avec succes.',
                    'success'
                  )         
              }
               
              })
                // .done(function(data) {
                //   alert(data)
                // })
                .fail(function() {
                  alert( "error" );
                })
                // .always(function() {
                //   alert( "finished" );
                // });
          }
})


  }else{

    alert("probleme")
  }
}


</script>
<script type="text/javascript">
$( document ).ready(function() {
    get_listN()//sans ps
    get_list()//avec procedure stocke
    
});
  function get_list() {
  // body...

  var row_count ="1000000";

  table=$("#identitetable").DataTable({
    "processing":true,
    "destroy" : true,
    "serverSide":true,
    "oreder":[[2, 'desc' ]],
    "ajax":{
      url:"<?=base_url()?>PsTest/listing/",
      type:"POST",
      data : {}
    },
    lengthMenu: [[10,50, 100, row_count], [10,50, 100, "All"]],
    pageLength: 10,
    "columnDefs":[{
      "targets":[],
      "orderable":false
    }],

    dom: 'Bfrtlip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ],
    language: {
      "sProcessing":     "Traitement en cours...",
      "sSearch":         "Rechercher&nbsp;:",
      "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
      "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
      "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      "sInfoPostFix":    "",
      "sLoadingRecords": "Chargement en cours...",
      "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
      "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
      "oPaginate": {
        "sFirst":      "Premier",
        "sPrevious":   "Pr&eacute;c&eacute;dent",
        "sNext":       "Suivant",
        "sLast":       "Dernier"
      },
      "oAria": {
        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
      }
    }

  });
}
  function get_listN() {
  // body...

  var row_count ="1000000";

  table=$("#identitetableN").DataTable({
    "processing":true,
    "destroy" : true,
    "serverSide":true,
    "oreder":[[2, 'desc' ]],
    "ajax":{
      url:"<?=base_url()?>PsTest/listingN/",
      type:"POST",
      data : {}
    },
    lengthMenu: [[10,50, 100, row_count], [10,50, 100, "All"]],
    pageLength: 10,
    "columnDefs":[{
      "targets":[],
      "orderable":false
    }],

    dom: 'Bfrtlip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ],
    language: {
      "sProcessing":     "Traitement en cours...",
      "sSearch":         "Rechercher&nbsp;:",
      "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
      "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
      "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      "sInfoPostFix":    "",
      "sLoadingRecords": "Chargement en cours...",
      "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
      "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
      "oPaginate": {
        "sFirst":      "Premier",
        "sPrevious":   "Pr&eacute;c&eacute;dent",
        "sNext":       "Suivant",
        "sLast":       "Dernier"
      },
      "oAria": {
        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
      }
    }

  });
}


</script>
<script type="text/javascript">
  function getOne(IDENTITE_ID) {
    // body...
    //alert(IDENTITE_ID)
    let url="<?= base_url('PsTest/getOne')?>";
    $.post(url,{IDENTITE_ID:IDENTITE_ID},function(data) {
      // body...
      let donne=JSON.parse(data);
      $('#IDENTITE_ID').val(donne.identite.IDENTITE_ID)
      $('#NOM').val(donne.identite.NOM)
      $('#SEXE_ID').html(donne.sexes)
      $('#ID_HOBBY').html(donne.hobbies)
      $('#PROVINCE_ID').html(donne.provinces)
      $('#COMMUNE_ID').html(donne.communes)
      $('#ZONE_ID').html(donne.zones)
      $('#COLLINE_ID').html(donne.collines)
      $('#ETAT_CIVIL_ID').html(donne.etacivil)
      $('#btnenregistr').html("Modifier")
      $('#nouveauidentite').modal('show')
      //alert(donne.identite.NOM)
    })
  }

  //////////////////////////////
  function deleteData(IDENTITE_ID) {
    // body...
    let url="<?=base_url()?>PsTest/deleteData/"
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.post(url,{IDENTITE_ID:IDENTITE_ID},function (data) {
          // body...
          if (data==1) {
            get_list()
            get_listN()
            Swal.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            )            
          }
        })

      }
    })   
  }
  function deleteAction() {
    // body...
  }
</script>
</html>