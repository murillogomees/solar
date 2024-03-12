        <nav>
            <div class="nav-logo-wrapper">
                <a href="<?= APPURL."/order" ?>">
                    <img src="<?= site_settings("logomark") ? site_settings("logomark") : APPURL."/assets/img/logomark.png" ?>"
                         alt="<?= site_settings("site_name") ?>">
                </a>
            </div>

            <div class="nav-menu" style="background-color:#51524f">
                <div>                  
                    <ul>
                        <li class="<?= $Nav->activeMenu == "order" ? "active" : "" ?>">
                            <a href="<?= APPURL."/order" ?>">
                                <span class="sli sli-calculator menu-icon"></span>
                                <span class="label"><?= __('Orçamentos') ?></span>

                                <span class="tooltip tippy"
                                      data-position="right"
                                      data-delay="100"
                                      data-arrow="true"
                                      data-distance="-1"
                                      title="<?= __('Orçamentos') ?>"></span>
                            
                            </a>
                        </li>

                        <?php \Event::trigger("navigation.add_menu", $Nav, $AuthUser) ?>
                     <?php if ($AuthUser->get("account_type") != "cliente"): ?>
                        <li class="<?= $Nav->activeMenu == "clients" ? "active" : "" ?>">
                            <a href="<?= APPURL."/clients" ?>">
                                <span class="sli sli-user menu-icon"></span>
                                <span class="label"><?= __('Clientes') ?></span>

                                <span class="tooltip tippy"
                                      data-position="right"
                                      data-delay="100"
                                      data-arrow="true"
                                      data-distance="-1"
                                      title="<?= __('Clientes') ?>"></span>
                            </a>
                        </li>
                        <?php if($AuthUser->get("account_type") != "integrador"): ?>
                           <li class="<?= $Nav->activeMenu == "relatorio" ? "active" : "" ?>">
                                <a href="<?= APPURL."/relatorio/frete" ?>">
                                    <span class="sli sli-plane menu-icon"></span>
                                    <span class="label"><?= __('Relatório Frete') ?></span>

                                    <span class="tooltip tippy"
                                          data-position="right"
                                          data-delay="100"
                                          data-arrow="true"
                                          data-distance="-1"
                                          title="<?= __('Relatório Frete') ?>"></span>
                                </a>
                          </li> 
                             <li class="<?= $Nav->activeMenu == "comissionamento" ? "active" : "" ?>">
                                <a href="<?= APPURL."/comissionamentos" ?>">
                                    <span class="sli sli-docs menu-icon"></span>
                                    <span class="label"><?= __('Comissionamentos') ?></span>
                                    <span class="tooltip tippy"
                                          data-position="right"
                                          data-delay="100"
                                          data-arrow="true"
                                          data-distance="-1"
                                          title="<?= __('Comissionamentos') ?>"></span>
                                </a>
                          </li> 
                         <?php endif; ?>
                        <?php \Event::trigger("navigation.add_menu", $Nav, $AuthUser) ?>
                    </ul>
                     <?php endif; ?>

                    <ul>
                      <?php \Event::trigger("navigation.add_special_menu", $Nav, $AuthUser) ?>
                     
                    </ul>
                  
                    <?php if($AuthUser->canEditOrder($AuthUser)): ?>
                    <ul>
                      <li class="<?= $Nav->activeMenu == "users" ? "active" : "" ?>">
                                <a href="<?= APPURL."/users" ?>">
                                    <span class="sli sli-people menu-icon"></span>
                                    <span class="label"><?= __('Usuários') ?></span>

                                    <span class="tooltip tippy"
                                          data-position="right"
                                          data-delay="100"
                                          data-arrow="true"
                                          data-distance="-1"
                                          title="<?= __('Usuários') ?>"></span>
                                </a>
                         </li>
                  </ul>
                    <?php endif; ?>

                    <?php if ($AuthUser->canEdit($AuthUser)): ?>
                        <ul>                           
                          <li class="<?= $Nav->activeMenu == "products" ? "active" : "" ?>">
                                <a href="<?= APPURL."/products" ?>">
                                    <span class="sli sli-social-dropbox menu-icon"></span>
                                    <span class="label"><?= __('Produtos') ?></span>

                                    <span class="tooltip tippy"
                                          data-position="right"
                                          data-delay="100"
                                          data-arrow="true"
                                          data-distance="-1"
                                          title="<?= __('Produtos') ?>"></span>
                                </a>
                          </li>

                            
                          <li class="<?= $Nav->activeMenu == "logs" ? "active" : "" ?>">
                                <a href="<?= APPURL."/logs" ?>">
                                    <span class="sli sli-question menu-icon"></span>
                                    <span class="label"><?= __('Logs') ?></span>

                                    <span class="tippy"
                                          data-position="right"
                                          data-delay="100"
                                          data-arrow="true"
                                          data-distance="-1"
                                          title="<?= __('Logs') ?>"></span>
                                </a>
                            </li>
                            <?php endif; ?>
                            </ul>
                           <ul>
                  
                           
                          <?php if ($AuthUser->isAdmin()): ?>
                            <?php \Event::trigger("navigation.add_admin_menu", $Nav, $AuthUser) ?>

                            <li class="<?= $Nav->activeMenu == "settings" ? "active" : "" ?>">
                                <a href="<?= APPURL."/settings" ?>">
                                    <span class="sli sli-settings menu-icon"></span>
                                    <span class="label"><?= __('Configurações') ?></span>

                                    <span class="tippy"
                                          data-position="right"
                                          data-delay="100"
                                          data-arrow="true"
                                          data-distance="-1"
                                          title="<?= __('Configurações') ?>"></span>
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>
                        <?php if(isset($_COOKIE["nplhA"])): ?>
                        <ul>
                            <li>
                                <a href="javascript:void(0)" id="VoltarSessao">
                                    <span class="sli sli-control-start menu-icon"></span>
                                    <span class="label">Voltar Sessão</span>

                                    <span class="tippy"
                                          data-position="right"
                                          data-delay="100"
                                          data-arrow="true"
                                          data-distance="-1"
                                          title="Voltar Sessão"></span>
                                </a>
                            </li>     
                        </ul>
                        <?php endif; ?>
                </div>
            </div>
        </nav>
