<?php
/**
 * Aba de Contas em Configurações "/config/conta/" Controller
 */
class LogsController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
        // Pega informações do usuário logado
        $AuthUser = $this->getVariable("AuthUser");
        //
      
        // Checagem se está logado e se é administrador
        if (!$AuthUser) {
            header("Location: ".APPURL."/login");
            exit;
        } else if ($AuthUser->get("is_active") == 0) {
             header("Location: ".APPURL."/aguarde");
             exit;
        } else if (!$AuthUser->canEdit($AuthUser)) {
            header("Location: ".APPURL."/order");
            exit;
        }else if($AuthUser->get("start_pw") == 1){
          header("Location: ".APPURL."/novasenha");
        }  
        //
      
        if ($_POST['action'] == 'otimizar') {				
					$this->otimizar();
			   }
      
       
        $this->view("logs");
        //
    }

      private function otimizar()
    {			
			header('Content-Type: application/json; charset=utf-8');			
			
      $Linhas = (int)$_POST['length'];
			$Start = (int)$_POST['start'];
			$Pagina = ($Start / $Linhas) + 1;
			
			$Search = $_POST['search'];
			$Search = $Search['value'];	
        
      $dados_requisicao = $_REQUEST;
			$colunas = [
			0 => 'id_user',
			1 => 'id_user',
			2 => 'account_type',
			3 => 'id_user',
      4 => 'id_user',
			5 => 'situacao',
			6 => 'horas',
			
			];
			$colun = 'horas';
			$colun = $colunas[$dados_requisicao['order'][0]['column']];
			$ordenacao = 'DESC';
			$ordenacao = $dados_requisicao['order'][0]['dir'];  
        
        
        $Logs = Controller::model("Logs");
        $Logs->search($Search)
					   ->setPageSize($Linhas)
						 ->setPage($Pagina)
             ->orderBy($colun,$ordenacao)
             ->fetchData();
			$QntCotacoes = $Logs->getTotalCount();
      
        $iLogs = [];
        $colm = [];
        foreach($Logs->getDataAs("Log") as $l){
          
          $Usuario = Controller::model("User", $l->get("id_user"));
          
         
            $id = $l->get("id");
            $user_id = $l->get("id_user");
            $nomeUser =  ucfirst(strtolower($Usuario->get("firstname")));
            $situacao = $l->get("situacao");
            $pagina = $l->get("pagina");
            $detalhe = $l->get("detalhes");
            $nivel = $Usuario->get("account_type");
            $horario = date("d/m/Y H:i:s", strtotime($l->get("horas"))) ;
         
          if($situacao == "success"){
            $situacaoRetorno = "  <span class='chip green lighten-5'>
                          <span class='green-text'>Sucesso</span>
                        </span>";
            
          }else{
            $situacaoRetorno = "  <span class='chip green lighten-5'>
                          <span class='red-text'>Erro</span>
                        </span>";
            
          }

				$colm[] = [
					$user_id,
					$nomeUser,
					$nivel,
					$pagina,
					$detalhe,
					$situacaoRetorno,
					$horario
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
  
  
}