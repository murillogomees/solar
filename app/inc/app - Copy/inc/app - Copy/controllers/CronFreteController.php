<?php
/**
 * Cron Controller
 */
class CronFreteController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
    set_time_limit(0);
    $SistemaOrigem = "Painel Solar";  
    $BDFrete = Controller::model("Frete");  
    $dbFrete = $this->dbFrete();	
			 $AuthUser = $this->getVariable("AuthUser");
				
		$result = $dbFrete->query("SELECT * FROM np_orders ");
				
		while ($row = mysqli_fetch_array($result)) {
      $IDSistemaFrete = $row['id_orcamento'];
			$BDFrete->select($IDSistemaFrete, "id_orcamento");       
      $Status = $row['status'];
			$FilialResponsavel = $row['filial'];
      $NumeroNF = $row['numero_nf'];
			$TipoTransporte = $row['tipo_transporte'];
      $NSantri = $row['numero_pedido_santri'];
      $NotaLiberada = $row['nota_liberada'];
			$Cliente = $row['cliente'];
      $TipoLocal = $row['tipo_local'];
      $Endereco = $row['endereco'];
      $Observacao = $row['observacao'];
      $CifFob = $row['cif_fob'];
      $EquipeAuxilio = $row['equipe_auxilio'];
			$Responsavel = $row['vendedor_responsavel'];
      $EquipamentoAuxilio = $row['equipamento_auxilio'];
      $EquipeAuxilio = $row['equipe_auxilio'];
      $CustoConsiderado = $row['custo_considerado'];
			$Produtos = $row['produtos'];
      $ValorTotal = $row['valor_total'];
      $DataValidade = $row['data_validade'];
			$ArquivoCotacao = $row['arquivo_cotacao'];
			$ArquivoCotacao2 = $row['arquivo_cotacao2'];
			$ArquivoCotacao3 = $row['arquivo_cotacao3'];
      $Rastreamento = $row['rastreamento'];
			$Cotacao = $row['cotacao'];
			$DataEnvio = $row['data_envio'];
			$DataPrevisao = $row['data_previsao'];
			$DataEntrega = $row['data_entrega'];
			$ValorPedido = $row['valor_pedido'];
		  $Filial = $BDFrete->get("filial");
      $BDFrete->set("id_orcamento", $IDSistemaFrete)
				      ->set("status", $Status)
				      ->set("filial", $FilialResponsavel)
              ->set("tipo_transporte", $TipoTransporte)	
							->set("rastreamento", $Rastreamento)
							->set("cotacao", $Cotacao)
              ->set("numero_nf", $NumeroNF) 
              ->set("numero_pedido_santri", $NSantri)
              ->set("cliente", $Cliente)
              ->set("vendedor_responsavel", $Responsavel)
              ->set("nota_liberada", $NotaLiberada)
              ->set("tipo_local", $TipoLocal)
              ->set("endereco", $Endereco)
              ->set("observacao", $Observacao)
              ->set("cif_fob", $CifFob)
              ->set("equipe_auxilio", $EquipeAuxilio)
              ->set("equipamento_auxilio", $EquipamentoAuxilio)
              ->set("custo_considerado", $CustoConsiderado)
							->set("produtos", $Produtos)
              ->set("valor_total", $ValorTotal)
							->set("arquivo_cotacao", $ArquivoCotacao)
							->set("arquivo_cotacao2", $ArquivoCotacao2)
							->set("arquivo_cotacao3", $ArquivoCotacao3)
              ->set("data_validade", $DataValidade)
							->set("data_envio", $DataEnvio)
							->set("data_previsao", $DataPrevisao)
							->set("data_entrega", $DataEntrega)
			        ->set("valor_pedido", $ValorPedido);
			
		$Cliente = json_decode($Cliente);	
		$Responsavel = json_decode($Responsavel);
		
		$ResponsavelDados = Controller::model("User" , $Responsavel->id);
			
		$SupervisorResponsavel = Controller::model("Users");
		$SupervisorResponsavel->where("account_type", "=" , "supervisor")	
													->where("office", "=" , $ResponsavelDados->get("office"))
													->fetchData();
		
		$quantidadeLoop = 1;	
		$quantidade = count($SupervisorResponsavel->getDataAs("User"));
			
		foreach($SupervisorResponsavel->getDataAs("User") as $s){			
			$Supervisores[] = [
				"email" => $s->get("email")
			];			
		} 				
		
	
		//$EmailCotacao = \Email::sendNotification("cotacao-atualizada-logistica", ["id" => $IDSistemaFrete, "status" => $Status, "tipo_transporte" => $TipoTransporte, "nome" => $Cliente->nome, "cnpj" => $Cliente->cnpj, "vendedor" => $Responsavel->nome, "supervisor" => $Supervisores]);	
     
	
			
     try {
     $BDFrete->save();    
     echo "Informações salvas com sucesso!<br/>";  
     $Modificado = 0; 
     $Insert = "UPDATE `np_orders` SET modificado = '$Modificado' , filial = '$Filial'  WHERE id_orcamento = '$IDSistemaFrete'"; 
     if ($dbFrete->query($Insert)) {
				echo "Campo 'Modificado' salvo com sucesso!";
		 } else {
				echo "Erro: " . $IDSistemaFrete;
		 } 
       
     } catch (Exception $e) {
       $this->logs($AuthUser->get("id"), "error","Sinc. Frete","Erro ao sincronizar o Frete do orçamento nº: ".$IDSistemaFrete.".<br/>" .$e);
     }
      
    	continue;
      
		}
			
		 $dbFrete->close();	
      
    }


}