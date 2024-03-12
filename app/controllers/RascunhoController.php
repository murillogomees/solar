<?php
/**
 * User Controller
 */
class RascunhoController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
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

        $User = Controller::model("Rascunho");

        if (isset($Route->params->id)) {
					
					$permisaoUsuario = json_decode($AuthUser->get("permissoes_usuarios"), true);
					$User->select($Route->params->id);
					
					$idResponsavel = $User->get("responsavel");
			
					if (!$User->isAvailable()) {
							header("Location: ".APPURL."/order");
							exit;
					}
					
					if ($AuthUser->get("account_type") == "vendedor"){
						
						if ($AuthUser->get("id") == $idResponsavel || in_array($idResponsavel, $permisaoUsuario) ){
						
						}else{
						header("Location: ".APPURL."/order");
							exit;
						}
					} else if ($AuthUser->get("account_type") == "supervisor"){						
						if ($User->get("loja_responsavel") != $AuthUser->get("office")){
						if ($AuthUser->get("id") == $idResponsavel || in_array($idResponsavel, $permisaoUsuario) ){
						}else{
							header("Location: ".APPURL."/order");
						}
							
							
						}
					}
					
        }
			
			
				$Clients = Controller::model("Clientes");
				$Usuarios = Controller::model("Users");
					
				if (!$AuthUser->canEdit($AuthUser)){ 
         $filial = $AuthUser->get("office");				
			   $query = "office = '$filial' " ;	 
					
				 $Usuarios->where(DB::raw("$query")) 
								->orderBy("firstname","ASC")
                ->fetchData();	

					
				} else {				
					
				$Usuarios->where("is_active","=", 1)								
								->orderBy("firstname","ASC")
                ->fetchData();		
				} 
			
				if ($AuthUser->get("account_type") == "integrador"){	
					$Usuarios->where("id","=", $AuthUser->get("id"))
								->orderBy("firstname","ASC")
                ->fetchData();
					$Clients->where("owner","=", $AuthUser->get("id"))
								->orderBy("id","DESC")
								->fetchData();
				} else {
					$Clients->where("branch","=", $AuthUser->get("office"))					
							 		->orderBy("name","ASC")
               		->fetchData();
				}
			
        $this->setVariable("Clients", $Clients);
			
				$Fretes = Controller::model("Shipping");
     		$Fretes->orderBy("name","ASC")
						->fetchData();
			
       	$this->setVariable("Fretes", $Fretes);	
      
       //get Product Models
       $ProdModel = Controller::model("ProductModels");
       $ProdModel->where("is_active","=", 1)
				 				->orderBy("name","ASC")
                 ->fetchData();
			
			//get Product Models
       $Prod = Controller::model("Products");
       $Prod->where("is_active","=", 1)
				 		->orderBy("name","ASC")
            ->fetchData();
      
      //get payment
       $Payment = Controller::model("Payments");
       $Payment->where("is_active","=", 1)
				 				->orderBy("name","ASC")
               ->fetchData();
      
      //get producer
      $Producer = Controller::model("Producers");
      $Producer->where("is_active","=", 1)
								->orderBy("name","ASC")
                  ->fetchData();
      
      //get kit
      $ProductKits = Controller::model("ProductKits");
      $ProductKits->where("is_active","=", 1)
									->orderBy("name","ASC")
                  ->fetchData();
      
      //get kit
      $Branchs = Controller::model("Branchs");
      $Branchs->where("is_active","=", 1)
			       	->where("tipo_filial","=", 1)
						->orderBy("name","ASC")
                  ->fetchData();
      
      //get kit
      $States = Controller::model("States");
      $States->where("is_active","=", 1)
							->orderBy("name","ASC")
                  ->fetchData();
      
       $ProdKit = Controller::model("Products");
			 $ProdKit->where("is_active","=", 1)
				       ->orderBy("name","ASC")
				 			 ->fetchData();
			
			 $ProdK = [];
			 $ProdI = [];	
			 $ProdC = [];
			
			foreach($ProdKit->getDataAs("Product") as $p){
				if ($p->get("product_type") == "Kit de Fixação"){
					if(!in_array($p->get("producer"), $ProdK)) {
						$ProdK[] = $p->get("producer");
						
					}
				} else if ($p->get("product_type") == "Inversor"){
					if(!in_array($p->get("producer"), $ProdI)) {
						$ProdI[] = $p->get("producer");						
					}	
				} else if ($p->get("product_type") == "Cabo Negativo" || $p->get("product_type") == "Cabo Positivo"){
					if(!in_array($p->get("producer"), $ProdC)) {
						$ProdC[] = $p->get("producer");						
					}	
				}
			}
			
            
      
      

			 $this->setVariable("Prod", $Prod);
			 $this->setVariable("ProdCabo", $ProdC);	
			 $this->setVariable("ProdInversor", $ProdI);
       $this->setVariable("ProdKit", $ProdK);
       $this->setVariable("ProdModel", $ProdModel);
       $this->setVariable("User", $User);
       $this->setVariable("Payment" , $Payment);
       $this->setVariable("Producer" , $Producer);
       $this->setVariable("ProductKits" , $ProductKits);
       $this->setVariable("Branchs" , $Branchs);
       $this->setVariable("States" , $States);
			 $this->setVariable("Usuarios" , $Usuarios);

        if (Input::post("action") == "saveRascunho") {
           $this->saveRascunho();
        } else if (Input::post("action") == "save") {
           $this->save();
        } else if (Input::post("action") == "copy"){
          $this->copyOrder();
        } else if (Input::post("action") == "searchUF"){
          $this->searchUF();
        }  else if (Input::post("action") == "selectKit"){
          $this->selectKit();
        }  else if (Input::post("action") == "calcFrete"){
          $this->calcFrete();
        } else if (Input::post("action") == "calcQuantidade"){
          $this->calcQuantidade();
        } else if (Input::post("action") == "calcValue"){
          $this->calcValue();
        } else if (Input::post("action") == "selectProduct"){
          $this->selectProduct();
        } else if (Input::post("action") == "selectInversor"){
					$this->selectInversor();
				} else if (Input::post("action") == "selectCabo"){
					$this->selectCabo();
				} else if (Input::post("action") == "selectKitdeFixacao"){
					$this->selectKitdeFixacao();
				} else if (Input::post("action") == "states"){
					$this->states();
				} else if (Input::post("action") == "selectClientes"){
					$this->selectClientes();
				}  else if (Input::post("action") == "linkFinanciamento"){
					$this->linkFinanciamento();
				}  else if (Input::post("action") == "ExisteFrete"){
					$this->ExisteFrete();
				} else if (Input::post("action") == "removeRascunho") {
           $this->removeRascunho();
        } else if (Input::post("action") == "selectTC") {
           $this->selectTC();
        } else if (Input::post("action") == "selectGateway") {
           $this->selectGateway();
        } else if (Input::post("action") == "selectConectores") {
           $this->selectConectores();
        } else if (Input::post("action") == "selectAcoplador") {
           $this->selectAcoplador();
        }
			
				$rascunho = 1;
		  	$this->setVariable("rascunho", $rascunho);
								
				$this->view("order");
				
        
    }
	

	
		/**
     * Save (new|edit) user
     * @return void
     */
    private function selectClientes()
    {
                $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");

      $Clientes = Controller::model("Clientes");
      $Clientes->search(Input::post("q"))
							 ->setPageSize(50)
               ->setPage(1)							
							 ->orderBy("name","ASC")
               ->fetchData();
			
				$data = [];
			
				foreach($Clientes->getDataAs("Cliente") as $f){
					$data[] = [
						"id" => $f->get("id"),
						"name" => $f->get("name"),
						"cnpj" => formata_cpf_cnpj($f->get("cnpj"))
					];
				}
			
        $this->resp = $data;       
        
        $this->jsonecho();
      
      
      
				$data = [];
			
				foreach($Clientes->getDataAs("Cliente") as $f){
					$data[] = [
						"id" => $f->get("id"),
						"name" => $f->get("name"),
						"cnpj" => formata_cpf_cnpj($f->get("cnpj"))
					];
				}
			
        $this->resp = $data;       
        
        $this->jsonecho();
    }
	
		/**
     * Save (new|edit) user
     * @return void
     */
    private function states()
    {
        $this->resp->result = 0;
      
         $States = Controller::model("States");
      $States->where("is_active","=", 1)
							->orderBy("name","ASC")
                  ->fetchData();
				
				$stat = [];
			
				foreach($States->getDataAs("State") as $f){
					$stat[] = [
						"uf" => $f->get("uf"),
						"name" => $f->get("name")
					];
				}
			
        $this->resp->states = $stat;       
        
        $this->jsonecho();
    }
	
		/**
     * Save (new|edit) user
     * @return void
     */
    private function linkFinanciamento()
    {
        $this->resp->result = 0;
      
        $Payment = Controller::model("Payment", Input::post("valor"));     
			
				if ($Payment->get("site") != ""){
					$this->resp->result = 1;
					$this->resp->payment = $Payment->get("site");
				}   
        
        $this->jsonecho();
    }
	
	
		/**
     * Save (new|edit) user
     * @return void
     */
    public function linkFinanciamentoEstatico($id)
    {
      $Pagamento = Controller::model("Payment", $id);
     
			return $Pagamento->get("site");
    }
  
    /**
     * Save (new|edit) user
     * @return void
     */
    private function searchUF()
    {
        $this->resp->result = 0;
      
        $id = Input::post("id");
      
        $ClienteUF = Controller::model("Cliente", $id);       
      
        $this->resp->uf = $ClienteUF->get("uf");
        $this->resp->type = $ClienteUF->get("client_type");
       
        $this->resp->result = 1;
        
        $this->jsonecho();
    }

  
   
  private function calcValue()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
			  $smgcalculo = "";
        // ID do Produto
        $id = Input::post("id");
        // Tipo do Orçamento
        $typeOder = Input::post("typeOrder");
				// Tipo de Frete
        $frete = Input::post("frete");
        // UF de Destino
        $ufClient = strtolower(Input::post("ufClient"));
    
        $id_cliente = strtolower(Input::post("id_cliente"));
        // UF de Origem
        $ufBranch = strtolower(Input::post("ufBranch"));
        // Perfil Tributário do Cliente
        $typeClient = Input::post("typeClient");
        // Se é para consumo próprio
        $useConsume = Input::post("useConsume"); 
        // Valor do KwP
        $kwp = Input::post("kwp");
			  // Condição de pagamento
				$pagamento = Input::post("paymentMode");
			  // Comissao de vendas
				$comissao = floatval (Input::post("comissao"));
				 // Desconto de vendas
        $desconto = str_replace(',', '.',Input::post("desconto"))/100;
        // Quantidade de Produto se Tiver
        $qntActive = Input::post("qnt");
		
		
		    $valor_Total_IPI = preg_replace('/[^0-9]/', '', Input::post("valorIPI")) / 100;
		    $valor_Total_Custo = preg_replace('/[^0-9]/', '', Input::post("valorCustoTOTAL")) / 100;
		    $soma_Custo_IPI = $valor_Total_Custo + $valor_Total_IPI;
		
			
		    $tensao = Input::post("tensao");
		    $fases = Input::post("fases");
			
        // Seleção do Produto      
        $Product = Controller::model("Product", $id); 
        $smgcalculo .= " Produto " . $Product->get("id")." - " .$Product->get("name") ;
				$productType = $Product->get("product_type");
			
				if ($Product->get("datasheet") != ""){
					$this->resp->datasheet = $Product->get("datasheet");
				} else {
					$this->resp->datasheet = "javascript:void(0)";
				}
				
				// Inicio do Cálculo
				$CredIcms = str_replace(',', '.',$Product->get("finance.cred_icms"))/100;
				$MargemBruta = (str_replace(',', '.',$Product->get("margem_product")))/100;
        $this->resp->kwpReal = 0;
        // Calcular Quantidade de Produtos
		
		     // Verifica se os produtos é para o fabricante enphase//
		     if($Product->get("producer") == "ENPHASE"){
           
            switch($productType){
          case "Painel":
            $ProductKwPs = $Product->get("finance");
            $Json_KwP = json_decode($ProductKwPs);        
            $qnt = $Json_KwP->watts;
            $quantidade = ((str_replace(',', '.',$kwp)) * 1000) / $qnt;
						$qntPlaca = (round($quantidade/2))*2;
            $this->resp->qnt = $qntPlaca;
						$Quant = ((int) $qnt) / 1000;
						$KwpReal = $qntPlaca * $Quant;						
						
						$this->resp->kwpReal = $KwpReal;
            $qntProduto = (round($quantidade/2))*2;					
						
            break;
				  case "Inversor":
						$QuantidadePainel = Input::post("painel");
            $this->resp->qnt = $QuantidadePainel;
            $qntProduto = $QuantidadePainel;				
				
            break;
					  case "Suporte":
						if($tensao == '4'){
            $this->resp->qnt = 2;
            $qntProduto = 2;	 
						 } else if ($tensao == '3'){
						$this->resp->qnt = 3;	
            $qntProduto = 3;	  
						} else if ($tensao == '2' && $fases == "1") {
						$this->resp->qnt = 1;
            $qntProduto = 1;	  
						} else if ($tensao == '2' && $fases >= "2") {
						$this->resp->qnt = 2;	
            $qntProduto = 2;	  
						} else if ($tensao == '1' && $fases == "1") {
						$this->resp->qnt = 2;
            $qntProduto = 2;	
						} else if ($tensao == '1' && $fases == "2") {
						$this->resp->qnt = 3;	
            $qntProduto = 3;	  
						} else if ($tensao == '1' && $fases == "3") {
						$this->resp->qnt = 4;	
            $qntProduto = 4;	  
						} else {
            $this->resp->qnt = 1;
            $qntProduto = 1;	  
            } 
            break;	 
				  case "Cabo":
						 
						if(strpos($Product->get("name"), 'CABO TRONCO') !== false){
						   $QuantidadePainel = Input::post("painel");
               $this->resp->qnt = $QuantidadePainel;
               $qntProduto = $QuantidadePainel;
					} else if(strpos($Product->get("name"), 'CABO PP') !== false){
						   $QuantidadePainel = Input::post("painel");
					     $qtdC = ( $QuantidadePainel / 10);
							 $qtd =  round($qtdC, 0);
							 $QTDfinal = ($qtd + 1 ) * 10;
               $this->resp->qnt = $QTDfinal;
               $qntProduto = $QTDfinal;
					}  
						 				
          break; 
          case "Kit de Fixação":           
            $QuantidadePainel = Input::post("painel"); 
						$KitFix = Controller::model("Product", Input::post("idkit"));						
            $QuantidadeKit =  $QuantidadePainel / $Product->get("finance.mppt");
            $QuantidadeKit = ceil($QuantidadeKit);    
            $this->resp->qnt = $QuantidadeKit;
            $qntProduto = $QuantidadeKit;
            break; 
         
				case "Conectores MC4":

						 if(strpos($Product->get("name"), 'Q-TERM') !== false){
						   $QuantidadePainel = Input::post("painel");
					     $qtdC = ( $QuantidadePainel / 10);
							 $qtd =  round($qtdC, 0);
							 if($qtd < $qtdC){
								 $QTDfinal = $qtd + 1;
                } else {
							 $QTDfinal = $qtd ;
							 }
							 
						$qntProduto = $QTDfinal;	 
            $this->resp->qnt = $QTDfinal;
					} else if(strpos($Product->get("name"), 'CONECTOR FEMEA') !== false){
						   $QuantidadePainel = Input::post("painel");
					     $qtdC = ( $QuantidadePainel / 10);
							 $qtd =  round($qtdC, 0);
							 if($qtd < $qtdC){
								 $QTDfinal = $qtd + 1;
                } else {
							 $QTDfinal = $qtd ;
							 }
						$qntProduto = $QTDfinal;	 
            $this->resp->qnt = $QTDfinal;
					} else if(strpos($Product->get("name"), 'CONECTOR MACHO') !== false){
						   $QuantidadePainel = Input::post("painel");
					     $qtdC = ( $QuantidadePainel / 10);
							 $qtd =  round($qtdC, 0);
							 if($qtd < $qtdC){
								 $QTDfinal = $qtd + 1;
                } else {
							 $QTDfinal = $qtd ;
							 }
						$qntProduto = $QTDfinal;	 
            $this->resp->qnt = $QTDfinal;
					}  
						
            break;
					 case "Trilho":
						$QuantidadeKit = Input::post("kit");
						$this->resp->QuantidadeKit = $QuantidadeKit;
						$Kit = Controller::model("Product", Input::post("idkit"));
					
						if ($Kit->get("finance.mppt") == "2"){
							if ($Product->get("finance.mppt") == "2"){
								$qntTrilho = $QuantidadeKit * 2;							
							} else if ($Product->get("finance.mppt") == "4"){
								$qntTrilho = $QuantidadeKit;							
							} else {
								$qntTrilho = 1;							
							}
						} else if($Kit->get("finance.mppt") == 4){
							if ($Product->get("finance.mppt") == 2){
								$qntTrilho = $QuantidadeKit * 4;							
							} else if ($Product->get("finance.mppt") == "4"){
								$qntTrilho = $QuantidadeKit * 2;								
							} else {
								$qntTrilho = 1;								
							}
						}
						
            $this->resp->qnt = (ceil($qntTrilho/2))*2;
            $qntProduto = (ceil($qntTrilho/2))*2;
            break;	
					 default:
            
						$this->resp->qnt = 1;
						$qntProduto = "1";

				
          }
        
		
				 } else if( $Product->get("producer") != "ENPHASE"){
           
           					 $QuantidadePainel = Input::post("painel"); 
         switch($productType){
          case "Painel":
            $ProductKwPs = $Product->get("finance");
            $Json_KwP = json_decode($ProductKwPs);        
            $qnt = $Json_KwP->watts;
            $quantidade = ((str_replace(',', '.',$kwp)) * 1000) / $qnt;
						$qntPlaca = (round($quantidade/2))*2;
            $this->resp->qnt = $qntPlaca;
						$Quant = ((int) $qnt) / 1000;
						$KwpReal = $qntPlaca * $Quant;						
						$this->resp->kwpReal = $KwpReal;
            $qntProduto = (round($quantidade/2))*2;					
            break;
             
           case "Kit de Fixação":           
            $QuantidadePainel = Input::post("painel"); 
						$KitFix = Controller::model("Product", Input::post("idkit"));						
            $QuantidadeKit =  $QuantidadePainel / $Product->get("finance.mppt");
            $QuantidadeKit = ceil($QuantidadeKit);    
            $this->resp->qnt = $QuantidadeKit;
            $qntProduto = $QuantidadeKit;
            break; 
             
          case "Cabo Positivo":
						
            $QuantidadePainel = Input::post("painel");
						$this->resp->qnt = "Não foi dessa vez";
						if ($Product->get("producer") == "REICON"){							
						
							if ($QuantidadePainel < 25) {
								$qntCabo = 50;								
							} else if ($QuantidadePainel >= 25 && $QuantidadePainel <= 36){
								$qntCabo = 70;							
							} else if ($QuantidadePainel >= 37 && $QuantidadePainel <= 75){
								$qntCabo = 100;							
							} else if ($QuantidadePainel >= 76 && $QuantidadePainel <= 100){
								$qntCabo = 150;							
							} else if ($QuantidadePainel > 100 && $QuantidadePainel <= 199){
								$qntCabo = 300;							
							} else if ($QuantidadePainel > 200){
								$qntCabo = 300 * ($QuantidadePainel / 100);							
							} else {
								$qntCabo = 50;
							}
						
							if ($Product->get("finance.mppt") > $qntCabo){
								$QuantidadeCabo = 1;
								$this->resp->qnt = 1;
								$qntProduto = 1;
							} else {
								$qnt = 1;
								while($Product->get("finance.mppt") < $qntCabo){
									$qntCabo = $qntCabo - $Product->get("finance.mppt");
									$qnt++;
								}
								$QuantidadeCabo = $qnt;
								$this->resp->qnt = $qnt;
								$qntProduto = $qnt;
							}
						 } else {
							$QuantidadeCabo =  $QuantidadePainel * 2.1;
            	$this->resp->qnt = (ceil($QuantidadeCabo/10))*10;
            	$qntProduto = (ceil($QuantidadeCabo/10))*10;
						 }
            break; 
             
					case "Cabo Negativo":
            $QuantidadePainel = Input::post("painel");
						$this->resp->qnt = "Não foi dessa vez";
						if ($Product->get("producer") == "REICON"){							
						
			        if ($QuantidadePainel < 25) {
								$qntCabo = 50;								
							} else if ($QuantidadePainel >= 25 && $QuantidadePainel <= 36){
								$qntCabo = 70;							
							} else if ($QuantidadePainel >= 37 && $QuantidadePainel <= 75){
								$qntCabo = 100;							
							} else if ($QuantidadePainel >= 76 && $QuantidadePainel <= 100){
								$qntCabo = 150;							
							} else if ($QuantidadePainel > 100 && $QuantidadePainel <= 199){
								$qntCabo = 300;							
							} else if ($QuantidadePainel > 200){
								$qntCabo = 300 * ($QuantidadePainel / 100);							
							} else {
								$qntCabo = 50;
							}
						
							if ($Product->get("finance.mppt") > $qntCabo){
								$QuantidadeCabo = 1;
								$this->resp->qnt = 1;
								$qntProduto = 1;
							} else {
								
								$qnt = 1;
								
								while($Product->get("finance.mppt") < $qntCabo){
									$qntCabo = $qntCabo - $Product->get("finance.mppt");
									$qnt++;
								}
								
								$QuantidadeCabo = $qnt;
								$this->resp->qnt = $qnt;
								$qntProduto = $qnt;
							}
						} else {
							$QuantidadeCabo =  $QuantidadePainel * 2.1;
            	$this->resp->qnt = (ceil($QuantidadeCabo/10))*10;
            	$qntProduto = (ceil($QuantidadeCabo/10))*10;
						}
            break; 	
             
				case "Conectores MC4":
						$InversorEscolhido = Input::post("inversor");						
						$Inversor = Controller::model("Product", $InversorEscolhido);
						$qntMPPT = $Inversor->get("finance.mppt");
						$qntMPPT = $qntMPPT + 1;
            $this->resp->qnt = $qntMPPT;
            $qntProduto = $qntMPPT;
            break;
             
					 case "Trilho":
						$QuantidadeKit = Input::post("kit");
						$this->resp->QuantidadeKit = $QuantidadeKit;
						$Kit = Controller::model("Product", Input::post("idkit"));
					
						if ($Kit->get("finance.mppt") == "2"){
							if ($Product->get("finance.mppt") == "2"){
								$qntTrilho = $QuantidadeKit * 2;							
							} else if ($Product->get("finance.mppt") == "4"){
								$qntTrilho = $QuantidadeKit;							
							} else {
								$qntTrilho = 1;							
							}
						} else if($Kit->get("finance.mppt") == 4){
							if ($Product->get("finance.mppt") == 2){
								$qntTrilho = $QuantidadeKit * 4;							
							} else if ($Product->get("finance.mppt") == "4"){
								$qntTrilho = $QuantidadeKit * 2;								
							} else {
								$qntTrilho = 1;								
							}
						}
            $this->resp->qnt = (ceil($qntTrilho/2))*2;
            $qntProduto = (ceil($qntTrilho/2))*2;
            break;	
             
					default:
			     
					      if(strpos($Product->get("name"), 'MARTELO') !== false){
						   $QuantidadePainel = Input::post("painel");
               $this->resp->qnt = $QuantidadePainel;
               $qntProduto = $QuantidadePainel;
					} else {
               
						$this->resp->qnt = 1;
						$qntProduto = "1";

             }
			 
        }
				 }
		
		
        
        // Verificar se produto está sendo setado quantidade na mão
        if ($qntActive != ""){
					if ($productType == "Painel"){
						$ProductKwPs = $Product->get("finance");
            $Json_KwP = json_decode($ProductKwPs);        
            $qnt = $Json_KwP->watts;
            $quantidade = ((str_replace(',', '.',$kwp)) * 1000) / $qnt;
						$qntPlaca = (round($quantidade/2))*2;
            $this->resp->qnt = $qntActive;
						$Quant = ((int) $qnt) / 1000;
						$KwpReal = $qntActive * $Quant;						
						
						$this->resp->kwpReal = $KwpReal;
            $qntProduto = (round($quantidade/2))*2;		
					}
					if ($qntActive == 0){
					$this->resp->qnt = 1;
          $qntProduto = 1;	
					} else {
					$this->resp->qnt = $qntActive;
          $qntProduto = $qntActive;	
					}
         
        }
				
				$estoque = $Product->get("estoque");
				$nomeEstoque = $Product->get("name");
			
				if ($estoque < $qntProduto || $estoque == null){
					$this->resp->estoque = 1;
					$this->resp->nomeEstoque = $nomeEstoque;
					$this->resp->qntEstoque = $estoque;
				}
        
				$selectIcms = "0";
			
        // Verifica se o tipo do orçamento encaixa no ICMS 
        $ProductKit = Controller::model("ProductKit", $typeOder);
  
        if ($ProductKit->get("is_active_icms") == "1") {
         $this->resp->onde = "ENTROU NO KIT";
         $selectIcms = $ProductKit->get("icms.$ufBranch");
          
     
    
          
         $DebIcms = $selectIcms->$ufClient;
				 $MargemBruta = (str_replace(',', '.',$Product->get("margem_kit")))/100;
				 $selectIcms = "1";
        } else if ($Product->get("is_active_icms") == "1"){
          $this->resp->onde = "ENTROU NO PRODUTO";
         	$selectIcms = $Product->get("icms.$ufBranch");
         	$DebIcms = $selectIcms->$ufClient; 
					$selectIcms = "1";
        } else {          
        // Verificação do Benefício Fiscal                      
          $TaxBenefit = Controller::model("TaxBenefits"); 
          $TaxBenefit->where("is_active","=","1")
										 ->search($ufBranch)
                     ->orderBy("id","DESC")
                     ->fetchData();          
  
          foreach($TaxBenefit->getDataAs("TaxBenefit") as $t){
            $TaxNcm = json_decode($t->get("ncm"));

            if ($TaxNcm[0]->value == "Todos" || $TaxNcm[0]->value == $Product->get("ncm")){
              $TaxProfiles = json_decode($t->get("tax_profiles"));

             if ($TaxProfiles[0]->value == "Todos" || $TaxProfiles[0]->value == $typeClient){
              $UFDestiny = json_decode($t->get("uf_destiny"));

              if ($UFDestiny[0]->value == "Todos" || $UFDestiny[0]->value == $ufClient){
                $this->resp->onde = "ENTROU NO BENEFITS";								
								$benefit = json_decode($t->get("benefits"));
								$tax = json_decode($t->get("tax_aliquota"));								
									
								if ($benefit[0]->id == "aliquota"){
									$this->resp->onde = "Entrou na aliquota";
									$CredIcms = $tax->credito->value;
									$DebIcms = $tax->debito->value;
									$selectIcms = "1";
								} else if ($benefit[0]->id == "base") {
									$this->resp->onde = "Entrou na base";
									$CredIcms = $tax->credito->value;
									$DebIcms = $tax->debito->value;
									$selectIcms = "1";
								} else if ($benefit[0]->id == "apuracao"){
									$this->resp->onde = "Entrou na apuracao";
									$CredIcms = $tax->credito->value;
									$DebIcms = $tax->debito->value;
									$selectIcms = "1";									
								}
                
              }
             } 
            }            
          }
        }
      
        // Continua Filtro Caso não tenha encontrado nenhuma opção de ICMS
      
        if($selectIcms == "0"){
          $segmentProduct = $Product->get("segment");
          
        // Verificação do Segmento     
        $sProduct = Controller::model("ProductSegment", $segmentProduct);     
        
          if ($sProduct->get("is_active_icms") == "1"){
            $this->resp->onde = "ENTROU EM SEGMENT";
            $selectIcms = $sProduct->get("icms.$ufBranch");
            $DebIcms = $selectIcms->$ufClient; 
          } else {
            // ICMS Geral
            $this->resp->onde = "ENTROU EM ICMS GERAL";
            $ICMSGeral = Controller::model("Icms");
            $ICMSGeral->where("uf_beggin","=",$ufBranch)
											->orderBy("id","DESC")
                     	->fetchData();
            
            foreach ($ICMSGeral->getDataAs("Icm") as $i){              
              $DebIcms = $i->get($ufClient); 
							$this->resp->deb1 = $DebIcms;
            }
          }
        }
			
				$Juros = 1;
			
				// Verificação de Condição de Pagamento 
				$CPagamentos = Controller::model("Payment", $pagamento);
				$Juros = (str_replace(',', '.', $CPagamentos->get("juros"))/100);  
		    
      
        // CALCULOS DE PREÇOS
      
        $CustoUnitario = str_replace(',', '.',$Product->get("cust"));
    
        $smgcalculo .= " Custo unitario = " . $CustoUnitario;
      
        $IPIB = $Product->get("finance.ipi");  
		    $IPIP = str_replace(',', '.',$IPIB);
		    $IPI = $IPIP / 100;
        $CredPisCofins = (str_replace(',', '.',$Product->get("finance.cred_pis")) + str_replace(',', '.',$Product->get("finance.cred_cofins")))/100;        
		
        $PrimeiroCampo = $CustoUnitario * (1 + $IPI);
        $SegundoCampo = $PrimeiroCampo * $CredPisCofins;
        $TerceiroCampo = $CustoUnitario * $CredIcms; 
		
				$CustoTotal = $CustoUnitario * $qntProduto;
  
		    $valorIPI = $CustoTotal * $IPI;
        $valorIPI = round($valorIPI, 2,PHP_ROUND_HALF_UP);
		
		
        //Define custo liquido//  
        $CustoLiquido = ( $PrimeiroCampo - $SegundoCampo - $TerceiroCampo )   ;
        //arredonda para duas casas decimais o custo liquido//
        $CustoLiquido  = round($CustoLiquido, 2,PHP_ROUND_HALF_UP);
        //Monta mensagem referente ao custo liquido//
		    $smgcalculo .= " | Preço produto custo Liquido = ".$CustoLiquido." => " . "[(".$CustoUnitario." * (1 -". $IPI. ")) - (".$CustoUnitario." * (1-". $IPI.") * ".$CredPisCofins.") - (".$CustoUnitario." * ". $CredIcms.") + ". $valCustComissao. "]";
      
      
        $DebIcms = (str_replace(',', '.',$DebIcms))/100;
        $DebPisCofins = (str_replace(',', '.',$Product->get("finance.deb_pis")) + str_replace(',', '.',$Product->get("finance.deb_cofins")))/100;
     
		    $id_user = Input::post("idUsuario");
		    $SelecUser = Controller::model("User");
				$SelecUser->select($id_user,"id");
    
		
				$valorMargemUser = floatval($SelecUser->get("margem_usuario"));
			  $valorMargemUsuario = $valorMargemUser / 100;	
		    $valorMargemUsuarioVendedor = $valorMargemUser / 100;	
    
    
        $selecAdicionalCliente = Controller::model("Cliente");
				$selecAdicionalCliente->select($id_cliente,"id");
        $valor_adicional = $selecAdicionalCliente->get("adicional_venda") / 100;
    
        $selectMargem = Controller::model("Option");
				$selectMargem->select(3,"id");
    
        $margemKIT = $Product->get("margem_kit") / 100;
        $margemUN = $Product->get("margem_product") / 100;
    
    
    
        if($typeOder != 1){
        $CampoDivisaoNormal =  1 - $DebIcms - $DebPisCofins - $valorMargemUsuario - $Juros - $margemUN ;   
		    $CampoDivisaoNormalSemComissao =  1 - $DebIcms - $DebPisCofins - $valorMargemUsuario - $Juros - $margemUN ;
        $smgcalculo .= " | Custos = ". $CampoDivisaoNormal . " => 1 - ".$DebIcms . " - ". $DebPisCofins . " - ". $valorMargemUsuario . " - ". $Juros ." - ".$margemUN;
        } else {
        $CampoDivisaoNormal =  1 - $DebIcms - $DebPisCofins - $valorMargemUsuario - $Juros - $margemKIT ;   
		    $CampoDivisaoNormalSemComissao =  1 - $DebIcms - $DebPisCofins - $valorMargemUsuario  - $Juros - $margemKIT ; 
        $smgcalculo .= " | Custos = ". $CampoDivisaoNormal . " => 1 - ".$DebIcms . " - ". $DebPisCofins . " - ". $valorMargemUsuario . " - ". $Juros ." - ".$margemKIT;
        }
  
        
     if (Input::post("comissaoActive") == "1"){
				 
		    //soma por produto de Custo + IPI
		   $soma_un_custo_IPI = $valorIPI + $CustoTotal;
		   // divisao dos valores de CUSTO/IPI unitario pelo total 
       $resultado_comissao = ($soma_un_custo_IPI / $soma_Custo_IPI) * $comissao ;
		   $resultado_comissao = $resultado_comissao * (1 - 0.0925);
			 $valCustComissao = 0;
		   if($resultado_comissao != 0 ){
				  $valCustComissao = $resultado_comissao / $qntProduto;
				  $valCustComissao =    round($valCustComissao, 2,PHP_ROUND_HALF_UP);
			 }
			
				} else {
				 $valCustComissao = 0;
         $resultado_comissao = 0 ;
			 }
    
    
    
        // calculo com comissao 
				$PrecoProdutoNormal = ($CustoLiquido / $CampoDivisaoNormal) + $valCustComissao;
        $PrecoProdutoNormal = $PrecoProdutoNormal  / (1 - $valor_adicional) ;  
        $PrecoProdutoNormal  = round($PrecoProdutoNormal, 2,PHP_ROUND_HALF_UP);
        $PrecoProduto = ( $CustoLiquido / $CampoDivisaoNormalSemComissao ) + $valCustComissao; 
        $PrecoProduto = $PrecoProduto / (1 - $valor_adicional ) ;     
        $PrecoProduto  = round($PrecoProduto, 2,PHP_ROUND_HALF_UP);
    
        $smgcalculo .= " | Preço Produto = " .$PrecoProduto . " => (". $CustoLiquido ." / ".$CampoDivisaoNormalSemComissao.") / (1 - ". $valor_adicional. ")";
		
				$PrecoFinal = $PrecoProduto ;
		
							$PrecoDesconto = $PrecoFinal * $desconto;				
							$PrecoFinal = $PrecoFinal - $PrecoDesconto;	

			
		
        $PrecoTotal = $PrecoFinal * $qntProduto;
	
		    // custo total produtos
				$CstTotal = $PrecoProdutoNormal * $qntProduto;
        $CstTotal = round($CstTotal, 2,PHP_ROUND_HALF_UP);
      

         if (Input::post("comissaoActive") == "1"){
            $valor_comissao = (($CustoTotal + $valorIPI) / ($valor_Total_IPI + $valor_Total_Custo ) * $comissao ) * (1 - 0.0925);
         } else {

           $valor_comissao = 0;
         }
		
			  $precoTotal = $PrecoFinal  * $qntProduto; 
		 
		    // valor ICMS
		    $valorICMS = ($PrecoFinal * 0) - $CustoTotal * $CredIcms;
        $valorICMS = round($valorICMS, 2,PHP_ROUND_HALF_UP);
        // valor condição de pagamento
		    $valorCondicaoPagamento = $precoTotal * $Juros;
        $valorCondicaoPagamento = round($valorCondicaoPagamento, 2);
        //Valor pis e cofins 
        $PeC = ($PrecoTotal - ( $CustoTotal + $valorIPI )) *  $CredPisCofins;
        $PeC = round($PeC, 2,PHP_ROUND_HALF_UP);
        // valor custo vendedor
		    $custoVendedor = ($precoTotal) * $valorMargemUsuarioVendedor;
        $custoVendedor = round($custoVendedor, 2,PHP_ROUND_HALF_UP);
    
		    $CustoTotalF = $CustoTotal + $valorIPI + $PeC + $custoVendedor  + $valorICMS + $valorCondicaoPagamento + $resultado_comissao ;
		    $MARGEM = $precoTotal - $CustoTotalF  ;
        $MARGEM =      round($MARGEM, 2,PHP_ROUND_HALF_UP);
    
       //calculo somente dos produtos 
    
    		$PrecoProdutoNormalSemComissao = ($CustoLiquido / $CampoDivisaoNormal) ;
        $PrecoProdutoNormalSemComissao = $PrecoProdutoNormalSemComissao  / (1 - $valor_adicional) ;  
        $PrecoProdutoNormalSemComissao  = round($PrecoProdutoNormalSemComissao, 2,PHP_ROUND_HALF_UP);
        $PrecoProdutoSemComissao = ( $CustoLiquido / $CampoDivisaoNormalSemComissao ); 
        $PrecoProdutoSemComissao = $PrecoProdutoSemComissao / (1 - $valor_adicional ) ;     
        $PrecoProdutoSemComissao  = round($PrecoProdutoSemComissao, 2,PHP_ROUND_HALF_UP);
    
       // $smgcalculo .= " | Preço Produto = " .$PrecoProduto . " => (". $CustoLiquido ." / ".$CampoDivisaoNormalSemComissao.") / (1 - ". $valor_adicional. ")";
		
				$PrecoFinalSemComissao = $PrecoProdutoSemComissao ;

        $PrecoDescontoSemComissao = $PrecoFinalSemComissao * $desconto;				
        $PrecoFinalSemComissao = $PrecoFinalSemComissao - $PrecoDescontoSemComissao;	

        $PrecoTotalSemComissao = $PrecoFinalSemComissao * $qntProduto;
	
		    // custo total produtos
				$CstTotalSemComissao = $PrecoProdutoNormalSemComissao * $qntProduto;
        $CstTotalSemComissao = round($CstTotalSemComissao, 2,PHP_ROUND_HALF_UP);
		
			  $precoTotalSemComissao = $PrecoFinalSemComissao  * $qntProduto; 
		 
		    // valor ICMS
		    $valorICMSSemComissao = ($PrecoFinalSemComissao * 0) - $CustoTotal * $CredIcms;
        $valorICMSSemComissao = round($valorICMSSemComissao, 2,PHP_ROUND_HALF_UP);
        // valor condição de pagamento
		    $valorCondicaoPagamentoSemComissao = $precoTotalSemComissao * $Juros;
        $valorCondicaoPagamentoSemComissao = round($valorCondicaoPagamentoSemComissao, 2,PHP_ROUND_HALF_UP);
        //Valor pis e cofins 
        $PeCSemComissao = ($PrecoTotalSemComissao - ( $CustoTotal + $valorIPI )) *  $CredPisCofins;
        $PeCSemComissao = round($PeCSemComissao, 2,PHP_ROUND_HALF_UP);
        // valor custo vendedor
		    $custoVendedorSemComissao = ($precoTotalSemComissao) * $valorMargemUsuarioVendedor;
        $custoVendedorSemComissao = round($custoVendedorSemComissao, 2,PHP_ROUND_HALF_UP);
    
		    $CustoTotalFSemComissao = $CustoTotal + $valorIPI + $PeCSemComissao + $custoVendedorSemComissao  + $valorICMSSemComissao + $valorCondicaoPagamentoSemComissao  ;
       
		    $MARGEM_SemComissao = $precoTotalSemComissao - $CustoTotalFSemComissao  ;
        $MARGEM_SemComissao = round($MARGEM_SemComissao, 2,PHP_ROUND_HALF_UP);
       
       
        $this->resp->value_sem_comissao = $PrecoFinalSemComissao;       
			  $this->resp->preco_total_sem_comissao = $precoTotalSemComissao;
				$this->resp->margem_produto_sem_comissao = $MARGEM_SemComissao;
        $this->resp->valorComissaoLiquida = $valor_comissao;
        $this->resp->value = $PrecoFinal;       
			  $this->resp->precototalsemjuros = $PrecoFinal;
				$this->resp->margemProduto = $MARGEM;
        $this->resp->margemUsuario = $valorMargemUser;
				$this->resp->nivel = $AuthUser->get("account_type");
		    $this->resp->valoIPI = $valorIPI;
		    $this->resp->valorCustoTotal = $CustoTotal;
				$this->resp->desconto = $desconto;
		    $this->resp->aTeste =  "  " .  $CustoUnitario ."   * ".  $qntProduto. " ". $Product->get("producer");  ;
        $this->resp->valuest = "0";        
        $this->resp->result = 1;
        $this->jsonecho();
    
	}
  
  
  
    private function calcFrete()
    {
		  $this->resp->result = 0;
		  $frete = Input::post("frete");
		  $ufFrete = Input::post("ufFrete");
		  $filial = Input::post("filial");
		  $painel = Input::post("painel");
			
			if ($frete == "3"){
				
			$Shipping = Controller::model("Shipp", $ufFrete);
        
      $ShippingPrice = $Shipping->get("price_shipp");
			
      $priceShipping = $ShippingPrice * $painel;
				
			$this->resp->price = $ShippingPrice;
			$this->resp->painel = $painel;
      $this->resp->calcFrete = $priceShipping;  
				
			} else {
				$this->resp->calcFrete = 0; 
			}    
			
			$this->resp->result = 1;
        
      $this->jsonecho();
      
    }
	
		/**
     * Save (new|edit) user
     * @return void
     */
    private function selectProduct()
    {
       $this->resp->result = 0;
       $AuthUser = $this->getVariable("AuthUser");
        $ProducerKit = Controller::model("Products");
			$cons = Input::post("cons");
				if ($cons == "1"){					
				$ProducerKit->where("is_active","=", 1)
                 ->orderBy("name","ASC")
                 ->fetchData();
				} else {
				$ProducerKit->where("product_type", "<>", "Painel")
								 ->where("is_active","=", 1)
                 ->orderBy("name","ASC")
                 ->fetchData();
				}
								 
        
        $log = [];
      
        foreach($ProducerKit->getDataAs("Product") as $s){
					$nome = "(" . $s->get("santri_cod") . ") " . $s->get("name");
          $log[] = [
            "name" => $nome,
            "id" => $s->get("id"),
						"datasheet" => $s->get("datasheet")
          ];
        }
			
      	$this->resp->conta = $AuthUser->get("account_type"); 
        $this->resp->products = $log;       
       	$this->resp->cons = $cons; 
        $this->resp->result = 1;
        
        $this->jsonecho();
    }
	
		/**
     * Save (new|edit) user
     * @return void
     */
    private function selectInversor()
    {
       $this->resp->result = 0;
      
        $ProducerInversor = Controller::model("Products")
								 ->where("product_type", "=", "Inversor")
					       ->where("producer", "=", Input::post("id"))
								 ->where("is_active","=", 1)
                 ->orderBy("name","ASC")
                 ->fetchData();
        
        $log = [];
      
        foreach($ProducerInversor->getDataAs("Product") as $s){
          $nome = "(" . $s->get("santri_cod") . ") " . $s->get("name") ;
					$log[] = [
            "name" => $nome,
            "id" => $s->get("id")
          ];
        }
      
        $this->resp->productsInversor = $log;       
       
        $this->resp->result = 1;
        
        $this->jsonecho();
    }
	
		/**
     * Save (new|edit) user
     * @return void
     */
    private function selectKitdeFixacao()
    {
       $this->resp->result = 0;
      
        $ProducerKitFix = Controller::model("Products")
								 ->where("product_type", "=", "Kit de Fixação")
								 ->where("product_model", "=", Input::post("model"))
					       ->where("producer", "=", Input::post("producer"))
								 ->where("is_active","=", 1)
                 ->orderBy("name","ASC")
                 ->fetchData();
        
        $log = [];
      
        foreach($ProducerKitFix->getDataAs("Product") as $s){
	
					$nome = "(" . $s->get("santri_cod") . ") " . $s->get("name");
          $log[] = [
            "name" => $nome,
            "id" => $s->get("id")
          ];
        }
      
        $this->resp->producerKitFix = $log;       
       
        $this->resp->result = 1;
        
        $this->jsonecho();
    }
	
	
	
	
	
	
	
	
	
	    private function selectTC()
    {
       $this->resp->result = 0;
      
        $ProducerTCS = Controller::model("Products")
								 ->where("product_type", "=", "Suporte")
					       ->where("producer", "=", "ENPHASE")
								 ->where("is_active","=", 1)
                 ->orderBy("name","ASC")
                 ->fetchData();
        
        $TCS = [];
      
        foreach($ProducerTCS->getDataAs("Product") as $s){
					$nome = "(" . $s->get("santri_cod") . ") " . $s->get("name");
          $TCS[] = [
            "name" => $nome,
            "id" => $s->get("id"),
						"type" => $s->get("product_type")
          ];
        }
      
        $this->resp->TCS = $TCS;       
       
        $this->resp->result = 1;
        
        $this->jsonecho();
    }
	
	
		    private function selectAcoplador()
    {
       $this->resp->result = 0;
      
        $ProducerTCS = Controller::model("Products")
					       ->where("producer", "=", "LEGRAND")
								 ->where("is_active","=", 1)
                 ->orderBy("name","ASC")
                 ->fetchData();
        
        $acoplador = [];
      
        foreach($ProducerTCS->getDataAs("Product") as $s){
					$nome = "(" . $s->get("santri_cod") . ") " . $s->get("name");
          $acoplador[] = [
            "name" => $nome,
            "id" => $s->get("id"),
						"type" => $s->get("product_type")
          ];
        }
      
        $this->resp->acoplador = $acoplador;       
       
        $this->resp->result = 1;
        
        $this->jsonecho();
    }
	
	
			    private function selectConectores()
    {
       $this->resp->result = 0;
      $AuthUser = $this->getVariable("AuthUser");
					
        $ProducerTCS = Controller::model("Products")
					       ->where("producer", "=", "ENPHASE")
								 ->where("is_active","=", 1)
                 ->orderBy("name","ASC")
                 ->fetchData();
        
        $caboTronco = [];
				$conectorMacho = [];
			  $conectorFemea = [];
      
        foreach($ProducerTCS->getDataAs("Product") as $i){
					
					 if(strpos($i->get("name"), 'CABO TRONCO') !== false ){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$caboTronco[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					 
					}else  if(strpos($i->get("name"), 'CONECTOR MACHO') !== false ){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$conectorMacho[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					}else if(strpos($i->get("name"), 'CONECTOR FEMEA') !== false ){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$conectorFemea[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					}
					
					
					
// 					$nome = "(" . $s->get("santri_cod") . ") " . $s->get("name");
//           $TCS[] = [
//             "name" => $nome,
//             "id" => $s->get("id")
//           ];
        }
            	
				$this->resp->conta = $AuthUser->get("account_type");
        $this->resp->tronco = $caboTronco;
				$this->resp->macho = $conectorMacho;
				$this->resp->femea = $conectorFemea;
					
					//$this->resp->ff = $TipoRede;  
       
        $this->resp->result = 1;
        
        $this->jsonecho();
    }
	
	
	
	
		    private function selectGateway()
    {
       $this->resp->result = 0;
      
				$TipoRede = Input::post("tensao");
				$fases = Input::post("fases");
				$medir = Input::post("medir");
					
					
					
        $ProducerTCS = Controller::model("Products")
					       ->where("product_type", "=", "GATEWAY")
								 ->where("is_active","=", 1)
                 ->orderBy("name","ASC")
                 ->fetchData();
        
        $tipoRede = [];
      
        foreach($ProducerTCS->getDataAs("Product") as $i){
					
					
					
					
					 if(strpos($i->get("name"), 'AM1-230-60') !== false && ( $TipoRede == '1' || $TipoRede == '2' || $TipoRede == '5' ) ){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$tipoRede[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					}else  if(strpos($i->get("name"), 'AM3-3P') !== false &&  $TipoRede == '3'   ){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$tipoRede[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					}else if(strpos($i->get("name"), 'AM1-240') !== false &&  $TipoRede == '4'   ){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$tipoRede[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					}
					
					
					
// 					$nome = "(" . $s->get("santri_cod") . ") " . $s->get("name");
//           $TCS[] = [
//             "name" => $nome,
//             "id" => $s->get("id")
//           ];
        }
      
        $this->resp->gateway = $tipoRede;  
					
					$this->resp->ff = $TipoRede;  
       
        $this->resp->result = 1;
        
        $this->jsonecho();
    }
	
	
		/**
     * Save (new|edit) user
     * @return void
     */
     private function selectCabo()
    {
       $this->resp->result = 0;		
			 
			 $QuantidadePainel = (int)Input::post("painel");
      
       $ProducerCabo = Controller::model("Products");
			 $ProducerCabo->where(DB::raw("(product_type = 'Cabo Positivo' OR product_type = 'Cabo Negativo') AND producer = '" . Input::post("id") . "' AND is_active = '1'"))
                    ->orderBy("name","ASC")
                    ->fetchData();
         
        $log = [];
      
        foreach($ProducerCabo->getDataAs("Product") as $s){
					
					if ($s->get("producer") == "REICON"){							

						if ($QuantidadePainel < 25) {
							$mpptCabo = 50;								
						} else if ($QuantidadePainel >= 25 && $QuantidadePainel <= 36){
							$mpptCabo = 70;							
						} else if ($QuantidadePainel >= 37 && $QuantidadePainel <= 75){
							$mpptCabo = 100;							
						} else if ($QuantidadePainel >= 76 && $QuantidadePainel <= 100){
							$mpptCabo = 150;							
						} else if ($QuantidadePainel > 100){
							$mpptCabo = 300;							
						} 

						if ($mpptCabo != $s->get("finance.mppt")){
							continue;
						}

					}
					
          $nome = "(" . $s->get("santri_cod") . ") " . $s->get("name");
					
					if ($s->get("product_type") == "Cabo Positivo"){
						$log1[] = [
							"name" => $nome,
							"id" => $s->get("id")
          	];
					} else {
						$log2[] = [
            "name" => $nome,
            "id" => $s->get("id")
          ];
					}					
        }
      
        $this->resp->productsCaboPositivo = $log1;       
       	$this->resp->productsCaboNegativo = $log2;
        $this->resp->result = 1;
        
        $this->jsonecho();
    }
	
		/**
     * Save (new|edit) user
     * @return void
     */
    function InfoProduto($id)
    {
      $InfoProduto = Controller::model("Product", $id);
      
      return $InfoProduto;
    }
  
    /**
     * Save (new|edit) user
     * @return void
     */
    private function selectKit()
    {
        $this->resp->result = 0;
				$AuthUser = $this->getVariable("AuthUser");
      	$model = Input::post("model");
				$producerInversor = Input::post("producerInversor");
				$producerKit = Input::post("producerKit");
				$producerCabo = Input::post("producerCabo");
			  $TipoRede = Input::post("TipoRede");
			
			
			     if($producerInversor == "ENPHASE"){
				
						 
						 
						 
						 
				$Kits = Controller::model("Products");			
			
				$Kits->where("is_active","=", 1)
						 ->where("producer","=",$producerKit)
						 ->where("product_type","=","Kit de Fixação")
						 ->where("product_model","=",$model)
						 ->orderBy("name","ASC")
						 ->fetchData();			
				
				$Inversor = Controller::model("Products");			
			
				$Inversor->where("is_active","=", 1)
								 ->where("producer","=",$producerInversor)
								 ->where("product_type","=","Inversor")								 
								 ->orderBy("name","ASC")
								 ->fetchData();
			
				$Trilhos = Controller::model("Products");			
			
				$Trilhos->where("is_active","=", 1)
						 ->where("producer","=",$producerKit)
						 ->where("product_type","=","Trilho")					
						 ->orderBy("name","ASC")
						 ->fetchData();
			
				$CabosP = Controller::model("Products");			
			
				$CabosP->where("is_active","=", 1)
						 ->where("producer","=", $producerCabo)
						 ->where("product_type","=","Cabo Positivo")					
						 ->orderBy("name","ASC")
						 ->fetchData();
			
				$CabosN = Controller::model("Products");			
			
				$CabosN->where("is_active","=", 1)
						 ->where("producer","=", $producerCabo)
						 ->where("product_type","=","Cabo Negativo")					
						 ->orderBy("name","ASC")
						 ->fetchData();
			
				$Produtos = Controller::model("Products");			
			
				$Produtos->where("is_active","=", 1)								 
								 ->where("product_type","<>","Inversor")
								 ->where("product_type","<>","Kit de Fixação")
								 ->orderBy("name","ASC")
								 ->fetchData();
			
        
        $Inv = [];
				$Kit = [];
				$caboQ = [];
			  $caboTerm = [];		
			  $conectorFemea = [];		
				$conectorMacho = [];	
				$caboPP = [];	
				$acoplador = [];	
			  $tipoRede = [];
				$TCS = [];		 
				$Trilho = [];
				$CaboA = [];
				$CaboB = [];			
				$Conector = [];
				$Painel = [];
				$Parafuso = [];
						 
	
						 
						 
			
				foreach($Inversor->getDataAs("Product") as $i){
					$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
					$Inv[] = [
						"id" => $i->get("id"),
            "name" => $nome,
            "type" => $i->get("product_type")
          ];
				}
				
				foreach($Kits->getDataAs("Product") as $i){
					$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
					$Kit[] = [
						"id" => $i->get("id"),
            "name" => $nome,
            "type" => $i->get("product_type")
          ];
				}
			
				foreach($Trilhos->getDataAs("Product") as $i){
					$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
					$Trilho[] = [
						"id" => $i->get("id"),
            "name" => $nome,
            "type" => $i->get("product_type")
          ];
				}
			
				foreach($CabosP->getDataAs("Product") as $i){						
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$CaboA[] = [
						"id" => $i->get("id"),
						"name" => $nome,
						"type" => $i->get("product_type")
						];					
				}
			
				foreach($CabosN->getDataAs("Product") as $i){						
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$CaboB[] = [
						"id" => $i->get("id"),
						"name" => $nome,
						"type" => $i->get("product_type")
						];					
				}
			
	  
				foreach($Produtos->getDataAs("Product") as $i){
					
					if(strpos($i->get("name"), 'CABO TRONCO') !== false){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$caboQ[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					} else if(strpos($i->get("name"), 'Q-TERM') !== false){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$caboTerm[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					} else if(strpos($i->get("name"), 'MARTELO') !== false){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$Parafuso[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					}  else if(strpos($i->get("name"), 'CONECTOR FEMEA') !== false){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$conectorFemea[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					} else if(strpos($i->get("name"), 'CONECTOR MACHO') !== false){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$conectorMacho[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					} else if(strpos($i->get("name"), 'CABO PP') !== false){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$caboPP[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					}else if(strpos($i->get("name"), 'ACOPLADOR TRIFASICO') !== false){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$acoplador[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					}else if(strpos($i->get("name"), 'AM1-230-60') !== false && ( $TipoRede == '1' || $TipoRede == '2' || $TipoRede == '5' ) ){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$tipoRede[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					}else  if(strpos($i->get("name"), 'AM3-3P') !== false &&  $TipoRede == '3'   ){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$tipoRede[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					}else if(strpos($i->get("name"), 'AM1-240') !== false &&  $TipoRede == '4'   ){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$tipoRede[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					}else if(strpos($i->get("name"), 'CT-200-SPLIT') !== false  ){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$TCS[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					} else if ($i->get("product_type") == "Conectores MC4"){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$Conector[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					}	else if ($i->get("product_type") == "Painel"){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$Painel[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					}			
				}
      	
				$this->resp->conta = $AuthUser->get("account_type");
				$this->resp->producerKit = $producerKit;
				$this->resp->Kit = $Painel;
				$this->resp->KitFix = $Kit;
        $this->resp->Inversor = $Inv;        
       	$this->resp->Trilho = $Trilho;
				$this->resp->caboQ = $caboQ;
				$this->resp->conectorMacho = $conectorMacho;
				$this->resp->conectorFemea = $conectorFemea;
				$this->resp->parafuso = $Parafuso;		 
				$this->resp->caboPP = $caboPP;
				$this->resp->acoplador = $acoplador;
				$this->resp->gateway = $tipoRede;
				$this->resp->caboTerm = $caboTerm;
				$this->resp->TCS =	$TCS;
				$this->resp->CaboA = $CaboA;
			  $this->resp->CaboB = $CaboB;
				$this->resp->Conectores = $Conector;
        $this->resp->result = 1;
						 
						 
						 
			
				 } else{
						 
					
				$Kits = Controller::model("Products");			
			
				$Kits->where("is_active","=", 1)
						 ->where("producer","=",$producerKit)
						 ->where("product_type","=","Kit de Fixação")
						 ->where("product_model","=",$model)
						 ->orderBy("name","ASC")
						 ->fetchData();			
				
				$Inversor = Controller::model("Products");			
			
				$Inversor->where("is_active","=", 1)
								 ->where("producer","=",$producerInversor)
								 ->where("product_type","=","Inversor")								 
								 ->orderBy("name","ASC")
								 ->fetchData();
			
				$Trilhos = Controller::model("Products");			
			
				$Trilhos->where("is_active","=", 1)
						 ->where("producer","=",$producerKit)
						 ->where("product_type","=","Trilho")					
						 ->orderBy("name","ASC")
						 ->fetchData();
			
				$CabosP = Controller::model("Products");			
			
				$CabosP->where("is_active","=", 1)
						 ->where("producer","=", $producerCabo)
						 ->where("product_type","=","Cabo Positivo")					
						 ->orderBy("name","ASC")
						 ->fetchData();
			
				$CabosN = Controller::model("Products");			
			
				$CabosN->where("is_active","=", 1)
						 ->where("producer","=", $producerCabo)
						 ->where("product_type","=","Cabo Negativo")					
						 ->orderBy("name","ASC")
						 ->fetchData();
			
				$Produtos = Controller::model("Products");			
			
				$Produtos->where("is_active","=", 1)								 
								 ->where("product_type","<>","Inversor")
								 ->where("product_type","<>","Kit de Fixação")
								 ->orderBy("name","ASC")
								 ->fetchData();
			
        
        $Inv = [];
				$Kit = [];
				$String = [];
				$Trilho = [];
				$CaboA = [];
				$CaboB = [];			
				$Conector = [];
				$Painel = [];
			
				foreach($Inversor->getDataAs("Product") as $i){
					$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
					$Inv[] = [
						"id" => $i->get("id"),
            "name" => $nome,
            "type" => $i->get("product_type")
          ];
				}
				
				foreach($Kits->getDataAs("Product") as $i){
					$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
					$Kit[] = [
						"id" => $i->get("id"),
            "name" => $nome,
            "type" => $i->get("product_type")
          ];
				}
			
				foreach($Trilhos->getDataAs("Product") as $i){
					$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
					$Trilho[] = [
						"id" => $i->get("id"),
            "name" => $nome,
            "type" => $i->get("product_type")
          ];
				}
			
				foreach($CabosP->getDataAs("Product") as $i){						
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$CaboA[] = [
						"id" => $i->get("id"),
						"name" => $nome,
						"type" => $i->get("product_type")
						];					
				}
			
				foreach($CabosN->getDataAs("Product") as $i){						
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$CaboB[] = [
						"id" => $i->get("id"),
						"name" => $nome,
						"type" => $i->get("product_type")
						];					
				}
			
	  
				foreach($Produtos->getDataAs("Product") as $i){
					if ($i->get("product_type") == "String Box"){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$String[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					} else if ($i->get("product_type") == "Conectores MC4"){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$Conector[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					}	else if ($i->get("product_type") == "Painel"){
						$nome = "(" . $i->get("santri_cod") . ") " . $i->get("name");
						$Painel[] = [
							"id" => $i->get("id"),
							"name" => $nome,
							"type" => $i->get("product_type")
          	];
					}			
				}
      	
				$this->resp->conta = $AuthUser->get("account_type");
				$this->resp->producerKit = $producerKit;
				$this->resp->Kit = $Painel;
				$this->resp->KitFix = $Kit;
        $this->resp->Inversor = $Inv;        
       	$this->resp->Trilho = $Trilho;
				$this->resp->String = $String;
				$this->resp->CaboA = $CaboA;
			  $this->resp->CaboB = $CaboB;
				$this->resp->Conectores = $Conector;
        $this->resp->result = 1;	 
						 
						 
						 
					 }
			
			
			
			
			
			
			
			
        
        $this->jsonecho();
    }


    /**
     * Save (new|edit) user
     * @return void
     */
    private function save()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
        $Order = $this->getVariable("User");

        // Check if this is new or not
        $is_new = !$Order->isAvailable();	
			
				$Frete =  Controller::model("Frete");
				$Frete->select($Order->get("order_id"));

				if ($Frete->isAvailable()){
					$this->resp->frete = 1;
					$this->jsonecho();
				}  
				
        // Check required fields
        $required_fields = ["status", "client", "typeOrder", "modelType", "producerKit", "producerInversor", "ufFrete", "paymentMode", "products"];

        foreach ($required_fields as $field) {
            if (!Input::post($field)) {
                $this->resp->msg = __("Preencha todos os campos obrigatórios");
                $this->jsonecho();
            }
        }
			
			 $MargemLucro = preg_replace('#[^0-9\.,]#', '', Input::post("margemLucro"));
			 $MargemLucro = str_replace(',', '.', $MargemLucro);
      	
			 if ($AuthUser->get("account_type") == "supervisor" && $MargemLucro < 12){
				 $this->resp->block = 1;
				 $this->jsonecho();
			 }
			
        if ($is_new){
          $version = "1";
          $Orders = Controller::model("Orders") 
                   ->limit(1)
                   ->orderBy("id","DESC")
                   ->fetchData(); 
          
        $orderId = [];
      	
        foreach($Orders->getDataAs("Order") as $s){
          $orderId = $s->get("order_id") + 1;				
					break;
        } 
          
        } else {
          $version = $Order->get("version") + 1;
          $orderId = $Order->get("order_id");
        }

             
       $Client = Controller::model("Cliente", Input::post("client"));
       $Vendor = Controller::model("User", Input::post("seller"));
       $Pagamento = Controller::model("Payment", Input::post("paymentMode"));
			
       $Cliente[] = [
         "id" => $Client->get("id"),
				 "cod_santri" => $Client->get("cod_santri"),
         "name" => $Client->get("name"),
         "cnpj" => $Client->get("cnpj"),
         "uf" => $Client->get("uf"),
				 "address" => $Client->get("address"),
				 "bairro" => $Client->get("bairro"),
         "type" => $Client->get("client_type"),
				 "city" => $Client->get("city"),
				 "cep" => $Client->get("cep"),
				 "phone" => $Client->get("phone")
       ];
      
       $Vendedor[] = [
         "id" => $Vendor->get("id"),
         "name" => $Vendor->get("firstname") . " " . $Vendor->get("lastname"),
         "phone" => $Vendor->get("phone"),
         "email" => $Vendor->get("email")        
       ];
      
       $PaymentDetails[] = [         
         "paymentTerms" => Input::post("paymentMode"),
				 "paymentName" => $Pagamento->get("name"),
         "typeOrder" => Input::post("typeOrder")      			 
       ];
      
       $ProductDetails[] = [       
         "modelType" => Input::post("modelType"),
         "producerKit" => Input::post("producerKit"),
         "producerInversor" => Input::post("producerInversor"),
				 "producerCabo" => Input::post("producerCabo"),
				 "tensao" => Input::post("tensao"),
				 "medir" => Input::post("medir"),
				 "medir_cc" => Input::post("medir_cc"),
				 "fases" => Input::post("fases"),
				 "kwpReal" => Input::post("kwpReal")
       ];
			
			$TotalUnit = preg_replace('#[^0-9\.,]#', '',Input::post("totalUnitField"));
			$TotalUnit = str_replace('.', '',$TotalUnit);
			$TotalUnit = str_replace(',', '.',$TotalUnit);
			
			$TotalTotal = preg_replace('#[^0-9\.,]#', '',Input::post("totalTotalField"));
			$TotalTotal = str_replace('.', '',$TotalTotal);
			$TotalTotal = str_replace(',', '.',$TotalTotal);
			
			$MargemLucro = preg_replace('#[^0-9\.,]#', '', Input::post("margemLucro"));
			$MargemLucro = str_replace(',', '.', $MargemLucro);	
      
      $ComissaoLiquida = preg_replace('#[^0-9\.,]#', '', Input::post("comissaoLiquida"));
			$ComissaoLiquida = str_replace(',', '.', $ComissaoLiquida);	
      
      $MargemLucroProduto = preg_replace('#[^0-9\.,]#', '', Input::post("margemLucroProdutoReal"));
			$MargemLucroProduto = str_replace(',', '.', $MargemLucroProduto);	
      
      $PrecoTotalSemComissao= preg_replace("/[^0-9]/","", Input::post("preco_total_sem_comissao"));
      $PrecoTotalSemComissao = $PrecoTotalSemComissao / 100;
			$PrecoTotalSemComissao = str_replace(',', '.', $PrecoTotalSemComissao);	
			
			$Desconto = preg_replace('#[^0-9\.,]#', '',Input::post("desconto"));
			$Desconto = str_replace(',', '.',$Desconto);
			
			
			$PriceTotal[] = [       
         "totalUnit" => $TotalUnit,         
         "totalTotal" => $TotalTotal,
				 "margemLucro" => $MargemLucro,
         "margemLucroProduto" => $MargemLucroProduto,
         "precoRealProdutos" =>  $PrecoTotalSemComissao,
				 "desconto" => $Desconto
       ];		
      
       $Products = Input::post("products");
			 $PrazoEntregaReal = 0;
       $Product = [];
       foreach ($Products as $p) {	
				 
				 $Produc = Controller::model("Product", $p['id']);
				 $Garantia = $Produc->get("garantia");
				 $PrazoEntrega = $Produc->get("prazo_entrega");
				 $Type = $Produc->get("product_type");
				 $Producer = $Produc->get("producer");
				 
				 if ($PrazoEntregaReal < $PrazoEntrega){
					 $PrazoEntregaReal = $PrazoEntrega;
				 }
				 
          $Product[] = [
						"id" => $p['id'],
						"type" => $Type,
            "product" => $p['product'],
						"prazo_entrega" => $PrazoEntrega,
            "quantidade" => $p['quantidade'],
						"garantia" => $Garantia,
						"producer" => $Producer,
            "price" => $p['price'],
						"margem_lucro" => $p['margemLucro'], 
            "priceTotal" => $p['priceTotal']
          ];					
				}
        
       $Cliente = json_encode($Cliente,JSON_UNESCAPED_UNICODE);
       $Vendedor = json_encode($Vendedor,JSON_UNESCAPED_UNICODE);
       $PaymentDetails = json_encode($PaymentDetails,JSON_UNESCAPED_UNICODE);
			 $PriceTotal = json_encode($PriceTotal,JSON_UNESCAPED_UNICODE);
       $ProductDetails = json_encode($ProductDetails,JSON_UNESCAPED_UNICODE);      
       $Product = json_encode($Product);
      	
				if (Input::post("renew") == 1){
					$Data = date('y-m-d');
					$Order->set("expirate_date", $Data);
				}
			  $santri = Input::post("santri");
       // Start setting data
       $Order->set("status", Input::post("status"))
            ->set("version", $version)
            ->set("order_id", $orderId)
            ->set("santri_id", $santri)
            ->set("client", $Cliente)
            ->set("seller", $Vendedor)
				 		->set("responsavel", $Vendor->get("id"))
				 		->set("loja_responsavel", $Vendor->get("office"))
            ->set("branch", Input::post("branch"))
				 		->set("destiny", Input::post("ufClient"))
				 		->set("uf_frete", Input::post("ufFrete"))
            ->set("payment_details", $PaymentDetails)
				 		->set("order_description", Input::post("description"))
			    	->set("descriptionP", Input::post("descriptionP"))
				 		->set("order_value", $PriceTotal)
				 		->set("prazo_entrega", $PrazoEntregaReal)
				    ->set("comissao", Input::post("comissao"))
            ->set("comissao_liquida",$ComissaoLiquida) 
            ->set("margem_real", $MargemLucroProduto) 
				    ->set("comissao_active", Input::post("comissaoActive"))
            ->set("product_details", $ProductDetails)
            ->set("products_order", $Product)      
            ->set("power", Input::post("power"))				 		
            ->set("owner", $AuthUser->get("id"));            

       try {
        $Order->save();
          
        $this->logs($AuthUser->get("id"), "success","Orçamento","Orçamento Nº <b>" .$orderId ."</b>  - Cliente: <b>" . $Client->get("name") . "</b> - Vendedor: <b>" . $Vendor->get("firstname") . "</b> - Detalhes de Pagamento: <b>".$Pagamento->get("name") . "</b> - Comissão: <b>". Input::post("comissao") ."</b> - Valor Total: <b>".$TotalTotal."</b> salvo com sucesso");  
        } catch (Exception $e){
        $this->logs($AuthUser->get("id"), "error","Orçamento","Erro ao modificar o Orçamento nº: ".$orderId.".<br/>" .$e);
        }  
			
				       
        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Orçamento cadastrado com sucesso! Por favor, recarregue a página.");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }
	
	
	  private function saveRascunho()
    {
        $this->resp->result = 0;
				$Route = $this->getVariable("Route");
				$Order = Controller::model("Rascunho");

			 if (isset($Route->params->id)) {
				$id = $Route->params->id;
					} else {
			  $id = Input::post("id");		
					}
				$Order->select($id,"id");
        $AuthUser = $this->getVariable("AuthUser");
      

        // Check if this is new or not
        $is_new = !$Order->isAvailable();	
			
				$Frete =  Controller::model("Frete");
				$Frete->select($Order->get("order_id"));

				if ($Frete->isAvailable()){
					$this->resp->frete = 1;
					$this->jsonecho();
				}  
				

			
			 $MargemLucro = preg_replace('#[^0-9\.,]#', '', Input::post("margemLucro"));
			 $MargemLucro = str_replace(',', '.', $MargemLucro);
      	
			 if ($AuthUser->get("account_type") == "supervisor" && $MargemLucro < 12){
				 $this->resp->block = 1;
				 $this->jsonecho();
			 }
			
        if ($is_new){
          $version = "1";
          $Orders = Controller::model("Rascunhos") 
                   ->limit(1)
                   ->orderBy("id","DESC")
                   ->fetchData(); 
          
        $orderId = [];
      	
        foreach($Orders->getDataAs("Rascunho") as $s){
          $orderId = $s->get("order_id") + 1;		
					break;				
        } 
          
        } else {
          $version = $Order->get("version") + 1;
          $orderId = $Order->get("order_id");
        }

             
       $Client = Controller::model("Cliente", Input::post("client"));
       $Vendor = Controller::model("User", Input::post("seller"));
       $Pagamento = Controller::model("Payment", Input::post("paymentMode"));
			
       $Cliente[] = [
         "id" => $Client->get("id"),
				 "cod_santri" => $Client->get("cod_santri"),
         "name" => $Client->get("name"),
         "cnpj" => $Client->get("cnpj"),
         "uf" => $Client->get("uf"),
				 "address" => $Client->get("address"),
				 "bairro" => $Client->get("bairro"),
         "type" => $Client->get("client_type"),
				 "city" => $Client->get("city"),
				 "cep" => $Client->get("cep"),
				 "phone" => $Client->get("phone")
       ];
      
       $Vendedor[] = [
         "id" => $Vendor->get("id"),
         "name" => $Vendor->get("firstname") . " " . $Vendor->get("lastname"),
         "phone" => $Vendor->get("phone"),
         "email" => $Vendor->get("email")        
       ];
      
       $PaymentDetails[] = [         
         "paymentTerms" => Input::post("paymentMode"),
				 "paymentName" => $Pagamento->get("name"),
         "typeOrder" => Input::post("typeOrder")      			 
       ];
      
       $ProductDetails[] = [       
         "modelType" => Input::post("modelType"),
         "producerKit" => Input::post("producerKit"),
         "producerInversor" => Input::post("producerInversor"),
				 "producerCabo" => Input::post("producerCabo"),
				 "tensao" => Input::post("tensao"),
				 "medir_cc" => Input::post("medir_cc"),
				 "medir" => Input::post("medir"),
				 "fases" => Input::post("fases"),
				 "kwpReal" => Input::post("kwpReal")
       ];
			
			$TotalUnit = preg_replace('#[^0-9\.,]#', '',Input::post("totalUnitField"));
			$TotalUnit = str_replace('.', '',$TotalUnit);
			$TotalUnit = str_replace(',', '.',$TotalUnit);
			
			$TotalTotal = preg_replace('#[^0-9\.,]#', '',Input::post("totalTotalField"));
			$TotalTotal = str_replace('.', '',$TotalTotal);
			$TotalTotal = str_replace(',', '.',$TotalTotal);
			
			$MargemLucro = preg_replace('#[^0-9\.,]#', '', Input::post("margemLucro"));
			 $MargemLucro = str_replace(',', '.', $MargemLucro);	
      
      $ComissaoLiquida = preg_replace('#[^0-9\.,]#', '', Input::post("comissaoLiquida"));
			$ComissaoLiquida = str_replace(',', '.', $ComissaoLiquida);	
      
       $PrecoTotalSemComissao= preg_replace("/[^0-9]/","", Input::post("preco_total_sem_comissao"));
      $PrecoTotalSemComissao = $PrecoTotalSemComissao / 100;
			$PrecoTotalSemComissao = str_replace(',', '.', $PrecoTotalSemComissao);	
      
      $MargemLucroProduto = preg_replace('#[^0-9\.,]#', '', Input::post("margemLucroProdutoReal"));
			$MargemLucroProduto = str_replace(',', '.', $MargemLucroProduto);
			
			$Desconto = preg_replace('#[^0-9\.,]#', '',Input::post("desconto"));
			$Desconto = str_replace(',', '.',$Desconto);
			
			
			$PriceTotal[] = [       
         "totalUnit" => $TotalUnit,         
         "totalTotal" => $TotalTotal,
				 "margemLucro" => $MargemLucro,
         "margemLucroProduto" => $MargemLucroProduto,
         "precoRealProdutos" =>  $PrecoTotalSemComissao,
				 "desconto" => $Desconto
       ];		
      
       $Products = Input::post("products");
			 $PrazoEntregaReal = 0;
       $Product = [];
       foreach ($Products as $p) {	
				 
				 $Produc = Controller::model("Product", $p['id']);
				 $Garantia = $Produc->get("garantia");
				 $PrazoEntrega = $Produc->get("prazo_entrega");
				 $Type = $Produc->get("product_type");
				 $Producer = $Produc->get("producer");
				 
				 if ($PrazoEntregaReal < $PrazoEntrega){
					 $PrazoEntregaReal = $PrazoEntrega;
				 }
				 
          $Product[] = [
						"id" => $p['id'],
						"type" => $Type,
            "product" => $p['product'],
						"prazo_entrega" => $PrazoEntrega,
            "quantidade" => $p['quantidade'],
						"garantia" => $Garantia,
						"producer" => $Producer,
            "price" => $p['price'],
						"margem_lucro" => $p['margemLucro'], 
            "priceTotal" => $p['priceTotal']
          ];					
				}
        
       $Cliente = json_encode($Cliente,JSON_UNESCAPED_UNICODE);
       $Vendedor = json_encode($Vendedor,JSON_UNESCAPED_UNICODE);
       $PaymentDetails = json_encode($PaymentDetails,JSON_UNESCAPED_UNICODE);
			 $PriceTotal = json_encode($PriceTotal,JSON_UNESCAPED_UNICODE);
       $ProductDetails = json_encode($ProductDetails,JSON_UNESCAPED_UNICODE);      
       $Product = json_encode($Product);
      	
				if (Input::post("renew") == 1){
					$Data = date('y-m-d');
					$Order->set("expirate_date", $Data);
				}
			  $santri = Input::post("santri");
       // Start setting data
       $Order->set("status", Input::post("status"))
            ->set("version", $version)
            ->set("order_id", $orderId)
            ->set("santri_id", $santri)
            ->set("client", $Cliente)
            ->set("seller", $Vendedor)
				 		->set("responsavel", $AuthUser->get("id"))
				 		->set("loja_responsavel", $AuthUser->get("office"))
            ->set("branch", Input::post("branch"))
				 		->set("destiny", Input::post("ufClient"))
				 		->set("uf_frete", Input::post("ufFrete"))
            ->set("payment_details", $PaymentDetails)
				 		->set("order_description", Input::post("description"))
				    ->set("descriptionP", Input::post("descriptionP"))
				 		->set("order_value", $PriceTotal)
				 		->set("prazo_entrega", $PrazoEntregaReal)
				    ->set("comissao", Input::post("comissao")) 
            ->set("comissao_liquida",$ComissaoLiquida) 
            ->set("margem_real", $MargemLucroProduto) 
				    ->set("comissao_active", Input::post("comissaoActive"))
            ->set("product_details", $ProductDetails)
            ->set("products_order", $Product)      
            ->set("power", Input::post("power"))				 		
            ->set("owner", $AuthUser->get("id"));              

       try {
        $Order->save();
          
        $this->logs($AuthUser->get("id"), "success","Orçamento","Orçamento Nº <b>" .$orderId ."</b>  - Cliente: <b>" . $Client->get("name") . "</b> - Vendedor: <b>" . $Vendor->get("firstname") ."</b><br/> Detalhes de Pagamento: <b>".$Pagamento->get("name") . "</b> - Comissão: <b>". Input::post("comissao") ."</b><br/> Valor Total: <b>".$TotalTotal."</b> salvo com sucesso");  
        } catch (Exception $e){
        $this->logs($AuthUser->get("id"), "error","Orçamento","Erro ao modificar o Orçamento nº: ".$orderId.".<br/>" .$e);
        }  
			
				       
        $this->resp->result = 1;
				$this->resp->id = $Order->get("id");
        if ($is_new) {
            $this->resp->msg = __("Orçamento cadastrado com sucesso! Por favor, recarregue a página.");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }
	
	
	/**
     * Save (new|edit) user
     * @return void
     */
    private function copyOrder()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
        $Order = Controller::model("Order");
				
        // Check required fields
        $required_fields = ["client", "typeOrder", "modelType", "producerKit", "producerInversor", "ufFrete", "paymentMode", "products"];

        foreach ($required_fields as $field) {
            if (!Input::post($field)) {
                $this->resp->msg = __("Preencha todos os campos obrigatórios");
                $this->jsonecho();
            }
        }
			
			 $MargemLucro = preg_replace('#[^0-9\.,]#', '', Input::post("margemLucro"));
			 $MargemLucro = str_replace(',', '.', $MargemLucro);
      	
			 if ($AuthUser->get("account_type") == "supervisor" && $MargemLucro < 12){
				 $this->resp->block = 1;
				 $this->jsonecho();
			 }
			
        
          $version = "1";
          $Orders = Controller::model("Orders") 
                   ->limit(1)
                   ->orderBy("id","DESC")
                   ->fetchData(); 
          
        $orderId = [];
      	
        foreach($Orders->getDataAs("Order") as $s){
          $orderId = $s->get("order_id") + 1;		
					break;
        } 

             
       $Client = Controller::model("Cliente", Input::post("client"));
       $Vendor = Controller::model("User", Input::post("seller"));
       $Pagamento = Controller::model("Payment", Input::post("paymentMode"));
			
       $Cliente[] = [
         "id" => $Client->get("id"),
         "cod_santri" => $Client->get("cod_santri"),
         "name" => $Client->get("name"),
         "cnpj" => $Client->get("cnpj"),
         "uf" => $Client->get("uf"),
				 "address" => $Client->get("address"),
				 "bairro" => $Client->get("bairro"),
         "type" => $Client->get("client_type"),
				 "city" => $Client->get("city"),
				 "cep" => $Client->get("cep"),
				 "phone" => $Client->get("phone")
       ];
      
       $Vendedor[] = [
         "id" => $Vendor->get("id"),
         "name" => $Vendor->get("firstname") . " " . $Vendor->get("lastname"),
         "phone" => $Vendor->get("phone"),
         "email" => $Vendor->get("email")        
       ];
      
       $PaymentDetails[] = [         
         "paymentTerms" => Input::post("paymentMode"),
				 "paymentName" => $Pagamento->get("name"),
         "typeOrder" => Input::post("typeOrder")      			 
       ];
      
       $ProductDetails[] = [       
         "modelType" => Input::post("modelType"),
         "producerKit" => Input::post("producerKit"),
         "producerInversor" => Input::post("producerInversor"),
				 "tensao" => Input::post("tensao"),
				 "medir" => Input::post("medir"),
				 "medir_cc" => Input::post("medir_cc"),
				 "fases" => Input::post("fases"),
				 "kwpReal" => Input::post("kwpReal")
       ];
			
			$TotalUnit = preg_replace('#[^0-9\.,]#', '',Input::post("totalUnitField"));
			$TotalUnit = str_replace('.', '',$TotalUnit);
			$TotalUnit = str_replace(',', '.',$TotalUnit);
			
			$TotalTotal = preg_replace('#[^0-9\.,]#', '',Input::post("totalTotalField"));
			$TotalTotal = str_replace('.', '',$TotalTotal);
			$TotalTotal = str_replace(',', '.',$TotalTotal);
			
			$MargemLucro = preg_replace('#[^0-9\.,]#', '', Input::post("margemLucro"));
			 $MargemLucro = str_replace(',', '.', $MargemLucro);	
      
      $PrecoTotalSemComissao= preg_replace("/[^0-9]/","", Input::post("preco_total_sem_comissao"));
      $PrecoTotalSemComissao = $PrecoTotalSemComissao / 100;
			$PrecoTotalSemComissao = str_replace(',', '.', $PrecoTotalSemComissao);	  
      
      $ComissaoLiquida = preg_replace('#[^0-9\.,]#', '', Input::post("comissaoLiquida"));
			$ComissaoLiquida = str_replace(',', '.', $ComissaoLiquida);	
      
      $MargemLucroProduto = preg_replace('#[^0-9\.,]#', '', Input::post("margemLucroProdutoReal"));
			$MargemLucroProduto = str_replace(',', '.', $MargemLucroProduto);
			
			$Desconto = preg_replace('#[^0-9\.,]#', '',Input::post("desconto"));
			$Desconto = str_replace(',', '.',$Desconto);
			
			
			$PriceTotal[] = [       
         "totalUnit" => $TotalUnit,         
         "totalTotal" => $TotalTotal,
				 "margemLucro" => $MargemLucro,
         "margemLucroProduto" => $MargemLucroProduto,
         "precoRealProdutos" =>  $PrecoTotalSemComissao,
				 "desconto" => $Desconto
       ];		
      
       $Products = Input::post("products");
			 $PrazoEntregaReal = 0;
       $Product = [];
       foreach ($Products as $p) {	
				 
				 $Produc = Controller::model("Product", $p['id']);
				 $Garantia = $Produc->get("garantia");
				 $PrazoEntrega = $Produc->get("prazo_entrega");
				 $Type = $Produc->get("product_type");
				 $Producer = $Produc->get("producer");
				 
				 if ($PrazoEntregaReal < $PrazoEntrega){
					 $PrazoEntregaReal = $PrazoEntrega;
				 }
				 
          $Product[] = [
						"id" => $p['id'],
						"type" => $Type,
            "product" => $p['product'],
						"prazo_entrega" => $PrazoEntrega,
            "quantidade" => $p['quantidade'],
						"garantia" => $Garantia,
						"producer" => $Producer,
            "price" => $p['price'],
						"margem_lucro" => $p['margemLucro'], 
            "priceTotal" => $p['priceTotal']
          ];					
				}
        
       $Cliente = json_encode($Cliente,JSON_UNESCAPED_UNICODE);
       $Vendedor = json_encode($Vendedor,JSON_UNESCAPED_UNICODE);
       $PaymentDetails = json_encode($PaymentDetails,JSON_UNESCAPED_UNICODE);
			 $PriceTotal = json_encode($PriceTotal,JSON_UNESCAPED_UNICODE);
       $ProductDetails = json_encode($ProductDetails,JSON_UNESCAPED_UNICODE);      
       $Product = json_encode($Product,JSON_UNESCAPED_UNICODE);
      	
				if (Input::post("renew") == 1){
					$Data = date('y-m-d');
					$Order->set("expirate_date", $Data);
				}
			
       // Start setting data
       $Order->set("status", "2")
            ->set("version", $version)
            ->set("order_id", $orderId)
            ->set("client", $Cliente)
            ->set("seller", $Vendedor)
				 		->set("responsavel", $Vendor->get("id"))
				 		->set("loja_responsavel", $Vendor->get("office"))
            ->set("branch", Input::post("branch"))
				 		->set("destiny", Input::post("ufClient"))
				 		->set("uf_frete", Input::post("ufFrete"))
            ->set("payment_details", $PaymentDetails)
				 		->set("order_description", Input::post("description"))
				 		->set("order_value", $PriceTotal)
				 		->set("prazo_entrega", $PrazoEntregaReal)
				    ->set("comissao", Input::post("comissao")) 
            ->set("comissao_liquida",$ComissaoLiquida) 
            ->set("margem_real", $MargemLucroProduto)
				    ->set("comissao_active", Input::post("comissaoActive"))
            ->set("product_details", $ProductDetails)
            ->set("products_order", $Product)      
            ->set("power", Input::post("power"))				 		
            ->set("owner", $AuthUser->get("id"));            

       try {
        $Order->save();
          
        $this->logs($AuthUser->get("id"), "success","Orçamento","Orçamento Nº <b>" .$orderId ."</b>  - Cliente: <b>" . $Client->get("name") . "</b> - Vendedor: <b>" . $Vendor->get("firstname") ."</b><br/> Valor Frete: <b>".$valorFrete."</b> - Detalhes de Pagamento: <b>".$Pagamento->get("name") . "</b> - Comissão: <b>". Input::post("comissao") ."</b><br/> Valor Total: <b>".$TotalTotal."</b> - ... duplicado com sucesso pelo usuário: ". $AuthUser->get("firstname"));  
        } catch (Exception $e){
        $this->logs($AuthUser->get("id"), "error","Orçamento","Erro ao modificar o Orçamento nº: ".$orderId.".<br/>" .$e);
        }  
			  
        $this->resp->result = 1;
      	$this->resp->idOrder = $Order->get("id");
        $this->jsonecho();
    }
	
		    private function removeRascunho()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");

        if (!Input::post("idRascunho")) {
            $this->jsonecho();
        }

        $User = Controller::model("Rascunho", Input::post("idRascunho"));

        if (!$User->isAvailable()) {
            $this->jsonecho();
          }       

        $User->delete();

        $this->resp->result = 1;
        $this->jsonecho();
		exit;			
    }


}
