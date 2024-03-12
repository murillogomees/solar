<?php 
/**
 * Email class to send advanced HTML emails
 * 
 * @author Onelab <hello@onelab.co>
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
class Email extends PHPMailer{
    /**
     * Email template html
     * @var string
     */
    public static $template;


    /**
     * Email and notification settings from database
     * @var DataEntry
     */
    public static $emailSettings;


    /**
     * Site settings
     * @var DataEntry
     */
    public static $siteSettings;


    public function __construct(){  
      
    }

  
    /**
     * Send notifications
     * @param  string $type notification type
     * @return [type]       
     */
    public static function sendNotification($type = "nova-cotacao", $data = [])
    {
        switch ($type) { 
            case "nova-cotacao":
                return self::sendCheckout($data);
                break;   
            case "cotacao-atualizada-logistica":
                return self::sendAtualizacaoCotacao($data);
                break;     
             case "aprovacao-frete":
                return self::sendAprovacaoFrete($data);
                break; 
             case "password-recovery":
                return self::sendPasswordRecoveryEmail($data);
                break;
             case "sign-up":
                return self::sendSignUpEmail($data);
                break;
             case "cadastro-aprovado":
                return self::SendCadastroAprovado($data);
                break; 
            case "senha-alterada":
                return self::SendSenhaAlterada($data);
                break; 
            
            default:
                break;
        }
    }

    private static function configSmtp($mail)
    {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'tls';
      $mail->Username = 'no-reply@horus.com.br';
      $mail->Password = 'iistdflmlnnittjn';
      $mail->Port = 587;
      $mail->CharSet = "UTF-8";   
      $mail->setFrom('Painel Solar - Horus Distribuidora');
      $mail->FromName = "Painel Solar - Horus Distribuidora";
      return $mail;
    }
  
    private static function confirmEmail($mail)
    {
          if(!$mail->send()) {
            return 'Não foi possível enviar a mensagem.<br>';           
        } else {
            $mail->ClearAllRecipients();
            $mail->ClearAttachments();
            return 'Mensagem enviada.';            
        }
    }
  
  
   /**
     * Send notification email to admins about new payments
     * @return bool
     */
    private static function sendCheckout($data = [])
    {       
        $mail = new PHPMailer();
        $mail = self::configSmtp($mail);        
      
        $mail->Subject = "Nova Cotação Frete - Painel Horus Distribuidora";   
      
        //$mail->addAddress('almoxarifadodf@horus.com.br');   
        
        //$mail->addCC('alessandra@horus.com.br', 'Alessandra Horus');
        $mail->addCC('no-reply@horus.com.br', 'Conferência Storgetec');    
        $mail->isHTML(true);
        $emailbody = "<p>Caro(a) usuário(a), </p>"
                
                   . "<p>Foi realizado um novo pedido de cotação em nosso sistema e está destinado a você: </p>"
                   . "<p>Informações do Pedido: </p>"
                   . "<p><b>ID do Pedido: ". $data['id'] ."</b></p>"
                   . "<p><b>Nome Cliente: ". $data['nome'] ."</b></p>"
                   . "<p><b>CNPJ Cliente: ". $data['cnpj'] ."</b></p>"
                   . "<p>A cotação precisará de continuidade por sua parte, para conferir em detalhes <a href='https://logistica.horus.com.br' target='_blank'>acesse agora o site.</a></p>"
                    
                   . "<p>E-Mail enviado automaticamente devido cotação efetuada via Painel Horus Solar.</p>"
                   . "<p>Não utilizar a opção de 'Responder ao Remetente', pois sua mensagem não será lida.</p>"
                   . "<p>Painel Solar - Horus Distribuidora</p>";
      
        $mail->Body = $emailbody;   
      
        $mail = self::confirmEmail($mail);
      
        return $mail;
    } 
  
  
   /**
     * Send notification email to admins about new payments
     * @return bool
     */
    private static function sendAprovacaoFrete($data = [])
    {       
        $mail = new PHPMailer();
        $mail = self::configSmtp($mail);        
      
        $mail->Subject = "Aprovação Cotação de Frete Nº " . $data['id'] . " - Painel Horus Distribuidora";   
      
        //$mail->addAddress('almoxarifadodf@horus.com.br');   
        
        //$mail->addCC('alessandra@horus.com.br', 'Alessandra Horus');
        $mail->addCC('no-reply@horus.com.br', 'Conferência Storgetec');    
        $mail->isHTML(true);
        $emailbody = "<p>Caro(a) usuário(a), </p>"
                
                   . "<p>O pedido número: " . $data['id'] . " foi aprovado em nosso sistema! </p>"
                   . "<p>Agora basta informar as datas para acompanhamento da entrega. </p>"
                   . "<p>A cotação precisará de continuidade por sua parte, para conferir em detalhes <a href='https://logistica.horus.com.br' target='_blank'>acesse agora o site.</a></p>"
                    
                   . "<p>E-Mail enviado automaticamente devido cotação efetuada via Painel Horus Solar.</p>"
                   . "<p>Não utilizar a opção de 'Responder ao Remetente', pois sua mensagem não será lida.</p>"
                   . "<p>Painel Solar - Horus Distribuidora</p>";
      
        $mail->Body = $emailbody;   
      
        $mail = self::confirmEmail($mail);
      
        return $mail;
    } 
  
  /**
     * Send notification email to admins about new payments
     * @return bool
     */
    private static function sendAtualizacaoCotacao($data = [])
    {       
        $mail = new PHPMailer();
        $mail = self::configSmtp($mail);        
      
        $mail->Subject = "Atualização da Cotação de Frete Nº " + $data['id'] + " - Painel Horus Distribuidora";   
      
        foreach($data['supervisor'] as $d){
         //$mail->addAddress($d["email"]); 
        }
      
        $mail->addCC('no-reply@horus.com.br', 'Conferência Storgetec');    
        $mail->isHTML(true);
        $emailbody = "<p>Caro(a) usuário(a), </p>"
                
                   . "<p>Foi realizado um novo pedido de cotação em nosso sistema e está destinado a você: </p>"
                   . "<p>Informações do Pedido: </p>"
                   . "<p><b>ID do Pedido: ". $data['supervisor'] ."</b></p>"
                   . "<p><b>Nome do Cliente: ". $data['nome'] ."</b></p>"
                   . "<p><b>CNPJ Cliente: ". $data['cnpj'] ."</b></p>"
                   . "<p><b>Tipo de Transporte: ". $data['tipo_transporte'] ."</b></p>"
                   . "<p><b>Vendedor Responsável: ". $data['vendedor'] ."</b></p>"
                   . "<p>A cotação precisará de aprovação por sua parte, para conferir em detalhes <a href='https://solar.horus.com.br' target='_blank'>acesse agora o site.</a></p>"
                    
                   . "<p>E-Mail enviado automaticamente devido cotação efetuada via Painel Horus Solar.</p>"
                   . "<p>Não utilizar a opção de 'Responder ao Remetente', pois sua mensagem não será lida.</p>"
                   . "<p>Painel Solar - Horus Distribuidora</p>";
      
        $mail->Body = $emailbody;   
      
        $mail = self::confirmEmail($mail);
      
        return $mail;
    } 
  
    /**
     * Send recovery instructions to the user
     * @return bool
     */
    private static function sendPasswordRecoveryEmail($data = [])
    {
        $mail = new PHPMailer();
        $mail = self::configSmtp($mail);        
      
        $mail->Subject = "Recuperação de Senha"; 
        $user = $data["user"];       

        $hash = sha1(uniqid(readableRandomString(10), true));
        $user->set("data.recoveryhash", $hash)->save();
        $mail->isHTML(true);
        $mail->addAddress($user->get("email"));

        $emailbody = "<p>Caro(a) usuário(a), </p>"
                
                   . "<p>Foi realizado um pedido de mudança de senha vindo do portal Horus Solar, caso não tenha sido você <a href=".APPURL.">acesse agora o nosso sistema</a> e altere sua senha!</p>"                
                   . "<a style='display: inline-block; background-color: #3b7cff; color: #fff; font-size: 14px; line-height: 24px; text-decoration: none; padding: 6px 12px; border-radius: 4px;' href='".APPURL."/recovery/".$user->get("id").".".$hash."'>".__("Clique aqui para resetar")."</a>"
                    
                   . "<p>E-Mail enviado automaticamente devido cadastro efetuado via Painel Horus Solar.</p>"
                   . "<p>Não utilizar a opção de 'Responder ao Remetente', pois sua mensagem não será lida.</p>"
                   . "<p>Painel Solar - Horus Distribuidora</p>";


        $mail->Body = $emailbody;   
      
        $mail = self::confirmEmail($mail);
      
        return $mail;
    }
  
    /**
     * Send notification email to admins about new payments
     * @return bool
     */
    private static function sendSignUpEmail($data = [])
    {       
        $mail = new PHPMailer();
        $mail = self::configSmtp($mail);        
      
        $mail->Subject = "Novo Cadastro Horus Solar - AGUARDANDO APROVAÇÃO - Painel Horus Distribuidora";   
      
        //$mail->addAddress('rainey.soares@horus.com.br');  
      
        $mail->addAddress('no-reply@horus.com.br', 'Conferência Storgetec');    
        $mail->isHTML(true);
        $emailbody = "<p>Caro(a) usuário(a), </p>"
                
                   . "<p>Há um novo cadastro em nosso sitema esperando por sua aprovação: </p>"
                   . "<p>Informações do Cadastro: </p>"                 
                   . "<p><b>Nome do Cliente: ". $data['nome'] ."</b></p>"
                   . "<p><b>CNPJ Cliente: ". $data['cnpj'] ."</b></p>"
                  
                   . "<p>Para que o usuário consiga utilizar nosso sistema, é necessario que você aprove o seu cadastro.</p>"
                   . "<p>Para conferir em detalhes <a href='https://solar.horus.com.br' target='_blank'>acesse agora o site.</a></p>"
                    
                   . "<p>E-Mail enviado automaticamente devido cadastro efetuado via Painel Horus Solar.</p>"
                   . "<p>Não utilizar a opção de 'Responder ao Remetente', pois sua mensagem não será lida.</p>"
                   . "<p>Painel Solar - Horus Distribuidora</p>";
      
        $mail->Body = $emailbody;   
      
        $mail = self::confirmEmail($mail);
      
        return $mail;
    } 
  
  /**
     * Send notification email to admins about new payments
     * @return bool
     */
    private static function SendCadastroAprovado($data = [])
    {       
        $mail = new PHPMailer();
        $mail = self::configSmtp($mail);        
      
        $mail->Subject = "Parabéns. Seu cadastro foi aprovado em nosso Sistema!";
      
        //$mail->addAddress($data['email']);   
        //$mail->addCC($data['supervisor'], 'Supervisor de Filial');
        $mail->addAddress('no-reply@horus.com.br', 'Conferência Storgetec');
      
        $mail->isHTML(true);
        $emailbody = "<p>Caro(a) ". $data['nome'].", </p>"
                
                   . "<p>Seu cadastro foi aprovado com sucesso em nosso sistema!</p>"                  
                   
                   . "<p>Acesse agora o nosso site e confira as ofertas imperdíveis. " 
                   . "<a href='https://solar.horus.com.br' target='_blank'>Acesse agora o site.</a></p>"
                    
                   . "<p>E-Mail enviado automaticamente devido cadastro efetuado via Painel Horus Solar.</p>"
                   . "<p>Não utilizar a opção de 'Responder ao Remetente', pois sua mensagem não será lida.</p>"
                   . "<p>Painel Solar - Horus Telecom</p>";
      
        $mail->Body = $emailbody;   
      
        $mail = self::confirmEmail($mail);
      
        return $mail;
    }
  
      private static function SendSenhaAlterada($data = [])
    {       
        $mail = new PHPMailer();
        $mail = self::configSmtp($mail);        
      
        $mail->Subject = "Alteração de senha - Painel Horus Distribuidora";   
      
        $mail->addAddress($data['email']);
        
        $mail->addCC('no-reply@horus.com.br', 'Conferência Storgetec');    
        $mail->isHTML(true);
        $emailbody = "<p>Olá, " . $data['nome']." </p>"
                
                   . "<p>Foi realizado uma alteração de senha vindo do Portal Horus Solar  <a href='https://solar.horus.com.br' target='_blank'>acesse agora o site.</a> Caso não tenha sido você entre em contato com o suporte imediatamente! </p>"
                   . "<p> Sua senha foi alterada para: " . $data['pass']." </p>"
                  
                    
                   . "<p>E-Mail enviado automaticamente devido cotação efetuada via Painel Horus Solar.</p>"
                   . "<p>Não utilizar a opção de 'Responder ao Remetente', pois sua mensagem não será lida.</p>"
                   . "<p>Painel Solar - Horus Distribuidora</p>";
      
        $mail->Body = $emailbody;   
      
        $mail = self::confirmEmail($mail);
      
        return $mail;
    }
    
}