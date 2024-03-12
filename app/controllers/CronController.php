<?php
/**
 * Cron Controller
 */
class CronController extends Controller
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
          
          $AtualizarCliente = Controller::model("Clientes");
          $AtualizarCliente->where("cnpj","=", $cnpj)
                           ->orderBy("id","DESC")
                           ->fetchData();
          
          if($AtualizarCliente->getDataAs("Cliente")){ 
            continue;            
          }
          
           $idCliente = preg_replace("/[^0-9]/","",$row['CADASTRO_ID']);
           $phoneCliente = preg_replace("/[^0-9]/","",$row['TELEFONE']);
           $cepCliente = preg_replace("/[^0-9]/","",$row['CEP']);
           
           if ($row['CADASTRO_ID'] == "N"){
             $perfilCliente = "Não Contribuinte";
           } else if ($row['CADASTRO_ID'] == "C"){
             $perfilCliente = "Contribuinte";
           } else if ($row['CADASTRO_ID'] == "R"){
             $perfilCliente = "Revenda";
           } else if ($row['CADASTRO_ID'] == "O"){
             $perfilCliente = "Construtora";
           } else  if ($row['CADASTRO_ID'] == "H"){
             $perfilCliente = "Hospital / Clínica";
           } else if ($row['CADASTRO_ID'] == "P"){
             $perfilCliente = "Órgao Público";
           } else if ($row['CADASTRO_ID'] == "U"){
             $perfilCliente = "Produtor Rural";
           } else if ($row['CADASTRO_ID'] == "A"){
             $perfilCliente = "Atacado";
           } else {
             $perfilCliente = "Error";
           }  
            
           $Registro = Controller::model("Cliente");
           // Start setting data
           $Registro->set("name", $row['NOME_RAZAO_SOCIAL'])
             ->set("cod_santri", $idCliente)
             ->set("cnpj", $cnpj)
             ->set("client_type", $perfilCliente)
             ->set("phone", $phoneCliente)             
             ->set("uf", $row['ESTADO_ID'])
             ->set("branch", "Filial Brasília")
             ->set("cep", $cepCliente)
             ->set("city", $row['NOME_CIDADE'])
             ->set("address", $row['LOGRADOURO'])
             ->set("owner", "0");

           $Registro->save();
          
          echo "SANTRI: " . $row['CPF_CNPJ'] . "</br>";
          $quantidade++;
        }
       // echo "</table>\n";      
      
        echo "Quantidade de registros: " . $quantidade . " da tabela: ". $tabela ."<br></br>";
        echo "[FINALIZAÇÃO]: " . endExec($startTIME);
      
    }


}