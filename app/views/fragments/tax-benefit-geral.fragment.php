<div class="clearfix">
    <div class="col s12 m12 l4 mb-20">
        <label class="form-label">
        <span class="compulsory-field-indicator">*</span> 
        <?= __("Status") ?>
        <span class="tooltip tippy"
              data-position="top"
              data-size="small"
              title="<?= __("Determina se o benefício estará Ativo/Desativado.") ?>">
              <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
        </label>

        <select class="input" name="is_active">
            <?php
                if ($User->isAvailable()) {
                    $status = $User->get("is_active") ? 1 : 0;
                } else {
                    $status = 1;
                }
            ?>
            <option value="1" <?= $status == 1 ? "selected" : "" ?>><?= __("Ativo") ?></option>
            <option value="0" <?= $status == 0 ? "selected" : "" ?>><?= __("Desativado") ?></option>
        </select>
    </div>

    <div class="col s12 s-last m12 m-last l8 l-last mb-20">
        <label class="form-label">
            <span class="compulsory-field-indicator">*</span>
            <?= __("Estado de Origem") ?>
            <span class="tooltip tippy"
                  data-position="top"
                  data-size="small"
                  title="<?= __("Selecione o estado de origem do benefício fiscal.") ?>">
                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
        </label>
        <?php $title = checkState($User->get("uf_origin"));  ?>
        <select class="input select2 inputUfOrigin" name="ufOrigin">
           <option value="" selected disabled hidden>Escolha um Estado</option>
            <?php foreach ($States->getDataAs("State") as $key) : ?>
            <option value="<?= $key->get("name") ?>" <?= $title == $key->get("name") ? "selected" : ""?> ><?= $key->get("name") ?></option>
          <?php endforeach; ?>
        </select>
    </div>

</div>
<div class="clearfix">
<div class="col s12 s-last m12 m-last l12 l-last">
  <label class="form-label" >
      <span class="compulsory-field-indicator">*</span>
      <?= __("Escolha o benefício que será trabalhado:") ?>
      <span class="tooltip tippy"
            data-position="top"
            data-size="small"
            title="<?= __("Abaixo selecione o tipo de beneficio a ser aplicado ticando-o e ativando a aba respectiva.") ?>">
            <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
  </label>
</div>
<div class="col s12 s-last m12 m-last l12 l-last box-benefit">
  <label class="form-label">
      <?= __("Redução de Aliquota") ?>
      <input class="checkBenefit" type="checkbox" data-name="Redução de Aliquota" name="aliquota" <?= $aliquota ? "checked" : ""?>/>
  </label>


  <label class="form-label">
      <?= __("Redução de Base de Cálculo") ?>
      <input class="checkBenefit" type="checkbox" data-name="Redução de Base" name="base" value="1" <?= $base ? "checked" : ""?>/>
  </label>

  <label class="form-label">
      <?= __("Desconto na Apuração") ?>
      <input class="checkBenefit" type="checkbox" data-name="Desconto na Apuração" name="apuracao" value="1" <?= $apuracao ? "checked" : ""?>/>
  </label>
</div>
<div class="col s12 s-last m12 m-last l12 l-last box-benefit">
  <label class="form-label clearfix">
      <?= __("Arraste na ordem de prioridade de Benefício Fiscal:") ?>
  </label>
</div>
<div class="col s12 s-last m12 m-last l12 l-last box-benefit mb-20">

  <div id="benefitsRank" class="tags clearfix ui-sortable">

  <?php foreach ($benefits as $t): ?>
    <div class="col s12 s-last m12 m-last l12 l-last">     
    
      <span class="<?= "benefitsRank " . $t->id?>"
            id="<?= htmlchars($t->id) ?>"
            draggable="true"
            data-id="<?= htmlchars($t->id) ?>"
            data-type="<?= htmlchars($t->type) ?>"          
            data-value="<?= htmlchars($t->value) ?>"
            style="margin: 0px 2px 3px 0px;">
            <?= htmlchars($t->value) ?>
        </span>
      </div>
  <?php endforeach ?>
</div>
</div>
</div>


<div class="clearfix mb-20">
  <div class="col s12 s-last m12 m-last l12 l-last">
    <label class="form-label">
        <span class="compulsory-field-indicator">*</span>
        <?= __("Descrição do Benefício Fiscal") ?>
        <span class="tooltip tippy"
              data-position="top"
              data-size="small"
              title="<?= __("Escreva a descrição sobre o que é esse benefício fiscal no sistema.") ?>">
              <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
    </label>

    <textarea id="description"
              class="input js-required"
              name="description"
              maxlength="500"
              rows="2"><?= htmlchars($User->get("description")) ?></textarea>

    </div>
</div>

