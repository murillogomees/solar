            <form class="js-ajax-form"
                  action="<?= APPURL . "/settings/" . $page ?>"
                  method="POST">
                <input type="hidden" name="action" value="save">

                <div class="section-header clearfix">
                    <h2 class="section-title"><?= __("Site Settings") ?></h2>
                    <div class="section-actions clearfix hide-on-large-only">
                        <a class="mdi mdi-menu-down icon js-settings-menu" href="javascript:void(0)"></a>
                    </div>
                </div>

                <div class="section-content">
                    <div class="form-result"></div>

                    <div class="clearfix">
                        <div class="col s12 m12 l12">
                            <div class="mb-20">
                                <label class="form-label"><?= __("Site name") ?>
                                  <span class="tooltip tippy"
                                          data-position="top"
                                          data-size="small"
                                          title="<?= __('Define o nome do Site.') ?>">
                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                </label>

                                <input class="input"
                                       name="name"
                                       type="text"
                                       value="<?= htmlchars($Settings->get("data.site_name")) ?>"
                                       placeholder="<?= __("Enter site name here") ?>"
                                       maxlength="100">
                            </div>

                            <div class="mb-20">
                                <label class="form-label"><?= __("Site description") ?>
                                  <span class="tooltip tippy"
                                          data-position="top"
                                          data-size="small"
                                          title="<?= __('Define a descrição do SITE.') ?>">
                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                        </label>

                                <textarea class="input"
                                          name="description"
                                          maxlength="255"
                                          rows="3"><?= htmlchars($Settings->get("data.site_description")) ?></textarea>

                                <ul class="field-tips">
                                    <li><?= __("Recommended length of the description is 150-160 characters") ?></li>
                                </ul>
                            </div>

                            <div class="mb-40">
                                <label class="form-label"><?= __("Keywords") ?>
                                  <span class="tooltip tippy"
                                          data-position="top"
                                          data-size="small"
                                          title="<?= __('Defina palavras chaves para as buscas.') ?>">
                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                </label>

                                <textarea class="input"
                                          name="keywords"
                                          maxlength="500"
                                          rows="3"><?= htmlchars($Settings->get("data.site_keywords")) ?></textarea>
                            </div>
                        </div>
                       
                    </div>

                    <div class="clearfix">
                        <div class="col s12 m12 l12">
                            <input class="fluid button" type="submit" value="<?= __("Save") ?>">
                        </div>
                    </div>
                </div>
            </form>
