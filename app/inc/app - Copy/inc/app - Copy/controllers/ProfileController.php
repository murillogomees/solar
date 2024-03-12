<?php
/**
 * Profile Controller
 */
class ProfileController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
        $AuthUser = $this->getVariable("AuthUser");
        $Route = $this->getVariable("Route");

        if (!$AuthUser){
            // Auth
            header("Location: ".APPURL."/login");
            exit;
        } 
      
        // Get Package
        
        $EmailSettings = \Controller::model("GeneralData", "email-settings");

        $this->setVariable("TimeZones", getTimezones())            
             ->setVariable("EmailSettings", $EmailSettings);

        if (Input::post("action") == "save") {
            $this->save();
        } 
      
        $this->view("profile");
    }

    /**
     * Save changes
     * @return void
     */
    private function save()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
        $EmailSettings = $this->getVariable("EmailSettings");        

      
        if($AuthUser->get("account_type") == "integrador") {
          $required_fields = ["email" => "E-mail", "firstname" => "Nome/Razão Social", "address" => "Endereço", "nome_responsavel" => "Nome do Responsável", "cpf_responsavel" => "CPF do Responsável","cep" => "CEP",
                              "cpf" => "CPF/CNPJ", "phone" => "Telefone"];
        }
         else {
           $required_fields = ["email" => "e-mail","firstname" => "Nome","cpf" => "CPF/CNPJ", "phone" => "Telefone"];
         }
      
      foreach ($required_fields as $field => $f) {
					if (!Input::post($field)) {						
						echo $this->toast("Preenchimento de campo obrigatório: " . $f );
            return false;			
					}
        }	
      
      
