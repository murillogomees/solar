<html>
  <head class="no-js" lang="<?= ACTIVE_LANG ?>">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta name="theme-color" content="#fff">
        <title>Definir Senha</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="<?= APPURL .  "/assets/css/materialize.css"?>">
 </head>
    <body><br><br>
         <div class="form-group d-flex justify-content-center">
                    <h4> Olá, <?= $AuthUser->get("firstname"); ?> </h4>
        </div>
         <div class="container d-flex justify-content-center ">
             <form class="formValidate" action="<?= APPURL . "/novasenha" ?>" method="POST">
					        <input name="action" value="novaSenha" type="hidden">
                  <input name="idUsuario" type="hidden" value="<?= $AuthUser->get("id"); ?>">
        <div class="form-group">
                   <label for="senha">Senha</label>
                   <input name="passwd" type="password" class="validate form-control" placeholder="" required >
        </div>
        <div class="form-group">
                    <label for="confirme-senha">Confirmar Senha</label>
                    <input name="confirm-passwd"  type="password" class="validate form-control" placeholder="" required >
       </div>
                  <p> &nbsp;&nbsp;&nbsp; Gentileza defina sua nova senha com no mínimo 6 caracteres! </p>
                        <button type="submit" class="btn btn-primary">Salvar</button>
             </form>
      </div>
            <!-- TOAST -->
      <script type="text/javascript" src="<?= APPURL. "/assets/js/materialize.js"?>"></script> 
      
  </body>
</html>