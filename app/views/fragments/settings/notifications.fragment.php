            <form class="js-ajax-form" 
                  action="<?= APPURL . "/settings/" . $page ?>"
                  method="POST">
                <input type="hidden" name="action" value="save">

                <div class="section-header clearfix">
                    <h2 class="section-title"><?= __("Notificações de E-Mail") ?></h2>
                    <div class="section-actions clearfix hide-on-large-only">
                        <a class="mdi mdi-menu-down icon js-settings-menu" href="javascript:void(0)"></a>
                    </div>
                </div>

                <div class="section-content">

                    <div class="clearfix">
                        <div class="col s12 m6 l5">
                            <div class="form-result"></div>

                            <div class="mb-40">
                                <label class="form-label"><?= __("Endereço de E-Mail") ?></label>

                                <textarea class="input" 
                                          name="emails"
                                          rows="3"
                                          placeholder="fabio@horustelecom.com.br, tarcisio@horustelecom.com.br"><?= htmlchars($EmailSettings->get("data.notifications.emails")) ?></textarea>

                                <ul class="field-tips">
                                    <li><?= __("As notificações de E-Mail serão enviadas para os endereços a cima.") ?></li>
                                </ul>
                            </div>

                            <div class="mb-20">
                                <label>
                                    <input type="checkbox" 
                                           class="checkbox" 
                                           name="new-user" 
                                           value="1" 
                                           <?= $EmailSettings->get("data.notifications.new_user") ? "checked" : "" ?>>
                                    <span>
                                        <span class="icon unchecked">
                                            <span class="mdi mdi-check"></span>
                                        </span>
                                        <?= __('Novo Usuário') ?>
                                        
                                        <ul class="field-tips">
                                            <li><?= __("Receber notificaçóes quando um novo usuário for cadastrado.") ?></li>
                                        </ul>
                                    </span>
                                </label>
                            </div>                           

                            <input class="fluid button" type="submit" value="<?= __("Salvar") ?>">
                        </div>
                    </div>
                </div>
            </form>