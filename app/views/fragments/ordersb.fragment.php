<div class='skeleton' id="orders">
	<div class="container-1400">
		<div class="row clearfix mb-20">		
		<?php if($AuthUser->canEditOrder($AuthUser)): ?>	
		<div class="col s3 s-last m3 m-last l3 mb-20">
				<label class="form-label">
					<?= __("Usuarios") ?>
				<span class="tooltip tippy"
							data-position="top"
							data-size="small"
							title="<?= __(".") ?>">
							<span class="mdi mdi-help-circle" style="font-size:13px;"></span>
				</label>
				<select id="usuarioFrete" class="input selectNivel select2"
								name="usuario"
								 >     
						 <option value="" selected disabled hidden>
								<?= __("Selecione") ?>
						</option>
					 <option value=""   >
								<?= __("Todos") ?>
						</option>
          <?php foreach($Usuarios->getDataAs("User") as $u): ?>
					 <option value="<?= $u->get("id") ?>" >
								<?= $u->get("firstname") ?>
						</option>
					<?php endforeach; ?>
					
				</select>
		</div>	
		<div class="col s12 s-last m12 m-last l9 l-last">
				<label style="text-align:left;" class="form-label">
					<?= __("Selecione um filtro abaixo") ?>
				<span class="tooltip tippy"
							data-position="top"
							data-size="small"
							title="<?= __("Click no filtro abaixo para filtrar") ?>">
							<span class="mdi mdi-help-circle" style="font-size:13px;"></span>
				</label>
				<div style='padding-top: 4px !important;'>	
				<span onclick="botaoaviao(null)" style="color:#000;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Todos</span>
				<span onclick="botaoaviao(11)" style="color:#12902d;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Entrega Realizada</span>
				<span onclick="botaoaviao(7)" style="color:#134f18;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Entregue em Parte</span>	
				<span onclick="botaoaviao(9)" style="color:#56e474;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Despachado em Partes</span>
				<span onclick="botaoaviao(8)" style="color:#20b23f;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Despachado</span>
				<span onclick="botaoaviao(10)" style="color:#6456da;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Em Serapação</span>		
				<span onclick="botaoaviao(6)" style="color:#3020b2;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Separado p/ Envio</span>	
				<span onclick="botaoaviao(1)" style="color:#027560;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Aprovado</span>
        <span onclick="botaoaviao(13)" style="color:blue;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Cotação Aprovada/Comercial</span>
				<span onclick="botaoaviao(3)" style="color:red;font-size:12px;margin-right:5px" class="mdi mdi-airplane iconmin">Reprovado/Vencido</span>	
				<span onclick="botaoaviao(2)" style="color:orange;font-size:12px;margin-right:5px" class="mdi mdi-airplane iconmin">Em análise</span>			
				<span onclick="botaoaviao(5)" style="color:#bf45bb;font-size:12px" class="mdi mdi-airplane iconmin">Aguardando Ação</span><br>
				</div>
			</div>
			<?php else: ?>
			<div class="col s12 s-last m12 m-last l9 l-last">
				<label style="text-align:left;" class="form-label">
					<?= __("Selecione um filtro abaixo") ?>
				<span class="tooltip tippy"
							data-position="top"
							data-size="small"
							title="<?= __("Click no filtro abaixo para filtrar") ?>">
							<span class="mdi mdi-help-circle" style="font-size:13px;"></span>
				</label>
        <input type='hidden' value="" id="usuarioFrete" > 
				<div style='padding-top: 4px !important;'>	
				<span onclick="botaoaviao(null)" style="color:#000;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Todos</span>
				<span onclick="botaoaviao(11)" style="color:#12902d;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Entrega Realizada</span>
				<span onclick="botaoaviao(7)" style="color:#134f18;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Entregue em Parte</span>	
				<span onclick="botaoaviao(9)" style="color:#56e474;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Despachado em Partes</span>
				<span onclick="botaoaviao(8)" style="color:#20b23f;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Despachado</span>
				<span onclick="botaoaviao(10)" style="color:#6456da;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Em Serapação</span>		
				<span onclick="botaoaviao(6)" style="color:#3020b2;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Separado p/ Envio</span>	
				<span onclick="botaoaviao(1)" style="color:#027560;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Aprovado</span>
        <span onclick="botaoaviao(13)" style="color:blue;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Cotação Aprovada/Comercial</span>
				<span onclick="botaoaviao(3)" style="color:red;font-size:12px;margin-right:5px" class="mdi mdi-airplane iconmin">Reprovado/Vencido</span>	
				<span onclick="botaoaviao(2)" style="color:orange;font-size:12px;margin-right:5px" class="mdi mdi-airplane iconmin">Em análise</span>			
				<span onclick="botaoaviao(5)" style="color:#bf45bb;font-size:12px" class="mdi mdi-airplane iconmin">Aguardando Ação</span><br>
				</div>
			</div>
			<?php endif; ?>	
				
				
		</div>
		<div class="row clearfix">
			<div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
				<span class="form1-label" >Tabela de Informações:</span>
		 	</div>
			<table id="tableOrders" class="tabela  ps-table table-responsive table table-hover display nowrap" style="margin-top:30px;">
				<thead>
					<th scope="col">Orçamento</th>
 					<th scope="col">Cliente</th>
				  <th scope="col">Responsável</th>		    						 
					<th scope="col">Pedido Santri</th> 					
					<th scope="col">NF</th> 
					<th scope="col">Frete</th> 
					<th scope="col">Status Frete</th>
					<th scope="col">Data Previsão Entrega</th>	
					<th scope="col">Data Entrega</th>
					<th scope="col">Medidor de entrega</th>
					<th scope="col">Ações</th> 
				</thead>
			</table>
			<center>
			<div class="row clearfix" style="margin-top:20px">	
<!-- 			<span onclick="botaotruck(2)" style="color:#FF8C00;font-size:12px" class="mdi mdi-truck iconmin">Transportadora</span>
			<span onclick="botaotruck(1)" style="color:#00008B;font-size:12px" class="mdi mdi-truck iconmin">Frota Própria</span>
			<span onclick="botaotruck(3)" style="color:#000;font-size:12px" class="mdi mdi-truck iconmin">Cotação de Frete</span><br>  -->
			<span  style="color:#51524f;font-weight:700">Legenda: </span>
			<span  style="color:gray;font-size:12px;margin-right:5px;" class='iconify icon1' data-icon='tabler:truck-off'></span><a style="color:gray;font-size:12px;margin-right:5px;">Sem Data</a>
      <span  style="color:green;font-size:12px;margin-right:5px;" class='iconify icon1' data-icon='mdi:truck-check'></span><a style="color:green;font-size:12px;margin-right:5px;">Entrega realizada antes da data prevista</a>
			<span  style="color:red;font-size:12px;margin-right:5px;" class='iconify icon1' data-icon='mdi:truck-remove'></span><a style="color:red;font-size:12px;margin-right:5px;">Entrega realizada depois da data prevista</a>
			<span  style="color:orange;font-size:12px;margin-right:5px;" class='iconify icon1' data-icon='mdi:truck-snowflake'>Data de Entrega Vencendo hoje</span><a style="color:orange;font-size:12px;margin-right:5px;" >Entrega realizada no dia previsto para entrega</a>	
		</div>
				</center>
		</div>
	</div>
</div>
<div>
</div>