<!-- <?php

class WebhookController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
			

			
			$data = file_get_contents("php://input");
      $event = json_decode($data, true);
      $file = $_SERVER["DOCUMENT_ROOT"] . '/assets/app/log.txt';
			$data =json_encode($event)."</br>"; 
			file_put_contents($file,$data.PHP_EOL,FILE_APPEND);
			
			$nome = $event['entry'][0]['changes'][0]['value']['contacts'][0]['profile']['name'];
			$from = $event['entry'][0]['changes'][0]['value']['messages'][0]['from'];
			$mensagem = $event['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
			$data_envio = $event['entry'][0]['changes'][0]['value']['messages'][0]['timestamp'];
			$date = new DateTime();
      $date->setTimestamp($data_envio);
      $data_formatada =  $date->format(' Y-m-d H:i:s');
			$DataPadrao = date('Y-m-d H:i:s' , strtotime('-10 minutes'));    
			
			$telefone = strval($from);
			
	  	$Webhooks = Controller::model("Webhooks");
			$Webhook = Controller::model("Webhook");
			
			if($from != null){

				$tipo_mensagem = 2;
			  $query = "data_envio >= '$DataPadrao' AND telefone = '556198791039'  ";
				
				
				
				
				
			$Webhooks->where(DB::raw("$query"))
									 ->orderBy("id", "DESC")
				->limit(1)
									 ->fetchData();		
	  $QntWebhook = $Webhooks->getTotalCount();
			
		if($QntWebhook == 0){
			
			$Webhook->set("unique_id",uniqid())
				      ->set("nome",$nome)
							->set("telefone",$from)
							->set("mensagem",$mensagem)
							->set("data_envio",$data_formatada)
							->set("tipo_mensagem",$tipo_mensagem);
			        $Webhook->save();
			       $nomeEnvio = $Webhook->get("nome");
	        	 $telefoneEnvio = $Webhook->get("telefone");
			sendWhatsappPadraoVariavel("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X",$telefoneEnvio,"cv_inicio",$nomeEnvio);
		//	usleep(1000000);
			sendWhatsappPadrao("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X",$telefoneEnvio,"menu_opcoes");
				
		}else{
			


			foreach($Webhooks->getDataAs("Webhook") as $w){
				$unique =  $w->get("unique_id");
				$idMneu =  $w->get("menu");

			$Webhook->set("unique_id",$unique)
				      ->set("nome",$nome)
							->set("telefone",$from)
							->set("mensagem",$mensagem);
				  if($mensagem == 2 || $mensagem == 1){
						  $Webhook->set("menu",$mensagem);
					}else{
						
						   $Webhook->set("menu",$idMneu);
					}
					
						$Webhook->set("data_envio",$data_formatada)
							->set("tipo_mensagem",$tipo_mensagem);
			        $Webhook->save();
			}
					//	usleep(800000);
		 $telefoneEnvio = $Webhook->get("telefone");
			
			
			
	if($mensagem == 1 || $mensagem == 2){
		
sendWhatsappPadrao("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X",$telefoneEnvio,"cnpj");
sleep(1);
$protocolo = $Webhook->get("unique_id");
$mProtocolo = 	"*Protocolo de Atendimento:* " . $protocolo ;	
sendWhatsappCustomizada("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X","$telefoneEnvio","$mProtocolo");	
	}	 else if($mensagem == 0) {
sendWhatsappPadrao("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X",$telefoneEnvio,"fechamento");
	}

			
$mensagemFormatada = preg_replace("/[^0-9]/","", $mensagem );	
$tamanhoString = strlen($mensagemFormatada);		
if($mensagem != null && is_numeric($mensagem) && $tamanhoString == 11 || $tamanhoString == 14){
	
	if($tamanhoString == 14){
	$cnpjMascara =  mask($mensagemFormatada, '##.###.###/####-##');
	}else if($tamanhoString == 11){
	$cnpjMascara = mask($mensagemFormatada, '###.###.###-##');
	}

	
	if($idMneu == 2){
	
		$Usuario = Controller::model("User");
		$Usuario->select($mensagemFormatada,"cpf/cnpj");
		
		$idUser = $Usuario->get("id");
		
		
		
		
		
		$Data10 = date('Y-m-d H:m:s' , strtotime('-7 day'));  
		$Fretes = Controller::model("Fretes");
	  $valor = $cnpjMascara;
    $like =  "cliente LIKE '%$valor%' ";
		$queryS = " data_origem >= '$Data10' AND ($like OR responsavel = '$idUser') ";
				
			$Fretes->where(DB::raw("$queryS"))
									 ->orderBy("data_origem", "DESC")
									 ->fetchData();		
	  $QntFrete = $Fretes->getTotalCount();
		$order = Controller::model("Order");
		if($QntFrete == 0){
		sendWhatsappCustomizada("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X","$telefoneEnvio","Não há registro de frete no cnpj/cpf informado. Entre em contato com a Horus através do telefone: (61) 3486-8097 para maiores detalhes");		
			
		}else{
			
		
	foreach($Fretes->getDataAs("Frete") as $F){
		$order->select($F->get("id_orcamento"), "order_id");
		$hash = $order->get("hash_link");
		$url = APPURL . "/orcamento/" . $hash;
		$id = $F->get("id");
		$data = date('d/m/Y',  strtotime($F->get("data_previsao")));
		$status = $F->get("status");
		$pedidoSantri = $F->get("numero_pedido_santri");
		
		if($F->get("data_previsao") == "0000-00-00"){
			$data = "Sem previsão de entrega";
		}
		
		
		
		
							switch ($status) {
					 case 1:
							
							   $NomeFrete = "Aprovado";
								 break;
					 case 2:
								
							    $NomeFrete = "Em análise";
								 break;
					 case 3:
				
							   $NomeFrete = "Reprovado";
								 break;
					case 4:
								
							   $NomeFrete = "Vencido";
								 break;
					case 5:
		
							  $NomeFrete = "Aguardando Ação";
							  
								 break;
					case 6:
							
							  $NomeFrete = "Separado para Envio";
								 break;
					case 7:
								
							  $NomeFrete = "Entregue em Parte";
								 break;
					case 8:
					
							   $NomeFrete = "Despachado";
								 break;
					case 9:
						
							   $NomeFrete = "Despachado em Parte";
								 break;
				  case 10:
					
							   $NomeFrete = "Em Separação";
								 break;
					case 11:
								
							  $NomeFrete = "Entrega Realizada";
								 break;
								
					 default:
								$NomeFrete = "Sem informações";	
								 break;
				}
		
		
		$mensagemFrete = "Segue informações so o frete Pedido Santri" .  $pedidoSantri . "para acessar o orçamento clique no link" . $url;
				sendWhatsappPadraoVariavelFrete("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X","$telefoneEnvio","frete_mod",$id,$pedidoSantri,$NomeFrete,$data);
					
 	}
			}
// 		sendWhatsappCustomizada("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X","$telefoneEnvio","$mProtocolo");	
// 		
		
	} else if($idMneu == 1){
		
	$tamanhoMS = strlen($mensagemFormatada);		
	if($tamanhoString == 14 || $tamanhoString == 11 ){

		
	
		
		
				$Usuario = Controller::model("User");
		$Usuario->select($mensagemFormatada,"cpf/cnpj");
		$idUser = $Usuario->get("id");
		
		$Data10 = date('Y-m-d H:m:s' , strtotime('-30 day'));  
		$Orders = Controller::model("Orders");
	  $valor = $mensagemFormatada;
    $like =  "client LIKE '%$valor%' ";
		$queryS = " date >= '$Data10' AND ( $like OR responsavel = '$idUser' ) ";
			$Orders->where(DB::raw("$queryS"))
									 ->orderBy("date", "DESC")
									 ->fetchData();		
	  $QntOrders = $Orders->getTotalCount();
		
		if($QntOrders == 0){
			sendWhatsappCustomizada("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X","$telefoneEnvio","Não há registro de orçamento no cnpj/cpf informado. Entre em contato com a Horus através do telefone: (61) 3486-8097 para maiores detalhes");	
		} else {
	sendWhatsappCustomizada("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X","$telefoneEnvio","*Digite o número de identificaço (ID) para mais detalhes!* ");			
			sleep(1);
	$msg = "";		
	foreach($Orders->getDataAs("Order") as $o){
		$id = $o->get("id");
				$Kw = json_decode($o->get("product_details")); 
		$KwP = number_format($Kw[0]->kwpReal, 2, ',','.');
	
		
 		$msg .= "*ID* " . $id . " *KwP real:* " . $KwP ."                                               ";  
		

	}
		sendWhatsappCustomizada("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X","$telefoneEnvio","$msg");	
			
			
			
		}
	
		
		
		
		
		
		
		
		
		
	} else {
		
		
		$idOrcamento = intval($mensagemFormatada);
		
		$OrdersF = Controller::model("Orders");
		$queryFB = " id = '$idOrcamento'  ";
			$OrdersF->where(DB::raw("$queryFB"))
									 ->orderBy("date", "DESC")
									 ->fetchData();		
	  $QntOrdersFB = $OrdersF->getTotalCount();
		
		if($QntOrdersFB == 0){
sendWhatsappCustomizada("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X","$telefoneEnvio","Não há registro de orçamento para o ID informado. Verifique se foi digitado corretamente");				
			
		} else {
	sendWhatsappCustomizada("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X","$telefoneEnvio","*Digite o número de identificaço (ID) para mais detalhes!* ");			
			sleep(1);
	$msg = "";		
	foreach($OrdersF->getDataAs("Order") as $oFB){
		$id = $oFB->get("id");
		$id_orcamento = $oFB->get("order_id");
		$Kw = json_decode($oFB->get("product_details")); 
		$KwP = number_format($Kw[0]->kwpReal, 2, ',','.');
		$data = date('d/m/Y', strtotime("+5 days", strtotime($oFB->get("expirate_date"))));
		$subTotal = json_decode($oFB->get("order_value")); 
		$Total = $subTotal[0]->totalTotal;
		$totalFinal = format_price($Total);
		$pedidoSantri = $oFB->get("numero_pedido_santri");
		$UrlProposta = APPURL . "/orcamento/" . $oFB->get("hash_link"); 
		
		
sendWhatsappPadraoVariavelOrder("103035725864169","EAAKdMM9ttGUBABCdICkqs4pqx6bKXWhZA9xMFZAAubZBWQ5UsZA07SlsABIlQqPsb3Kx3fZBjTDSBtWM6ZC8nb3TXPjZCKDOvihttBxUDbzvLFOogZAiM3ht5n7RBYlCy3Gkoq272EmFuTPvi0ctjKZAZA11nzfECqEu6MjvnUZBy0mDatjIgOJZCO1X","$telefoneEnvio","mod_solar",$id_orcamento,$KwP,$data,$totalFinal,$UrlProposta);
 	
	}
		
		}	
	}	
 
		
		
		
		
		
		
		
		
		
		
		
		
// 
		
		
		
		
		

	}  
	
	
	
	
	

		
// 	
	
			}				
			
			
			
			
		   }	
			}
		 }
    }
