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
					$diaVencimento = date("y-m-d", strtotime("+5 Days", strtotime($o->get("expirate_date"))));;
					$diaHoje = date('y-m-d');
					if($diaHoje > $diaVencimento){					
					 $o->set('status',4);
					 $o->save();
					}
					echo "Dia Vencimento:" . $diaVencimento . " - Dia hoje: " . $diaHoje;
				}
			}
			
      echo "Cron de Vencimento realizada com sucesso!";
    }
}
