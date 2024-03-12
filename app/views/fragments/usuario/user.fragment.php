                        <div style="max-width: 92% !important;"  class="section-content">
                            <div class="form-result"></div>

                            <div class="clearfix">
                                    <div class="clearfix mb-20">
                                        <div class="col s6 m6 l6">
                                            <label class="form-label">
                                            <span class="compulsory-field-indicator">*</span>
                                              <?= __("Nível da Conta") ?>
                                            <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __("Atribui o nível de permissão da conta.") ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                            <select id="selectNivel" class="input selectNivel select2" name="account_type">     
                                                 <option value="select" selected disabled hidden>
                                                    <?= __("Selecione") ?>
                                                </option>    
                                              
                                                <option value="vendedor" <?= $User->get("account_type") == "vendedor" ? "selected" : "" ?>>
                                                    <?= __("Vendedor") ?>
                                                </option>
																							
																								<?php if($AuthUser->canEdit($AuthUser)): ?>
																							
																								<option value="integrador" <?= $User->get("account_type") == "integrador" ? "selected" : "" ?>>
                                                    <?= __("Integrador") ?>
                                                </option>
																							
																								<?php endif; ?>
																							
																								<?php if($AuthUser->isAdmin()): ?>		
																							
                                                <option value="supervisor" <?= $User->get("account_type") == "supervisor" ? "selected" : "" ?>>
                                                    <?= __("Supervisor") ?>
                                                </option>
                                                <option value="gerente" <?= $User->get("account_type") == "gerente" ? "selected" : "" ?>>
                                                    <?= __("Gerente") ?>
                                                </option>
                                                <option value="admin" <?= $User->get("account_type") == "admin" ? "selected" : "" ?>>
                                                    <?= __("Administrador") ?>
                                                </option>
                                                <?php endif; ?>
                                              	<?php if($AuthUser->isMaster()): ?>	
                                                <option value="representante" <?= $User->get("account_type") == "representante" ? "selected" : "" ?>>
                                                    <?= __("Representante") ?>
                                                </option>
																								<option value="financeiro" <?= $User->get("account_type") == "financeiro" ? "selected" : "" ?>>
                                                    <?= __("Financeiro") ?>
                                                </option>
                                                <option  value="diretoria" <?= $User->get("account_type") == "diretoria" ? "selected" : "" ?>>
                                                    <?= __("Diretoria") ?>
                                                </option>
																								<?php endif; ?>
                                            </select>
                                        </div>

                                        <div class="col s6 s-last m6 m-last l6 l-last">
                                            <label class="form-label">
                                            <span class="compulsory-field-indicator">*</span>
                                              <?= __("Status") ?>
                                            <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __("Determina se o usuário estará Ativo/Desativado.") ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                            <select class="input select2"
                                                    name="is_active"
                                                    <?= $User->get("id") == $AuthUser->get("id") ? "disabled" : "" ?>>
                                                <?php
                                                    if ($User->isAvailable()) {
                                                        $status = $User->get("is_active") ? 1 : 0;
                                                    } else {
                                                        $status = 1;
                                                    }
                                                ?>
                                                <option value="1" <?= $status == 1 ? "selected" : "" ?>><?= __("Ativo") ?></option>
                                                <option value="0" <?= $status == 0 ? "selected" : "" ?>><?= __("Desativado") ?></option>
                                            </select>
                                             <select style="display:none" class="input"
                                                    name="is_active_antigo"
                                                    <?= $User->get("id") == $AuthUser->get("id") ? "disabled" : "" ?>>
                                                <?php
                                                    if ($User->isAvailable()) {
                                                        $status = $User->get("is_active") ? 1 : 0;
                                                    } else {
                                                        $status = 1;
                                                    }
                                                ?>
                                                <option value="0" selected <?= $status == 0 ? "selected" : "" ?>><?= __("Desativado") ?></option>
                                                <option value="1" <?= $status == 1 ? "selected" : "" ?>><?= __("Ativo") ?></option>
                                                
                                            </select>  
                                        </div>
                                    </div>



                                    <div class="clearfix mb-20">
                                        <div class="col s12 m6 l6">
                                            <label class="form-label">
                                                <span class="compulsory-field-indicator">*</span>
                                                <?= __("Nome") ?>
                                                <span class="tooltip tippy"
                                                      data-position="top"
                                                      data-size="small"
                                                      title="<?= __("Determina o nome do Usuário.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                            <input class="input js-required"
                                                   name="firstname"
                                                   type="text"
                                                   value="<?= htmlchars($User->get("firstname")) ?>"
                                                   maxlength="30">
                                        </div> 
                                     <div class="col s12 m6 m-last l6 l-last">
                                        <label class="form-label">
                                            <span class="compulsory-field-indicator">*</span>
                                            <?= __("E-mail") ?>
                                            <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __("Insira um endereço de e-mail válido.") ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                        </label>

                                        <input class="input js-required"
                                               name="email"
                                               type="email"
                                               value="<?= htmlchars($User->get("email")) ?>"
                                               maxlength="80">
                                    </div>
                                    </div>

                                    <div class="clearfix mb-20">
                                        <div class="col s6 m6 l6">
                                            <label class="form-label">
                                                <span class="compulsory-field-indicator">*</span>
                                                <?= __("CPF/CNPJ") ?>
                                                <span class="tooltip tippy"
                                                      data-position="top"
                                                      data-size="small"
                                                      title="<?= __("Insira um CPF válido.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>


                                            <input class="input js-required"
                                                   name="cpf"
                                                   type="text"
                                                   onkeypress="onlynumberrealy();"
                                                   placeholder= "Ex: 000.000.000-00"
                                                   onblur="javascript: formatField(this);"                                                   
                                                   onfocus="javascript: cleanFormat(this);"
                                                   value="<?= formatar('cpf', $User->get("cpf/cnpj"), strlen($User->get("cpf/cnpj"))) ?>"
                                                   maxlength="14">
                                        </div>


                                        <div class="col s6 s-last m6 m-last l6 l-last">
                                            <label class="form-label">
                                                <span class="compulsory-field-indicator">*</span>
                                                <?= __("Telefone") ?>
                                                <span class="tooltip tippy"
                                                      data-position="top"
                                                      data-size="small"
                                                      title="<?= __("Insira um número de telefone com DD.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                            <input class="input js-required"
                                                   name="phone"
                                                   type="tel"
                                                   onkeypress="onlynumberrealy();"
                                                   onblur="javascript: formatTel(this);" 
                                                   onfocus="javascript: cleanFormat(this);"
                                                   placeholder="Ex: (00) 000000000"
                                                   value="<?= formatar('fone', $User->get("phone")) ?>"
                                                   maxlength="11">
                                        </div>

                                    </div>

                                    <div class="clearfix mb-20 divLoja" <?= $User->get("account_type") == "integrador" ? "style='display:none'" : "" ?>>
                                        <div class="col s6 m6 l6">
                                            <label class="form-label">
                                                <span class="compulsory-field-indicator">*</span>
                                                <?= __("Loja") ?>
                                                <span class="tooltip tippy"
                                                      data-position="top"
                                                      data-size="small"
                                                      title="<?= __("Selecione a Loja que o usuário pertencerá.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                             <select class="input select2" name="branch">
                                                 <option value="" selected disabled hidden>Filial de Origem</option>                                                  
                                                  <?php foreach($ArrayFiliais as $k):?>
                                                    <option value="<?= $k['nome'] ?>" <?= $User->get("office") == $k['nome'] ? "selected"  : "" ?> ><?= $k['nome'] ?></option>
                                                  <?php endforeach;?>                                                                                                  
                                              </select>
                                        </div>

                                        <div class="col s6 s-last m6 m-last l6 l-last">
                                            <label class="form-label">
                                            <span class="compulsory-field-indicator">*</span>
                                              <?= __("Equipe") ?>
                                            <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __("Selecione a Equipe que o usuário pertencerá.") ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                        </label>

                                            <select class="input select2"
                                                    name="team"
                                                     >
                                                <option value="projeto" <?= $User->get("team") == "projeto" ? "selected" : "" ?>>
                                                    <?= __("Projeto") ?>
                                                </option>

                                                <option value="distribuicao" <?= $User->get("team") == "distribuicao" ? "selected" : "" ?>>
                                                    <?= __("Distribuição") ?>
                                                </option>

                                                <option value="televendas" <?= $User->get("team") == "televendas" ? "selected" : "" ?>>
                                                    <?= __("Televendas") ?>
                                                </option>
                                              <?php if($AuthUser->isAdmin()): ?>
                                              <option value="integrador" <?= $User->get("team") == "integrador" ? "selected" : "" ?>>
                                                    <?= __("Integrador") ?>
                                                </option>
                                              <?php endif; ?>

                                            </select>
                                        </div>
                                    </div>
                                          
                                          <div class="clearfix mb-20">
                                              <div class="col s12 s-last m4 m-last l12 l-last pos-r">
                                              <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("ID único:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Gere a chave a chave única.") ?>">
                                                        <span class="mdi mdi-help-circle" ></span>
                                              </label>

                                        <input class="input rightpad santriID " name="api_key" value="<?= $User->get("api_key"); ?>" >
                                        <a href="javascript:void(0)">
                                        <span class="sli sli-plus field-icon--right genSantri" style="bottom: 3px;right: 5px;padding:3px;width:20px;height:20px; background-color: #51524f;color:#fff;border-radius:50px;cursor:pointer;position:absolute;"></span>
                                        </a>  
                                      </div>
                                         </div>
                                         
                                 <div <?= $AuthUser->get("is_active") == 1 ? "style='border: 1px solid #cecece;padding: 30px;margin-bottom:20px'" : "style='display:none'" ?> id="BrancoSenha">
																	Deseja alterar sua senha? -  <a href="javascript:void(0)" id="abrirsenha" style="color:#fd7e14"> Clique aqui 	</a>
																</div>
                                <div id="campoSenha" class="ps-form__content" <?= $AuthUser->get("is_active") == 0 ? "style='border: 1px solid #cecece;padding: 30px;margin-bottom:20px'" : "style='display:none'" ?>>
                                 <div class="col s6 m6 l6">
                                                <label class="form-label">
                                                    <?= __("Nova senha") ?>
                                                    <?php if (!$User->isAvailable()): ?>
                                                        <span class="compulsory-field-indicator">*</span>
                                                    <?php endif ?>
                                                </label>
                                                 <input type="password" style="display:none">
                                                <input class="input <?= $User->isAvailable() ? "" : "js-required" ?>" name="password" type="password" value="">
                                            </div>

                                            <div class="col s6 s-last m6 m-last l6 l-last">
                                              <a href="javascript:void(0)" id="fechar" style="color:red; display: inline-block; float: right;" > X Fechar 	</a>
                                                <label class="form-label">
                                                    <?= __("Confirme a senha") ?>
                                                    <?php if (!$User->isAvailable()): ?>
                                                        <span class="compulsory-field-indicator">*</span>
                                                    <?php endif ?>
                                                </label>
                                                <input class="input <?= $User->isAvailable() ? "" : "js-required" ?>" name="password-confirm" type="password" value="">
                                            </div>
                                        </div>
                                </div>
																					<?php if ($User->isAvailable()): ?>
                                            <ul class="field-tips">
                                                <li><?= __("Se você não deseja alterar a senha, mantenha os campos de senha em branco!") ?></li>
                                            </ul>
                                        <?php endif ?>

                        </div>
                   