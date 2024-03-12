
                        <div class="clearfix mb-20">
                          <label class="form-label">
                              <?= __("Destaca na NF") ?>
                              <input class="tagNF" type="checkbox" name="nf_base" data-type="base" data-value="nf_base" <?= $User->get("nota_fiscal.base.value") == "true" ? "checked" : "none"?>/>
                          </label>
                        </div>
                          <div class="clearfix mb-20">
                            <div class="col s6 m6 l6">
                                <label class="form-label">
                                    <span class="compulsory-field-indicator">*</span>
                                    <?= __("Crédito (Redução de Base): ") ?>
                                    <span class="tooltip tippy"
                                          data-position="top"
                                          data-size="small"
                                          title="<?= __("Determine o valor do crédito da redução de base.") ?>">
                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                </label>

                                <input class="tagBase input js-required"
                                       name="cred_base"
                                       data-type="credito"
                                       data-id="base"
                                       type="text"
                                       value="<?= $User->get("tax_base.credito.value") ?>"
                                       maxlength="30">
                            </div>

                            <div class="col s6 s-last m6 m-last l6 l-last">
                                <label class="form-label">
                                  <span class="compulsory-field-indicator">*</span>  
                                     <?= __("Débito (Redução de base):") ?>
                                     <span class="tooltip tippy"
                                          data-position="top"
                                          data-size="small"
                                          title="<?= __("Determine o valor do débito da redução de base.") ?>">
                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                </label>

                                <input class="tagBase input js-required"
                                       name="deb_base"
                                       data-type="debito"
                                       data-id="base"
                                       type="text"                                       
                                       value="<?= $User->get("tax_base.debito.value"); ?>"
                                       maxlength="30">
                            </div>
</div>
                    
