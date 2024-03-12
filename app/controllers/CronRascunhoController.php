<?php
 
class CronRascunhoController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
    
		$Rascunho = Controller::model("Rascunhos");
		$Rascunho->where("date", "<", date("Y-m-d H:i:s", strtotime("-7 days")))
						 ->fetchData();
		
		$quantidade = 0;	
			
		foreach($Rascunho->getDataAs("Rascunho") as $r){
			
			$r->remove();
			
			$quantidade++;
		}
			
   	echo "<br></br>Quantidade de registros: " . $quantidade . "<br></br>";
			
    }
	
}

