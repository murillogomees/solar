<?php
/**
 * User Controller
 */
class FreteController extends Controller
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

        $User = Controller::model("Order");
				$Frete = Controller::model("Frete");
				

        if (isset($Route->params->id)) {
					
					$User->select($Route->params->id);
					$Frete->select($User->get("order_id"));
					
					if (!$User->isAvailable()) {
							header("Location: ".APPURL."/order");
							exit;
					}
			}				
			
			if(Input::post("action") == "save"){
				$this->save();
			} else if(Input::post("action") == "searchCep"){
				$this->searchCep();
			}
			
			 $Branch = Controller::model("Branchs");
			 $Branch->where("is_active","=", 1)
			       	->where("tipo_filial","=", 1)
				      ->orderBy("name","DESC")
							 ->fetchData();

			$this->setVariable("Branch", $Branch);
			
			
      $Estados = Controller::model("States");
			$Estados->orderBy("name", "ASC")
							->fetchData();
			
			$this->setVariable("Estados", $Estados);
			
			$this->setVariable("User", $User);	
			$this->setVariable("Frete", $Frete);	
			$this->view("frete");
        
    }
    

	    private function searchCep()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
      
        $User = $this->getVariable("User");
        $clearFormatCnpj= preg_replace("/[^0-9]/","", Input::post("cep"));
      
        if (strlen($clearFormatCnpj) == 0){
           $this->resp->cep = "";
           $this->jsonecho();
        } 
      
        $resultado = cep($clearFormatCnpj);
        $this->resp->logradouro = $resultado['logradouro'];
        $this->resp->bairro = $resultado['bairro'];
        $this->resp->uf = $resultado['uf'];
        $this->resp->localidade = $resultado['localidade'];
        $this->resp->result = 1;
        $this->jsonecho();  
    }
	
	
    private function save()
    {
        $this->resp->result = 0;
				$Hoje = date('Y-m-d H:i:s');						
				$Sistema = "Painel Solar";		
				$New = 0;		
        $AuthUser = $this->getVariable("AuthUser");
				$idFrete = Input::post("frete");	
			  $idOrder = Input::post("id_order");
				$CodOriginal = Input::post("id_original");
				$Status = Input::post("status");
				$Frete = Controller::model("Frete", Input::post("id_order"));
        // Check required fields
        $required_fields = [ "telefone_cliente"=>"Telefone do cliente", "cnpj_cliente"=>"CNPJ do cliente","nome_cliente"=>"Nome do cliente",  "tipo_local"=>"Tipo de Local de Entrega",
                            "endereco_entrega"=>"Endereço de Entrega","bairro_entrega"=>"Bairro de Entrega",
                            "cidade_entrega"=>"Cidade de Entrega","uf_entrega"=>"UF de Entrega","cep_entrega"=>"CEP de Entrega","numero_santri"=>"Número do Pedido no Santri"];

        foreach ($required_fields as $field => $f) {
					if (!Input::post($field)) {						
						echo $this->toast("Campo: " . $f . " é obrigatório.");
            return false;			
					}
        }	
			
			$Order = Controller::model("Order", Input::post("id_original"));
			
			$Cliente = [
				"nome" => Input::post("nome_cliente"),
				"cnpj" => Input::post("cnpj_cliente"),
				"telefone" => Input::post("telefone_cliente")					 
			];
				 
			$Cliente = json_encode($Cliente,JSON_UNESCAPED_UNICODE);
			
			$Respon = Controller::model("User", $Order->get('responsavel'));

			$ResponsavelFrete = $Respon->get("id");
			
			$Responsavel = [
				"id" => $Respon->get("id"),				
				"nome" => $Respon->get("firstname"),
				"email" => $Respon->get("email"),
				"origem" => $Respon->get("office"),
				"telefone" => $Respon->get("phone")
			];
			
			$Responsavel = json_encode($Responsavel,JSON_UNESCAPED_UNICODE);
			
			
			
			
			$Numero_NF = Input::post("numero_nf");
      $Numero_NF_remessa = Input::post("numero_nf_remessa");
			$TipoFrete = Input::post('tipo_transporte');
			$NotaLiberada = Input::post("nota_liberada");
			$Observacao = Input::post('observacao');
			$CodSantri = Input::post("numero_santri");
      $id_cliente_santri = Input::post("id_cliente_santri");
			$TipoLocal = Input::post("tipo_local");
			$CifFob = Input::post("cif_fob");
			$EquipeAuxilio = Input::post("equipe_auxilio");
			$NomeTransporadora = Input::post("nome_transportadora");
			$EquipamentoAuxilio = Input::post("equipamento_auxilio");	
			$Cotacao = Input::post("cotacao");	
			$Rastreamento = Input::post("rastreamento");
			$Modificado = 0;
			$CustoConsiderado = preg_replace('#[^0-9\.,]#', '',Input::post("custo_considerado"));
			$CustoConsiderado = str_replace('.', '',$CustoConsiderado);
			$CustoConsiderado = str_replace(',', '.',$CustoConsiderado);
			$CepNormal = Input::post("cep_entrega");
			$Cep = preg_replace("/[^0-9]/", "", $CepNormal);
			$FilialResponsavel = Input::post("filial");
			$Endereco = [
				"endereco" => Input::post("endereco_entrega"),
				"bairro" => Input::post("bairro_entrega"),
				"cidade" => Input::post("cidade_entrega"),	
				"uf" => Input::post("uf_entrega"),
				"cep" => $Cep
			];	 
				 
			$Endereco = json_encode($Endereco,JSON_UNESCAPED_UNICODE);
			
			
			 if (isset($_FILES['arquivoNF'])){
        if($_FILES['arquivoNF']['error'] == 0){                    
        $path_to_users = ROOTPATH."/assets/uploads/"
                               . $AuthUser->get("id")
                               . "/";
          
        $path_to_users_directory = ROOTPATH."/assets/uploads/"
                               . $AuthUser->get("id")
                               . "/frete/";
          
         if (!file_exists($path_to_users_directory)) {
            mkdir($path_to_users, 0777);
            mkdir($path_to_users_directory, 0777);
         }   
          
         $user_dir_url = APPURL."/assets/uploads/"
                    . $AuthUser->get("id")
                    . "/frete/";
          
          // Pega Nome Temporario do Arquivo
          $arquivo_tmp = $_FILES['arquivoNF']['tmp_name']; 
          // Pega a extensão
          $extensao = pathinfo($_FILES['arquivoNF']['name'], PATHINFO_EXTENSION);    
          // Converte a extensão para minúsculo
          $extensao = strtolower($extensao); 
          // Criando Nome arquivo      
          $nome = "nf_frete_" . $idOrder . "." . $extensao;  
          // Destino Final
          $destino = $path_to_users_directory . $nome;
          echo $destino;
          echo $extensao;
          echo $arquivo_tmp;
          // Checagem de Segurança
          if (strstr('jpg;jpeg;gif;png;pdf', $extensao) ) {
            $arquivoNF = $user_dir_url.$nome;
            // tenta mover o arquivo para o destino
            if(move_uploaded_file($arquivo_tmp,$destino)){              
              $Frete->set("arquivo_nf", $arquivoNF);
            } else {
              echo 'Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.<br />';
            }
            
          } else {
            echo $arquivo_tmp . "  -  " . $nome . "  -  " . $extensao;
            echo 'Você poderá enviar apenas arquivos "*.jpg;*.jpeg;*.gif;*.png"<br />';
          }
          
        }
        }			
				
				
		$dbFrete = $this->dbFrete();					
		$result = $dbFrete->query("SELECT * FROM np_orders WHERE id_orcamento = '$idOrder'");	
			
		while ($row = mysqli_fetch_array($result)) {
			$New = 1;   					
		}						
		
      
      if($NotaLiberada == "1"){
        	$Status = "1";
          $Order->set("status",$Status)->save();
      } else if($Status == null){
				$Status = "2";
			}
			
			
     $Frete->set("status", $Status)
			 		 ->set("id_orcamento", $idOrder)
					 ->set("cotacao", $Cotacao)	
					 ->set("numero_nf", $Numero_NF) 
           ->set("numero_nf_remessa", $Numero_NF_remessa) 
					 ->set("numero_pedido_santri", $CodSantri)
           ->set("id_cliente_santri", $id_cliente_santri)
					 ->set("cliente", $Cliente)
			     ->set("filial", $FilialResponsavel)
			 		 ->set("vendedor_responsavel", $Responsavel)
			     ->set("responsavel", $ResponsavelFrete)	
					 ->set("tipo_local", $TipoLocal)       
					 ->set("endereco", $Endereco)
					 ->set("observacao", $Observacao)
			 		 ->set("cif_fob", $CifFob)
					 ->set("equipe_auxilio", $EquipeAuxilio)
			 		 ->set("equipamento_auxilio", $EquipamentoAuxilio)           
			 		 ->set("custo_considerado", $CustoConsiderado); 		
			
			if ($TipoFrete != null){
				$Frete->set("tipo_transporte", $TipoFrete);		
			}
			
			if($NotaLiberada != null){
				$Frete->set("nota_liberada", $NotaLiberada);
			} else {
				if ($Frete->isAvailable()){
					$NotaLiberada = $Frete->get("nota_liberada");
				} else {
					$NotaLiberada = "2";
				}				
			}
		
		if ($New == 1){
		
		$Frete->save();            
    $this->logs($AuthUser->get("id"), "success","Frete","Frete para o orçamento Nº <b>" . $idOrder ."</b><br/> atualizado com sucesso pelo usuário: ". $AuthUser->get("firstname"));
			
				$Insert = "UPDATE np_orders SET sistema_origem = '$Sistema', status = '$Status', id_cliente_santri = '$id_cliente_santri', cliente = '$Cliente' , filial = '$FilialResponsavel'  , vendedor_responsavel = '$Responsavel' ,responsavel = '$ResponsavelFrete' , endereco = '$Endereco', observacao = '$Observacao', numero_nf = '$Numero_NF', numero_nf_remessa = '$Numero_NF_remessa', nota_liberada = '$NotaLiberada', data_origem = '$Hoje', numero_pedido_santri = '$CodSantri', tipo_local = '$TipoLocal', cif_fob = '$CifFob', equipe_auxilio = '$EquipeAuxilio', equipamento_auxilio = '$EquipamentoAuxilio', custo_considerado = '$CustoConsiderado', modificado = '$Modificado', cod_original = '$CodOriginal', arquivo_nf = '$arquivoNF', cotacao = '$Cotacao', data_atualizacao = '$Hoje' WHERE id_orcamento = '$idOrder'";
					
			if ($dbFrete->query($Insert)){
				if ($Status == "1"){
					$send = \Email::sendNotification("aprovacao-frete", ["id" => $idOrder]);
				}				
			}
			
			//Log por processo      
    if($AuthUser->isFinanceiro() && $NotaLiberada == "1"){     
			
			$Usuario = $AuthUser->get("id");
			$Msg = "[IMPORTANTE] Nota fiscal liberada com sucesso pelo usuário: " .$AuthUser->get("firstname");
			$data = date("Y-m-d H:i:s");
			$InsertHistorico = "INSERT INTO np_logs_order (id_user, situacao, pagina, detalhe, id_order, horas) VALUES ('$Usuario', '$Status', 'Painel Solar', '$Msg','$idOrder', '$data' )";	  

			$dbFrete->query($InsertHistorico);
      
    } else { 
			
			$Usuario = $AuthUser->get("id");
			$Msg = "Pedido de Cotação de Frete modificado com sucesso pelo usuário: " .$AuthUser->get("firstname");
			$data = date("Y-m-d H:i:s");
			$InsertHistorico = "INSERT INTO np_logs_order (id_user, situacao, pagina, detalhe, id_order, horas) VALUES ('$Usuario', '$Status', 'Painel Solar', '$Msg','$idOrder', '$data' )";	  

			$dbFrete->query($InsertHistorico);      
    }
   
	 } else {
							
		$ProdutosFrete = json_decode($Order->get("products_order"));

		foreach($ProdutosFrete as $p){
			$ProdutosFreteArray[] = [
			"id" => $p->id,
			"produto" => $p->product,
			"quantidadeEntregue" => "0",
			"quantidadePendente" => $p->quantidade,		
			"quantidadeTotal" => $p->quantidade,	
			];
		}	

		$ProdutosArrayFrete = json_encode($ProdutosFreteArray, true);

		$Frete->set("produtos", $ProdutosArrayFrete);	
		$Frete->save();            
    $this->logs($AuthUser->get("id"), "success","Frete","Frete para o orçamento Nº <b>" . $idOrder ."</b><br/> criado com sucesso pelo usuário: ". $AuthUser->get("firstname"));	
		
			$Insert = "INSERT INTO np_orders (id_orcamento,tipo_transporte , sistema_origem, status, filial, id_cliente_santri, cliente, vendedor_responsavel , responsavel , endereco, observacao, numero_nf, numero_nf_remessa, nota_liberada, data_origem, data_atualizacao, numero_pedido_santri, tipo_local, cif_fob, equipe_auxilio, equipamento_auxilio, custo_considerado, modificado, cod_original, arquivo_nf, cotacao, produtos) VALUES ('$idOrder','3','$Sistema','$Status','$FilialResponsavel' ,'$id_cliente_santri' ,'$Cliente','$Responsavel','$ResponsavelFrete','$Endereco','$Observacao','$Numero_NF','$Numero_NF_remessa','$NotaLiberada','$Hoje','$Hoje','$CodSantri','$TipoLocal','$CifFob','$EquipeAuxilio','$EquipamentoAuxilio','$CustoConsiderado','$Modificado','$CodOriginal', '$arquivoNF', '$Cotacao','$ProdutosArrayFrete')";					
							
			
      
			if($dbFrete->query($Insert)){
				$send = \Email::sendNotification("nova-cotacao", ["id" => $idOrder, "nome" => Input::post("nome_cliente"), "cnpj" => Input::post("cnpj_cliente")]);
			}
			
			$Usuario = $AuthUser->get("id");
			$Msg = "Pedido de Cotação de Frete criado com sucesso pelo usuário: " .$AuthUser->get("firstname");
			$data = date("Y-m-d H:i:s");
			$InsertHistorico = "INSERT INTO np_logs_order (id_user, situacao, pagina, detalhe, id_order, horas) VALUES ('$Usuario', '$Status', 'Painel Solar', '$Msg','$idOrder', '$data' )";	  

			$dbFrete->query($InsertHistorico);      
			
		}
			
		header("Location: ".APPURL."/order");         
    }


}
