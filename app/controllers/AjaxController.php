<?php

class AjaxController extends Controller
{
   
    public function process()
    { 
			

$table = 'np_orders';
$primaryKey = 'id';

$columns = array(
    array( 'db' => 'order_id', 'dt' => 0 ),
    array( 'db'    => 'client',
           'dt'    => 1,
           'formatter' => function( $d, $row ) {
					  $Cliente = json_decode($d, true);
					 	foreach($Cliente as $keys => $c){
							$client = $c['name'];
							$cnpj = $c['cnpj'];
					 }
					 $CNPJ = formata_cpf_cnpj($cnpj);
					 $retornoClient = "<span style='color:#000;font-weight:700'> $client  </span></br><span style='olor:#51524f'> $CNPJ </span></td>";
            return $retornoClient;
        }
    ),
	 array('db'    => 'seller',
         'dt'    => 2,
         'formatter' => function( $d, $row ) {
					  $responsavel = json_decode($d, true);
					 	foreach($responsavel as $keys => $r){
							$nome = $r['name'];
							$email = $r['email'];
					 }
					 $NOME = ucwords(strtolower($nome));
					 $retornoResponsavel = "<span style='color:#000;font-weight:700'> $NOME </span></br><span style='color:#51524f;font-size:12px;'>$email</span>";
            return $retornoResponsavel;
        }
    ),
	 array('db'    => 'status',
         'dt'    => 3,
         'formatter' => function( $d, $row ) {
					 
						 switch ($d) {
					 case 1:
								 $status = "<span style='color:#28a745;border-radius:5px;'>Aprovado</span>";
								 break;
					 case 2:
								$status =  "<span style='color:#17a2b8;border-radius:5px;'>Aguardando</span>";
								 break;
					 case 3:
								 $status = "<span style='color:#dc3545;border-radius:5px;'>Reprovado</span>";
								 break;
					case 4:
								 $status =  "<span style='color:#dc3545;border-radius:5px;'>Vencido</span>";
								 break;
					 default:
								 $status =  "<span style='color:#17a2b8;border-radius:5px;'>Aguardando</span>";
								 break;
				}

            return $status;
        }
    ),
	 array('db'    => 'expirate_date',
         'dt'    => 4,
         'formatter' => function( $d, $row ) {
					 $Emissao = date('Y-m-d', strtotime($d));          
           $Validade = date("d/m/Y", strtotime("+2 days", strtotime($Emissao)));
			     $retornoValidade = "<span style='color:#2a3f54'> $Validade </span>";
   
            return $retornoValidade;
        }
    ),	
	 array('db'    => 'order_value',
         'dt'    => 5,
         'formatter' => function( $d, $row ) {
					  $valor = json_decode($d, true);
					 	foreach($valor as $keys => $v){
							$valorTotal = $v['totalTotal'];
							
					 }
					 $VALOR = format_price($valorTotal);
					 $retornoPreco =  "<span style='color:#000;font-weight:700'>$VALOR</span>";
            return $retornoPreco;
        }
    ),
		array('db'    => 'id',
         'dt'    => 6,
         'formatter' => function( $d, $row ) {
					  $idOrder = Controller::model("Order");
					  $idOrder->select($d, "id"); 
						$IccD = $idOrder->get("order_id");
					 
					  $frete = Controller::model("Frete");
					  $frete->select($IccD, "id_orcamento"); 
						$FRETE = $frete->get("status");
					 
					 
					  $HTML = "error";	
					  switch ($FRETE) {
					 case 1:
								 $HTML = "<span style='color:#027560;' class='mdi mdi-airplane icon1'></span>";
								 break;
					 case 2:
									$HTML = "style='color:orange;' class='mdi mdi-airplane icon1'";
								 break;
					 case 3:
								 $HTML = "style='color:red;' class='mdi mdi-airplane icon1'";
								 break;
					case 4:
								 $HTML = "style='color:red;' class='mdi mdi-airplane icon1'";
								 break;
					case 5:
								 $HTML = "style='color:#bf45bb;' class='mdi mdi-airplane icon1'";
								 break;
					case 6:
								 $HTML = "style='color:#3020b2;' class='mdi mdi-airplane icon1'";
								 break;
					case 7:
								$HTML = "style='color:#12902d;' class='mdi mdi-airplane icon1'";
								 break;
					case 8:
								$HTML = "style='color:#20b23f;' class='mdi mdi-airplane icon1'";
								 break;
					case 9:
								 $HTML = "style='color:#56e474;' class='mdi mdi-airplane icon1'";
								 break;
				  case 10:
								 $HTML = "style='color:#6456da;' class='mdi mdi-airplane icon1'";
								 break;
					case 11:
								 $HTML = "style='color:#134f18;' class='mdi mdi-airplane icon1'";
								 break;
								
					 default:
								 $HTML = $HTML = "class='mdi mdi-airplane-off icon1'";	;
								 break;
				}
          $url = APPURL . "/frete/$d";
					$RetornoFrete = "<a data-id='$d' id='frete-form' href='$url'><span $HTML ></span></a>";
		
            return $RetornoFrete;
        }
    ),
		array( 'db' => 'id', 'dt' => 7,
				   'formatter' => function( $d, $row ) {
						 $urlB = APPURL."/budget";
						 $urlO = APPURL."/order";
						 $idOrder = Controller::model("Order");
					   $idOrder->select($d, "id"); 
						 $status = $idOrder->get("status");
						 
						 if($status != 4){
							 $proposta = "<a class='icon1' href='$urlB/$d'><span class='mdi mdi-printer icon1' title='Visualizar proposta.'></span> </a>";
						 } else {
							 $proposta = "<a class='icon1 imprimirPDF' href='javascript:void(0)'><span class='mdi mdi-printer icon1 imprimirPDF' title='Gerar proposta.'></span></a>";
						 }
						 
					 $acoes = "<center>
					   
              $proposta
						  <a href='$urlO/$d' class='edit-line icon2'><span style='margin:15px;' class='sli sli-pencil icon2' title='Editar proposta.'></span></a>							
 							<a href='javascript:void(0)' data-id='$d' class='delete-line'><span class='sli sli-ban icon menu-icon icon3' title='Excluir proposta.'></span></a>
							<span class='sli sli-ban icon menu-icon' style='opacity:0'></span>
                          </center>";
            return $acoes;
        })

  );

$sql_details = array(
    'user' => 'usuario_solar',
    'pass' => '@LPko2930nleh@',
    'db'   => 'banco_solar',
    'host' => 'localhost'
);
 
			$AuthUser = $this->getVariable("AuthUser");
      $idUser = $AuthUser->get("id");
      $User = Controller::model("User");
      $User->select($idUser, "id"); 
      $permissoes =  $User->get("permissoes");
      $permissoesDecode = json_decode($permissoes);
      
      
    if($permissoesDecode->filiais->mtz == true){
      $t = "LOJA_RESPONSAVEL = 'Filial Brasília' OR ";
    }
    if($permissoesDecode->filiais->gyn == true){
       $t .= "LOJA_RESPONSAVEL = 'Filial Goiânia' OR ";
    }
    if($permissoesDecode->filiais->rvd == true){
       $t .= "LOJA_RESPONSAVEL = 'Filial Palmas' OR ";
    }
    if($permissoesDecode->filiais->plm == true){
       $t .= "LOJA_RESPONSAVEL = 'Filial Rio Verde' OR ";
    }
    if($permissoesDecode->filiais->grd == true){
       $t .= "LOJA_RESPONSAVEL = 'Filial Goiânia - Radial' OR ";
    }
    if($permissoesDecode->filiais->ftz == true){
      $t .= "LOJA_RESPONSAVEL = 'Filial Fortaleza' OR ";
    }
    if($permissoesDecode->filiais->fbe == true){
      $t .= "LOJA_RESPONSAVEL = 'Filial Brasília Externa' OR  ";
    }
      
      $condicao = $t . "LOJA_RESPONSAVEL = 'Default'";
			

 require_once(APPPATH.'/inc/Ssp.Class.php'); 

 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $condicao, $primaryKey, $columns )
);
			
			

   }
	
}
       