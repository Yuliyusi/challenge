<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>bootstrap-5.0.2-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>bootstrap-5.0.2-dist/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url()?>bootstrap-5.0.2-dist/css/bootstrap-multiselect.css">
	<title>PROCEDURE STOCKE</title>
</head>
<body style="padding: 10px;">
<div class="row">
  <!-- Button trigger modal -->
<div class="col-2">
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Nouveaux
</button>
</div>

<!-- Modal -->
<div class="modal fade modal-xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-6">
            <label>Nom</label>
            <input type="text" name="NOM" id="NOM" class="form-control">
          </div>
          <div class="col-6">
            <label>Sexe</label>
            <select class="form-control" id="SEXE_ID" name="SEXE_ID" >
              <option value="">Select</option>
              
            </select>
          </div>
          <div class="col-6">
            <label>Etat civil</label>
            <select class="form-control" id="ETAT_CIVIL_ID" name="ETAT_CIVIL_ID">
              <option value="">Select</option>
              
            </select>            
          </div>
          <div class="col-6">
            <label>Province</label>
            <select class="form-control" id="PROVINCE_ID" name="PROVINCE_ID">
              <option value="">Select</option>
              
            </select>            
          </div>
          <div class="col-6">
            <label>Commune</label>
            <select class="form-control" id="COMMUNE_ID" name="COMMUNE_ID">
              <option value="">Select</option>
              
            </select>            
          </div>
          <div class="col-6">
            <label>Zone</label>
            <select class="form-control" id="ZONE_ID" name="ZONE_ID">
              <option value="">Select</option>
              
            </select>            
          </div>
          <div class="col-6">
            <label>Colline</label>
            <select class="form-control" id="ZONE_ID" name="ZONE_ID">
              <option value="">Select</option>
              
            </select>            
          </div>
          <div class="col-6">
            <label>Hobby</label>
            <select class="form-control" id="ID_HOBBY" name="ID_HOBBY">
              <option value="">Select</option>
              
            </select>            
          </div> 

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
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

<script  src="<?= base_url()?>bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
<script  src="<?= base_url()?>bootstrap-5.0.2-dist/js/jquery-3.6.1.min.js"></script>
<script  src="<?= base_url()?>bootstrap-5.0.2-dist/js/jquery.dataTables.min.js"></script>
<script  src="<?= base_url()?>bootstrap-5.0.2-dist/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example-dropUp').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: true
        });
    });
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
</html>