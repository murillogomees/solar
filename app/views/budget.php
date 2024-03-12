<!DOCTYPE html>
<html lang="<?= ACTIVE_LANG ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta name="theme-color" content="#fff">

        <meta name="description" content="<?= site_settings("site_description") ?>">
        <meta name="keywords" content="<?= site_settings("site_keywords") ?>">

        <link rel="icon" href="<?= site_settings("logomark") ? site_settings("logomark") : APPURL."/assets/img/logomark.png" ?>" type="image/x-icon">
        <link rel="shortcut icon" href="<?= site_settings("logomark") ? site_settings("logomark") : APPURL."/assets/img/favicon.png" ?>" type="image/x-icon">
        
      
        
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/invoicenovo.css"?>">
        <link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/core.css"?>">
        <link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/style.min.css"?>">
        <link rel="stylesheet" type="text/css" href="https://pixinvent.com/materialize-material-design-admin-template/app-assets/vendors/vendors.min.css">
        <link rel="stylesheet" type="text/css" href="https://pixinvent.com/materialize-material-design-admin-template/app-assets/css/themes/vertical-modern-menu-template/materialize.min.css">
        <link rel="stylesheet" type="text/css" href="https://pixinvent.com/materialize-material-design-admin-template/app-assets/css/pages/app-invoice.min.css">

      <?php 
        $Client = json_decode($User->get("client"));
        $Kw = json_decode($User->get("product_details"));
        $subTotal = json_decode($User->get("order_value")); 
      ?>
        <?php if($AuthUser): ?>
        <title><?= $User->get("order_id") . "_" . date("Ymd") . "_Orçamento - Horus Solar_" . $Client[0]->name . "_" .  number_format($Kw[0]->kwpReal, 2, ',','.') . "KWp_R$" . number_format((float)$subTotal[0]->totalTotal,2,",",".") ?></title>
        <meta property=’og:title’ content='<?= $User->get("order_id") . "_" . date("Ymd") . "_Orçamento - Horus Solar_" . $Client[0]->name . "_" .  number_format($Kw[0]->kwpReal, 2, ',','.') . "KWp_R$" . number_format((float)$subTotal[0]->totalTotal,2,",",".") ?>' >
        <?php else: ?>
        <title><?= "Orçamento - Solar: Nº " . $User->get("order_id") . " para o cliente: " .  $Client[0]->name ?></title>
        <meta property=’og:title’ content='<?= "Orçamento - Solar: Nº " . $User->get("order_id") . " para o cliente: " .  $Client[0]->name ?>' >
        <?php endif;?>
      
        <meta property=’og:image’ content='<?= APPURL."/assets/img/thumb_orcamento.png" ?>' >
        <meta property="og:image:type" content="image/png" />
        <meta property="og:image:width" content="600" />
        <meta property="og:image:height" content="600" />
        <meta property="og:type" content='website'/>
      
        <?php if($AuthUser): ?>
        <meta property=’og:title’ content='<?= $User->get("order_id") . "_" . date("Ymd") . "_Orçamento - Horus Solar_" . $Client[0]->name . "_" .  number_format($Kw[0]->kwpReal, 2, ',','.') . "KWp_R$" . number_format((float)$subTotal[0]->totalTotal,2,",",".") ?>'/>
        <?php else: ?>
        <meta property=’og:title’ content='<?= "Orçamento - Solar: Nº " . $User->get("order_id") . " para o cliente: " .  $Client[0]->name ?>'/>
        <?php endif;?>
    </head>
    <style>
     td {
        padding: 0px 0px 0px 0px !important;
      }
      
      @media screen and (max-width: 475px){
        
      tr td {
        font-size:11px;
      }
        
      }
    </style>
    <body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 2-columns  app-page " data-open="click" data-menu="vertical-modern-menu" data-col="2-columns">        
       
        <?php if(!$AuthUser): ?>
        <?php require_once(APPPATH.'/views/fragments/budget.fragment.php'); ?>
        <?php endif; ?>
      
        <?php if($AuthUser->get("account_type") == "integrador"):?>
        <?php require_once(APPPATH.'/views/fragments/budgetIntegrador.fragment.php'); ?>
        <?php else:?>
        <?php require_once(APPPATH.'/views/fragments/budget.fragment.php'); ?>
        <?php endif;?>
      
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
 
        <script type="text/javascript" src="https://pixinvent.com/materialize-material-design-admin-template/app-assets/js/plugins.min.js"></script>  
        <script type="text/javascript" src="https://pixinvent.com/materialize-material-design-admin-template/app-assets/js/search.min.js"></script>  
        <script type="text/javascript" src="https://pixinvent.com/materialize-material-design-admin-template/app-assets/js/scripts/customizer.min.js"></script>  
        <script type="text/javascript" src="https://pixinvent.com/materialize-material-design-admin-template/app-assets/js/scripts/app-invoice.min.js"></script>   
        <script type="text/javascript">
          
          function whatsApp(){
            $.ajax({
                  url: document.baseURI,
                  type: "POST",
                  dataType: "jsonp",
                  data: {
                    action: "logWhats",		
                  },
                  error: function(resp) {
                    console.log("Errado");
                  },
                  success: function(resp) {
                   console.log("Salvou");
                  }
            });
          }
      
        </script>  
        
        <?php require_once(APPPATH.'/views/fragments/google-analytics.fragment.php'); ?>
    </body>
</html>

