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
				<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css ">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/plug-ins/1.12.1/integration/font-awesome/dataTables.fontAwesome.css">
			  <script src="<?= APPURL . "/assets/js/jquery-3.5.1.js" ?>"></script>
				<script type="text/javascript" charset="utf8" src="<?= APPURL . "/assets/js/otimiza-frete.js" ?>"></script>
				<link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/plugins.css?v=".VERSION ?>">
			
				<link rel="stylesheet" type="text/css" href=" <?= APPURL."/assets/css/core.css?v=".VERSION ?>  ">
				<link rel="stylesheet" type="text/css" href=" <?= APPURL."/assets/css/toastr/toastr.min.css?v=".VERSION ?>">
				<link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/js/bootstrap/bootstrap-modal.css" ?>">     
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.3.1/css/rowReorder.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
				<title><?=__("Relatório Frete - ". site_settings("site_name")) ?></title>
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

    </style>
  <body>
	
      <?php $Nav=new stdClass;
      $Nav->activeMenu="relatorio";
      require_once(APPPATH.'/views/fragments/navigation.fragment.php');
      ?><?php $TopBar=new stdClass;
      $TopBar->title=__("Relatório Frete");

      require_once(APPPATH.'/views/fragments/topbar.fragment.php');
      ?><?php require_once(APPPATH.'/views/fragments/ordersb.fragment.php');
      ?><?php require_once(APPPATH.'/views/fragments/footer-copyright.fragment.php');
      ?>
    <script type="text/javascript" src="<?= APPURL."/assets/js/plugins.js?v=".VERSION ?>"></script>		
    <script type="text/javascript "src="<?= APPURL . "/assets/js/jquery.dataTables.min.js" ?>"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/rowreorder/1.3.1/js/dataTables.rowReorder.min.js"></script>    
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>  
	  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	  <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
	  <script type="text/javascript" src="<?= APPURL . "/assets/js/otimizar.js" ?>"></script>
    <script type="text/javascript" src="<?= APPURL . "/assets/js/dataTables.buttons.min.js" ?>"></script>
    <script type="text/javascript" src="<?= APPURL . "/assets/js/jszip.min.js" ?>"></script>
    <script type="text/javascript" src="<?= APPURL . "/assets/js/pdfmake.min.js" ?>"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
    <script type="text/javascript" src="<?= APPURL . "/assets/js/buttons.html5.min.js" ?>"></script>
    <script type="text/javascript" src="<?= APPURL . "/assets/js/buttons.print.min.js" ?>"></script>	
		<script type="text/javascript" src="<?= APPURL . "/assets/js/core.js"?>"></script>



</body>
</html>