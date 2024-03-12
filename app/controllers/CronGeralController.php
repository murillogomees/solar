<?php
/**
 * User Controller
 */
class CronGeralController extends Controller
{
    /**
     * Process
     */
    public function process()
    {      
       
       $Users = Controller::model("Orders");
       $Users->where("status","=","2")			
             ->orderBy("id","DESC")
             ->fetchData();
    
			
       if (date('w') != 1 ) {
 				foreach($Users->getDataAs('Order') as $o){
          $frete = Controller::model("Frete");
					$frete->select($o->get("order_id"), "id_orcamento"); 
          $status = $frete->get("status");
          
 					 $diaVencimento = date("y-m-d", strtotime("+5 Days", strtotime($o->get("expirate_date"))));;
  				 $diaHoje = date('y-m-d');
          
   
             if($diaHoje > $diaVencimento && $status == null){					
               $o->set('status',4);
               $o->save();
              } else if(($status == 1 || ( $status >= 6 && $status <= 11 ) )){					
               $o->set('status',1);
               $o->save();
              } else if ($status == 3 || $status == 4 ){
                $msg = "Orçamento reprovado automaticamente pleo sistema na data " . date("d/m/Y H:i:s", strtotime(date("Y-m-d H:i:s"))) . " devido a cotação de frete esta vencida ou ter sido reprovada!";
               $o->set('status',3)
                 ->set('order_description',$msg);
               $o->save();
             }
          

 					echo "Dia Vencimento:" . $diaVencimento . " - Dia hoje: " . $diaHoje . " Orçamento ". $o->get("order_id") . "<br>";
 				}
 			}
			
      echo "Cron de Vencimento realizada com sucesso!";
    }
}
