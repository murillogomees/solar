
  <div class="clearfix mb-20">
    <label class="form-label">
        <?= __("Destaca na NF") ?>
        <input class="tagNF" type="checkbox" name="nf_aliquota" data-type="aliquota" data-value="nf_aliquota"  <?= $User->get("nota_fiscal.aliquota.value") == "true" ? "checked" : "none"?>/>
    </label>
  </div>
    <div class="clearfix mb-20">
      <div class="col s6 m6 l6">
          <label class="form-label">
              <span class="compulsory-field-indicator">*</span>
              <?= __("Crédito (Redução de Aliquota): ") ?>
              <span class="tooltip tippy"
                    data-position="top"
                    data-size="small"
                    title="<?= __("Determine o valor do crédido da redução de aliquota.") ?>">
                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
          </label>

          <input class="tagAliquota input js-required"
                 name="cred_aliquota"
                 data-type="credito"
                 data-id="aliquota"
                 type="text"
                 value="<?= $User->get("tax_aliquota.credito.value") ?>"
                 maxlength="30">
      </div>

      <div class="col s6 s-last m6 m-last l6 l-last">
          <label class="form-label">
            <span class="compulsory-field-indicator">*</span>  
            <?= __("Débito (Redução de Aliquota):") ?>
              <span class="tooltip tippy"
                    data-position="top"
                    data-size="small"
                    title="<?= __("Determine o valor do débito da redução de aliquota.") ?>">
                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
          </label>

          <input class="tagAliquota input js-required"
                 name="deb_aliquota"
                 data-type="debito"
                 data-id="aliquota"
                 type="text"
                 value="<?= $User->get("tax_aliquota.debito.value") ?>"
                 maxlength="30">
      </div>
    </div>
