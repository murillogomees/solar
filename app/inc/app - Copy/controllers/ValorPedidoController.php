<?php
/**
 * Index Controller
 */
class ValorPedidoController extends Controller
{
    /**
     * Process
     */
    public function process()    
    { 
		

   set_time_limit(0);
  
    $startTIME = startExec();  
   
      
    $quantidade = 0;   
      
    // Iniciando Conexão BD Santri
    $conn = $this->dbSantri();        
    
			
			$Frete = Controller::model("Fretes");
			$Frete->where(DB::raw(" valor_pedido = '' "))  
						->setPage(Input::get("page"))
						->orderBy("id","DESC")
						->fetchData();
			
			foreach($Frete->getDataAs("Frete") as $f){
				$pedidoSantri = $f->get("numero_pedido_santri");

      $SQLSantri = "SELECT * FROM VW_WEB_PEDIDOS WHERE PEDIDO_ID = '$pedidoSantri' ";
      
      $stid = oci_parse($conn, $SQLSantri); 
      oci_execute($stid);
      
	
      while (($row = oci_fetch_assoc($stid)) != false) {
       
        $valorPedido = $row['VALOR_PEDIDO'];
       $quantidade++;
			}
				$f->set("valor_pedido" , $valorPedido);
				$f->save();
				
		}

   	echo "<br></br>Quantidade de registros: " . $quantidade . "<br></br>";
   	echo "[FINALIZAÇÃO]: " . endExec($startTIME);

}
}
	