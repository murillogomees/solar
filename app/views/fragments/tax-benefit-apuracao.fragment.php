
                        <div class="clearfix mb-20">
                          <label class="form-label">
                              <?= __("Destaca na NF") ?>
                              <input class="tagNF" type="checkbox" name="nf_apuracao" data-type="apuracao" data-value="nf_apuracao"  <?= $User->get("nota_fiscal.apuracao.value") == "true" ? "checked" : "none"?>/>
                          </label>
                        </div>


                            <label class="form-label">
                              <?= __("Selecione a redução do benefício ou desconto:") ?>
                            </label>

                        <div class="clearfix mb-20">
                          <div class="col s12 m12 l12" style="display:flex;border: solid 1px #f3f3f3;text-align: end;padding-top: 1%;background-color: rgb(218 250 255 / 30%);padding:14px 5px 10px 0px;justify-content:space-evenly;">
                            <label class="form-label">
                                <?= __("Redução de Aliquota") ?>
                                <input class="tagAbA" type="checkbox" data-value="aliquota"  <?= $User->get("tax_apuracao.credito.id") == "aliquota" ? "checked" : "none"?>/>
                            </label>
                            <label class="form-label">
                                <?= __("Redução de Base") ?>
                                <input class="tagAbA" type="checkbox" data-value="base"  <?= $User->get("tax_apuracao.credito.id") == "base" ? "checked" : "none"?>/>
                            </label>
                            <label class="form-label">
                                <?= __("Desconto Integral") ?>
                                <input class="tagAbA" type="checkbox" data-value="integral" <?= $User->get("tax_apuracao.credito.id") == "integral" ? "checked" : "none"?>/>
                            </label>

                          </div>
                        </div>
                          <div id="aliquota" class="apuracaoModTax aliquotaApuracao clearfix mb-20" hidden>
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

                                <input class="input js-required tagApuracao"
                                       name="cred_aliquota"
                                       type="text"
                                       data-id="aliquota"
                                       data-type="credito"   
                                       value="<?= $User->get("tax_apuracao.credito.value") ?>"
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

                                <input class="input js-required tagApuracao"
                                       name="deb_aliquota"
                                       type="text"
                                       data-id="aliquota"
                                       data-type="debito"  
                                       value="<?= $User->get("tax_apuracao.debito.value") ?>"
                                       maxlength="30">
                            </div>
                          </div>
                          <div id="base" class="apuracaoModTax baseApuracao clearfix mb-20" hidden>
                            <div class="col s6 m6 l6">
                                <label class="form-label">
                                    <span class="compulsory-field-indicator">*</span>
                                    <?= __("Crédito (Redução de Base): ") ?>
                                    <span class="tooltip tippy"
                                          data-position="top"
                                          data-size="small"                                          
                                          title="<?= __("Determine o valor do crédido da redução de base.") ?>">
                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                </label>

                                <input class="input js-required tagApuracao"
                                       name="cred_base"
                                       type="text"
                                       data-id="base"
                                       data-type="credito"
                                       value="<?= $User->get("tax_apuracao.credito.value") ?>"
                                       maxlength="30">
                            </div>

                            <div class="col s6 s-last m6 m-last l6 l-last">
                                <label class="form-label">
                                    <span class="compulsory-field-indicator">*</span>
                                    <?= __("Débito (Redução de Base):") ?>
                                    <span class="tooltip tippy"
                                          data-position="top"
                                          data-size="small"                                          
                                          title="<?= __("Determine o valor do débito da redução de base.") ?>">
                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                </label>

                                <input class="input js-required tagApuracao"
                                       name="deb_base"
                                       type="text"
                                       data-id="base"
                                       data-type="debito"
                                       value="<?= $User->get("tax_apuracao.debito.value") ?>"
                                       maxlength="30">
                            </div>
                          </div>
                          <div id="integral" class="apuracaoModTax integralApuracao clearfix mb-20" hidden>
                            <div class="col s6 m6 l6">
                                <label class="form-label">
                                    <span class="compulsory-field-indicator">*</span>
                                    <?= __("Crédito (Redução Integral): ") ?>
                                    <span class="tooltip tippy"
                                          data-position="top"
                                          data-size="small"
                                          data-id="integral"
                                          data-type="credito"  
                                          title="<?= __("Determine o valor do crédido da redução integral.") ?>">
                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                </label>

                                <input class="input js-required tagApuracao"
                                       name="cred_integral"
                                       type="text"
                                       value="<?= $User->get("tax_apuracao.credito.value") ?>"
                                       maxlength="30">
                            </div>

                            <div class="col s6 s-last m6 m-last l6 l-last">
                                <label class="form-label">
                                    <span class="compulsory-field-indicator">*</span>
                                    <?= __("Débito (Redução Integral):") ?>
                                    <span class="tooltip tippy"
                                          data-position="top"
                                          data-size="small"                                         
                                          title="<?= __("Determine o valor do débito da redução integral.") ?>">
                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                </label>

                                <input class="input js-required tagApuracao"
                                       name="deb_aliquota"
                                       type="text"
                                       data-id="integral"
                                       data-type="debito" 
                                       value="<?= $User->get("tax_apuracao.debito.value") ?>"
                                       maxlength="30">
                            </div>
                          </div>
