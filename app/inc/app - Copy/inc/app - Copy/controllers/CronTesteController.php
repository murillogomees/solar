<?php
 
class CronTesteController extends Controller
{
    /**
     * Process
     */
    public function process()
    { 
      
		echo "AQUI FOI";
		// Setando Tempo Limite do PHP  
    set_time_limit(0);
  
      
    // Quantidade de Registros Inicial
    $quantidade = 0;   
      
    // Iniciando Conexão BD Santri
    $conn = $this->dbSantri();        	
			
		$stid = oci_parse($conn, "SELECT * FROM VW_WEB_ESTOQUES");
      
    $stid = oci_parse($conn, $stid); 
    oci_execute($stid);
			
			
		 while (false !== ($row = oci_fetch_assoc($stid))) {				
    			
			echo "Entrou";
			echo "<pre>"; 
			print_r($row);
			echo "</pre>"; 
			 
      }
			
    }
	
}

