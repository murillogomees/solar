<?php
/**
 * User Controller
 */
class ComissionamentosController extends Controller
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
			
			
      
     $this->view('comissionamentos');
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
				
			$AuthUser = $this->getVariable("AuthUser");	
			header('Content-Type: application/json; charset=utf-8');			
		  $dados_requisicao = $_REQUEST;
			$Search = $_POST['search']['value'];
      $id_Usuario = $AuthUser->get("id");
      $tipo_Conta = $AuthUser->get("account_type");
        
        
        
        
        			$colunas = [
			0 => 'id',
			1 => 'id',
			2 => 'id',
			3 => 'id',
			4 => 'id',
			5 => 'id',
			6 => 'id',	
	    7 => 'id',
			8 => 'id',
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
      $dbFrete = $this->dbFrete();        
			$idUser = $AuthUser->get("id");
			$Filial = $AuthUser->get("office");
			$NivelConta = $AuthUser->get("account_type");
        
			//$Search = $Search['value'];	
		  
		  $query = " status = '1' AND comissao_active = '1' AND ( comissao_liquida <> '' OR comissao_liquida <> '0.00' ) " ;
        
        
      		//$query = "id <> '' ";
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
          				$Orders = Controller::model("Orders");
			      $Orders->search($Search)
									 ->setPageSize($Linhas)
									 ->where(DB::raw("$query"))
									 ->setPage($Pagina)
									 ->orderBy($colun, $ordenacao)
									 ->fetchData();		
					    $QntCotacoes = $Orders->getTotalCount();
					
				  } else if($AuthUser->get("account_type") == "supervisor"){
						  //$query .= " AND status <> '3' ";
					    		$Orders = Controller::model("Orders");
			$Orders->search($Search)
									 ->setPageSize($Linhas)
									 ->where(DB::raw("$query"))
									 ->setPage($Pagina)
									 ->orderBy($colun, $ordenacao)
									 ->fetchData();		
					    $QntCotacoes = $Orders->getTotalCount();
				  }
		  	} else {
			
             		$Orders = Controller::model("Orders");
			      $Orders->search($Search)
									 ->setPageSize($Linhas)
									 ->where(DB::raw("$query"))
									 ->setPage($Pagina)
									 ->orderBy($colun, $ordenacao)
									 ->fetchData();		
					    $QntCotacoes = $Orders->getTotalCount();
				}  
        
        
        
        
        
//       if($tipo_Conta == "vendedor"){
//         $query .= " AND responsavel = '$id_Usuario' ";
//       } elseif($tipo_Conta == "supervisor"){
//         $query .= " AND responsavel = '$id_Usuario' "; 
//       }  
        

				
	
			  $colm = [];		
        foreach($Orders->getDataAs("Order") as $o){
					$id_oc =  $o->get("id") ;
          $id_orcamento =  $o->get("order_id") ;
          $comissao = str_replace(".", "", $o->get("comissao_liquida")); 
          $valor = $comissao / 100;  
          $comissaoLiquida =  format_price($valor);
          $comissaoBruta =  format_price($o->get("comissao"));
 				  $Cliente = json_decode($o->get("client"), true);
				  $Vendedor = json_decode($o->get("seller"),true);
          $comissionamento = Controller::model("Comissionamento");
          $comissionamento->select($id_oc,"id_orcamento");
 				  $pedido_santri = $comissionamento->get("pedido_santri");
			    $id_cliente_santri = $comissionamento->get("id_cliente_santri");
          $nota_fiscal = $comissionamento->get("nota_fiscal");
          $statusComissionamento =  $comissionamento->get("status") ;
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
	
				$valor_pedido = format_price($comissionamento->get("valor_pedido_santri"));
 				$urlComissionamentos = APPURL."/comissionamentos";						
				$acoes = "<center> <a href='$urlComissionamentos/$id_oc' class='edit-line icon2'><span style='margin:15px;' class='sli sli-pencil icon2' title='acessar.'></span></a><span class='sli sli-ban icon menu-icon' style='opacity:0'></span> </center>";
       
          
               switch ($statusComissionamento) {
          case 0:
              $StatusComissao = "  <span class='chip green lighten-5'>
                        <span class='red-text'>Pendente</span>
                      </span>";
              break;
          case 1:
              $StatusComissao = "  <span class='chip green lighten-5'>
                        <span class='green-text'>Liberado Controladoria</span>
                      </span>";
              break;
          case 2:
              $StatusComissao = "  <span class='chip green lighten-5'>
                        <span class='red-text'>Comissionamento Pago</span>
                      </span>";
              break;
          case 3:
              $StatusComissao = "  <span class='chip green lighten-5'>
                        <span class='red-text'>Comissionamento Solicitado</span>
                      </span>";
              break;
          } 
     
				
				$colm[] = [
					$id_orcamento,
          $id_cliente_santri,
					$retornoClient,
					$retornoResponsavel,
					$pedido_santri,
					$nota_fiscal,
					$valor_pedido,
					$comissaoBruta,
					$comissaoLiquida,
					$StatusComissao,
					$acoes,
					
				];		
					
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
