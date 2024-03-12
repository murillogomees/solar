        <div class="skeleton skeleton--full" id="user">
            <div class="clearfix">
                <aside class="skeleton-aside hide-on-medium-and-down">
                    <?php
                        $form_action = APPURL."/icms";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php";
                    ?>

                    <div class="js-search-results" style="background-color: #fff";>
                        <div class="aside-list js-loadmore-content" data-loadmore-id="1"></div>

                        <div class="loadmore pt-20 none">
                            <a class="fluid button button--light-outline js-loadmore-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?= APPURL."/icms?aid=".$Route->params->id."&q=".urlencode(Input::get("q")) ?>">
                                <span class="icon sli sli-refresh"></span>
                                <?= __("Carregar Mais") ?>
                            </a>
                        </div>
                    </div>
                </aside>
                <section class="skeleton-content">
                    <form class="js-ajax-form"
                          action="<?= APPURL."/icms/" . $Route->params->id ?>"
                          method="POST">

                        <input type="hidden" name="action" value="save">

                            <?php
                                $estado = checkState($User->get("uf_beggin"));
                                if(null !== $User->get("uf_beggin")){
                                    $titulo = "Estado: <div style=\"color:#51524f;\">" . $estado . "</div>";
                                } else {
                                    $titulo = "ICMS";
                                }
                             ?>

                        <input type="hidden" name="uf_beggin" value="<?= $User->get("uf_beggin") ?>">

                        <div class="section-header" style="border-left: 5px solid #f07e13">
                          <div class="clearfix">
                            <div class="col s4 m4 l4">
                              <?= $titulo; ?>
                           </div>
                         </div>
                        </div>
                                <div class="section-content">
                                    <div class="form-result"></div>

                                        <div class="clearfix mb-20">
                                            <div class="col s6 m3 l3">
                                                <label class="form-label">
                                                    <?= __("Acre (AC) ") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="ac"
                                                    type="text"
                                                    onkeypress="return onlynumber(this);"
                                                    placeholder="Ex:2%"
                                                    value="<?= $User->get("ac") != NULL ? $User->get("ac") : "0"?>%"
                                                    maxlength="50"
                                                    >
                                            </div>

                                            <div class="col s6 s-last m3 l3">
                                                <label class="form-label">
                                                    <?= __("Alagoas (AL)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="al"
                                                    type="text"
                                                    min="0"
                                                    max="100"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("al") != NULL ? $User->get("al") : "0" ?>%"
                                                    maxlength="50"
                                                    >
                                            </div>

                                            <div class="col s6 m3 l3">
                                                <label class="form-label">
                                                    <?= __("Amapá (AP)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="ap"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("ap") != NULL ? $User->get("ap") : "0" ?>%"
                                                    maxlength="50"
                                                    >
                                            </div>

                                            <div class="col s6 s s-last m3 m-last l3 l-last">
                                                <label class="form-label">
                                                    <?= __("Amazonas (AM)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="am"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("am") != NULL ? $User->get("am") : "0" ?>%"
                                                    maxlength="50"
                                                    >
                                            </div>

                                        </div>

                                        <div class="clearfix mb-20">

                                            <div class="col s6 m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Bahia (BA)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="ba"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("ba") != NULL ? $User->get("ba") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 s-last m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Ceará (CE)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="ce"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("ce") != NULL ? $User->get("ce") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Distrito Federal (DF)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="df"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("df") != NULL ? $User->get("df") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 s-last m3 m-last l3 l-last">
                                                <label class="form-label">
                                                    <?= __("Espírito Santo (ES)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="es"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("es") != NULL ? $User->get("es") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>
                                        </div>

                                        <div class="clearfix mb-20">

                                            <div class="col s6 m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Goiás (GO)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="go"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("go") != NULL ? $User->get("go") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 s-last m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Maranhão (MA)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="ma"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("ma") != NULL ? $User->get("ma") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Mato Grosso (MT)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="mt"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("mt") != NULL ? $User->get("mt") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 s-last m3 m-last l3 l-last">
                                                <label class="form-label">
                                                    <?= __("Mato Grosso do Sul (MS)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="ms"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("ms") != NULL ? $User->get("ms") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>


                                        </div>

                                        <div class="clearfix mb-20">

                                            <div class="col s6 m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Minas Gerais (MG)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="mg"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("mg") != NULL ? $User->get("mg") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 s-last m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Pará (PA)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="pa"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("pa") != NULL ? $User->get("pa") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Paraíba (PB)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="pb"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("pb") != NULL ? $User->get("pb") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 s-last m3 m-last l3 l-last">
                                                <label class="form-label">
                                                    <?= __("Paraná (PR)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="pr"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("pr") != NULL ? $User->get("pr") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>


                                        </div>

                                        <div class="clearfix mb-20">

                                            <div class="col s6 m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Pernambuco (PE)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="pe"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("pe") != NULL ? $User->get("pe") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 s-last m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Piauí (PI)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="pi"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("pi") != NULL ? $User->get("pi") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Rio de Janeiro (RJ)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="rj"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("rj") != NULL ? $User->get("rj") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 s-last m3 m-last l3 l-last">
                                                <label class="form-label">
                                                    <?= __("Rio Grande do Norte (RN)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="rn"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("rn") != NULL ? $User->get("rn") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>


                                        </div>

                                        <div class="clearfix mb-20">

                                            <div class="col s6 m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Rio Grande do Sul (RS)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="rs"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("rs") != NULL ? $User->get("rs") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 s-last m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Rondônia (RO)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="ro"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("ro") != NULL ? $User->get("ro") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Roraima (RR)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="rr"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("rr") != NULL ? $User->get("rr") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 s-last m3 m-last l3 l-last">
                                                <label class="form-label">
                                                    <?= __("Santa Catarina (SC)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="sc"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("sc") != NULL ? $User->get("sc") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>


                                        </div>

                                        <div class="clearfix mb-20">

                                            <div class="col s6 m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("São Paulo (SP)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="sp"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("sp") != NULL ? $User->get("sp") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 s-last m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Sergipe (SE)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="se"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("se") != NULL ? $User->get("se") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                             <div class="col s6 m3 l3 ">
                                                <label class="form-label">
                                                    <?= __("Tocantins (TO)") ?>
                                                </label>

                                                <input class="input js-required"
                                                    name="to"
                                                    type="text"
                                                    onkeypress="return onlynumber();"
                                                    placeholder="Ex: 2 %"
                                                    value="<?= $User->get("to") != NULL ? $User->get("to") : "0" ?>%"
                                                    maxlength="20"
                                                    >
                                            </div>

                                            <div class="col s6 s-last m3 m-last l3 l-last" style="padding-top:22px">
                                                 <input class="fluid button" type="submit" value="<?= __("Salvar") ?>">
                                            </div>

                                          </div>

                                    </div>
                                </div>

                        </div>
                    </form>
                </section>
            </div>
        </div>
