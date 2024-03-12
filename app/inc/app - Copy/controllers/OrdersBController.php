<?php
/**
 * User Controller
 */
class OrdersBController extends Controller
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
        }  else if ($AuthUser->get("is_active") == 0) {
             header("Location: ".APPURL."/aguarde");
             exit;
        }else if($AuthUser->get("start_pw") == 1){
          header("Location: ".APPURL."/novasenha");
        }
			
		 $Usuarios = Controller::model("Users");
     $Usuarios->orderBy("id", "DESC")
              ->where("is_active","=","1")
              ->fetchData();
	   $this->setVariable("Usuarios", $Usuarios);
        if (Input::post("action") == "remove") {
            $this->remove();
        } else if (Input::post("action") == "desativar") {
            $this->desativar();
        }  else if ($_POST['action'] == 'otimizar') {				
					$this->otimizar();
			   }
			
			
      
     $this->view('ordersb');
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
		  $dados_requisicao = $_REQUEST;
			$Search = $_POST['search'];
			$Search = $Search['value'];	
		  $query = "tipo_transporte <> '' ";
		  $id_user = Input::post("paramentro1");
		  $id_aviao = Input::post("paramentro2");
		  $id_truck = Input::post("paramentro3");

		 if(Input::post("paramentro1") != null){
			 $userSelect = '{"id":"' . $id_user . '"';
			 $query .= " AND vendedor_responsavel LIKE '%$userSelect%' ";
			}	
		 if(Input::post("paramentro2") != null){
			 $query .= " AND status = '$id_aviao' ";
			}	
		if(Input::post("paramentro3") != null){
			 $query .= " AND tipo_transporte = '$id_truck' ";
		 }		
	
			$colunas = [
			0 => 'id_orcamento',
			1 => 'cliente',
			2 => 'vendedor_responsavel',
			3 => 'numero_pedido_santri',
			4 => 'numero_nf_remessa',
			5 => 'tipo_transporte',
			6 => 'status',	
	    7 => 'data_previsao',
			8 => 'data_entrega',
			9 => 'id',
			];
			$Linhas = (int)$_POST['length'];
			$Start = (int)$_POST['start'];
			$Pagina = ($Start / $Linhas) + 1;
			
			$AuthUser = $this->getVariable("AuthUser");
			$idUser = $AuthUser->get("id");
			$colun = $colunas[$dados_requisicao['order'][0]['column']];
			$ordenacao = $dados_requisicao['order'][0]['dir'];
		
			$url = APPURL . "/order";
      $dbSolar = $this->dbSolar();        
    
			// Pegando orçamentos APROVADOS no sistema 
				
				
				
						$idUser = $AuthUser->get("id");
			$Filial = $AuthUser->get("office");
			if($Search != null && !is_numeric($Search)){
			 $NomeBusca =  $Search;
				if($AuthUser->get("account_type") == "vendedor" ){
					$query .= " AND vendedor_responsavel LIKE '%$NomeBusca%' AND responsavel = '$idUser' OR cliente LIKE '%$NomeBusca%'  ";
				} else if ($AuthUser->get("account_type") == "supervisor"){
					$query .= " AND vendedor_responsavel LIKE '%$NomeBusca%' AND filial = '$Filial' OR cliente LIKE '%$NomeBusca%'  ";
				} else {
					$query .= " AND vendedor_responsavel LIKE '%$NomeBusca%' OR cliente LIKE '%$NomeBusca%' ";
				}
				
			}	
				
				  $Filial = $AuthUser->get("office");
				  $NivelConta = $AuthUser->get("account_type");
				
			if(!$AuthUser->isFinanceiro()){
					
				  if($AuthUser->get("permissoes_filiais") != null){
						
           $filialPermissao = json_decode($AuthUser->get("permissoes_filiais"), true);
			     $filialPermissao = "(" . implode(',', $filialPermissao) . ")";
					
					 $query .= "  AND (filial = '$Filial') OR filial IN $filialPermissao ";
						
						
								}else if($AuthUser->get("account_type") == "supervisor") {
						
									$query .= " AND filial = '$Filial' ";
								} 
					if($AuthUser->get("permissoes_usuarios") != null){
						$usuarioPermissao = json_decode($AuthUser->get("permissoes_usuarios"), true);
						$usuarioPermissao = "(" . implode(',', $usuarioPermissao) . ")";
						
				 if($AuthUser->get("account_type") == "integrador" || $AuthUser->get("account_type") == "vendedor" ){
				        $query .= " AND responsavel IN $usuarioPermissao ";
				  } else if($AuthUser->get("account_type") == "supervisor"){
												
						     $query .= " AND ( status <> '3')  AND responsavel IN $usuarioPermissao ";
				  }
								} else if($NivelConta == "vendedor" || $NivelConta == "integrador" ){
					         $query .= " AND responsavel = '$idUser' ";
								} 
				  if($AuthUser->get("account_type") == "integrador" || $AuthUser->get("account_type") == "vendedor" ){
						  $query .= " AND status <> '3' ";
          						
			$CotacaoFrete = Controller::model("Fretes");
			$CotacaoFrete
									 ->setPageSize($Linhas)
									 ->where(DB::raw("$query"))
									 ->setPage($Pagina)
									 ->orderBy($colun, $ordenacao)
									 ->fetchData();		
					    $QntCotacoes = $CotacaoFrete->getTotalCount();
					
				  } else if($AuthUser->get("account_type") == "supervisor"){
						  
					  				
			$CotacaoFrete = Controller::model("Fretes");
			$CotacaoFrete
									 ->setPageSize($Linhas)
									 ->where(DB::raw("$query"))
									 ->setPage($Pagina)
									 ->orderBy($colun, $ordenacao)
									 ->fetchData();		
					    $QntCotacoes = $CotacaoFrete->getTotalCount();
				  }
		  	} else {
			
             				
			$CotacaoFrete = Controller::model("Fretes");
			$CotacaoFrete
									 ->setPageSize($Linhas)
									 ->where(DB::raw("$query"))
									 ->setPage($Pagina)
									 ->orderBy($colun, $ordenacao)
									 ->fetchData();		
					    $QntCotacoes = $CotacaoFrete->getTotalCount();
				}	
				
				
				
				

     
			
        foreach($CotacaoFrete->getDataAs("Frete") as $frete){
	       
			//	  $id_oc =  str_pad($frete->get("id_orcamento") , 9 , '0' , STR_PAD_LEFT);
					$id_oc =  $frete->get("id_orcamento") ;
		      $result = $dbSolar->query("SELECT id, order_id, status, seller, order_value, client , expirate_date  FROM np_orders WHERE order_id LIKE '%$id_oc%'   ");	
	  	  while ($row = mysqli_fetch_array($result)) {
	
			  $Situacao = $row['status'];
				//decode no cliente
 				$Cliente = json_decode($row['client'], true);
		   //decode no vendedor
				$Vendedor = json_decode($row['seller'],true);
				//seta id orçamento
				$Sistema = $row['order_id'];
				//
				$IdOrder = $row['id']; 
    
			}

				
				  $ID_Frete = $frete->get("id");
				  $TipoFrete = $frete->get("tipo_transporte");
				  $PedidoSantri = $frete->get("numero_pedido_santri");
				  $DataPrevisao = $frete->get("data_previsao");
	        $DataEntrega = $frete->get("data_entrega");
				  $NotasFiscais = $frete->get("numero_nf_remessa");
					$FRETE = $frete->get("status");
								 
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


           $Validade = date("d/m/Y", strtotime("+2 days", strtotime($Emissao)));
			     $retornoValidade = "<span style='color:#2a3f54'> $Validade </span>";   
				
          $EntregaFrete = date("d/m/Y",strtotime($DataEntrega));
					if($DataEntrega == "0000-00-00" && $DataPrevisao != "0000-00-00"){
			    $retornoEntrega = "<span style='color:#2a3f54'>Em processo de entrega</span>";
					} else if($DataEntrega == "0000-00-00" ){
				  $retornoEntrega = "<span style='color:#2a3f54'></span>";
					} else {
			    $retornoEntrega = "<span style='color:#2a3f54'> $EntregaFrete </span>";
					}
				
				  $PrevisaoFrete = date("d/m/Y",strtotime($DataPrevisao));
					if($DataPrevisao == "0000-00-00"){
						$retornoPrevisao = "<span style='color:#2a3f54'></span>";   
					}else{
			    $retornoPrevisao = "<span style='color:#2a3f54'> $PrevisaoFrete </span>";   
					}


					$HTML = "error";	
					switch ($FRETE) {
					 case 1:
								 $HTML = "style='color:#027560;' class='mdi mdi-airplane icon1'";
							   $NomeFrete = "Aprovado";
								 break;
					 case 2:
									$HTML = "style='color:orange;' class='mdi mdi-airplane icon1'";
							    $NomeFrete = "Em análise";
								 break;
					 case 3:
								 $HTML = "style='color:red;' class='mdi mdi-airplane icon1'";
							   $NomeFrete = "Reprovado";
								 break;
					case 4:
								 $HTML = "style='color:red;' class='mdi mdi-airplane icon1'";
							   $NomeFrete = "Vencido";
								 break;
					case 5:
								 $HTML = "style='color:#bf45bb;' class='mdi mdi-airplane icon1'";
							  $NomeFrete = "Aguardando Ação";
							  
								 break;
					case 6:
								 $HTML = "style='color:#3020b2;' class='mdi mdi-airplane icon1'";
							  $NomeFrete = "Separado para Envio";
								 break;
					case 7:
								$HTML = "style='color:#134f18;' class='mdi mdi-airplane icon1'";
							  $NomeFrete = "Entregue em Parte";
								 break;
					case 8:
							   $HTML = "style='color:#20b23f;' class='mdi mdi-airplane icon1'";
							   $NomeFrete = "Despachado";
								 break;
					case 9:
								 $HTML = "style='color:#56e474;' class='mdi mdi-airplane icon1'";
							   $NomeFrete = "Despachado em Parte";
								 break;
				  case 10:
								 $HTML = "style='color:#6456da;' class='mdi mdi-airplane icon1'";
							   $NomeFrete = "Em Separação";
								 break;
					case 11:
								 $HTML = "style='color:#12902d;' class='mdi mdi-airplane icon1'";
							  $NomeFrete = "Entrega Realizada";
								 break;
								
					 default:
								 $HTML = $HTML = "class='mdi mdi-airplane-off icon1'";	
								 break;
				}
	 			
	
	
	
	      if($DataPrevisao == "0000-00-00" ){
					$HTMLFrete = "style='color:gray;' class='iconify icon1' data-icon='tabler:truck-off'";
				} else if($DataPrevisao > $DataEntrega && $DataEntrega != "0000-00-00" ){
					$HTMLFrete = "style='color:green;' class='iconify icon1' data-icon='mdi:truck-check'";
				} else if($DataEntrega == $DataPrevisao  ){
					$HTMLFrete = "style='color:orange;' class='iconify icon1' data-icon='mdi:truck-snowflake'";
				} else if(($DataPrevisao <  $DataEntrega) || $DataPrevisao <  $DataEntrega && $DataEntrega == "0000-00-00" ){
					$HTMLFrete = "style='color:red;' class='iconify icon1' data-icon='mdi:truck-remove'";
				}  else if($DataPrevisao > $DataEntrega && $DataEntrega == "0000-00-00" ){
					$HTMLFrete = "style='color:blue;' class='iconify icon1' data-icon='mdi:truck-snowflake'";
				}
	
	
				
					switch ($TipoFrete) {
					 case 1:
								$NomeTipoFrete =  "Frota Própria";
								 break;
					 case 2:
									$NomeTipoFrete =  "Transportadora";
								 break;
					 case 3:
								 $NomeTipoFrete =  "Cotação de Frete";
								 break;
				}
          $url = APPURL . "/frete/$IdOrder";
				$retornoStatusTransporte = "<a data-id='$IdOrder' id='frete-form' href='$url'><span $HTMLFrete ></span><br></a>";
				
					$RetornoFrete = "<a  data-id='$IdOrder' id='frete-form' href='$url'><span $HTML ></span><br>$NomeFrete</a>";
		
				
						 $urlB = APPURL."/budget";
						 $urlO = APPURL."/order";						

						 
						 if($Situacao != 4){
							 $proposta = "<a class='icon1' href='$urlB/$IdOrder'><span class='mdi mdi-printer icon1' title='Visualizar proposta.'></span> </a>";
						 } else {
							 $proposta = "<a class='icon1 imprimirPDF' href='javascript:void(0)'><span class='mdi mdi-printer icon1 imprimirPDF' title='Gerar proposta.'></span></a>";
						 }
						 
					 $acoes = "<center>
              $proposta
						  <a href='$urlO/$IdOrder' class='edit-line icon2'><span style='margin:15px;' class='sli sli-pencil icon2' title='Editar proposta.'></span></a>							
							<span class='sli sli-ban icon menu-icon' style='opacity:0'></span>
                          </center>";

				
				
				$colm[] = [
					$Sistema,
					$retornoClient,
					$retornoResponsavel,
					$PedidoSantri,
					$NotasFiscais,
					$NomeTipoFrete,
					$RetornoFrete,
					$retornoPrevisao,
					$retornoEntrega,
					$retornoStatusTransporte,
					$acoes
				];		
					unset($Sistema);
}
				

			
			$columns = [				
  			"recordsTotal" => $QntCotacoes,
 				"recordsFiltered" => $QntCotacoes,
  			"data" => $colm
			];
			
			echo json_encode($columns);
			exit;
    }

}