<div class="clearfix mb-20">
<div class="col s12 s-last m12 m-last l12 l-last">
  <label class="form-label">
      <span class="compulsory-field-indicator">*</span>
      <?= __("Selecione um NCM:") ?>
      <span class="tooltip tippy"
            data-position="top"
            data-size="small"
            title="<?= __("Selecione os ncms que fazem parte do benefício fiscal.") ?>">
            <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
  </label>

  <select class="input select2 inputNcm" name="ncm">
     <option value="" selected disabled hidden>Escolha os Ncm's inclusos no produto</option>
     <option value="Todos"><?= __("TODOS") ?></option>
      <?php foreach ($Ncms->getDataAs("Ncm") as $key) : ?>
      <option value="<?= $key->get("cod_ncm") ?>" ><?= $key->get("cod_ncm") ?></option>
    <?php endforeach; ?>
  </select>
</div>
</div>

<div class="clearfix mb-20">
<label class="form-label">
    <?= __("NCM inseridos:") ?></label>
    <a href="javascript:void(0)" data-toggle="modal" data-target="#target-list-popup">
        <span class="mdi mdi-plus-box" style="    position: absolute; margin-left: -27px; margin-top: 15px; color: #2a3f54; font-size: 30px;"></span>
    </a>
<div class="col s12 s-last m12 m-last l12 l-last box-field" style="height: 50px">
    <div id="ncm" class="tags clearfix mt-10 mb-10">
  <?php
        $targets = $User->isAvailable()
                 ? json_decode($User->get("ncm"))
                 : [];
    ?>
    <?php foreach ($targets as $t): ?>
        <span class="tag ncms pull-left"
              data-type="<?= htmlchars($t->type) ?>"             
              data-value="<?= htmlchars($t->value) ?>"
              style="margin: 0px 2px 3px 0px;">

              <?= __("NCM: ") . htmlchars($t->value) ?>
              <span class="mdi mdi-close remove"></span>
          </span>
    <?php endforeach ?>
</div>
</div>
</div>

<div class="clearfix mb-20">
<div class="col s12 s-last m12 m-last l12 l-last">
  <label class="form-label">
      <span class="compulsory-field-indicator">*</span>
      <?= __("Selecione os estados de destino que o benefício se aplica :") ?>
      <span class="tooltip tippy"
            data-position="top"
            data-size="small"
            title="<?= __("Selecione os estados de destino que fazem parte do benefício fiscal.") ?>">
            <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
  </label>

  <select class="input select2 uf-destiny" name="uf-destiny">
     <option value="" selected disabled hidden>Escolha os Estados de Destino</option>
     <option value="Todos"><?= __("TODOS") ?></option>
      <?php foreach ($States->getDataAs("State") as $key) : ?>
      <option value="<?= $key->get("name") ?>" ><?= $key->get("name") ?></option>
    <?php endforeach; ?>
  </select>

</div>
</div>

<div class="clearfix mb-20">
<label class="form-label">
    <?= __("Estados destino inseridos:") ?></label>
<div class="col s12 s-last m12 m-last l12 l-last box-field">
    <div id="uf_destiny" class="tags clearfix mt-10 mb-10">
  <?php
        $targets = $User->isAvailable()
                 ? json_decode($User->get("uf_destiny"))
                 : [];
    ?>
    <?php foreach ($targets as $t): ?>
        <span class="tag ufdestiny pull-left"
              data-type="<?= htmlchars($t->type) ?>"              
              data-value="<?= htmlchars($t->value) ?>"
              style="margin: 0px 2px 3px 0px;">

              <?= htmlchars($t->value) ?>
              <span class="mdi mdi-close remove"></span>
          </span>
    <?php endforeach ?>
</div>
</div>
</div>

<div class="clearfix mb-20">
<div class="col s12 s-last m12 m-last l12 l-last">
  <label class="form-label">
      <span class="compulsory-field-indicator">*</span>
      <?= __("Selecione um Perfil Tributário:") ?>
      <span class="tooltip tippy"
            data-position="top"
            data-size="small"
            title="<?= __("Selecione os ncms que fazem parte do benefício fiscal.") ?>">
            <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
  </label>

  <select class="input select2 inputTaxProfile" name="taxProfile">
     <option value="" selected disabled hidden>Escolha Perfis Tributários</option>
     <option value="Todos"><?= __("TODOS") ?></option>
      <?php foreach ($taxProfile->getDataAs("TaxProfile") as $key) : ?>
      <option value="<?= $key->get("name") ?>" ><?= $key->get("name") ?></option>
    <?php endforeach; ?>
  </select>

</div>
</div>

<div class="clearfix mb-20">
<label class="form-label">
    <?= __("Perfis Tributários inseridos:") ?></label>
<div class="col s12 s-last m12 m-last l12 l-last box-field">
    <div id="taxProfile" class="tags clearfix mt-10 mb-10">
  <?php
        $targets = $User->isAvailable()
                 ? json_decode($User->get("tax_profiles"))
                 : [];
    ?>
    <?php foreach ($targets as $t): ?>
        <span class="tag taxProfile pull-left"
              data-type="<?= htmlchars($t->type) ?>"              
              data-value="<?= htmlchars($t->value) ?>"
              style="margin: 0px 2px 3px 0px;">

              <?= htmlchars($t->value) ?>
              <span class="mdi mdi-close remove"></span>
          </span>
    <?php endforeach ?>
</div>
</div>
</div>
  <div>
    <?php require_once(APPPATH.'/views/fragments/model.fragment.php');?>
  </div>
