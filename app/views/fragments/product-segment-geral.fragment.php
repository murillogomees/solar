    <div class="clearfix mb-20">
        <div class="col s12 m6 l6">
          <label class="form-label">
          <span class="compulsory-field-indicator">*</span>
          <?= __("Status:") ?>
          <span class="tooltip tippy"
                data-position="top"
                data-size="small"
                title="<?= __("Determina se o segmento estará Ativa/Desativada.") ?>">
                <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
          </label>

          <select class="input"
                  name="is_active"
                  >
              <?php
                  if ($ProdSegment->isAvailable()) {
                      $status = $ProdSegment->get("is_active") ? 1 : 0;
                  } else {
                      $status = 1;
                  }
              ?>
              <option value="1" <?= $status == 1 ? "selected" : "" ?>><?= __("Ativo") ?></option>
              <option value="0" <?= $status == 0 ? "selected" : "" ?>><?= __("Desativado") ?></option>
          </select>
        </div>

        <div class="col s12 s-last m6 m-last l6 l-last">
          <label class="form-label">
          <span class="compulsory-field-indicator">*</span>
          <?= __("Nome:") ?>
          <span class="tooltip tippy"
                data-position="top"
                data-size="small"
                title="<?= __("Determina o nome para o segmento a ser criado.") ?>">
                <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
          </label>

          <input class="input js-required"
                 name="name"
                 type="text"
                 value="<?= htmlchars($ProdSegment->get("name")) ?>"
                 maxlength="30">
        </div>
    </div>

    <label class="form-label">
        <span class="compulsory-field-indicator">*</span>
        <?= __("Escolha os campos do regime de incidência cumulativa:") ?>
        <span class="tooltip tippy"
              data-position="top"
              data-size="small"
              title="<?= __("Determina os campos que irão ser exigidos no segmento cadastrado.") ?>">
              <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
    </label>
    <div class="clearfix mb-20" style="border: solid 1px #f3f3f3;text-align: left;;padding-top: 1%;padding-left: 1%;background-color: rgb(218 250 255 / 30%);">

       <div class="col s12 m6 l2">

         <label class="form-label">
            <?= __("Crédito Cofins") ?>
            <input type="checkbox" name="cred_cofins" <?= $Fields['fiscal']['cred_cofins'] == "on" ? "checked" : "" ?>/>
        </label>

         <label class="form-label">
            <?= __("Débito Cofins") ?>
            <input type="checkbox" name="deb_cofins" <?= $Fields['fiscal']['deb_cofins'] == "on" ? "checked" : "" ?>/>
        </label>



      </div>
      <div class="col s12 m6 m-last l2 l-last">

        <label class="form-label">
            <?= __("Crédito ICMS") ?>
            <input type="checkbox" name="cred_icms" <?= $Fields['fiscal']['cred_icms'] == "on" ? "checked" : "" ?>/>
        </label>

        <label class="form-label">
            <?= __("Débito ICMS") ?>
            <input type="checkbox" name="deb_icms" <?= $Fields['fiscal']['deb_icms'] == "on" ? "checked" : "" ?>/>
        </label>
       </div>

      <div class="col s12 m6 l2">
        <label class="form-label">
            <?= __("Débito PIS") ?>
            <input type="checkbox" name="deb_pis" <?= $Fields['fiscal']['deb_pis'] == "on" ? "checked" : "" ?>/>
        </label>

        <label class="form-label">
            <?= __("Crédito PIS") ?>
            <input type="checkbox" name="cred_pis" <?= $Fields['fiscal']['cred_pis'] == "on" ? "checked" : "" ?>/>
        </label>




      </div>

      <div class="col s12 m6 m-last l2">
      <label class="form-label">
            <?= __("MVA") ?>
            <input type="checkbox" name="mva" <?= $Fields['fiscal']['mva'] == "on" ? "checked" : "" ?>/>
        </label>

        <label class="form-label">
            <?= __("MPPT") ?>
            <input type="checkbox" name="mppt" <?= $Fields['fiscal']['mppt'] == "on" ? "checked" : "" ?>/>
        </label>



      </div>
      <div class="col s12 s-last m2 m-last l2 l-last">

        <label class="form-label">
            <?= __("IPI") ?>
            <input type="checkbox" name="ipi" <?= $Fields['fiscal']['ipi'] == "on" ? "checked" : "" ?>/>
        </label>

        <label class="form-label">
            <?= __("MB") ?>
            <input type="checkbox" name="mb" <?= $Fields['fiscal']['mb'] == "on" ? "checked" : "" ?>/>
        </label>
      </div>
    </div>
