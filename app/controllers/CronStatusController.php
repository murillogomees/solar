<?php
/**
 * Users Controller
 */
class CronStatusController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
      $tabelaB = "VW_WEB_PEDIDOS";    
      
      set_time_limit(0);     
      $startTIME = startExec();
      $conn = $this->dbSantri();    
      
      $CheckOuts = Controller::model("Orders");
      $CheckOuts->where("status", "=", "2") 
                ->where("santri_id", "!=", "")
                ->orderBy("id", "ASC")
                ->fetchData();
      
      foreach($CheckOuts->getDataAs("Order") as $c){
        $valor = $c->get("santri_id");
        
        //echo $c->get("id") . "</br>";
       // echo $valor . "</br>";
        
        if (isset($valor)){  
          $stid = oci_parse($conn, "SELECT * FROM $tabelaB");        
          oci_set_prefetch($stid, 2000);
          oci_execute($stid);         
          
          while (($row = oci_fetch($stid)) != false) {
       
            $c->set("status", 1);

            $c->save();      
            continue;
          }        
        }          
      }
      
      echo "[FINALIZAÇÃO]: " . endExec($startTIME);
        
    } 
  	
}
