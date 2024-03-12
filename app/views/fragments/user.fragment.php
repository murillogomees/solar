        <div class="skeleton skeleton--full" id="user">
            <div class="clearfix">
                <aside class="skeleton-aside hide-on-medium-and-down">
                    <?php
                        $form_action = APPURL."/users";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php"; ?>
                    <div class="js-search-results">
                        <div class="aside-list js-loadmore-content" data-loadmore-id="1"></div>

                        <div class="loadmore pt-20 none">
                          <a class="fluid button button--light-outline js-loadmore-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?= APPURL."/users?aid=".$User->get("id")."&q=".urlencode(Input::get("q")) ?>">
                            <span class="icon sli sli-refresh"></span>
                            <?= __("Carregar Mais") ?>
                          </a>
                        </div>
                    </div>
                </aside>
                <section  class="skeleton-content">
                    
                    <form class="js-ajax-form"
                          action="<?= APPURL."/users/".($User->isAvailable() ? $User->get("id") : "new") ?>"
                          method="POST">

                       <input type="hidden" name="action" value="save">
                       <input style="display:none">
                       <input type="password" style="display:none">

                        <?php
                            if(null !== $User->get("id")){
                                if($User->get("is_active")){
                                  $titulo = "Usuário: <label style=\"color:#51524f;\">" . htmlchars($User->get("firstname")) . " ". htmlchars($User->get("lastname")) . "</label>";
                                }else{
                                  $titulo = "Usuário: <label style=\"color:red;\">" . htmlchars($User->get("firstname")) . " ". htmlchars($User->get("lastname")) . "</label>";
                                }
                            } else {
                                $titulo = "Cadastro de Usuário";
                            }
                        ?>
                        <div class="section-header" style="border-left: 5px solid #f07e13">
                              <div class="clearfix">
                                     <div class="col s12 m12 l6">
                                        <?= $titulo; ?>                                       
                                     </div> 
                                    <?php if($User->get("account_type") != "diretoria" && $User->get("is_active") == 1): ?>
                                     <div class="col s12 m12 l6 l-last">   
                                      <button style='width:100%' class="fluid button" name="lg" id="logarUsuario">
                                          <?= __("Logar") ?>
                                      </button>                               
                                    </div>
                                    <?php endif; ?>
                             </div>
                          
                        </div>
                       <div id="tabs" class="af-tab-heads clearfix">
                           <a href="javascript:void(0)" id="geral" class="tab-user geral active"><?= __("Informações Pessoais") ?></a>
                           <?php if($AuthUser->canEdit($AuthUser)): ?>
                           <a href="javascript:void(0)" id="permissoes" class="tab-user permissoes"><?= __("Permissões") ?></a>
                           <?php endif; ?>
                       </div>
                        <div style="max-width:100% !important" class="section-content">
                            <div class="form-result"></div>
                              <div id="geral_tab" class="tab_content clearfix" >
                                <?php require_once(APPPATH.'/views/fragments/usuario/user.fragment.php'); ?>
                              </div>
                              <?php if($AuthUser->canEdit($AuthUser)): ?>
                              <div id="permissoes_tab" class="tab_content" hidden>
                                <?php require_once(APPPATH.'/views/fragments/usuario/permissoes.fragment.php'); ?>
                              </div>
                              <?php endif; ?>
                              <div class="clearfix">
                                  <div class="col s12 m12 l12">
                                      <input  style='width:100%' class="fluid button" name="submiggt" type="submit" value="<?= __("Salvar") ?>">
                                  </div>
                              </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>