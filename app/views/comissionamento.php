<!DOCTYPE html>
<html lang="<?= ACTIVE_LANG ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta name="theme-color" content="#fff">
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />

        <meta name="description" content="<?= site_settings("site_description") ?>">
        <meta name="keywords" content="<?= site_settings("site_keywords") ?>">

        <link rel="icon" href="<?= site_settings("logomark") ? site_settings("logomark") : APPURL."/assets/img/logomark.png" ?>" type="image/x-icon">
        <link rel="shortcut icon" href="<?= site_settings("logomark") ? site_settings("logomark") : APPURL."/assets/img/favicon.png" ?>" type="image/x-icon">
        
        <link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/plugins.css" ?>">
       <link rel="stylesheet" href="<?= APPURL . '/assets/css/magnific-popup.css'?>">
        <link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/core.css" ?>">
        <link rel="stylesheet" href="<?= APPURL . "/assets/css/materialize.css"?>">

        <title><?= __("Comissionamento - ". site_settings("site_name")) ?></title>

    </head>
    <style>
     td {
        padding: 0px 0px 0px 0px !important;
      }
    </style>
    <body>
        <?php
            $Nav = new stdClass;
            $Nav->activeMenu = "comissionamento";
            require_once(APPPATH.'/views/fragments/navigation.fragment.php');
        ?>

        <?php
            $TopBar = new stdClass;
            $TopBar->title = __("Comissionamento");
           
            require_once(APPPATH.'/views/fragments/topbar.fragment.php');
        ?>
      
        <?php require_once(APPPATH.'/views/fragments/comissionamento.fragment.php'); ?>
    
        <?php require_once(APPPATH.'/views/fragments/footer-copyright.fragment.php'); ?>
       <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script type="text/javascript" src="<?= APPURL."/assets/js/plugins.js"?>"></script>     
        <?php require_once(APPPATH.'/inc/js-locale.inc.php'); ?>  
        <script src="<?= APPURL . "/assets/js/magnific-popup.js"?>"></script>
        <script type="text/javascript" src="<?= APPURL."/assets/js/core.js"?>"></script>      
        <script type="text/javascript" src="<?= APPURL."/assets/js/materialize.js"?>"></script> 
        <script type="text/javascript" charset="utf-8">
            $(function(){
                NextPost.Frete();
                $(document).ready(function() {
                  $('form#orderForm').bind("keypress", function(e) {
                      if ((e.keyCode == 10)||(e.keyCode == 13)) {
                          e.preventDefault();
                          }
                      });    
                  });
            })   
        </script>
        <?php require_once(APPPATH.'/views/fragments/google-analytics.fragment.php'); ?>
        <script src="//code-sa1.jivosite.com/widget/1W9Z4XvgpL" async></script>
       <script>
         $(document).ready(function() {
          $('.zoom-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            closeOnContentClick: false,
            closeBtnInside: false,
            mainClass: 'mfp-with-zoom mfp-img-mobile',
            image: {
              verticalFit: true,
              titleSrc: function(item) {
                return item.el.attr('title') + ' &middot; <a class="image-source-link" href="'+item.el.attr('data-source')+'" target="_blank">batcar</a>';
              }
            },
            gallery: {
              enabled: true
            },
            zoom: {
              enabled: true,
              duration: 300, // don't foget to change the duration also in CSS
              opener: function(element) {
                return element.find('img');
              }
            }

          });
           
         $('.iframe-popup').magnificPopup({
              type: 'iframe'
          });
       });
      </script>
    </body>
</html>

