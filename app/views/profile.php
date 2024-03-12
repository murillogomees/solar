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
         
        <link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/plugins.css" ?>">        
        <link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/core.css" ?>">
        <link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/toastr/toastr.min.css" ?>">
      <link rel="stylesheet" href="<?= APPURL . "/assets/css/materialize.css"?>">

        <title><?= "Perfil: " . htmlchars($AuthUser->get("firstname")." ".$AuthUser->get("lastname"))  ?></title>
    </head>

    <body>
        <?php
            $Nav = new stdClass;
            $Nav->activeMenu = false;
            require_once(APPPATH.'/views/fragments/navigation.fragment.php');
        ?>

        <?php
            $TopBar = new stdClass;
            $TopBar->title = "Edição: " . htmlchars($AuthUser->get("firstname")." ".$AuthUser->get("lastname"));
            $TopBar->btn = false;
            require_once(APPPATH.'/views/fragments/topbar.fragment.php');
        ?>
                     
        <?php require_once(APPPATH.'/views/fragments/profile.fragment.php'); ?>
      
        <?php require_once(APPPATH.'/views/fragments/footer-copyright.fragment.php'); ?>

        <script type="text/javascript" src="<?= APPURL."/assets/js/plugins.js" ?>"></script>
        <?php require_once(APPPATH.'/inc/js-locale.inc.php'); ?>
        <script type="text/javascript" src="<?= APPURL."/assets/js/toastr/toastr.min.js"?>"></script>
        <script type="text/javascript" src="<?= APPURL."/assets/js/core.js" ?>"></script>
        <script type="text/javascript" src="<?= APPURL."/assets/js/materialize.js"?>"></script> 
        <script type="text/javascript" charset="utf-8">
            $(function(){              
                NextPost.Profile();
  $("#abrirsenha").on("click",function(e){	
	$("#BrancoSenha").hide();
	$("#campoSenha").show();
});
  $("#fecharprofile").on("click",function(e){	
	$("#BrancoSenha").show();
	$("#campoSenha").hide();
});
               $(document).ready(function() {
                  $('form#profileForm').bind("keypress", function(e) {
                      if ((e.keyCode == 10)||(e.keyCode == 13)) {
                          e.preventDefault();
                        }
                    });
                });             
            });
        </script>
        <?php require_once(APPPATH.'/views/fragments/google-analytics.fragment.php'); ?>
    </body>
</html>
