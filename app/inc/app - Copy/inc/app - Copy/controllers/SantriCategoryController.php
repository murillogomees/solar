<?php
/**
 * States Controller
 */
class SantriCategoryController extends Controller
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
      
        $tabela = "VW_WEB_GRUPOS_PRODUTOS_WEB";
       // $idProduto = "14512";
        $stid = oci_parse($conn, "SELECT * FROM $tabela");
        echo "Tempo após parse sql: " . endExec($startTIME) ."<br></br>";
        oci_set_prefetch($stid, 2000);
        oci_execute($stid);
        echo "Tempo após executar sql: " . endExec($startTIME) ."<br></br>";
      
        $quantidade = 0;
        // echo "<table border='1'>\n";
        while (false !== ($row = oci_fetch_assoc($stid))) {
          
          echo "<pre>";
          print_r($row[0]);
          echo "</pre>";
           $quantidade++;  
        }
      
        
        echo "Quantidade de registros: " . $quantidade . " da tabela: ". $tabela ."<br></br>";
        echo "[FINALIZAÇÃO]: " . endExec($startTIME);
    }

}
