<?php
/**
 * Cron Controller
 */
class CronInatividadeController extends Controller
{
    /**
     * Process
     */
    public function process()
    {

			$Data = date('Y-m-d H:i:s' , strtotime('-6 minutes'));  
			$Data1 = date('Y-m-d H:i:s' , strtotime('-7 minutes ')); 
echo $Data1 . "</br>";
			echo $Data . "</br>";
			$Webhooks = Controller::model("Webhooks");
			$Webhook = Controller::model("Webhook");
			
			

			$query = "data_envio > '$Data1' AND data_envio <= '$Data' AND  menu > '0' ";
			$Webhooks->where(DB::raw("$query"))
									 ->orderBy("id", "DESC")
									 ->fetchData();		
	  $QntWebhook = $Webhooks->getTotalCount();
			
			var_dump($QntWebhook);
			
			foreach($Webhooks->getDataAs("Webhook") as $wA){
				$arrayAviso[] =  array(
				"telefone" =>$wA->get("telefone")
				); 
				
			}

			$arrayUnicoAviso = array_unique($arrayAviso,SORT_REGULAR);
	
			foreach($arrayUnicoAviso as $f){
				$telEnvioAviso =  $f['telefone'] ; 
				
sendWhatsappCustomizada("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X","$telEnvioAviso","Ainda estamos conectados?");		
			}
				
				
		
			$DataPadrao = date('Y-m-d H:i:s' , strtotime('-8 minutes'));  
			$DataPadrao1 = date('Y-m-d H:i:s' , strtotime('-10 minutes ')); 
echo $DataPadrao . "</br>";
			echo $DataPadrao1 . "</br>";
			
			$WebhooksF = Controller::model("Webhooks");
			$WebhookF = Controller::model("Webhook");
			
			

			$queryFinal = "data_envio > '$DataPadrao1' AND data_envio <= '$DataPadrao' AND  menu > '0' ";
			$WebhooksF->where(DB::raw("$queryFinal"))
									 ->orderBy("id", "DESC")
									 ->fetchData();		
	  $QntWebhookF = $WebhooksF->getTotalCount();
			
			foreach($WebhooksF->getDataAs("Webhook") as $w){
				$arrayFinal[] =  array(
				"telefone" =>$ww->get("telefone")
				); 
			}
			$arrayUnicoFinal = array_unique($arrayFinal,SORT_REGULAR);
			foreach($arrayUnicoFinal as $final){
				$telEnvioFinal =  $f['telefone'] ; 
				
	sendWhatsappCustomizada("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X","$telEnvioFinal","Como não tivemos um retorno seu, vou encerrar nossa sessão de bate-papo. Por favor, entre em contato novamente, caso ainda tenha dúvidas.");		
					usleep(100000);
				sendWhatsappPadrao("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X",$telEnvioFinal,"fechamento");
			}
			
				
			
			
			
			
			
			
			
			
			
			
			var_dump($QntWebhook);
			

			}
      
      
    }

  