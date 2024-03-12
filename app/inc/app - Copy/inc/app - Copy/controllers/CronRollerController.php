<?php
/**
 * Cron Controller
 */
class CronRollerController extends Controller
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
      
        $tabela = "VW_WEB_CLIENTES";
       // $idProduto = "14512";
        $stid = oci_parse($conn, "SELECT * FROM $tabela");
        echo "Tempo após parse sql: " . endExec($startTIME) ."<br></br>";
        oci_set_prefetch($stid, 2000);
        oci_execute($stid);
        echo "Tempo após executar sql: " . endExec($startTIME) ."<br></br>";
      
        $quantidade = 0;
        // echo "<table border='1'>\n";
        while (false !== ($row = oci_fetch_assoc($stid))) {
          $cnpj = preg_replace("/[^0-9]/","", $row['CPF_CNPJ']);
          $idCliente = preg_replace("/[^0-9]/","",$row['CADASTRO_ID']);
          
          $AtualizarCliente = Controller::model("Clientes");
          $AtualizarCliente->where("cnpj","=", $cnpj)
                           ->orderBy("id","DESC")
                           ->fetchData();
          
          foreach($AtualizarCliente->getDataAs("Cliente") as $ac){ 
           $id = $ac->get("id"); 
           $Registro = Controller::model("Cliente", $id);
           $Registro->set("cod_santri", $idCliente);
           $Registro->save();            
          }
          
          echo "SANTRI: " . $row['CPF_CNPJ'] . "</br>";
          $quantidade++;
        }
       // echo "</table>\n";      
      
        echo "Quantidade de registros: " . $quantidade . " da tabela: ". $tabela ."<br></br>";
        echo "[FINALIZAÇÃO]: " . endExec($startTIME);
      
    }


}