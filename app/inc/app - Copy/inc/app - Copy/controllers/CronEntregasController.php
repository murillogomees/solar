<?php
 
class CronEntregasController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
    // Setando Tempo Limite do PHP  
    set_time_limit(0);
  
    // Iniciando contagem tempo de execução do código
    $startTIME = startExec();  
      
    // Setando as tabelas do Santri  
    $tabelaPedidos = "VW_WEB_ITENS_PEDIDOS";  
    $tabelaPendentes = "VW_WEB_ENTREGAS_PENDENTES";  
    $tabelaFinalizadas = "VW_WEB_ENTREGAS_FINALIZADAS"; 
    $CamposNecessarios = "$tabelaPedidos.PEDIDO_ID , $tabelaPedidos.PRODUTO_ID, $tabelaPedidos.NOME_PRODUTO, $tabelaPendentes.STATUS as STATUS_PENDENTE ,$tabelaFinalizadas.STATUS as STATUS_FINALIZADO, $tabelaPendentes.QUANTIDADE_PENDENTE, $tabelaFinalizadas.QUANTIDADE_ENTREGUE, $tabelaPedidos.QUANTIDADE, $tabelaPendentes.PREVISAO_ENTREGA, $tabelaFinalizadas.DATA_ENTREGA, $tabelaFinalizadas.NOME_PESSOA_RECEBEU";
    
      
    // Quantidade de Registros Inicial
    $quantidade = 0;   
      
    // Iniciando Conexão BD Santri
    $conn = $this->dbSantri();        
    
    // Pegando orçamentos APROVADOS no sistema      
    $CotacaoFrete = Controller::model("Fretes");
    $CotacaoFrete->where(DB::raw("status >= '6' AND status <= '10'"))    
								 ->where("numero_pedido_santri", "<>", "")								
                 ->fetchData();
     
			
    // Percorrendo todos os dados recebidos do model  
    foreach($CotacaoFrete->getDataAs("Frete") as $f){
      
      $IDPedidoSantri = $f->get("numero_pedido_santri"); 
               
      $SQLSantri = "SELECT $CamposNecessarios FROM $tabelaPedidos LEFT JOIN $tabelaPendentes ON ($tabelaPedidos.PEDIDO_ID = $tabelaPendentes.PEDIDO_ID AND $tabelaPedidos.PRODUTO_ID = $tabelaPendentes.PRODUTO_ID) LEFT JOIN $tabelaFinalizadas ON ($tabelaPedidos.PEDIDO_ID = $tabelaFinalizadas.PEDIDO_ID AND $tabelaPedidos.PRODUTO_ID = $tabelaFinalizadas.PRODUTO_ID) WHERE $tabelaPedidos.PEDIDO_ID = $IDPedidoSantri";
      
      $stid = oci_parse($conn, $SQLSantri); 
      oci_execute($stid);
      
      $arrayProdutos = [];
	  $situacaoEntrega = "0";
		
      while (($row = oci_fetch_assoc($stid)) != false) {
       
       $arrayProdutos[] = [
				"idProduto" => $row['PRODUTO_ID'],				
				"nomeProduto" => $row['NOME_PRODUTO'],
				"quantidadeTotal" => $row['QUANTIDADE'],
				"quantidadePendente" => $row['QUANTIDADE_PENDENTE'],
				"quantidadeEntregue" => $row['QUANTIDADE_ENTREGUE'],
				"statusPendente" => $row['STATUS_PENDENTE'],
				"statusFinalizado" => $row['STATUS_FINALIZADO'],
				"previsaoEntrega" => $row['PREVISAO_ENTREGA'],
				"dataEntrega" => $row['DATA_ENTREGA'],
				"nomePessoaRecebeu" => $row['NOME_PESSOA_RECEBEU']
			 ];
		  
		 		 if($row['NOME_PESSOA_RECEBEU'] != "")	{
					$situacaoEntrega = "1";
				} else {
					$situacaoEntrega = "0";
				}
		  
			}
			
			$jsonProdutos = json_encode($arrayProdutos, true);
		
			if ($situacaoEntrega == "1"){
				$f->set("status", "11");	
			}
		
			$f->set("produtos", $jsonProdutos);
			$f->save();
			
			
			$quantidade++;
     	echo "[ORÇAMENTO " . $IDPedidoSantri . "]</br>";
		}
			
   	echo "<br></br>Quantidade de registros: " . $quantidade . "<br></br>";
   	echo "[FINALIZAÇÃO]: " . endExec($startTIME);
			
    }
	
}

