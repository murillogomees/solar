<?php $Client = json_decode($User->get("client")); ?>

<?php $OrcamentoFeito = json_decode($User->get("products_order")); ?>
<?php $subTotal = json_decode($User->get("order_value")); ?>
<?php $paymentDetails = json_decode($User->get("payment_details")); ?>
<?php $Seller = json_decode($User->get("seller")); ?>
<?php $Kw = json_decode($User->get("product_details")); ?>


<background <!-- app invoice View Page -->
	<section class="invoice-view-wrapper section">
		<div class="row">
			<!-- invoice view page -->
			<div class="col l9 m8 s12">

				<div class="card">
					<div class="card-content invoice-print-area">
					
						<!-- header section -->
            <div class="row ">
							<div class="col l4 m12 s12 pos-center">
                 <img class="img-order2" src="<?= $AuthUser->get("logotipo") ?>" alt="logo" height="60" width="220">
							</div>
              <div class="col l4 m12 s12 dados-horus" >
                <span style="font-weight:bold;"><?= strtoupper($AuthUser->get("firstname")) ?> - CPF/CNPJ: <?= formata_cpf_cnpj($AuthUser->get("cpf/cnpj")) ?></span><br/>
                <span class="fontAddress"><?= strtoupper($AuthUser->get("address")) ?> CEP: <?= $AuthUser->get("cep") ?></span>  
              </div>
							<div class="col s12 m12 l4 invoice-date pos-center">
									<span style="font-weight:bold;">Orçamento Nº:</span>
									<span><?= $User->get("order_id") ?></span><br />
									<span class="fontcel" style="font-weight:bold;">Última Atualização:</span>
									<span class="emiss fontcel"><?= date('d/m/Y', strtotime($User->get("expirate_date"))) ?></span>									
							</div>
					</div>
            
						
            
              <table class="table" style="margin-bottom: 25px;">
  <thead class="thead-dark">
    <tr>
      <th scope="col" class="tit-table">DADOS DO CLIENTE</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row" class="tit-top-table">Nome/Razão Social: <span style="font-weight:300;"> <?= $Client[0]->name ?> </span></th>
      <th class="tit-top-table">CNPJ: <span style="font-weight:300;"> <?= formatar('cnpj', $Client[0]->cnpj)?> </span></th>
  </tr>
    <tr>
      <th scope="row" class="tit-top-table">Telefone: <span style="font-weight:300;"><?= formatar('fone',$Client[0]->phone,11) ?></span></th>
      <th class="tit-top-table">Logradouro: <span style="font-weight:300;"><?=  $Client[0]->address ?></span></th>
    </tr>
    <tr>
      <th scope="row" class="tit-top-table">Bairro: <span style="font-weight:300;"><?= $Client[0]->bairro ?></th>
      <th class="tit-top-table">CEP: <span style="font-weight:300;"><?= formatar('cep', $Client[0]->cep)?></span></th>
    </tr>
  </tbody>
            </table>
              
 <table class="table" style=" text-align-last: left; margin-bottom: 25px;">    
       <thead class="thead-dark">
									<tr>
										<th>ITEM</th>                   
										<th>FABRICANTE</th>
										<th>QTD</th>
										<th>GARANTIA</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($OrcamentoFeito as $o): ?>
                  <?php $produto = $this->idProduto($o->id); ?>
									<tr>
										<td>
											<?=$o->product ?>
										</td>                   
										<td>
											<?=$o->producer ?>
										</td>
										<td>
											<?= $o->quantidade ?>
										</td>
										<td>
											<?= $o->garantia ?>
											<?php if($o->type == "Painel"){ echo "*"; $Painel = 1;} ?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
  </table>
       
            <table class="table" style="margin-bottom: 25px;">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col" class="tit-table">VALORES</th>

                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row" class="tit-top-table" >Sub-total: <span style="font-weight:300;">	<?php echo format_price($subTotal[0]->totalTotal) ?></span></th>
                     </tr>
                    <tr>
                      <th scope="row" class="tit-top-table">Frete: <span style="font-weight:300;"> 
												<?php $Frete = $this->frete($User->get("order_id"));?>
												<?php if($Frete['status'] == 1 || $Frete['status'] >= 6 ): ?>
												<?php if($Frete['tipo_transporte']  == 1 ): ?>
												<?php $TP = "Frota Própria" ?>								
												<?php else: ?>
												<?php $TP = "Transportadora" ?>	
												<?php endif; ?>
												<?php echo $TP . " - "  . format_price($Frete['valor_total']  ) ; ?>
												<?php else: ?>
												<?php 			echo "FOB (A Consultar)" ?>
												<?php	endif;	 ?>
												</span></th>
                    </tr>
                   <tr>
										 <?php $Total = $subTotal[0]->totalTotal + $Frete['valor_total'] ; ?>
                      <th scope="row" class="tit-top-table" style="font-size:18px; font-weight:700;">Valor total: <span><?php echo format_price($Total) ?></span></th>
                    </tr>
                  </tbody>
             </table>
            
             <table class="table" style="margin-bottom: 25px;">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col" class="tit-table">CONDIÇÕES DE PAGAMENTO E ENTREGA</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row" class="tit-top-table" >Forma de Pagamento: <span style="font-weight:300;"><?= $paymentDetails[0]->paymentName ?></span></th>
                     </tr>										
                    <tr>
                      <th scope="row" class="tit-top-table">Prazo de Entrega: <span style="font-weight:300;"> <?= $User->get("prazo_entrega"); ?> dias</span></th>
                    </tr>
                    <tr>
                      <th scope="row" class="tit-top-table">Validade da Proposta: <span style="font-weight:300;">5 dias</span></th>
                    </tr>
                    <tr>
                      <th scope="row" class="tit-top-table">KwP: <span style="font-weight:300;"><?= number_format($Kw[0]->kwpReal, 2, ',','.'); ?> real</span></th>
                    </tr>

                  </tbody>
             </table>
            
             <table class="table" style="margin-bottom: 0px;">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col" class="tit-table">OBSERVAÇÕES IMPORTANTES:</th>
                    </tr>
                  </thead>
                  <tbody>                  
                    <tr>
                      <th scope="row" class="tit-top-table">OBSERVAÇÕES DE ENTREGA:</th>
                    </tr>
                     <tr>
                      <th scope="row" class="tit-top-table"><span style="font-weight:300;">- Endereço de entrega deve constar na NF-e corretamente.	</span></th>
                    </tr>
                     <tr>
                      <th scope="row" class="tit-top-table"><span style="font-weight:300;">- Entregas em locais como fazenda, zona rural, rua sem asfalto ou de difícil acesso deve ser comunicada antes do faturamento.</span></th>
                    </tr>
                     <tr>
                      <th scope="row" class="tit-top-table"><span style="font-weight:300;">- Não fazemos entregas onde tenha que, subir escadas, descarregar painel em distanciais acima de 20 metros, sendo essa responsabilidade do destinatário.</span></th>
                    </tr>
                    <tr>
                      <th scope="row" class="tit-top-table"><span style="font-weight:300;">- Nossas entregas são somente em Paletes com auxílio da Paleteira.</span></th>
                    </tr>
                     <tr>
                      <th scope="row" class="tit-top-table"><span style="font-weight:300;">-Quaisquer informações indevidas ou omitidas poderão gerar custos extras ao destinatário.</span></th>
                    </tr>
                     <tr>
                      <th scope="row" class="tit-top-table">OBSERVAÇÕES DE PREÇOS:</th>
                    </tr>
                    <tr>
                      <th scope="row" class="tit-top-table"><span style="font-weight:300;">- Os preços apresentados nesta proposta são fixos durante a validade da proposta.</span></th>
                    </tr> 
                    <tr>
                      <th scope="row" class="tit-top-table"><span style="font-weight:300;">- A validade da proposta será desconsiderada, em casos de alteração da moeda (dolár) ou falta de estoque.</span></th>
                    </tr>
											<?php if($Painel == 1):?>
										 <tr>
                      <th scope="row" class="tit-top-table">OBSERVAÇÕES DE GARANTIA:</th>
                    </tr>
										<th scope="row" class="tit-top-table"><span style="font-weight:300;">- * Garantia de 25 anos para eficiência 80% da primeira geração</span></th>
										<?php endif;?>
										<?php if($User->get("descriptionP")  != null):?>
										<tr>
                      <th scope="row" class="tit-top-table">OBSERVAÇÕES COMPLEMENTARES:</th>
                    </tr>
										<th scope="row" class="tit-top-table"><span style="font-weight:300;">- * <?= $User->get("descriptionP") ?></span></th>
                   <?php endif;?>  
                  </tbody>
             </table>
					</div>
				</div>
        <div class="quebra"></div>
        <div style="break-after:page"></div>
        <h1></h1>
        <div class="card card-imprimir">
					<div class="card-content invoice-print-area termo-responsavel">
            
            <img class="logo-termo-integrador" src="https://devsolar.storgetec.com.br/inc/themes/default/assets/images/horus-solar.png" alt="logo" height="60" width="220">
            
            <img class="img-order3" src="https://devsolar.storgetec.com.br/assets/img/logo-horus-budg.png" alt="marca">
            <div class="termo-integrador">
						<h5 style="text-align: center; margin-top: 15px;"> TERMO DE RESPONSABILIDADE DO INTEGRADOR</h5>
						<!-- header section -->
            </div>            
          	<p style="padding: 0px 100px; line-height: 35px;">
              <p class="font-termo padding-termo" style="font-weight:700;line-height: 35px;">Ref. a proposta nº:</p>
              <p class="font-termo padding-termo" style="font-weight:700;line-height: 35px;">Dados do Integrador:</p>
              <p class="font-termo padding-termo" style="line-height: 35px;">Empresa:</p>
              <p class="font-termo padding-termo" style="line-height: 35px;">CNPJ:</p>
              <p class="font-termo padding-termo" style="line-height: 35px;">End:</p>
              <p class="font-termo padding-termo" style="line-height: 35px;">Resp:</p>
              <p class="font-termo padding-termo" style="line-height: 35px;">CPF:</p>
              </p><br>
              <p class="font-termo2 padding-termo" style="line-height: 35px;">
             &emsp;&emsp; Declaro ser a única responsável pela execução dos serviços de instalações , aprovações junto a concessionaria de energia local, recolhimento dos tributos e demais obrigações inerente ao projeto em questão. Assim sendo isento totalmente a HORUS S/A de quaisquer responsabilidade sobre os serviços a serem executados, considerando ser somente fornecedora dos materiais.
              </p>
            <p class="font-termo" style="text-align: center; margin-top:55px;" >
            Brasília-DF, _____de_______________de 20__.
            </p>
            <p class="font-termo" style="text-align: center; margin-top: 150px;">___________________________________________________ </p>
            <p class="font-termo" style="text-align: center;">Assinatura do responsável pelo integrador </p>
            <p class="font-termo" style="text-align: center; margin-bottom: 100px;"> (Nome e CPF) </p>
            
            <div class="info-horus">
              <h5 style="font-weight:bold;line-height: 5px;">HORUS MATRIZ</h5>
              <p class="font-termo" style="font-weight:bold;">Núcleo Bandeirante - DF</p>
              <p class="font-termo">SIBS Quadra 1 Conj B Lote 15</p>
              <p class="font-termo" style="font-weight:bold;">CEP: 71.736.102</h6>
            </div>
      
            <div class="budget-midias">
              <i class="material-icons icon-bud">photo_camera</i><span>@horustelecom</span>
              <i class="material-icons icon-bud">email</i><span>contato@horustelecom.com.br</span>
              <i class="material-icons icon-bud">language</i><span>www.horustelecom.com.br</span>
              <i class="material-icons icon-bud">email</i><span>(61)3486-8000</span>
            </div>
            <div class="budget-filiais">
              <span>FILIAIS:</span>
              <span>GOIÂNIA ▬</span>
              <span style="word-spacing:0px;">RIO VERDE</span>
              <span>▬ PALMAS ▬</span>
              <span>FORTALEZA</span>
            </div>
					</div>
    
				</div>

        
			</div>
			<!-- invoice action  -->
			<div class="col xl3 m3 s12">
				<div class="card invoice-action-wrapper">
					<div class="card-content">
						<div class="invoice-action-btn">							
              <span style="font-weight:bold">Data Original:</span><span> <?= date('d/m/Y', strtotime($User->get("origem_date"))) ?></span>            
						</div>
						<div class="invoice-action-btn">
							<a onClick="window.print()" class="btn-block btn btn-light-indigo waves-effect waves-light invoice-print">
              <span>Imprimir</span>
            </a>
						</div>
						<div class="invoice-action-btn">
							<a onclick="history.back()" class="btn-block btn btn-light-indigo waves-effect waves-light">
              <span>Voltar</span>
            </a>
						</div>

					</div>
				</div>
			</div>
      
		</div>