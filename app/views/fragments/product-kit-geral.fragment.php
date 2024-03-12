    <div class="clearfix mb-20">
        <div class="col s12 m6 l4 mb-20">
          <label class="form-label"> 
          <span class="compulsory-field-indicator">*</span>
          <?= __("Status:") ?>
          <span class="tooltip tippy"
                data-position="top"
                data-size="small"
                title="<?= __("Determina se o fabriante do kit estará Ativo/Desativado.") ?>">
                <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
          </label>

          <select class="input"
                  name="is_active"
                  >
              <?php
                  if ($ProdKit->isAvailable()) {
                      $status = $ProdKit->get("is_active") ? 1 : 0;
                  } else {
                      $status = 1;
                  }
              ?>
              <option value="1" <?= $status == 1 ? "selected" : "" ?>><?= __("Ativo") ?></option>
              <option value="0" <?= $status == 0 ? "selected" : "" ?>><?= __("Desativado") ?></option>
          </select>
        </div>

        <div class="col s12 s-last m4 m-last l4 mb-20">
          <label class="form-label">
          <span class="compulsory-field-indicator">*</span>
          <?= __("Nome:") ?>
          <span class="tooltip tippy"
                data-position="top"
                data-size="small"
                title="<?= __("Determine o nome do fabricante para o Kit.") ?>">
                <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
          </label>

          <input class="input js-required"
                 name="name"
                 type="text"
                 value="<?= htmlchars($ProdKit->get("name")) ?>"
                 maxlength="30">
        </div>
          
          <div class="col s12 s-last m6 m-last l4 l-last">
          <label class="form-label">
              <?= __("MB (%):") ?>
              <span class="tooltip tippy"
                    data-position="top"
                    data-size="small"
                    title="<?= __("Determine a margem bruta do kit em (%).") ?>">
                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span>                    
          </label>

          <input class="input"
                 name="margem_bruta"
                 type="text"
                 value="<?= htmlchars($ProdKit->get("margem_bruta")) ?>"
                 maxlength="30">
        </div>
    </div>

   
