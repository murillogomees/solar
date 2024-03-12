<?php
/**
 * Users Controller
 */
class CronEstoqueSantriController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
      
    set_time_limit(0);
      
        $startTIME = startExec();
        $conn = $this->dbSantri();      
        echo "Tempo após conexão: " . endExec($startTIME) . "<br></br>";
      
        $tabela = "VW_WEB_PRODUTOS";
        $tabelab = "VW_WEB_EMPRESAS";
        $tabelaE = "VW_WEB_ESTOQUES";
       // $idProduto = "14512";
        $stid = oci_parse($conn, "SELECT * FROM $tabelaE WHERE EMPRESA_ID = '9' ORDER BY DATA_HORA_ALTERACAO_ESTOQUE ASC");
        echo "Tempo após parse sql: " . endExec($startTIME) ."<br></br>";
        oci_set_prefetch($stid, 3000);
        oci_execute($stid);
        echo "Tempo após executar sql: " . endExec($startTIME) ."<br></br>";
      
        $quantidade = 0;
        
        while (false !== ($row = oci_fetch_assoc($stid))) {				
    			
				$Produto = Controller::model("Product");	
        $Produto->select($row['PRODUTO_ID'], "santri_cod");
			
       if (!$Produto->isAvailable()) {
         	continue;            
       }
				
			 $Produto->set("estoque",$row['ESTOQUE'])->save();	
         
 	     $quantidade++;
       }
        
        echo "Quantidade de registros: " . $quantidade . " da tabela: ". $tabelaE ."<br></br>";
        echo "[FINALIZAÇÃO]: " . endExec($startTIME);
        
    }
}
