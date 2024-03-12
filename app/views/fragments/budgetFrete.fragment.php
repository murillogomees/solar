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
			<div class="col xl9 m8 s12">

				<div class="card">
					<div class="card-content invoice-print-area">
						<img class="img-order print-img" src="<?= APPURL . '/assets/img/logo-horus-marca.png'?>" />
						
            <!-- header section -->
					<div class="row invoice-date-number div-invoice">
							<div class="col xl4 s12">
									<img class="img-order2" src="<?= APPURL . '/inc/themes/default/assets/images/horus-solar.png'?>" alt="logo" height="60" width="220">
							</div>
              <div class="col xl4 s12 h-horus">
                <span style="font-weight:bold;">Horus Telecom - CNPJ: 02.677.045/0001-20</span><br />
                <span class="emiss fontAddress">SIBS Quadra 1 Conjunto B Lote 15, Nucleo Bandeirante - DF</span>
								<span style="font-size:4px;"><?= $subTotal[0]->margemLucro ?></span> 
              </div>
							<div class="col s12 xl4 invoice-date display-flex pos-emitdate">
									<span style="font-weight:bold;">Orçamento Nº:</span>
									<span class="emiss mr-4"><?= $User->get("order_id") ?></span><br />
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
              
              <table class="table" style="margin-bottom: 25px;">
  <thead class="thead-dark" >
    <tr>
      <th scope="col" class="tit-table">DADOS DO VENDEDOR</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row" class="tit-top-table">Nome: <span style="font-weight:300;"><?= $Seller[0]->name ?></span></th>
      <th class="tit-top-table">E-mail: <span style="font-weight:300;"><?= $Seller[0]->email ?></span></th>
      <th class="tit-top-table">Telefone: <span style="font-weight:300;"><?= formatar('fone',$Seller[0]->phone,11) ?></span></th>
    </tr>
 </tbody>
           </table>
              
 <table class="table" style=" text-align-last: left; margin-bottom: 25px;">    
       <thead class="thead-dark">
									<tr>
										<th>ITEM</th>
										<th>DIMENSÃO (Unitária)</th>
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
											<?php echo $produto->get("altura") . "cm x " . $produto->get("largura") . "cm x " . $produto->get("comprimento") . "cm"; ?>
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
                      <th scope="row" class="tit-top-table">Frete: <span style="font-weight:300;"> 	<?php echo "A Consultar" ?></span></th>
                    </tr>
                   <tr>
                      <th scope="row" class="tit-top-table" style="font-size:18px; font-weight:700;">Valor total: <span><?php echo format_price($User->get("valorFrete") + $subTotal[0]->totalTotal) ?></span></th>
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
										<?php if($paymentDetails[0]->paymentName == "Depósito Antecipado" || $paymentDetails[0]->paymentName == "BV Financeira" || $paymentDetails[0]->paymentName == "Santander"): ?>
										<tr>
											<th scope="row" class="tit-top-table">Banco Itaú <span style="font-weight:300;">(341)</span> - Conta Corrente:<span style="font-weight:300;"> 53944-0</span> - Agência:<span style="font-weight:300;"> 0542 </span>- Horus Telecomunicações LTDA - CNPJ:<span style="font-weight:300;"> 02.677.045/0007-16</span></th>
                    </tr>
										<?php endif; ?>
										<?php if($paymentDetails[0]->paymentName == "Pix"): ?>
										<tr>
											<th scope="row" class="tit-top-table">Banco do Brasil: <span style="font-weight:300;">02.667.045/0001-20</span> -Itaú: <span style="font-weight:300;">(61) 9 9856-5064</span> - Santander: <span style="font-weight:300;">sergio@horustelecom.com.br</span> - Horus Solar: <span style="font-weight:300;">02.667.045/0007-16</span></th>
                    </tr>
										<?php endif; ?>
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
            
             <table class="table" style="margin-bottom: 25px;">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col" class="tit-table">OBSERVAÇÕES IMPORTANTES:</th>

                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row" class="tit-top-table" ><span style="font-weight:300;">- A HORUS é somente a fornecedora dos equipamentos fotovoltaicos.</span></th>
                     </tr>
                    <tr>
                      <th scope="row" class="tit-top-table"><span style="font-weight:300;">- A HORUS não se responsabiliza sobre qualquer projeto, dimensionamento ou instalação do sistema de energia Fotovoltaica.</span></th>
                    </tr>
                    <tr>
                      <th scope="row" class="tit-top-table"><span style="font-weight:300;">- A HORUS não se responsabiliza pela aprovação do projeto junto a concessionária de energia local.</span></th>
                    </tr>
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
                      <th scope="row" class="tit-top-table"><span style="font-weight:300;">- Quaisquer informações indevidas ou omitidas poderão gerar custos extras ao destinatário.</span></th>
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
			</div>
			<!-- invoice action  -->
			<div class="col xl3 m4 s12">
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