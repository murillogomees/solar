<?php
/**
 * User Controller
 */
class OrdersController extends Controller
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
			  } else if (Input::post("action") == 'orcamentoAtencao') {				
					$this->orcamentoAtencao();
			  }
			
			
			 if(!$AuthUser->isFinanceiro()){
			 $idUser = $AuthUser->get("id");
			 $Filial = $AuthUser->get("office");
			 $NivelConta = $AuthUser->get("account_type");	 
			 $query = "id <> ''";	 
			 if($AuthUser->get("permissoes_filiais") != null){
				 $filialPermissao = json_decode($AuthUser->get("permissoes_filiais"), true);
				 $filialPermissao = "(" . implode(',', $filialPermissao) . ")";
							$query .= " AND loja_responsavel IN $filialPermissao ";
							}else if($AuthUser->get("account_type") == "supervisor") {
								$query .= " AND loja_responsavel = '$Filial' ";
							} 
				if($AuthUser->get("permissoes_usuarios") != null){
					$usuarioPermissao = json_decode($AuthUser->get("permissoes_usuarios"), true);
					$usuarioPermissao = "(" . implode(',', $usuarioPermissao) . ")";
							$query .= " AND responsavel IN $usuarioPermissao ";
							} else if($NivelConta == "vendedor" || $NivelConta == "integrador" ){
								 $query .= " AND responsavel = '$idUser' ";
							} 	 
				 
			 $Rascunhos = Controller::model("Rascunhos");
       $Rascunhos->where(DB::raw("$query")) 
				 				->orderBy("id","DESC")
                 ->fetchData();
			 } else {
			 $Rascunhos = Controller::model("Rascunhos");
       $Rascunhos->orderBy("id","DESC")
                 ->fetchData();
			 }
		 $ContagemRascunho = $Rascunhos->getTotalCount();
			
		 $this->setVariable("Rascunhos", $Rascunhos);
		 $this->setVariable("ContagemRascunho", $ContagemRascunho);
      
     $this->view('orders');
    }
  
  /**
     * Remove User
     * @return void 
     */
	
	
	   private function orcamentoAtencao()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
			 
       if($AuthUser->get("account_type") != "admin" ){
				$id = $AuthUser->get("id");
       $Fretes = Controller::model("Fretes");
       $Fretes->where(DB::raw("status = '5' AND responsavel = '$id' ")) 
				 				->orderBy("id","DESC")
                 ->fetchData();
			 $QntFretes = $Fretes->getTotalCount(); 
				 
				 if($QntFretes != 0){
					 
					$retorno = '<div style="overflow-y: scroll;height: 375px;"><table id="atencao" class="tabela  ps-table table-responsive table table-hover display nowrap"  border="1"> <tr> <td>ID</td><td>Status</td> <td>Ação</td></tr>';
			  foreach($Fretes->getDataAs("Frete") as $f){
					$id = $f->get("id");
					
					$id_orcamento = $f->get("id_orcamento");
					$id_oc0 =  str_pad($id_orcamento , 9 , '0' , STR_PAD_LEFT);
				  $Orderid = Controller::model("Order");
					$Orderid->select($id_oc0,"order_id");
					
					 if ($Orderid->isAvailable()) {
					     $numero_ID = $Orderid->get("id");
            } else {
						 
					$Orderid = Controller::model("Order");
					$Orderid->select($id_orcamento,"order_id");
					  $numero_ID = $Orderid->get("id");	 
					 }
					$status = $f->get("status");
					
					
					switch ($status) {
					case 5:
								 $HTML = "Aguardando Ação";
					 break;
				}
					
					$acao = '<a href="'. APPURL . '/frete/'. $numero_ID .'"> Acessar </a>';
			    $retorno .= '<tr> <td>'.$id_orcamento.'</td><td>'. $HTML .'</td> <td>'. $acao .'</td> </tr>';
				}
			 $retorno .= '</table></div>';
        $this->resp->mensagem = $retorno ;
	      $this->resp->result = 1;
				 }
				 
			 } else {
				  $this->resp->result = 2;
			 }
        $this->jsonecho();
    }
	
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
				
				$TextoCompleto = $User->get("order_description") . " - [Observação]: " . Input::post("textExclusao");
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
			0 => 'order_id',
			1 => 'client',
			2 => 'responsavel',
			3 => 'status',
			4 => 'expirate_date',
			5 => 'order_value',
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
			$query = "id <> '' ";
			$Search = $_POST['search'];
			$Search = $Search['value'];	
			$id_oc = "";
				
			if($Search != null && is_numeric($Search) && $Search >= 3 ){
			$id_oc = $Search;	
			}
				
			$idUser = $AuthUser->get("id");
			$Filial = $AuthUser->get("office");
			if($Search != null && !is_numeric($Search)){
			 $NomeBusca =  $Search;
				if($AuthUser->get("account_type") == "vendedor" || $AuthUser->get("account_type") == "representante" ){
					$query .= " AND seller LIKE '%$NomeBusca%' AND responsavel = '$idUser' OR client LIKE '%$NomeBusca%'  ";
				} else if ($AuthUser->get("account_type") == "supervisor"){
					$query .= " AND seller LIKE '%$NomeBusca%' AND loja_responsavel = '$Filial' OR client LIKE '%$NomeBusca%'  ";
				} else {
					$query .= " AND seller LIKE '%$NomeBusca%' OR client LIKE '%$NomeBusca%' ";
				}
				
			}	
				
				  $Filial = $AuthUser->get("office");
				  $NivelConta = $AuthUser->get("account_type");
				
			if(!$AuthUser->isFinanceiro()){
					
				  if($AuthUser->get("permissoes_filiais") != null){
						
           $filialPermissao = json_decode($AuthUser->get("permissoes_filiais"), true);
			     $filialPermissao = "(" . implode(',', $filialPermissao) . ")";
					
					 $query .= "  AND (loja_responsavel = '$Filial') OR loja_responsavel IN $filialPermissao ";
						
						
								}else if($AuthUser->get("account_type") == "supervisor") {
						
									$query .= " AND loja_responsavel = '$Filial' ";
								} 
					if($AuthUser->get("permissoes_usuarios") != null){
						$usuarioPermissao = json_decode($AuthUser->get("permissoes_usuarios"), true);
						$usuarioPermissao = "(" . implode(',', $usuarioPermissao) . ")";
						
				 if($AuthUser->get("account_type") == "integrador" || $AuthUser->get("account_type") == "vendedor" || $AuthUser->get("account_type") == "representante" ){
				        $query .= " AND responsavel IN $usuarioPermissao ";
				  } else if($AuthUser->get("account_type") == "supervisor"){
												
						     $query .= " AND ( status <> '3')  OR responsavel IN $usuarioPermissao ";
				  }
								} else if($NivelConta == "vendedor" || $NivelConta == "integrador" || $NivelConta == "representante"  ){
					         $query .= " AND responsavel = '$idUser' ";
								} 
				  if($AuthUser->get("account_type") == "integrador" || $AuthUser->get("account_type") == "vendedor" || $AuthUser->get("account_type") == "representante" ){
						  $query .= " AND status <> '3' ";
          		$Cotacoes = Controller::model("Orders");
							$Cotacoes->search($id_oc)
							         ->where(DB::raw("$query")) 
											 ->setPageSize($Linhas)
											 ->setPage($Pagina)
											 ->orderBy($colun,$ordenacao)
											 ->fetchData();		
					    $QntCotacoes = $Cotacoes->getTotalCount();
					
				  } else if($AuthUser->get("account_type") == "supervisor"){
						  //$query .= " AND status <> '3' ";
					    $Cotacoes = Controller::model("Orders");
							$Cotacoes->search($id_oc)
							         ->where(DB::raw("$query")) 
											 ->setPageSize($Linhas)
											 ->setPage($Pagina)
											 ->orderBy($colun,$ordenacao)
											 ->fetchData();		
					    $QntCotacoes = $Cotacoes->getTotalCount();
				  }
		  	} else {
			
              $Cotacoes = Controller::model("Orders");
							$Cotacoes->search($id_oc)
							         ->where(DB::raw("$query ")) 
											 ->setPageSize($Linhas)
											 ->setPage($Pagina)
											 ->orderBy($colun,$ordenacao)
											 ->fetchData();		
					    $QntCotacoes = $Cotacoes->getTotalCount();
				}
				
			$url = APPURL . "/order";
			foreach($Cotacoes->getDataAs('Order') as $c) {
				
				
			
					
					//decode no cliente
 				$Cliente = json_decode($c->get("client"), true);
		   //decode no vendedor
				$Vendedor = json_decode($c->get("seller"),true);
				//seta id orçamento
				$Sistema = $c->get('order_id');
				//
				$IdOrder = $c->get('id');
				
					//foreach no cliente		 
					foreach($Cliente as $keys => $d){
					$client = mb_convert_case($d['name'], MB_CASE_TITLE, "UTF-8");
					$cnpj = $d['cnpj'];
					 }
				
					 $CNPJ = formata_cpf_cnpj($cnpj);
					 $retornoClient = "<span style='color:#000;font-weight:700'> $client  </span></br><span style='olor:#51524f'> $CNPJ </span></td>";
				
				 //foreach no vendedor
					foreach($Vendedor as $keys => $r){
							$nome = mb_convert_case($r['name'], MB_CASE_TITLE, "UTF-8");
							$email = $r['email'];
					 }
			
					 $retornoResponsavel = "<span style='color:#000;font-weight:700'> $nome </span></br><span style='color:#51524f;font-size:12px;'>$email</span>";

				   //foreach no valor 
					 $valor = json_decode($c->get("order_value"), true);
					 foreach($valor as $keys => $v){
					 $valorTotal = $v['totalTotal'];
							
					 }
					 $VALOR = format_price($valorTotal);
					 $retornoPreco =  "<span style='color:#000;font-weight:700'>$VALOR</span>";
				
				
				 // faz switch para verificação do status
				switch ($c->get("status")) {
					 case 1:
								 $status = "<span style='color:#28a745;border-radius:5px;'>Aprovado</span>";
								 break;
					 case 2:
								$status =  "<span style='color:#17a2b8;border-radius:5px;'>Aguardando</span>";
								 break;
					 case 3:
								 $status = "<span style='color:#dc3545;border-radius:5px;'>Reprovado</span>";
								 break;
					case 4:
								 $status =  "<span style='color:#dc3545;border-radius:5px;'>Vencido</span>";
								 break;
					 default:
								 $status =  "<span style='color:#17a2b8;border-radius:5px;'>Aguardando</span>";
								
				}
              
           $Validade = date("d/m/Y", strtotime("+5 Days", strtotime($c->get("expirate_date"))));;
			     $retornoValidade = "<span style='color:#2a3f54'> $Validade </span>";   
				
					//busca na tabela frete situação do frete referente ao pedido
					$frete = Controller::model("Frete");
					$frete->select($Sistema, "id_orcamento"); 
					$FRETE = $frete->get("status");


					$HTML = "error";	
					switch ($FRETE) {
					 case 1:
								 $HTML = "style='color:#027560;' class='mdi mdi-airplane icon1'";
								 break;
					 case 2:
									$HTML = "style='color:orange;' class='mdi mdi-airplane icon1'";
								 break;
					 case 3:
								 $HTML = "style='color:red;' class='mdi mdi-airplane icon1'";
								 break;
					case 4:
								 $HTML = "style='color:red;' class='mdi mdi-airplane icon1'";
								 break;
					case 5:
								 $HTML = "style='color:#bf45bb;' class='mdi mdi-airplane icon1'";
								 break;
					case 6:
								 $HTML = "style='color:#3020b2;' class='mdi mdi-airplane icon1'";
								 break;
					case 7:
								$HTML = "style='color:#12902d;' class='mdi mdi-airplane icon1'";
								 break;
					case 8:
								$HTML = "style='color:#20b23f;' class='mdi mdi-airplane icon1'";
								 break;
					case 9:
								 $HTML = "style='color:#56e474;' class='mdi mdi-airplane icon1'";
								 break;
				  case 10:
								 $HTML = "style='color:#6456da;' class='mdi mdi-airplane icon1'";
								 break;
					case 11:
								 $HTML = "style='color:#134f18;' class='mdi mdi-airplane icon1'";
								 break;
          case 13:
								 $HTML = "style='color:blue;' class='mdi mdi-airplane icon1'";
								 break;
								
					 default:
								 $HTML = $HTML = "class='mdi mdi-airplane-off icon1'";	;
								 break;
				}
          $url = APPURL . "/frete/$IdOrder";
					$RetornoFrete = "<a data-id='$IdOrder' id='frete-form' href='$url'><span $HTML ></span></a>";
		
				
						 $urlB = APPURL."/budget";
						 $urlO = APPURL."/order";						
						 $Situacao = $c->get("status");
						 
						 if($Situacao != 4){
							 $proposta = "<a class='icon1' href='$urlB/$IdOrder'><span style='margin:15px;' class='mdi mdi-printer icon1' title='Visualizar proposta.'></span> </a>";
						 } else {
							 $proposta = "<a class='icon1 imprimirPDF' href='javascript:void(0)'><span style='margin:15px;' class='mdi mdi-printer icon1 imprimirPDF' title='Gerar proposta.'></span></a>";
						 }
						 
					 $acoes = "<center>
					   
              $proposta
						  <a href='$urlO/$IdOrder' class='edit-line icon2'><span class='sli sli-pencil icon2' title='Editar proposta.'></span></a>												<a href='javascript:void(0)' data-id='$IdOrder' data-value='$Sistema' class='duplicar-orcamento icon2'><span style='margin:15px;' class='mdi mdi-content-copy icon2' title='Duplicar Orçamento.'></span></a>
 							<a href='javascript:void(0)' data-id='$IdOrder' class='delete-line'><span class='sli sli-ban icon menu-icon icon3' title='Excluir proposta.'></span></a>
							<span class='sli sli-ban icon menu-icon' style='opacity:0'></span>
                          </center>";

				
				
				$colm[] = [
					$Sistema,
					$retornoClient,
					$retornoResponsavel,
					$status,
					$retornoValidade,
					$c->get("power") . " KWp",
					$retornoPreco,
					$RetornoFrete,
					$acoes
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
									->set("status", 2)
									->set("client", $OrcamentoAntigo->get("client"))
									->set("seller", $OrcamentoAntigo->get("seller"))
									->set("comissao", $OrcamentoAntigo->get("comissao"))
									->set("comissao_active", $OrcamentoAntigo->get("comissao_active"))
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
