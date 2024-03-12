<?php
/**
 * User Controller
 */
class RelatorioController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
      
      $AuthUser = $this->getVariable("AuthUser");

        // Auth
        if (!$AuthUser){
          header("Location: ".APPURL."/login");
          exit;
        } else if ($AuthUser->get("is_active") == 0) {
          header("Location: ".APPURL."/aguarde");
          exit;
        } else if($AuthUser->get("start_pw") == 1){
          header("Location: ".APPURL."/novasenha");
        }
		
        if (Input::post("action") == "removeRascunho") {
          $this->remove();
        } else if (Input::post("action") == "desativar") {
          $this->desativar();
        } else if ($_POST['action'] == 'otimizar') {				
					$this->otimizar();
			  } else if (Input::post("action") == 'duplicarOrcamento') {				
					$this->duplicarOrcamento();
			  }
			
				$Usuarios = Controller::model("Users");
				$Usuarios->where(DB::raw("is_active = '1' ")) 
								 ->orderBy("id","DESC")
								 ->fetchData();		
		 $this->setVariable("Usuarios", $Usuarios);
			
			$unidade = Controller::model("Branchs");
			$unidade->orderBy("id","DESC")
							 ->fetchData();		
		 $this->setVariable("unidade", $unidade);	
			
		 if (Input::post("fim") != ""){ 
            $hoje = Input::post("fim");  
        } else {
            $hoje = date('Y-m-d H:m:s');  
        }

         if (Input::post("inicio") != ""){
              $DataPadrao = Input::post("inicio");  
					    
        } else {
              $DataPadrao = date('Y-m-d H:m:s' , strtotime('-5 month'));  
        }	
			
			    $this->setVariable("hoje", $hoje);  
        $this->setVariable("DataPadrao", $DataPadrao);  
      
			
	
			
     $this->view('relatorio');
    }
  
  /**
     * Remove User
     * @return void 
     */
    private function remove()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");

        if (!Input::post("id")) {
            $this->resp->msg = __("ID is requred!");
            $this->jsonecho();
        }

        $User = Controller::model("Order", Input::post("id"));

        if (!$User->isAvailable()) {
            $this->resp->msg = __("Orçamento não encontrado!");
            $this->jsonecho();
          }       

        $User->delete();

        $this->resp->result = 1;
        $this->jsonecho();
    }
	
    private function desativar()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");

        if (!Input::post("id") || !Input::post("textExclusao")) {
            $this->resp->msg = __("Descreva a observação com detalhes!");
            $this->jsonecho();
        }
			
				if (strlen(Input::post("textExclusao")) < 15 ){
					$this->resp->msg = __("A observação precisa ter no mínimo 15 caracteres!");
          $this->jsonecho();
				}

        $User = Controller::model("Order", Input::post("id"));

        if (!$User->isAvailable()) {
            $this->resp->msg = __("Orçamento não encontrado!");
            $this->jsonecho();
          }       
				
				$TextoCompleto = $User->get("order_description") . " - [Observação de Exclusão]: " . Input::post("textExclusao");
        $User->set("order_description", $TextoCompleto);
				$User->set("status", 3);
				try { 
				$User->save();
        $this->logs($AuthUser->get("id"), "success","Orçamentos","Usuário <b>" . $User->get('firstname') . "</b> desativou o orçamento <b>". $User->get("order_id") ."</b> com sucesso");  
        } catch (Exception $e){
        $this->logs($AuthUser->get("id"), "error","Orçamentos","Usuário " .  $User->get('firstname') . " não conseguiu desativar o orçamento ". $User->get("order_id") .". <br/> Erro: " .$e);
        }  
			
        $this->resp->result = 1;
        $this->jsonecho();
    }

	    private function otimizar()
    {			
			header('Content-Type: application/json; charset=utf-8');			
			$AuthUser = $this->getVariable("AuthUser");
		 $dados_requisicao = $_REQUEST;
			$colunas = [
			0 => 'id',
			1 => 'id',
			2 => 'id',
			3 => 'id',
			4 => 'id',
			5 => 'id',
			6 => 'id',	
			7 => 'id',	
			];
			$colun = 'order_id';
			$colun = $colunas[$dados_requisicao['order'][0]['column']];
			$ordenacao = 'DESC';
			$ordenacao = $dados_requisicao['order'][0]['dir'];
				
			$Linhas = (int)$_POST['length'];
			$Start = (int)$_POST['start'];
			$Pagina = ($Start / $Linhas) + 1;
		  $query = "is_active = '1' ";
			$Search = $_POST['search'];
			$Search = $Search['value'];	
			$id_oc = "";
	
			if($Search != null && is_numeric($Search) && $Search >= 3 ){
			$id_oc = $Search;	
			}
		 $idVendedor = Input::post("paramentro1"); 
		 if($idVendedor != "0" ){
			  $query .= " AND id = '$idVendedor' "; 
		 }	
				
		$filial = Input::post("paramentro4"); 
		 if($filial != "0" ){
			  $query .= " AND office = '$filial' "; 
		 }			
				
				
				 if (Input::post("paramentro3") != ""){ 
            $hoje = Input::post("paramentro3");  
        } else {
            $hoje = date('Y-m-d H:m:s');  
        }

         if (Input::post("paramentro2") != ""){
              $DataPadrao = Input::post("paramentro2");  
					    
        } else {
              $DataPadrao = date('Y-m-d H:m:s' , strtotime('-5 month'));  
        }			
				
		
			$idUser = $AuthUser->get("id");
			$Filial = $AuthUser->get("office");
			if($Search != null && !is_numeric($Search)){
			 $NomeBusca =  $Search;
			}	
				
				  $Filial = $AuthUser->get("office");
				  $NivelConta = $AuthUser->get("account_type");
				
				      $Orders = Controller::model("Orders");
							$Orders->fetchData();	
				    foreach($Orders->getDataAs("Order") as $o){
							$arrayUsuarioOrder[] = [
							  $o->get("responsavel"),
							];
						}
				

			      
              $Cotacoes = Controller::model("Users");
							$Cotacoes->search($id_oc)
							         ->where(DB::raw("$query")) 
											 ->setPageSize($Linhas)
											 ->setPage($Pagina)
											 ->orderBy("$colun",$ordenacao)
											 ->fetchData();		
					    $QntCotacoes = $Cotacoes->getTotalCount();
				
				
				
					 
	
			foreach($Cotacoes->getDataAs("User") as $c) {
      $id = $c->get("id");

				$nome = $c->get("firstname");
		$valorProposta =	$this->valorProposta($id,$DataPadrao,$hoje);	
		$valorPropostaAP =	$this->valorPropostaAP($id,$DataPadrao,$hoje);
    $precoPropostas = format_price(	$valorProposta['valor_proposta']);
		$precoPropostasAP = format_price(	$valorPropostaAP['valor_propostaAP']);
				
				$colm[] = [
					$id,
					$c->get("office"),
				$nome,
					$valorProposta['qtd_propostas'],
			$precoPropostas,
				$valorPropostaAP['qtd_propostasAP'],
				$valorPropostaAP['valor_propostaAP'],
				];	
				
			};
			
			$columns = [				
  			"recordsTotal" => $QntCotacoes,
 				"recordsFiltered" => $QntCotacoes,
  			"data" => $colm
			];
			
			echo json_encode($columns);
			exit;
    }
	

	
	
	 public function valorProposta($id,$DataPadrao,$hoje)  {

		 $queryValor= "responsavel = '$id' AND date >= '$DataPadrao' AND date <= '$hoje' ";
     $AuthUser = $this->getVariable("AuthUser");
		 $valorOrders = Controller::model("Orders");
		 $valorOrders->where(DB::raw("$queryValor")) 
							->fetchData();		
	
		 $QtdOrder = $valorOrders->getTotalCount();
		 
		 foreach($valorOrders->getDataAs("Order") as $o){
			 $decodeValor = json_decode($o->get("order_value"),true);
			
			 
		 }
		$ValorTotal = 0;
		foreach($decodeValor as $v){
       $ValorTotal += $v['totalTotal'];  
       }  
		 
		 
		 $arrayPropostas = array(
		 "qtd_propostas" => $QtdOrder,
		 "valor_proposta"	=> $ValorTotal
		 
		 );
		 
		 
     return $arrayPropostas;
  }
	
	
	 public function valorPropostaAP($id,$DataPadrao,$hoje)  {

		 $queryValorAP = "( responsavel = '$id' AND status = '1' ) AND date >= '$DataPadrao' AND date <= '$hoje' ";
     $AuthUser = $this->getVariable("AuthUser");
		 $valorOrdersAP = Controller::model("Orders");
		 $valorOrdersAP->where(DB::raw("$queryValorAP")) 
							->fetchData();		
		 $QtdOrderAP = $valorOrdersAP->getTotalCount();
	
		 
		 foreach($valorOrdersAP->getDataAs("Order") as $o){
			 $decodeValorAP = json_decode($o->get("order_value"),true);
			 
		 }
		$ValorTotalAP = 0;
		if($decodeValorAP != null){
			
		foreach($decodeValorAP as $v){
       $ValorTotalAP += $v['totalTotal'];  
       }  
		} 
		 $arrayPropostasAprovadas = array(
		 "qtd_propostasAP" => $QtdOrderAP,
		 "valor_propostaAP"	=> $ValorTotalAP
		 
		 );
		 
		 
     return $arrayPropostasAprovadas;
  }
	
	
	
	
	
	
	
	
	
	
	
	
	private function duplicarOrcamento(){
		
		$this->resp->result = 0;
		$AuthUser = $this->getVariable("AuthUser");		
		$IdOrcamento = Input::post("id");
		
		
		$NOrcamento = Controller::model("Orders");
		$NOrcamento->limit(1)
							 ->orderBy("order_id", "DESC")
							 ->fetchData();
		
		foreach($NOrcamento->getDataAs("Order") as $o){
			$NumeroOrcamento = $o->get("order_id");			
			break;
		}
		
		$NumeroOrcamento = $NumeroOrcamento + 1;

		$OrcamentoAntigo = Controller::model("Order", $IdOrcamento);
		
		$OrcamentoNovo = Controller::model("Order");
		
		$OrcamentoNovo->set("order_id", $NumeroOrcamento)
								  ->set("santri_id", $OrcamentoAntigo->get("santri_id"))
									->set("version", "1")
									->set("status", $OrcamentoAntigo->get("status"))
									->set("client", $OrcamentoAntigo->get("client"))
									->set("seller", $OrcamentoAntigo->get("seller"))
									->set("comissao", $OrcamentoAntigo->get("comissao"))
									->set("comissaoActive", $OrcamentoAntigo->get("comissao_active"))
									->set("responsavel", $OrcamentoAntigo->get("responsavel"))
									->set("loja_responsavel", $OrcamentoAntigo->get("loja_responsavel"))
									->set("branch", $OrcamentoAntigo->get("branch"))
									->set("destiny", $OrcamentoAntigo->get("destiny"))
									->set("uf_frete", $OrcamentoAntigo->get("uf_frete"))
									->set("valorFrete", $OrcamentoAntigo->get("valorFrete"))
									->set("payment_details", $OrcamentoAntigo->get("payment_details"))
									->set("product_details", $OrcamentoAntigo->get("product_details"))
									->set("products_order", $OrcamentoAntigo->get("products_order"))
									->set("power", $OrcamentoAntigo->get("power"))
									->set("order_value", $OrcamentoAntigo->get("order_value"))
									->set("order_description", $OrcamentoAntigo->get("order_description"))
									->set("description", $OrcamentoAntigo->get("description"))						
									->set("origem_date", date("Y-m-d H:s:i"))
									->set("prazo_entrega", $OrcamentoAntigo->get("prazo_entrega"))
									->set("owner", $AuthUser->get("id"));
		
	try {
	$OrcamentoNovo->save();	
	$this->resp->msg = "Orçamento duplicado com sucesso. Novo id: " . $NumeroOrcamento;
	}	catch (Exception $e){
	$this->resp->msg = "Erro ao duplicar orçamento:" . $e;	
	}
	
		
	$this->resp->result = 1;
	$this->resp->numOrcamento = $IdOrcamento;
		
	$this->jsonecho();									
		
	}

}
