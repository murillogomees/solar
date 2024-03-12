<div class='skeleton' id="orders">
	<div class="container-1400">

		<div class="row clearfix">
			<div class="row">
				<div class="col s12 m8 m-last l3 mb-20">
					<label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Unidade de Negócio") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determina unidade de negocio.") ?>">
                                                          <span class="mdi mdi-help-circle"></span>
                                                </label>
					<select onchange="relatorio()" id="filial" class="input js-required select2 " name="filial">
						    <option selected value="0"   >Todos</option>
								<?php foreach($unidade->getDataAs("Branch") as $un): ?>
                <option value="<?= $un->get("name") ?>"  ><?= $un->get("name") ?> </option>
								<?php endforeach; ?>
              </select>
				</div>
				<div class="col s12 m8 m-last l3 mb-20">
					<label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Vendedor") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determina o vendedor.") ?>">
                                                          <span class="mdi mdi-help-circle"></span>
                                                </label>
					<select  onchange="relatorio()"  id="idVendedor" class="input js-required select2  " data-type="status" name="vendedor">
						<option value="0"  selected   >Todos</option>
             	<?php foreach($Usuarios->getDataAs("User") as $user): ?>
                <option value="<?= $user->get("id") ?>"  >
                  <?= $user->get("firstname") ?>
                </option>
								<?php endforeach; ?>
              </select>
				</div>
				<div class="col s12 m8 m-last l3 mb-20">
					<label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Data Inicio") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determina inicio da data.") ?>">
                                                          <span class="mdi mdi-help-circle"></span>
                                                </label>
					<input id="inicio" onchange="relatorio()" class="input" name="inicio" type="datetime-local" value="<?= $DataPadrao ?>">
				</div>
				<div class="col s12 m8 m-last l3 l-last mb-20">
					<label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Data Final") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determina limite data final") ?>">
                                                          <span class="mdi mdi-help-circle"></span>
                                                </label>
					<input id="fim" onchange="relatorio()" class="input" name="fim" type="datetime-local" value="<?= $hoje ?>">

				</div>



				<table id="tableOrders" class="tabela  ps-table table-responsive table table-hover display nowrap" style="margin-top:30px;">

					<thead>
						<th scope="col">ID </th>
						<th scope="col">Unidade de negócio</th>
						<th scope="col">Usuário</th>
						<th scope="col">Qtd Propostas feitas</th>
						<th scope="col">Valor propostas feitas</th>
						<th scope="col">Qtd propostas aprovadas</th>
						<th scope="col">Valor Propostas aprovadas</th>
					</thead>

				</table>


				<center>
					<div class="row clearfix" style="margin-top:20px">
						<span style="color:#51524f;font-weight:700">Legenda: </span>
						<span style="color:#12902d;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Entrega Realizada</span>
						<span style="color:#134f18;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Entregue em Parte</span>
						<span style="color:#56e474;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Despachado em Partes</span>
						<span style="color:#20b23f;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Despachado</span>
						<span style="color:#6456da;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Em Serapação</span>
						<span style="color:#3020b2;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Separado p/ Envio</span>
						<span style="color:#027560;font-size:12px;margin-right:5px;" class="mdi mdi-airplane iconmin">Aprovado</span>
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