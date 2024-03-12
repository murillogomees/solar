<!DOCTYPE html>
<html class="no-js" lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta name="theme-color" content="#fff">

        <meta name="description" content="<?= site_settings("site_description") ?>">
        <meta name="keywords" content="<?= site_settings("site_keywords") ?>">        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="<?= active_theme_url() . "/assets/styles/main.css?v=".VERSION ?>">
        <link rel="icon" href=" <?= site_settings("logomark") ? site_settings("logomark") : APPURL."/assets/img/logomark.png" ?>" type="image/x-icon">
			  <link rel="shortcut icon" href=" <?= site_settings("logomark") ? site_settings("logomark") : APPURL."/assets/img/favicon.png" ?>" type="image/x-icon">
        <title><?= site_settings("site_name") ?></title>
    </head>

    <body>
       
        <?php $action = \Input::post("action"); ?>
        <section id="signin">        
          
            <div class="page-holder clearfix">            
             
                <div class="signin side float-left flex flex-center flex-middle" data-active="<?= $action == "login" ? "true" : ($action=="signup" || $Route->target == "Signup" ? "false" : "") ?>">    
                    
                    <div class="signin-form">
                      <div style="width:100%">
                            <div class="image-horus mb-20">                              
                        </div>
                        </div>
                        <form action="<?= APPURL."/login" ?>" method="POST" autocomplete="off">
                            <input type="hidden" name="action" value="login">
                            <?php if (Input::post("action") == "login"): ?>
                                <div class="form-result">
                                    <div class="color-danger">
                                        <span class="mdi mdi-close"></span>
                                        </br>
                                        <?= "Usuário e/ou senha incorretos!" ?>
                                    </div>
                                </div>
                            <?php endif; ?> 
                            <div class="form">                             
                                <div class="form-element">                                  
                                    <div class="input-wrapper material-style">
                                        <input type="text" 
                                               class="input-style" 
                                               id="username" 
                                               name="username"
                                               placeholder="E-mail"
                                               value="<?= Input::Post("username") ?>">                                      
                                    </div>
                                </div>
                                <div class="form-element">
                                    <div class="input-wrapper material-style">
                                        <input 
                                        type="password"
                                        class="input-style"
                                        id="password"
                                        placeholder="Senha"
                                        name="password"
                                        > 
                                      <a href="javascript:void(0)">                                   
                                       <svg style="bottom: 8px;right: 5px;padding:3px;width:20px;height:20px;color:#fff;border-radius:50px;cursor:pointer;position:absolute;filter: opacity(0.5);display:none" data-value="text" class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv hidePass textPass" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="EyeOutlineIcon"><path d="M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9M12,4.5C17,4.5 21.27,7.61 23,12C21.27,16.39 17,19.5 12,19.5C7,19.5 2.73,16.39 1,12C2.73,7.61 7,4.5 12,4.5M3.18,12C4.83,15.36 8.24,17.5 12,17.5C15.76,17.5 19.17,15.36 20.82,12C19.17,8.64 15.76,6.5 12,6.5C8.24,6.5 4.83,8.64 3.18,12Z"></path></svg> 
                                        <svg style="bottom: 8px;right: 5px;padding:3px;width:20px;height:20px;color:#fff;border-radius:50px;cursor:pointer;position:absolute;filter: opacity(0.5);" data-value="pass" class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv hidePass codePass" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="EyeOffOutlineIcon"><path d="M2,5.27L3.28,4L20,20.72L18.73,22L15.65,18.92C14.5,19.3 13.28,19.5 12,19.5C7,19.5 2.73,16.39 1,12C1.69,10.24 2.79,8.69 4.19,7.46L2,5.27M12,9A3,3 0 0,1 15,12C15,12.35 14.94,12.69 14.83,13L11,9.17C11.31,9.06 11.65,9 12,9M12,4.5C17,4.5 21.27,7.61 23,12C22.18,14.08 20.79,15.88 19,17.19L17.58,15.76C18.94,14.82 20.06,13.54 20.82,12C19.17,8.64 15.76,6.5 12,6.5C10.91,6.5 9.84,6.68 8.84,7L7.3,5.47C8.74,4.85 10.33,4.5 12,4.5M3.18,12C4.83,15.36 8.24,17.5 12,17.5C12.69,17.5 13.37,17.43 14,17.29L11.72,15C10.29,14.85 9.15,13.71 9,12.28L5.6,8.87C4.61,9.72 3.78,10.78 3.18,12Z"></path></svg>
                                      </a> 
                                    </div>
                                  
                                  
                                </div>
                                <div class="form-element submit">
                                    <button class="button-style purple" type="submit">
                                        <?= __("Acessar!") ?>
                                    </button>                
                          
                              <small style="font-style:italic; color:#f33c6c; margin-bottom: 20px;">*Ao entrar ou criar uma conta, você concorda com  <a style="color:black;" href="<?= APPURL. "/termo" ?>" target="_blank"><u>Termos e Condições</u> </a>  e <a style="color:black;" target="_blank" href="<?= APPURL. "/politica-privacidade" ?>" ><u>Política de Privacidade.</u></a></small>
                               
                                </div>
                               <div class="form-element submit">
                                    
                                  <input class="form-control" type="checkbox" id="remember-me" name="remember">
                                        <label for="remember-me">Lembrar Login</label>
                                </div>
                                <div class="reset-pass">
                                    <a href="<?= APPURL."/recovery" ?>"><?= "Esqueci minha senha" ?></a>
                                </div>
                              <div class="cadastre">
                                    <a href="#cadastro"><?= "Cadastre-se agora!" ?></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="signup side float-left flex flex-start flex-middle" data-active="<?= $action == "signup" || $Route->target == "signup" ? "true" : ($action=="login" ? "false" : "") ?>">
                    <div class="details">
                        <div class="heading-title">
                            <h6> <?= __("Cadastre-se") ?></h6>
                        </div>
                        <div class='extra'>
                            <div class="desc-text">
                                <p><?= __("Rapido e simples!<br> Não dura nem 30 segundos.") ?></p>
                            </div>                        
                            <a href="<?= APPURL."/signup" ?>" class="sign-up button-style"><?= "Comece Agora" ?></a>
                        </div>
                    </div>

                    <div id="cadastro" class="signup-form">
                        <div class="form-holder">                            
                            <div class="form">
                                <form action="<?= APPURL."/signup" ?>" method="POST" autocomplete="off">
                                <input type="hidden" name="action" value="signup">
                                <?php if (!empty($FormErrors)): ?>
                                    <div class="form-result">
                                        <?php foreach ($FormErrors as $error): ?>
                                            <div class="color-danger">
                                                <span class="mdi mdi-close"></span>
                                                <?= $error ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="form-element">
                                    <div class="input-wrapper material-style">
                                        <input type="text" class="input-style <?= Input::Post("firstname") ? "has-value" : "" ?>" name="firstname" placeholder="Razão Social" value="<?= Input::Post("firstname") ?>">
                                    </div>
                                </div>                                
                                  <div class="form-element">
                                    <div class="input-wrapper  material-style">
                                        <input type="text" name="cpf/cnpj" class="input-style <?= Input::Post("cpf/cnpj") ? "has-value" : "" ?>" placeholder="CNPJ" value="<?= Input::Post("cpf/cnpj") ?>" value="<?= Input::Post("cpf/cnpj") ?>">
                                    </div>
                                </div>
                                <div class="form-element">
                                    <div class="input-wrapper  material-style">
                                        <input type="email" name="email" class="input-style <?= Input::Post("email") ? "has-value" : ""  ?>" placeholder=" E-mail" value="<?= Input::Post("email") ?>" value="<?= Input::Post("email") ?>">
                                    </div>
                                </div>
                                <div class="form-element">
                                    <div class="input-wrapper material-style">
                                        <input type="tel" class="input-style <?= Input::Post("phone") ? "has-value" : "" ?>" name="phone" placeholder="Celular com DDD" value="<?= Input::Post("phone") ?>">
                                    </div>
                                </div>
                                <div class="form-element">
                                    <div class="input-wrapper  material-style">
                                        <input type="password" class="input-style" name="password" placeholder="Senha">
                                    </div>
                                </div>
                                <div class="form-element">
                                    <div class="input-wrapper  material-style">
                                        <input type="password" class="input-style" placeholder ="Confirme a senha" name="password-confirm">
                                    </div>
                                </div>
                                <div class="form-element submit">
                                    <button class="button-style purple" type="submit">
                                        <?= __("Conecte-se agora") ?>
                                    </button>
                                  
                              <small style="font-style:italic; color:#f33c6c; margin-bottom: 20px;">*Ao entrar ou criar uma conta, você concorda com  <a style="color:black;" href="<?= APPURL. "/termo" ?>"target="_blank"><u>Termos e Condições</u> </a>  e <a style="color:black;" target="_blank" href="<?= APPURL. "/politica-privacidade" ?>" ><u>Política de Privacidade.</u></a></small>
                                </div>
                            </form>
                            </div>
                            <div class="agreement">                               
                               <div style="color:#fff">                                     
                                 <a style="font-weight:700;" href="<?= APPURL."/login" ?>"><?= "Já possui uma conta? Acesse aqui!" ?></a>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
         <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="<?= active_theme_url() . "/assets/styles/vendor.css?v=".VERSION ?>">
        <script type="text/javascript" src="<?= active_theme_url() . "/assets/scripts/vendor.js?v=".VERSION?>"></script>
        <script type="text/javascript" src="<?= active_theme_url() . "/assets/scripts/main.js?v=".VERSION?>"></script>
  
        <script>
            $(document).on("click", ".hidePass", function(){
              var data = $(this).data("value");             
         
              if (data == "pass"){
                $(".codePass").hide();
                $(".textPass").show();
                $("#password").attr("type", "text");           
              } else if (data == "text"){
                $(".textPass").hide();
                $(".codePass").show();
                $("#password").attr("type", "password");
              } 

            });
        </script>
    </body>
</html>