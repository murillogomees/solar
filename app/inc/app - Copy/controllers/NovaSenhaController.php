<?php
/**
 * Index Controller
 */
class NovaSenhaController extends Controller
{
   
  
   public function process()
    {
        // Pega informações do usuário logado
        $AuthUser = $this->getVariable("AuthUser");
        $Route = $this->getVariable("Route");
        //
        if (!$AuthUser){
            header("Location: ".APPURL."/login");
            exit;
        }else  if ($AuthUser->get("start_pw") == 0) {
            header("Location: ".APPURL."/");
            exit;
        } else  {
            
         
       if (Input::post("action") == "novaSenha") {
           $this->novaSenha();       
     }
        
       $this->view("novasenha" , "site");
          
      }
  
   }
       
  
      private function novaSenha()
    {        
      // Pega informações do usuário logado
      $AuthUser = $this->getVariable("AuthUser");      
      
      // Pegar Model da Equipe
      $Usuario = Controller::model("User", Input::post("idUsuario"));      
      
      // Pegar Model dos Logs
      $Log = Controller::model("Log");
       
        
       //Recebe senhas
      $SenhaNova = Input::post("passwd");      
      $SenhaHash = $Usuario->get("password");   
   
              // Check pass.
        if (mb_strlen(Input::post("passwd")) > 0) {
            if (mb_strlen(Input::post("passwd")) < 6) {
              echo $this->toast("Sua senha necessita possuir 6 caracteres");
              return false;                
            }
            if (Input::post("confirm-passwd") != Input::post("passwd")) {
              echo $this->toast("Senhas não coincidem");
              return false;
            }
            if(password_verify($SenhaNova, $SenhaHash)){
              echo $this->toast("Sua senha não pode ser igual a anterior!");
              return false;
          }
        }


      try { 
        $Usuario->set("start_pw", 0);
          //Insere senha no banco
                if (mb_strlen(Input::post("passwd")) > 0) {
            $passhash = password_hash(Input::post("passwd"), PASSWORD_DEFAULT);
            $Usuario->set("password", $passhash);
               //Envio de email com a senha 
             $nome = $Usuario->get("firstname");     
             $email = $Usuario->get("email");
             $passwd = Input::post("passwd");      
             $send = \Email::sendNotification("senha-alterada", ["email" => $email, "pass" => $passwd , "nome" => $nome]);
        }
        
      
      $LogMensagem = "Senha alterada com sucesso pelo usuário: " . $AuthUser->get("firstname");   
        
      $Log->set("id_user", $AuthUser->get("id"))
          ->set("situacao", "success")
          ->set("pagina", "Novasenha")
          ->set("detalhes", $LogMensagem);
        

      } catch (Exception $e){
      $LogMensagem = "Erro ao alterar senha pelo usuário: " . $AuthUser->get("firstname") . " " . $e->getMessage();   
        
      $Log->set("id_user", $AuthUser->get("id"))
          ->set("situacao", "erro")
          ->set("pagina", "Novasenha")
          ->set("detalhes", $LogMensagem);
      }
      
      $Usuario->save();
      $Log->save();
        
     setcookie("nplh", $Usuario->get("id").".".md5($Usuario->get("password")), 0, "/");
      
      echo "<meta http-equiv='refresh' content='0'>";
      
      return false;       
    }
  
 
}

?>