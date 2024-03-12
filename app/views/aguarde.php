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
        <link rel="apple-touch-icon" href="https://pixinvent.com/materialize-material-design-admin-template/app-assets/images/favicon/apple-touch-icon-152x152.png">      
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- BEGIN: VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="https://pixinvent.com/materialize-material-design-admin-template/app-assets/vendors/vendors.min.css">
        <!-- END: VENDOR CSS-->
        <!-- BEGIN: Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="https://pixinvent.com/materialize-material-design-admin-template/app-assets/css/themes/vertical-modern-menu-template/materialize.css">
        <link rel="stylesheet" type="text/css" href="https://pixinvent.com/materialize-material-design-admin-template/app-assets/css/themes/vertical-modern-menu-template/style.css">
        <link rel="stylesheet" type="text/css" href="https://pixinvent.com/materialize-material-design-admin-template/app-assets/css/pages/page-maintenance.css">
        <!-- END: Page Level CSS-->
        <!-- BEGIN: Custom CSS-->
        <link rel="stylesheet" type="text/css" href="https://pixinvent.com/materialize-material-design-admin-template/app-assets/css/custom/custom.css">

        <title><?= __("Aguardando Aprovação ". site_settings("site_name")) ?></title>

    </head>

   <body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 1-column    blank-page blank-page" data-open="click" data-menu="vertical-modern-menu" data-col="1-column">
    <div class="row">
      <div class="col s12">
        <div class="container"><div class="section p-0 m-0 height-100vh section-maintenance">
            <div class="row">
              <!-- Maintenance -->
              <div id="maintenance" class="col s12 center-align white">
                <img src="<?= APPURL . "/assets/img/analise-min.png"?>" class="responsive-img maintenance-img" alt="">
                <h4 class="error-code">O sistema está temporariamente bloqueado para novos cadastros!</h4>
                <h6 class="mb-2 mt-2">Não se preocupe, você será avisado por e-mail assim que seu cadastro estiver aprovado e o sistema liberado. <br></h6>      
              </div>
            </div>
          </div>
        </div>
        <div class="content-overlay"></div>
      </div>
    </div>

    <!-- BEGIN VENDOR JS-->
    <script src="https://pixinvent.com/materialize-material-design-admin-template/app-assets/js/vendors.min.js"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN THEME  JS-->
    <script src="https://pixinvent.com/materialize-material-design-admin-template/app-assets/js/plugins.js"></script>
    <script src="https://pixinvent.com/materialize-material-design-admin-template/app-assets/js/search.js"></script>
    <script src="https://pixinvent.com/materialize-material-design-admin-template/app-assets/js/custom/custom-script.js"></script>
    <!-- END THEME  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <!-- END PAGE LEVEL JS-->
  </body>
</html>

