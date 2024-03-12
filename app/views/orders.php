<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
        <meta name="theme-color" content="#fff" />
        <meta name="description" content="<?= site_settings("site_description") ?>">
			  <meta name="keywords" content="<?= site_settings("site_keywords") ?> ">
		  	<link rel="icon" href=" <?= site_settings("logomark") ? site_settings("logomark") : APPURL."/assets/img/logomark.png" ?>" type="image/x-icon">
			  <link rel="shortcut icon" href=" <?= site_settings("logomark") ? site_settings("logomark") : APPURL."/assets/img/favicon.png" ?>" type="image/x-icon">
				<link rel="stylesheet" href="<?= APPURL . "/assets/css/buttons.dataTables.min.css"?>"> 
				<link rel="stylesheet" href="<?= APPURL . "/assets/css/jquery.dataTables.min.css"?>"> 
				<script src="<?= APPURL . "/assets/js/jquery-3.5.1.js" ?>"></script>
				<script type="text/javascript" charset="utf8" src="<?= APPURL . "/assets/js/otimize.js" ?>"></script>
				<link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/plugins.css?v=".VERSION ?>">
				<link rel="stylesheet" type="text/css" href="  https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css ">
			  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/plug-ins/1.12.1/integration/font-awesome/dataTables.fontAwesome.css">
				<link rel="stylesheet" type="text/css" href=" <?= APPURL."/assets/css/core.css?v=".VERSION ?>  ">
				<link rel="stylesheet" type="text/css" href=" <?= APPURL."/assets/css/toastr/toastr.min.css?v=".VERSION ?>">
				<link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/js/bootstrap/bootstrap-modal.css" ?>">
				<title><?=__("Orçamentos - ". site_settings("site_name")) ?></title>


	</head>
		
		
	<style>.lineTitle {
	font-weight: 300;
	font-size: 20px;
	padding-top: 3px;
}

.lineSub {
	font-size: 16px;
	color: #2a3f54;
	position: absolute;
	padding-top: 3.1rem;
}

.lineText {
	font-size: 14px;
	position: absolute;
}

.lineModal {
	border-bottom: solid 1px #cecece;
}
		
.modal {
 margin: 10px !important;
}
		
.dataTables_filter {
	margin: 5px !important;
}
		
@media screen and (max-width: 992px) {
	table {
		display: block;
	}
	table>*,
	table tr,
	table td,
	table th {
		display: block;
	}
	table thead tr {
   display:none;
	}
	table tbody tr {
		height: auto;
		padding: 15px 0;
	}
	table tbody tr td {
		text-align: center;
		margin-bottom: 4px;
	}
	table tbody tr td:first-child {	
		border-top:8px solid #51524f;
		border-radius: 10px 10px 0px 0px;
	}
	table tbody tr td:last-child {
		margin-bottom: 0;
		border-bottom:8px solid #f07e13;
		border-radius: 0px 0px 10px 10px;
	}
	table tbody tr td:before {
		font-family: OpenSans-Regular;
		font-size: 14px;
		color: #999999;
		text-align: center;
		line-height: 1.2;
		font-weight: unset;
		position: absolute;
		width: 40%;
		left: 30px;
		top: 0;
	}
	.column4,
	.column5,
	.column6 {
		text-align: center;
	}
	.column4,
	.column5,
	.column6,
	.column1,
	.column2,
	.column3 {
		width: 100%;
	}
	tbody tr {
		font-size: 14px;
	}
}

@media (max-width: 576px) {
	.container-table100 {
		padding-left: 15px;
		padding-right: 15px;
	}
}

</style><body>
	
	<?php $Nav=new stdClass;
$Nav->activeMenu="order";
require_once(APPPATH.'/views/fragments/navigation.fragment.php');
?><?php $TopBar=new stdClass;
$TopBar->title=__("Orçamentos");
$TopBar->btn = array(
                "icon" => "sli sli-calculator",
                "title" => __("Cadastrar Orçamentos"),
                "link" => APPURL."/order/new"
            );	

require_once(APPPATH.'/views/fragments/topbar.fragment.php');
?><?php require_once(APPPATH.'/views/fragments/orders.fragment.php');
?><?php require_once(APPPATH.'/views/fragments/footer-copyright.fragment.php');
?>
<script type="text/javascript" src="<?= APPURL."/assets/js/plugins.js?v=".VERSION ?>"></script>		

	
    <script type="text/javascript" src="<?= APPURL . "/assets/js/jquery-3.5.1.js" ?>"></script>
    <script type="text/javascript "src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= APPURL . "/assets/js/dataTables.buttons.min.js" ?>"></script>
    <script type="text/javascript" src="<?= APPURL . "/assets/js/jszip.min.js" ?>"></script>
    <script type="text/javascript" src="<?= APPURL . "/assets/js/pdfmake.min.js" ?>"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
    <script type="text/javascript" src="<?= APPURL . "/assets/js/buttons.html5.min.js" ?>"></script>
    <script type="text/javascript" src="<?= APPURL . "/assets/js/buttons.print.min.js" ?>"></script>	
		<script type="text/javascript" src="<?= APPURL . "/assets/js/core.js"?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  

   <script>
	$(document).ready( function () {
		
	  	var url = document.baseURI;
			$.ajax({
			url:url,
			type: "POST",
			dataType: "jsonp",
			data: {
				action: "orcamentoAtencao",      
			},
			error: function(resp) {   
				console.log(resp);
			},
			success: function(resp) {		
			
			console.log(resp);
				
			if(resp.result == 1){
				 
							Swal.fire(
							'Cotações que precisam de sua atenção!',
							resp.mensagem,
							'info'
						)
				 }			
			}
		});
	

	
		
		

		
    $('#tableRascunho').DataTable({
				paging: true,				
				pagingType: 'full_numbers',
				searching: true,

			  order: [0, 'DESC'],
        lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"] ],   
				pageLength: 10,
				ordering: true,
				language: {
 					url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json'
				}
		});
} );
		 
	</script>

</body>
</html>