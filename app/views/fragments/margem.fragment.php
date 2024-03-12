        <div class="skeleton skeleton--full" id="user">
            <div class="clearfix">
                <section class="skeleton-content">
                    <form class="js-ajax-form"
                          action="<?= APPURL."/margem/" ?>"
                          method="POST">
                        <input type="hidden" name="action" value="save">
                        <div class="section-header  mb-20" style="border-left: 5px solid #f07e13">
                           Margem  Kit's / Unitários
                        </div>
                            <div class="clearfix mb-20" style="padding: 24px;">
                              <div class="col s6 m6 l6  mb-20">
                                 <label class="form-label">
                                              <span class="compulsory-field-indicator">*</span>
                                              <?= __("Margem Kit") ?>
                                              <span class="tooltip tippy"
                                                    data-position="top"
                                                    data-size="small"
                                                    title="<?= __("Determina a margem para o calculo do KIT.") ?>">
                                                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                          </label>

                                          <input class="input js-required"
                                                 name="kit"
                                                 onkeypress="onlynumber();"
                                                 type="text"
                                                 value="<?= htmlchars($opcao->get("margem_kit")) ?>"
                                                 maxlength="3">
                              </div>
                              <div class="col s6 s-last m6 m-last l6 l-last  mb-20">
                                  <label class="form-label">
                                    <span class="compulsory-field-indicator">*</span>
                                    <?= __("Margem Unitário") ?>
                                    <span class="tooltip tippy"
                                        data-position="top"
                                        data-size="small"
                                        title="<?= __("Determina a margem para o calculo  unitário.") ?>">
                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                  </label>

                               <input class="input js-required"
                                                 name="unitario"
                                                 type="text"
                                                 onkeypress="onlynumber();"
                                                 value="<?= htmlchars($opcao->get("margem_un")) ?>"
                                                 maxlength="3">
                              </div> 
                            <div class="clearfix">
                                <div style="width:100%" class="col s12 m12 l6">
                                    <input style="width:100%; border-radius:10px;" class="fluid button" type="submit" value="<?= __("Salvar") ?>">
                                </div>
                            </div>
                            </div>
                    </form>
                </section>
            </div>
        </div>
