<?php
                                                $finance = $User->isAvailable()
                                                         ? json_decode($User->get("finance"))
                                                         : [];
?>

<div class="clearfix mb-20" style="border-bottom:solid 1px #cecece;margin-left:15px;">
<span class="form-label">Regime de Incidência Cumulativa:</span> </div> 


  <div class="clearfix mb-20">
    <div class="col s12 m6 l2">
                                                <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Crédito Cofins (%)") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determine o Crédito de Cofins do Produto.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

                                                <input class="input js-required priceProduct" style="text-align:center" name="cred_cofins" type="text" value="<?= $finance->cred_cofins ?>" maxlength="30">
    </div>


    <div class="col s12 s-last m6 m-last l2">
                                               <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Débito Cofins (%)") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Determine o Débito de Cofins do Produto.") ?>">
                                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                              </label>

                                              <input class="input js-required priceProduct" style="text-align:center" name="deb_cofins" type="text" value="<?= $finance->deb_cofins ?>" maxlength="30">
    </div>

    <div class="col s12 m6 l2">
                                                <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Crédito ICMS (%)") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determine o Crédito de ICMS do Produto") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

                                                <input class="input js-required priceProduct" style="text-align:center" name="cred_icms" type="text" value="<?= $finance->cred_icms ?>" maxlength="30">
    </div>


    <div class="col s12 s-last m6 m-last l2">
      <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Débito ICMS (%)") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Determine o Débito de ICMS do Produto.") ?>">
                                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                              </label>

      <input class="input js-required priceProduct" style="text-align:center" name="deb_icms" type="text" value="<?= $finance->deb_icms ?>" maxlength="30">
    </div>
  
      
      

    <div class="col s12 m6 l2">
                                                <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Crédito PIS (%)") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determine o Crédito de PIS do Produto.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

                                                <input class="input js-required priceProduct" style="text-align:center" name="cred_pis" type="text" value="<?= $finance->cred_pis ?>" maxlength="30">
    </div>


    <div class="col s12 m6 m-last l2 l-last">
                                               <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Débito PIS (%)") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Determine o Débito de PIS do Produto.") ?>">
                                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                              </label>

                                              <input class="input js-required priceProduct" style="text-align:center" name="deb_pis" type="text" value="<?= $finance->deb_pis ?>" maxlength="30">
    </div>
      </div>
   <div class="clearfix">
    <div class="col s12 m6 l2">
                                                 <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("MVA Externo (%)") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determine a Margem de Valor Agregado do Produto.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

                                                <input class="input js-required priceProduct" style="text-align:center" name="mvaexterno" type="text" value="<?= $finance->mvaexterno ?>" maxlength="30">
    </div>
      
      <div class="col s12 m6 l2">
                                                 <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("MVA Interno (%)") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determine a Margem de Valor Agregado do Produto para comercialização interna no DF.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

                                                <input class="input js-required priceProduct" style="text-align:center" name="mvainterno" type="text" value="<?= $finance->mvainterno ?>" maxlength="30">
    </div>


    <div class="col s12 s-last m6 m-last l2 ">
                                              <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("IPI (%)") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Determine a Margem o IPI do Produto.") ?>">
                                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                              </label>

                                              <input class="input js-required priceProduct" style="text-align:center" name="ipi" type="text" value="<?= $finance->ipi ?>" maxlength="30">
    </div>
      <div class="col s12 m6 l2">
      <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("MPPT") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determina a maximum power point tracking “ponto rastreador de potência máxima do produto.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

        
        
      <input class="input js-required" style="text-align:center" name="mppt" type="text" value="<?= $finance->mppt ?>" maxlength="30">
    </div>

      <div class="col s12 m6 l2">
                                                <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Watts") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determine a potência em Watts do produto.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

                                                <input class="input js-required" style="text-align:center" name="watts" type="text" value="<?= $finance->watts ?>" maxlength="30">
    </div>
        
      <div class="col s12 m6 m-last l2 l-last">
                                                <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Voltagem (VA)") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determine o volt-ampére do Produto.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

                                                <input class="input js-required" style="text-align:center" name="va" type="text" value="<?= $finance->va ?>" maxlength="30">
    </div>  
</div>
        
        
<div class="clearfix mb-20 mt-20" style="border-bottom:solid 1px #cecece">
<span class="form-label">Preços: </span> </div>       
        
        
<div class="clearfix mb-20">        
    <div class="col s12 s-last m12 m-last l2">
      <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Custo") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determine o custo do Produto.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

      <input class="input js-required priceProduct" style="text-align:center" data-type="cust" name="cust" type="text" value="<?= htmlchars($User->get("cust")) ?>" maxlength="30">
    </div>
   <div class="col s12 m12 m-last l3">
      <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Custo Líquido") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Informa o custo líquido calculado do Produto.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

      <input class="input js-required" data-type="liquid_cust" name="liquid_cust" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" type="text" style="color: #ffffff;
              background-color: #8b9fb3;
              font-weight: 400;
              font-size: large;"
              value="<?= htmlchars($User->get("liquid_cust")) ?>" maxlength="30" readonly>
    </div>
     
     <div class="col s12 s-last m12 m-last l2">
      <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Margem Kit") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determine a margem bruta(MB) para o kit.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

      <input class="input js-required priceProduct" style="text-align:center" data-type="mb" name="margem_kit" type="text" value="<?= htmlchars($User->get("margem_kit")) ?>" maxlength="30">
    </div>
     
    <div class="col s12 s-last m12 m-last l2">
      <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Margem Unitária") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determine a margem bruta(MB) do Produto.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

      <input class="input js-required priceProduct" style="text-align:center" data-type="mb" name="margem_product" type="text" value="<?= htmlchars($User->get("margem_product")) ?>" maxlength="30">
    </div>
      <div class="col s12 s-last m12 m-last l3 l-last">
      <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Preço Produto") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Informa o preço calculado do Produto.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

      <input class="input js-required number" data-type="price" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" name="price" type="text" style="color: #ffffff;
              background-color: #2a3f54;
              font-weight: 400;
              font-size: large;"
              value="<?= $User->get("price") ?>" maxlength="30" readonly>
    </div>
</div>        