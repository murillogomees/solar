<?php
/**
 * User Controller
 */
class ComissionamentoController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
   
      
				header("Content-type: text/html; charset=utf-8");
        $Route = $this->getVariable("Route");
        $AuthUser = $this->getVariable("AuthUser");

        // Auth
        if (!$AuthUser){
            header("Location: ".APPURL."/login");
            exit;
        } else if ($AuthUser->get("is_active") == 0) {
            header("Location: ".APPURL."/aguarde");
            exit;
        } 
      
        $comissionamento = Controller::model("Comissionamento");
        $Order = Controller::model("Order");
				$Frete = Controller::model("Frete");
      
         if (isset($Route->params->id)) {
					$permisaoUsuario = json_decode($AuthUser->get("permissoes_usuarios"), true);
					$permissaoFilial = json_decode($AuthUser->get("permissoes_filiais"), true);
					$Order->select($Route->params->id);
					
					$idResponsavel = $Order->get("responsavel");
					$LojaResponsavel = $Order->get("loja_responsavel");
					if (!$Order->isAvailable()) {
							header("Location: ".APPURL."/comissionamentos");
							exit;
					}
					 if ($AuthUser->get("account_type") == "vendedor"){
						
						if ($AuthUser->get("id") == $idResponsavel || in_array($idResponsavel, $permisaoUsuario) ){
						
						}else{
						header("Location: ".APPURL."/comissionamentos");
							exit;
						}
					 } else if ($AuthUser->get("account_type") == "supervisor"){		
						if ($Order->get("loja_responsavel") != $AuthUser->get("office")){
			      if ($AuthUser->get("id") == $idResponsavel || in_array($idResponsavel, $permisaoUsuario) || $permissaoFilial != null ){
							
						}else{
							header("Location: ".APPURL."/comissionamentos");
						}
						}
					}
           
					$comissionamento->select($Route->params->id,"id_orcamento");
					$Order->select($Route->params->id);
					$Frete->select($Order->get("order_id"));
           
        }
      
      
      
      
				
					
							
			if(Input::post("action") == "save"){
				$this->save();
			} 
			
			$this->setVariable("comissionamento", $comissionamento);	
			$this->setVariable("Order", $Order);	
			$this->setVariable("Frete", $Frete);	
			$this->view("comissionamento");
  
    }
    

    private function save()
    {
        
        $AuthUser = $this->getVariable("AuthUser");
        $id = Input::post("id_original");
        $status = Input::post("status_comissionamento");
        $pedido_santri = Input::post("numero_santri");
        $nf = Input::post("numero_nf");
        $id_cliente = Input::post("id_cliente_santri");
        $razao_social = Input::post("nome_cliente");
        $cnpj = preg_replace("/[^0-9]/","", Input::post("cnpj_cliente"));
        $telefone = preg_replace("/[^0-9]/","", Input::post("telefone_cliente"));
        $dados_pagamento = Input::post("dados_pagamento");
        $id_descriptografado = decrypt($id);
        $Order = Controller::model("Order");
        $Order->select($id_descriptografado);
        $vendedor = json_decode($Order->get("seller"));
        $email =  $vendedor[0]->email;
        $Comissionamento = Controller::model("Comissionamento");
        $Comissionamento->select($id_descriptografado,"id_orcamento");
        $statusAnterior = $Comissionamento->get("status");
        $new = 0;
        if(!$Comissionamento->isAvailable()){
          $status = 3;
          $new = 1;
          $Comissionamento->set("status",$status);
        }
        if($AuthUser->isAdmin() && $status != 2){
          $Comissionamento->set("status",$status);
        } else if($AuthUser->isSetorFinanceiro()){
          $Comissionamento->set("status",$status);
        }
      
        $Comissionamento->set("id_orcamento",$id_descriptografado)
                        ->set("pedido_santri",$pedido_santri)
                        ->set("nota_fiscal",$nf)
                        ->set("id_cliente_santri",$id_cliente)
                        ->set("razao_social",$razao_social)
                        ->set("cnpj",$cnpj)
                        ->set("telefone",$telefone)
                        ->set("dados_pagamento",$dados_pagamento); 
           
      
        if(!file_exists($_SERVER['DOCUMENT_ROOT']."/assets/uploads/".$Order->get("id")."/comissionamento/nf_comissao.pdf") && $_FILES['arquivoNF']['size'] == 0){
          echo  $this->sweet("error","Só é possivel salvar com o envio do arquivo!");
          return false;
        } else  {
           if (isset($_FILES['arquivoNF'])){
            if($_FILES['arquivoNF']['error'] == 0){                    
            $path_to_users = ROOTPATH."/assets/uploads/"
                                   . $id_descriptografado
                                   . "/";

            $path_to_users_directory = ROOTPATH."/assets/uploads/"
                                   . $id_descriptografado
                                   . "/comissionamento/";

             if (!file_exists($path_to_users_directory)) {
                mkdir($path_to_users, 0777);
                mkdir($path_to_users_directory, 0777);
             }   

             $user_dir_url = APPURL."/assets/uploads/"
                        . $id_descriptografado
                        . "/comissionamento/";

              // Pega Nome Temporario do Arquivo
              $arquivo_tmp = $_FILES['arquivoNF']['tmp_name']; 
              // Pega a extensão
              $extensao = pathinfo($_FILES['arquivoNF']['name'], PATHINFO_EXTENSION);    
              // Converte a extensão para minúsculo
              $extensao = strtolower($extensao); 
              // Criando Nome arquivo      
              $nome = "nf_comissao" . $idOrder . "." . $extensao;  
              // Destino Final
              $destino = $path_to_users_directory . $nome;

              // Checagem de Segurança
              if (strstr('pdf', $extensao) ) {
                $arquivoNF = $user_dir_url.$nome;
                // tenta mover o arquivo para o destino
                if(move_uploaded_file($arquivo_tmp,$destino)){              
                  try {
                    $Comissionamento->save();
                    $this->logs($AuthUser->get("id"), "success","Comissionamento","Comissionamento <b>ID[" . $id_descriptografado . "]</b> Status " . $status . " salvo com sucesso");  
                    } catch (Exception $e){
                    $this->logs($AuthUser->get("id"), "error","Comissionamento","Erro ao modificar o comissionamento: ". $id_descriptografado. "<br/>" .$e);
                    }  
                } else {
                  echo  $this->sweet("error","Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.");
                  return false;
                }

              } else {
                echo $arquivo_tmp . "  -  " . $nome . "  -  " . $extensao;

                echo  $this->sweet("error","Você poderá enviar apenas arquivos *.pdf;");
                  return false;
              }

            }
            }	
          
       if (isset($_FILES['comprovante'])){
        if($_FILES['comprovante']['error'] == 0){                    
        $path_to_users = ROOTPATH."/assets/uploads/"
                               . $id_descriptografado
                               . "/";
          
        $path_to_users_directory = ROOTPATH."/assets/uploads/"
                               . $id_descriptografado
                               . "/comissionamento/";
          
         if (!file_exists($path_to_users_directory)) {
            mkdir($path_to_users, 0777);
            mkdir($path_to_users_directory, 0777);
         }   
          
         $user_dir_url = APPURL."/assets/uploads/"
                    . $id_descriptografado
                    . "/comissionamento/";
          
          // Pega Nome Temporario do Arquivo
          $arquivo_tmp = $_FILES['comprovante']['tmp_name']; 
          // Pega a extensão
          $extensao = pathinfo($_FILES['comprovante']['name'], PATHINFO_EXTENSION);    
          // Converte a extensão para minúsculo
          $extensao = strtolower($extensao); 
          // Criando Nome arquivo      
          $nome = "comprovante" . $idOrder . "." . $extensao;  
          // Destino Final
          $destino = $path_to_users_directory . $nome;
         
          // Checagem de Segurança
          if (strstr('jpg;jpeg;gif;png;pdf', $extensao) ) {
            $arquivoComprovante = $user_dir_url.$nome;
            // tenta mover o arquivo para o destino
            if(move_uploaded_file($arquivo_tmp,$destino)){ 
              $Comissionamento->set("link_comprovante", $arquivoComprovante);
              try {
                $Comissionamento->save();
                $this->logs($AuthUser->get("id"), "success","Comissionamento","Comissionamento <b>ID[" . $id_descriptografado . "]</b> Status " . $status . " salvo com sucesso");  
                } catch (Exception $e){
                $this->logs($AuthUser->get("id"), "error","Comissionamento","Erro ao modificar o comissionamento: ". $id_descriptografado. "<br/>" .$e);
                }  
            } else {
              echo  $this->sweet("error","Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.");
              return false;
            }
            
          } else {
            echo $arquivo_tmp . "  -  " . $nome . "  -  " . $extensao;
            
            echo  $this->sweet("error","Você poderá enviar apenas arquivos *.jpg;*.jpeg;*.png;*.pdf");
              return false;
          }
          
        }
        }	
          
          
          
          
          
          
          $Comissionamento->save();    
       if($new == 1 && $status == 3){
           $send = \Email::sendNotification("solicitacao-comissao", ["id" => $id_descriptografado, "id_santri" => $id_cliente , "cnpj" => $cnpj, "razao" => $razao_social ]);
       } else if($statusAnterior != $status && $status == 1){
           $send = \Email::sendNotification("liberado-comissao", ["id" => $id_descriptografado, "id_santri" => $id_cliente , "cnpj" => $cnpj, "razao" => $razao_social ]); 
       } else if($statusAnterior != $status && $status == 2){
         $send = \Email::sendNotification("pago-comissao", ["id" => $id_descriptografado, "id_santri" => $id_cliente , "cnpj" => $cnpj, "razao" => $razao_social ,"pagamento" => $dados_pagamento, "email" => $email ]); 
       }
        header("Location: ".APPURL."/comissionamentos");
          
      }
      
      
    
      
    }
  
 public function retornoPagamento($id){
   $Pagamento = Controller::model("Payment");
   $Pagamento->select($id,"id");
   return $Pagamento->get("name");
  }
  
  
  private function sweet($icon,$texto){
      $toast = "<script>
      console.log('entou');
      setTimeout(function() {
              Swal.fire({
                      icon: '$icon',
                      title: 'Oops...',
                      text:  '$texto',
                    })
              }, 1500)</script>";        
        return $toast;
    
    
  } 
  


}
