


<div class='skeleton' id="orders">
	<div class="container-1400">
		
		<div class="row clearfix">
 
			<div class="col s12 s-last m12 m-last l3 mb-20">			
			<button type="button" class="button--oval button" data-toggle="modal" data-target="#exampleModalCenter" style="height:23px;padding:2px 2px;font-size:13px;width:100%"><?= $ContagemRascunho . " rascunhos de Orçamento" ?></button>
 			</div>
			<table id="tableOrders" class="tabela  ps-table table-responsive table table-hover display nowrap" style="margin-top:30px;">

				<thead>
					<th scope="col">Código</th>
 					<th scope="col">Cliente</th>
				  <th scope="col">Responsável</th>
					<th scope="col">Situação</th>
					<th scope="col">Validade</th>
					<th scope="col">Potência</th>
					<th scope="col">Valor Total</th>
		    	<th scope="col">Frete</th>
					<th scope="col">Ações</th> 
				</thead>

			</table>
			
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div style="width:auto !important;" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Rascunhos de Orçamentos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <table id="tableRascunho" class="tabela  ps-table table-responsive table table-hover display nowrap" style="padding: 19px">
				<thead>
					<th scope="col">Código</th>
 					<th scope="col">Cliente</th>
				  <th scope="col">Responsável</th>
					<th scope="col">Valor Total</th>
					<th scope="col">Ações</th> 
				</thead>
				<tbody>
					<?php foreach($Rascunhos->getDataAs("Rascunho") as $r):?>
          <?php $cliente = json_decode($r->get("client"),true); ?>
					<?php $vendedor = json_decode($r->get("seller"),true); ?>
					<?php $valorRascunho = json_decode($r->get("order_value"),true); ?>
						<tr class="list">                       
							<td><?= $r->get("order_id") ?></td>
								<td><?= $cliente[0]['name'] ?></td>
								<td><?= $vendedor[0]['name']?></td>
					  		<td><?= "R$: ". number_format((float)$valorRascunho[0]['totalTotal'],2,",",".")?></td>
								<td>
								<center>
							<?php $id_oc = $r->get("id") ?>												
						  <a href="<?= APPURL . "/rascunho/" . $id_oc ?>" class='edit-line icon2'><span style='margin:15px;' class='sli sli-pencil icon2' title='Editar proposta.'></span></a>		
							<a href='javascript:void(0)' data-id="<?= $id_oc ?>" data-value="<?= $r->get("order_id") ?>" class='duplicar-orcamento icon2'><span style='margin:15px;' class='mdi mdi-content-copy icon2' title='Duplicar proposta.'></span></a>		
 							<?php if($AuthUser->canEdit($AuthUser)): ?>
									<a onclick="removeRascunho()" href='javascript:void(0)' data-id="<?= $id_oc ?>" ><span class='sli sli-ban icon menu-icon icon3' title='Excluir proposta.'></span></a>
              <?php endif; ?>
							
									<span class='sli sli-ban icon menu-icon' style='opacity:0'></span>
                 </center>
							  </td>
							
						</tr>
					<?php endforeach;?>

				</tbody>
			</table>
     
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color:#f07e13;">Fechar</button>
  
      </div>
    </div>
  </div>
</div>
			<center>
			<div class="row clearfix" style="margin-top:20px">	
			<span style="color:#51524f;font-weight:700">Legenda: </span>
			<span  style="color:#12902d;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Entrega Realizada</span>
      <span style="color:#134f18;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Entregue em Parte</span>	
			<span style="color:#56e474;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Despachado em Partes</span>
			<span style="color:#20b23f;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Despachado</span>
			<span style="color:#6456da;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Em Serapação</span>		
			<span style="color:#3020b2;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Separado p/ Envio</span>	
			<span style="color:#027560;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Aprovado</span>
      <span style="color:blue;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Cotação Aprovada / Comercial</span>
			<span style="color:red;font-size:12px;margin-right:5px" class="mdi mdi-airplane iconmin">Reprovado/Vencido</span>	
			<span style="color:orange;font-size:12px;margin-right:5px" class="mdi mdi-airplane iconmin">Em análise</span>			
			<span style="color:#bf45bb;font-size:12px" class="mdi mdi-airplane iconmin">Aguardando Ação</span>
			<span style="font-size:12px" class="mdi mdi-airplane-off iconmin">Sem Cotação de Frete</span>	
        
		</div>
				</center>
		</div>
	</div>
</div>
<div>
</div>