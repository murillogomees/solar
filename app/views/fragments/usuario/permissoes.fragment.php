<div style="max-width:100% !important"  class="section-content col s12 m12 l12">
	<div class="form-result"></div>
	<div style="width:95%" class="clearfix mb-20">
  	<div class="clearfix mb-20">
    <?php if($AuthUser->isMaster()): ?>
		<div class="col s12 m12  l12 ">
			<label class="form-label">
					<span class="compulsory-field-indicator">*</span>
					<?= __("Selecione estados de atuação :") ?>
					<span class="tooltip tippy"
								data-position="top"
								data-size="small"
								title="<?= __("Define o estado dos clientes que serão visíveis para este usuário.") ?>">
								<span class="mdi mdi-help-circle" style="font-size:13px;"></span>
			</label>
				<?php $Estados = json_decode($User->get("estados_atuacao"), true); ?>
				<select   id="estadoSelecionado"  style="width:100%" class="select2 browser-default"  name="estadoSelecionado[]" class="select2 browser-default" multiple>
 
							<?php foreach($ArrayEstados as $es): ?>

								 <option style="background-color: #f07e13;
    color: #fff;" <?php 
														if ($Estados != null) { 
															foreach($Estados as $e){                                       
															if ($e == $es['uf'] ){
																echo "selected"; 
															}  else {
																echo ""; }
															}
														}
											 ?>
											 value="<?= $es['uf'] ?>"><?= $es['nome'] ?></option>
							 <?php endforeach; ?>
        </select>
		</div>
   <?php endif; ?> 
	</div>  
	<div class="clearfix mb-20">
		<div class="col s12 m12  l12 ">
			<label class="form-label">
					<span class="compulsory-field-indicator">*</span>
					<?= __("Selecione os usuários permitidos :") ?>
					<span class="tooltip tippy"
								data-position="top"
								data-size="small"
								title="<?= __("Define as contas de usuário que serão visíveis para este usuário.") ?>">
								<span class="mdi mdi-help-circle" style="font-size:13px;"></span>
			</label>
				<?php $Usuario = json_decode($User->get("permissoes_usuarios"), true); ?>
				<select   id="usuariosSelecionado"  style="width:100%" class="select2 browser-default"  name="usuariosSelecionado[]" class="select2 browser-default" multiple>
          <?php if($User->get("permissoes_usuarios") == null){
	        $idUsuario = $User->get("id") ;
        	$NomeUsuario = $User->get("firstname") ;
					echo "<option value=". $idUsuario . " selected>". $NomeUsuario. "</option>";
}  ?>
							<?php foreach($ArrayUsuarios as $u): ?>

								 <option style="background-color: #f07e13;
    color: #fff;" <?php 
														if ($Usuario != null) { 
															foreach($Usuario as $s){                                       
															if ($s == $u['id'] ){
																echo "selected"; 
															}  else {
																echo ""; }
															}
														}
											 ?>
											 value="<?= $u['id'] ?>"><?= $u['nome'] ?></option>
							 <?php endforeach; ?>
        </select>
		</div>
	</div>
	<div class="clearfix mb-20">
		<div class="col s12 m12  l12 ">
			<label class="form-label">
					<span class="compulsory-field-indicator">*</span>
					<?= __("Selecione a unidade de negócio permitida:") ?>
					<span class="tooltip tippy"
								data-position="top"
								data-size="small"
								title="<?= __("Define as unidades de negócios que serão visíveis ao usuário no painel de orçamentos.") ?>">
								<span class="mdi mdi-help-circle" style="font-size:13px;"></span>
			</label>
				<?php $Filial = json_decode($User->get("permissoes_filiais"), true); ?>
				<select id="usuariosSelecionado"  style="width:100%" class="select2 browser-default"  name="filialSelecionada[]" class="select2 browser-default" multiple>
						<?php foreach($ArrayFiliais as $f): ?>
							 <option <?php 
													if ($Filial != null) { 
														foreach($Filial as $fil){
														$filial = "'". $f['nome'] ."'"; 
														if ($fil == $filial){
															echo "selected"; 
														} else {
															echo ""; }
														}
													}
										 ?>
										 value="<?= "'". $f['nome'] . "'" ?>"><?= $f['nome'] ?></option>
						 <?php endforeach; ?>
					</select>
				</div>
		</div>
			<div class="clearfix mb-20">
		<div class="col s12 m12  l12 ">
			<label class="form-label">
					<span class="compulsory-field-indicator">*</span>
					<?= __("Selecione a margem para o usuário:") ?>
					<span class="tooltip tippy"
								data-position="top"
								data-size="small"
								title="<?= __("Selecione a margem que será somada ou subtraida no orçamento do usuario.") ?>">
								<span class="mdi mdi-help-circle" style="font-size:13px;"></span>
			</label>
         <input class="input js-required "
								placeholder="Ex:-10"
								onkeypress="onlynumber();"
								 name="margem_usuario"
								 type="text"
								 value="<?= $User->get("margem_usuario")?>"
								 maxlength="3">
				</div>
		</div>
	</div>
 </div>

                   