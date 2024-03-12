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
        <link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/core.css" ?>">
        <link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/toastr/toastr.min.css" ?>">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

        <title><?= __("Orçamentos - ". site_settings("site_name")) ?></title>

    </head>
    <style>
     td {
        padding: 0px 0px 0px 0px !important;
      }
.lineTitle {
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
      
      /*desabilita a seleção no body*/
body {
    -webkit-touch-callout: none; /* iOS Safari */
      -webkit-user-select: none; /* Chrome/Safari/Opera */
       -khtml-user-select: none; /* Konqueror */
         -moz-user-select: none; /* Firefox */
          -ms-user-select: none; /* Internet Explorer/Edge */
              user-select: none;
}

/*habilita a seleção nos campos editaveis*/
input, textarea {
    -webkit-touch-callout: initial; /* iOS Safari */
      -webkit-user-select: text; /* Chrome/Safari/Opera */
       -khtml-user-select: text; /* Konqueror */
         -moz-user-select: text; /* Firefox */
          -ms-user-select: text; /* Internet Explorer/Edge */
              user-select: text;
}

/*habilita a seleção nos campos com o atributo contenteditable*/
[contenteditable=true] {
    -webkit-touch-callout: initial; /* iOS Safari */
      -webkit-user-select: all; /* Chrome/Safari/Opera */
       -khtml-user-select: all; /* Konqueror */
         -moz-user-select: all; /* Firefox */
          -ms-user-select: all; /* Internet Explorer/Edge */
              user-select: all;
}

      {
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
  }
      
    </style>
    <body >
        <?php
            $Nav = new stdClass;
            $Nav->activeMenu = "order";
            require_once(APPPATH.'/views/fragments/navigation.fragment.php');
        ?>

        <?php
            $TopBar = new stdClass;
            $TopBar->title = __("Orçamento");
           
            require_once(APPPATH.'/views/fragments/topbar.fragment.php');
        ?>
        <?php require_once(APPPATH.'/views/fragments/order.fragment.php'); ?>
        <?php require_once(APPPATH.'/views/fragments/footer-copyright.fragment.php'); ?>
        <script type="text/javascript" src="<?= APPURL."/assets/js/plugins.js"?>"></script>   
        <?php require_once(APPPATH.'/inc/js-locale.inc.php'); ?>
        <script type="text/javascript" src="<?= APPURL."/assets/js/toastr/toastr.min.js"?>"></script>
        <script type="text/javascript" src="<?= APPURL."/assets/js/core.js?" . VERSION ?>"></script>      
        <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>	
      <script src="https://cdn.jsdelivr.net/gh/brunoalbim/devtools-detect/index.js"></script>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      
      <script>
        
// function mensagem(text) {
//       alert('Conteúdo protegido pela nossa politica de privacidade.');
//       return false;
//     }

//     function bloquearCopia(Event) {
//       var Event = Event ? Event : window.event;
      
//       var tecla = (Event.keyCode) ? Event.keyCode : Event.which;
//       console.log(tecla);
//       if (sessionStorage.getItem("ultimaTecla") === "17" && tecla === 85 || tecla == 123) {
//         Event.preventDefault();
//         window.location = "https://suporte.horus.com.br";
//       }
//       sessionStorage.setItem("ultimaTecla", tecla);
//     }

// $(document).keypress(bloquearCopia);
// $(document).keydown(bloquearCopia);
// $(document).contextmenu(mensagem); 
        
        
//         if (window.devtools.isOpen === true) {
//             window.location = "https://suporte.horus.com.br";
//     }
//   	window.addEventListener('devtoolschange', event => {
//       if (event.detail.isOpen === true) {
//               window.location = "https://suporte.horus.com.br";
//       }
//   	});
        
</script>
      
        <script type="text/javascript" charset="utf-8">
					

					
            $(function(){
                NextPost.Order();
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
    </body>
</html>