//         foreach ($required_fields as $field) {
//             if (!Input::post($field)) {
//               echo "<script>";
//               echo "alert('Falta informações obrigatórias a serem preenchidas!')";
//               echo "</script>";
//               return false;
//             }
//         }

        $email = strtolower(Input::post("email"));

        // Check email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo $this->toast("E-mail inválido");
            return false;
        }

        $u = Controller::model("User", $email);
        if ($u->isAvailable() && $u->get("id") != $AuthUser->get("id")) {
            echo $this->toast("E-mail indisponível");
            return false;
        }

        // Check if email changed
        // Verification email must be send if email changed
        $email_changed = $email == $AuthUser->get("email") ? false : true;

        // Check pass.
        if (mb_strlen(Input::post("password")) > 0) {
            if (mb_strlen(Input::post("password")) < 6) {
           	 	echo $this->toast("A senha precisa mais de 6 dígitos");
            	return false;
            }

            if (Input::post("password-confirm") != Input::post("password")) {
              echo $this->toast("As senhas não coincidem");
              return false;
            }
        }
      
       $clearFormatTel = preg_replace("/[^0-9]/","", Input::post("phone")); 
       $clearFormatCnpj = preg_replace("/[^0-9]/","", Input::post("cpf")); 
      
      // Check CPF.
        if (mb_strlen(Input::post("cpf")) > 0) {
            if (mb_strlen(Input::post("cpf")) < 11) {
              echo $this->toast("CPF ou CNPJ inválido");
              return false;
            }
        }

        // Check Telefone.
        if (mb_strlen(Input::post("phone")) > 0) {
            if (mb_strlen(Input::post("phone")) < 10) {
              echo $this->toast("O telefone precisa ter no mínimo 10 dígitos");
            	return false;
            }
        }
      
       
        if (isset($_FILES['arquivoLogo'])){
        if($_FILES['arquivoLogo']['error'] == 0){                    
        $path_to_users = ROOTPATH."/assets/uploads/"
                               . $AuthUser->get("id")
                               . "/";
          
        $path_to_users_directory = ROOTPATH."/assets/uploads/"
                               . $AuthUser->get("id")
                               . "/logotipo/";
          
         if (!file_exists($path_to_users_directory)) {
            mkdir($path_to_users, 0777);
            mkdir($path_to_users_directory, 0777);
         }   
          
         $user_dir_url = APPURL."/assets/uploads/"
                    . $AuthUser->get("id")
                    . "/logotipo/";
          
          // Pega Nome Temporario do Arquivo
          $arquivo_tmp = $_FILES['arquivoLogo']['tmp_name']; 
          // Pega a extensão
          $extensao = pathinfo($_FILES['arquivoLogo']['name'], PATHINFO_EXTENSION);    
          // Converte a extensão para minúsculo
          $extensao = strtolower($extensao); 
          // Criando Nome arquivo      
          $nome = "logotipo_user" . $AuthUser->get("id") . "." . $extensao;  
          // Destino Final
          $destino = $path_to_users_directory . $nome;
          echo $destino;
          echo $extensao;
          echo $arquivo_tmp;
          // Checagem de Segurança
          if (strstr('jpg;jpeg;gif;png', $extensao) ) {
            
            // tenta mover o arquivo para o destino
            if(move_uploaded_file($arquivo_tmp,$destino)){              
              $AuthUser->set("logotipo", $user_dir_url.$nome);
            } else {
              echo 'Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.<br />';
            }
            
          } else {
            echo $arquivo_tmp . "  -  " . $nome . "  -  " . $extensao;
            echo 'Você poderá enviar apenas arquivos "*.jpg;*.jpeg;*.gif;*.png"<br />';
          }
          
        }
        }
      
        if (isset($_FILES['arquivoFoto'])){
        if($_FILES['arquivoFoto']['error'] == 0){       
          
        $path_to_users = ROOTPATH."/assets/uploads/"
                               . $AuthUser->get("id")
                               . "/";  
          
        $path_to_users_directory = ROOTPATH."/assets/uploads/"
                               . $AuthUser->get("id")
                               . "/imagem/";
          
         if (!file_exists($path_to_users_directory)) {
           mkdir($path_to_users, 0755);
            mkdir($path_to_users_directory, 0755);
         }   
          
         $user_dir_url = APPURL."/assets/uploads/"
                    . $AuthUser->get("id")
                    . "/imagem/";
          
          // Pega Nome Temporario do Arquivo
          $arquivo_tmp = $_FILES['arquivoFoto']['tmp_name']; 
          // Pega a extensão
          $extensao = pathinfo($_FILES['arquivoFoto']['name'], PATHINFO_EXTENSION);    
          // Converte a extensão para minúsculo
          $extensao = strtolower($extensao); 
          // Criando Nome arquivo      
          $nome = "imagem_user" . $AuthUser->get("id") . "." . $extensao;  
          // Destino Final
          $destino = $path_to_users_directory . $nome;
          
          // Checagem de Segurança
          if (strstr('jpg;jpeg;gif;png', $extensao) ) {
            
            // tenta mover o arquivo para o destino
            if(move_uploaded_file($arquivo_tmp,$destino)){              
              $AuthUser->set("imagem", $user_dir_url.$nome);
            } else {
              echo 'Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.<br />';
            }
            
          } else {
            echo $arquivo_tmp . "  -  " . $nome . "  -  " . $extensao;
            echo 'Você poderá enviar apenas arquivos "*.jpg;*.jpeg;*.gif;*.png"<br />';
          }
          
        }
        }
       
      
        // Start setting data
        $AuthUser->set("firstname", Input::post("firstname"))
                 ->set("lastname", Input::post("lastname"))
                 ->set("email", Input::post("email"))
                 ->set("status", Input::post("status"))
                 ->set("address", Input::post("address"))
                 ->set("cep", Input::post("cep"))
                 ->set("cpf/cnpj", $clearFormatCnpj)
                 ->set("phone", $clearFormatTel)                  
                 ->set("nome_responsavel", Input::post("nome_responsavel"))
                 ->set("cpf_responsavel", Input::post("cpf_responsavel"))
                 ->set("rg_responsavel", Input::post("rg_responsavel"));


        if (mb_strlen(Input::post("password")) > 0) {
            $passhash = password_hash(Input::post("password"), PASSWORD_DEFAULT);
            $AuthUser->set("password", $passhash);
        }
      
      
           try {
        $AuthUser->save();
          
        $this->logs($AuthUser->get("id"), "success","Perfil","Alteração no Perfil" . " salvo com sucesso");  
        } catch (Exception $e){
        $this->logs($AuthUser->get("id"), "error","Perfil","Erro ao modificar o Perfil. " . $e);
        }  

        // update cookies
        setcookie("nplh", $AuthUser->get("id").".".md5($AuthUser->get("password")), 0, "/");        
      
        echo "<meta http-equiv='refresh' content='0'>";
      
        //return false; 
    }


   
}
