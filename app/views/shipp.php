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
         
        <link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/plugins.css?v=".VERSION ?>">
        <link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/core.css?v=".VERSION ?>">

        <title><?= __("Frete - Horus Solar") ?></title>

    </head>

    <body>
        <?php
            $Nav = new stdClass;
            $Nav->activeMenu = "users";
            require_once(APPPATH.'/views/fragments/navigation.fragment.php');
        ?>

        <?php
            $TopBar = new stdClass;
            $TopBar->title = __("Frete");
            $TopBar->btn = array(
                "icon" => "sli sli-map",
                "title" => __("Adicionar Frete"),
                "link" => APPURL."/shipping/new"


            );
            require_once(APPPATH.'/views/fragments/topbar.fragment.php');
        ?>

        <?php require_once(APPPATH.'/views/fragments/shipp.fragment.php'); ?>
      
        <?php require_once(APPPATH.'/views/fragments/footer-copyright.fragment.php'); ?>

        <script type="text/javascript" src="<?= APPURL."/assets/js/plugins.js?v=".VERSION ?>"></script>
        <?php require_once(APPPATH.'/inc/js-locale.inc.php'); ?>
        <script type="text/javascript" src="<?= APPURL."/assets/js/core.js?v=".VERSION ?>"></script>
        <script type="text/javascript" charset="utf-8">
            $(function(){
                NextPost.UserForm();
                NextPost.Cnpj();
            })

            function onlynumber(evt) {
               var theEvent = evt || window.event;
               var key = theEvent.keyCode || theEvent.which;
               key = String.fromCharCode( key );

               //var regex = /^[0-9.,]+$/;
               var regex = /^[0-9.]+$/;
               if( !regex.test(key) ) {
                  theEvent.returnValue = false;
                  if(theEvent.preventDefault) theEvent.preventDefault();
               }

            }


        </script>

        <?php require_once(APPPATH.'/views/fragments/google-analytics.fragment.php'); ?>
    </body>
</html>
       