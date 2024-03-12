<?php if (!defined('APP_VERSION')) die("Yo, what's up?"); ?>
<!DOCTYPE html>
<html class="no-js" lang="<?= ACTIVE_LANG ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta name="theme-color" content="#fff">

        <meta name="description" content="<?= site_settings("site_description") ?>">
        <meta name="keywords" content="<?= site_settings("site_keywords") ?>">

       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="icon" href="<?= site_settings("logomark") ? site_settings("logomark") : active_theme_url() . "/assets/images/favicon.png"?>" type="image/x-icon">
        <link rel="shortcut icon" href="<?= site_settings("logomark") ? site_settings("logomark") : active_theme_url() . "/assets/images/favicon.png"?>" type="image/x-icon">
        
        <link rel="stylesheet" type="text/css" href="<?= active_theme_url() . "/assets/styles/vendor.css?v=neptun010002" . VERSION ?>">
        <link rel="stylesheet" type="text/css" href="<?= active_theme_url() . "/assets/styles/main.css?v=neptun010002" . VERSION ?>">


        <title><?= __("Cadastro de Usuário") ?></title>
    </head>

    <body>
        <section id="signin">
            <div class="page-holder clearfix">              
               <div class="signup side flex flex-center flex-middle" style="left:0px !important">
               </div>             
            </div>
                
            
            <div class="signup-form pos-signup">
               <div class="form-holder">
                 <div class="form">
                   <h2 style="color:#5a5a5a; text-align:center;">
                     CADASTRO
                   </h2>
                    <form action="<?= APPURL."/signup" ?>" method="POST" autocomplete="off">
                       <input type="hidden" name="action" value="signup">
           
                                <div class="form-element">
                                    <div class="input-wrapper material-style">
                                        <input type="text" class="input-style <?= Input::Post("firstname") ? "has-value" : "" ?>" name="firstname" placeholder="Razão Social" value="<?= htmlchars(Input::Post("firstname")) ?>">
                                       
                                    </div>
                                </div>                                
                                  
                                  <div class="form-element">
                                    <div class="input-wrapper  material-style">
                                        <input type="text" name="cpf/cnpj" class="input-style <?= Input::Post("cpf") ? "has-value" : "" ?>" placeholder="CNPJ" value="<?= htmlchars(Input::Post("cpf/cnpj")) ?>">
                                    </div>
                                </div>

                                <div class="form-element">
                                    <div class="input-wrapper  material-style">
                                        <input type="email" name="email" class="input-style <?= Input::Post("email") ? "has-value" : ""  ?>" placeholder=" E-mail" value="<?= htmlchars(Input::Post("email")) ?>">
                                    </div>
                                </div>
                                
                                <div class="form-element">
                                    <div class="input-wrapper material-style">
                                        <input type="tel" class="input-style <?= Input::Post("phone") ? "has-value" : "" ?>" name="phone" placeholder="Celular com DDD" value="<?= htmlchars(Input::Post("phone")) ?>">
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

                      <small style="font-style:italic; color:#f33c6c; margin-bottom: 20px;">*Ao entrar ou criar uma conta, você concorda com  <a style="color:black;"  data-toggle="modal" data-target="#exampleModal"><u>Termos e Condições</u> </a>  e <a style="color:black;" href="<?= APPURL. "/politica-privacidade" ?>" ><u>Política de Privacidade.</u></a></small>
                                

                                <div class="form-element submit" style="margin-top: 30px; text-align: center;">
                                    <button class="button-style" type="submit">
                                        <?= __("Cadastrar") ?>
                                    </button>                                   
                                </div>
                                 <center>
                                   <a href="<?= APPURL . "/login"?>"><small style="font-style:italic; margin-bottom: 20px;top: -10px">Já tem um usuário? Acesse agora.</small></a>
                                 </center>
                            </form>

                      <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">TERMO DE ACEITE PARA TRATAMENTO DE DADOS PESSOAIS </h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                             <p>Este documento visa registrar a manifestação livre, informada e inequívoca pela qual o usuário concorda com o tratamento de seus dados pessoais para finalidade específica, em conformidade com a Lei nº 13.709 – Lei Geral de Proteção de Dados Pessoais (LGPD).</p>
                            <p>
                             Ao aceitar o presente termo, o usuário consente e concorda que a empresa  Horus S/A Distribuidora de Solucoes Tecnologicas, CNPJ nº 02.677.045/0001-20, com sede no Setor De Indust Bern Sayao Qd 01 Conj B, 15 – Bairro N Bandeirante – Brasília/DF, telefone (61) 3486.8000, e-mail  <b>suporte@horus.com.br</b>,
                             doravante denominada Controlador, tome decisões referentes ao tratamento de seus dados pessoais, bem como realize o tratamento de seus dados pessoais, envolvendo operações como as que se referem a coleta, produção, recepção, classificação, utilização, acesso, reprodução, transmissão, distribuição, processamento, 
                             arquivamento, armazenamento, eliminação, avaliação ou controle da informação, modificação, comunicação, transferência, difusão ou extração.
                              </p>  
                             Dados Pessoais O Controlador fica autorizado a tomar decisões referentes ao tratamento e a realizar o tratamento dos seguintes dados pessoais do Titular:</br>
                                                                  • Nome completo / Razão Social. </br>
                                                                  • Número do Cadastro de Pessoas Físicas (CPF) / Número do Cadastro de Pessoas Juridica (CNPJ). </br>
                                                                  • Endereço de e-mail pessoal </br>
                                                                  • Telefone / Celular.</br>
                                    <p>Finalidades do Tratamento dos Dados O tratamento dos dados pessoais listados neste termo tem as seguintes finalidades:</p>   
                                                    • Possibilitar que o Controlador identifique e entre em contato com o Titular para fins de relacionamento.</br>
                                                    • Possibilitar que o Controlador possa dar acesso ao sistema de cotação da Horus S/A.</br>
                               <h6> Compartilhamento de Dados </h6>
                                O Controlador fica autorizado a compartilhar os dados pessoais do Titular com outros agentes de tratamento de dados, caso seja necessário para as finalidades listadas neste termo, observados os princípios e as garantias estabelecidas pela Lei nº 13.709.
                                 <h6>  Segurança dos Dados </h6>
                               <p>
                                O Controlador responsabiliza-se pela manutenção de medidas de segurança, técnicas e administrativas aptas a proteger os dados pessoais de acessos não autorizados e de situações acidentais ou ilícitas de destruição, perda, alteração, comunicação ou qualquer forma de tratamento inadequado ou ilícito. 
                                Em conformidade ao art. 48 da Lei nº 13.709, o Controlador comunicará ao Titular e à Autoridade Nacional de Proteção de Dados (ANPD) a ocorrência de incidente de segurança que possa acarretar risco ou dano relevante ao Titular. 
                                Término do Tratamento dos Dados O Controlador poderá manter e tratar os dados pessoais do Titular durante todo o período em que os mesmos forem pertinentes ao alcance das finalidades listadas neste termo.
                                Dados pessoais anonimizados, sem possibilidade de associação ao indivíduo, poderão ser mantidos por período indefinido.
                                </p>
                               <h6>   O Titular poderá solicitar via e-mail ou correspondência ao Controlador, a qualquer momento, que sejam eliminados os dados pessoais não anonimizados do Titular Direitos do Titular O Titular tem direito a obter do Controlador, em relação aos dados por ele tratados, a qualquer momento e mediante requisição: </h6>
                                I - confirmação da existência de tratamento;</br>
                                II - acesso aos dados;</br>
                                III - correção de dados incompletos, inexatos ou desatualizados; </br>
                                IV - anonimização, bloqueio ou eliminação de dados desnecessários, excessivos ou tratados em desconformidade com o disposto na Lei nº 13.709;</br>
                                V - portabilidade dos dados a outro fornecedor de serviço ou produto, mediante requisição expressa, de acordo com a regulamentação da autoridade nacional, observados os segredos comercial e industrial; </br>
                                VI - eliminação dos dados pessoais tratados com o consentimento do titular, exceto nas hipóteses previstas no art. 16 da Lei nº 13.709;</br>
                                VII - informação das entidades públicas e privadas com as quais o controlador realizou uso compartilhado de dados; </br>
                                VIII - informação sobre a possibilidade de não fornecer consentimento e sobre as consequências da negativa; </br>
                                IX - revogação do consentimento, nos termos do § 5º do art. 8º da Lei nº 13.709. </br>
                              <strong> Direito de Revogação do Consentimento.</strong></br>
                                 Este consentimento poderá ser revogado pelo usuário, a qualquer momento, mediante solicitação via e-mail ou correspondência ao Controlador.
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            </div>
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
        <script type="text/javascript" src="<?= active_theme_url() . "/assets/scripts/vendor.js?v=neptun010002" . VERSION?>"></script>
        <script type="text/javascript" src="<?= active_theme_url() . "/assets/scripts/main.js?v=neptun010002" . VERSION?>"></script>
        <script type="text/javascript" charset="utf-8">
        </script>
        <?php require_once APPPATH . '/views/fragments/google-analytics.fragment.php';?>
    </body>
</html>