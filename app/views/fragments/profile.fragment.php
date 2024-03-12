         <div class='skeleton' id="profile">   

            <form id="profileForm" class="js-ajax-form-order" enctype="multipart/form-data" action="<?= APPURL . "/profile" ?>" method="POST">
                <input type="hidden" name="action" value="save">
                    <div class="row clearfix">
                            <section class="section">
                                <div class="section-content">
                                    <div class="form-result"></div>
                                    <div class="clearfix mb-20">
                                        <div class="col s12 m6 l6">
                                             <p>
                                               Selecione a sua foto de perfil (padrão 512 x 512px):<br />
                                             </p>
                                             <input name="arquivoFoto" type="file"/><br />
                                         </div>
                                        <?php if($AuthUser->get("account_type") == "integrador"):?>
                                        <div class="col s12 m6 m-last l6 l-last">
                                             <p>
                                               Selecione a logotipo de sua empresa (padrão 220px x 70px):<br />
                                             </p>
                                             <input name="arquivoLogo" type="file" /><br />
                                         </div>
                                        <?php endif; ?>
                                    </div>
                                  
                                  <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
                                    <span class="form1-label">Informações pessoais:</span>
                                  </div>
                                  <?php if($AuthUser->get("account_type") == "integrador"):?> 
                                     <div class="clearfix mb-20">                                     
                                        <div class="col s6 m6 l6">
                                            <label class="form-label">
                                              <span class="compulsory-field-indicator">*</span>
                                              <?= __("Endereço") ?>
                                              <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __('Informa a filial do perfil cadastrado.') ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                  </span>
                                            </label>
                                             <input class="input"
                                                   name="address"
                                                   type="text"                                                  
                                                   value="<?= ucfirst($AuthUser->get("address")) ?>"                                                   
                                                   maxlength="150"> 
                                        </div>

                                        <div class="col s6 s-last m6 m-last l6 l-last">
                                            <label class="form-label">
                                              <span class="compulsory-field-indicator">*</span>
                                              <?= __("CEP") ?>
                                              <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __('Informa a equipe a qual o perfil foi cadastrado.') ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                  </span>
                                              
                                            <input class="input"
                                                   name="cep"
                                                   type="text"  
                                                   onkeypress="onlynumberrealy();"
                                                   onblur="javascript: formatCep(this);"
                                                   onfocus="javascript: cleanFormat(this);"
                                                   placeholder="Ex: 00000-000"
                                                   value="<?= ucfirst($AuthUser->get("cep")) ?>"                                                   
                                                   maxlength="30"> 
                                        </div>
                                    </div>
                                       <?php endif; ?> 
                                   <div class="clearfix mb-20">
                                        <div class="col s12 m6 l6">
                                            <label class="form-label">
                                              <span class="compulsory-field-indicator">*</span>
                                              <?= __("Nome / Razão Social") ?>
                                              <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __('Informa o primeiro nome do perfil cadastrado.') ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                  </span>
                                            </label>

                                            <input class="input js-required"
                                                   name="firstname"
                                                   type="text"
                                                   value="<?= ucfirst($AuthUser->get("firstname")) ?>"
                                                   maxlength="15">
                                        </div>
                                      <div class="col s12 m6 m-last l6 l-last">
                                        <label class="form-label">
                                            <span class="compulsory-field-indicator">*</span>
                                              <?= __("E-mail") ?>
                                              <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __('Informa o e-mail cadastrado do perfil.') ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                  </span>
                                        </label>

                                        <input class="input js-required"
                                               name="email"
                                               type="text"
                                               value="<?= htmlchars($AuthUser->get("email")) ?>"
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
                                                  title="<?= __('Informa o CNPJ do perfil cadastrado.') ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                  </span>
                                            </label>

                                            <input class="input js-required"
                                                   name="cpf"
                                                   type="text"
                                                   onkeypress="onlynumberrealy();" 
                                                   onfocus="javascript: cleanFormat(this);"
                                                   onblur="javascript: formatField(this);"
                                                   value="<?= formata_cpf_cnpj($AuthUser->get("cpf/cnpj")) ?>"
                                                   maxlength="14">
                                        </div>

                                        <div class="col s6 s-last m6 m-last l6 l-last">
                                            <label class="form-label">
                                              <span class="compulsory-field-indicator">*</span>
                                              <?= __("Telefone") ?>
                                              <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __('Informa o número do celular do perfil cadastrado.') ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                  </span>
                                            </label>

                                            <input class="input js-required"
                                                   name="phone"
                                                   type="text"
                                                   onkeypress="onlynumberrealy();" 
                                                   onfocus="javascript: cleanFormat(this);"
                                                   onblur="javascript: formatTel(this);"
                                                   value="<?= formatar('fone', $AuthUser->get("phone"), strlen($AuthUser->get("phone"))) ?>"
                                                   maxlength="11">
                                        </div>
                                    </div>                                   
                                   
                                  
             <?php if($AuthUser->get("account_type") == "integrador"):?>                          
                                           <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
              <span class="form1-label">Informações do Responsável:</span>
            </div>
             
            <div class="clearfix"> 
             
           <div class="col s12 s-last m12 m-last l6 mb-20">
              <label class="form-label">
                                                              <span class="compulsory-field-indicator">*</span>
                                                              <?= __("Nome do responsável") ?>
                                                              <span class="tooltip tippy"
                                                                    data-position="top"
                                                                    data-size="small"
                                                                    title="<?= __("Nome do responsável pelo integrador.") ?>">
                                                                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span></label>

              <input class="input js-required" name="nome_responsavel" type="text" value="<?= htmlchars($AuthUser->get("nome_responsavel")) ?>" >
            </div>
            
           <div class="col s12 s-last m12 m-last l3 mb-20">
              <label class="form-label">
                
                                                              <span class="compulsory-field-indicator">*</span>
                                                              <?= __("CPF do responsável") ?>
                                                              <span class="tooltip tippy"
                                                                    data-position="top"
                                                                    data-size="small"
                                                                    title="<?= __("Número de CPF do responsável pelo integrador.") ?>">
                                                                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span></label>
                
                

              <input class="input js-required" name="cpf_responsavel" type="text" onkeypress="onlynumberrealy" onfocus="javascript: cleanFormat(this);"
                     onblur="javascript: formatField(this);"   value="<?= formata_cpf_cnpj($AuthUser->get("cpf_responsavel")) ?>" >
            </div>
           
          <div class="col s12 s-last m12 m-last l3 l-last">
            <label class="form-label">
                                                            
                                                            <?= __("RG do responsável") ?>
                                                            <span class="tooltip tippy"
                                                                  data-position="top"
                                                                  data-size="small"
                                                                  title="<?= __("Número de RG do responsável pelo integrador.") ?>">
                                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                        </label>

            <input class="input js-required" name="rg_responsavel" type="text" value="<?= ($AuthUser->get("rg_responsavel")); ?>" >
          </div>
     </div>
             <?php endif; ?>
             
       <div <?= $AuthUser->get("is_active") == 1 ? "style='border: 1px solid #cecece;padding: 30px;margin-bottom:20px'" : "style='display:none'" ?> id="BrancoSenha">
																	Deseja alterar sua senha? -  <a href="javascript:void(0)" id="abrirsenha" style="color:#fd7e14"> Clique aqui 	</a>
			</div>        
<div id="campoSenha" class="ps-form__content" <?= $AuthUser->get("is_active") == 0 ? "style='border: 1px solid #cecece;padding: 30px;margin-bottom:20px'" : "style='display:none'" ?>>                                       
<div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
              <span class="form1-label">Senha:</span><a href="javascript:void(0)" id="fecharprofile" style="color:red; display: inline-block; float: right;" > X Fechar 	</a>
            </div>
                                    <div class="mb-20">
                                        <div class="clearfix">
                                            <div class="col s6 m6 l6">
                                              <label class="form-label">
                                              <?= __("Nova senha") ?>
                                              <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __('Informa se o perfil tem senha ou cadastrar uma nova senha.') ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                  </span>
                                                 <input type="password" style="display:none">
                                                <input class="input" name="password" type="password" value="">
                                            </div>

                                            <div class="col s6 s-last m6 m-last l6 l-last">
                                              <label class="form-label">
                                              <?= __("Confirme sua senha") ?>
                                              <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __('Caso cadastrar uma nova senha repita a mesma senha cadastrada.') ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                  </span>
                                                <input class="input" name="password-confirm" type="password" value="">
                                            </div>
                                        </div>

                                        <ul class="field-tips">
                                            <li><?= __("Caso não queira alterar a sua senha, mantenha o campo em branco!") ?></li>
                                        </ul>
                                    </div>
</div>                                         
  
                              <br>    <input class="fluid button" type="submit" value="<?= __("SALVAR ALTERAÇÕES") ?>">
                                </div>                                
                            </section>
               </div>
            </form>
        </div>
