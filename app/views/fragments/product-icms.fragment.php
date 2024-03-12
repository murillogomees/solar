<div class="clearfix mb-20">
  <div class="col s12 m12 l12 mb-20">
    <label class="form-label">
        <span class="compulsory-field-indicator">*</span>
        <?= __("Status do ICMS:") ?>
    </label>
    
    <select class="input active-icms" name="is_active_icms">       
        <option value="0" <?= $User->get("is_active_icms") == 0 ? "selected" : "" ?> selected><?= __("Desativado") ?></option>
        <option value="1" <?= $User->get("is_active_icms") == 1 ? "selected" : "" ?>><?= __("Ativo") ?></option>        
    </select>
  </div>
 
  <div class="table-icms col s12 s-last m12 m-last l12 l-last" <?= $User->get("is_active_icms") == 1 ? "" : "hidden disabled" ?>>
    <label class="form-label">
        <?= __("Tabela de ICMS:") ?>
    </label>
    
    <table border="1">
      <tr>
        <th style="background-color: #2a3f54;color: #fff;">Estados</th>
        <?php foreach($Estados->getDataAs("State") as $tx): ?>
          <th scope="col" style="background-color: antiquewhite;"><?= strtoupper($tx->get("uf")) ?></th>
        <?php endforeach; ?>
      </tr>
      <tr>        
       <?php foreach($Estados->getDataAs("State") as $tx): ?>
        <tr>
          <th scope="row" style="background-color: lightsteelblue;"><?= strtoupper($tx->get("uf")) ?></th>
          <?php foreach($Estados->getDataAs("State") as $txLinha): ?>
            <td><input name="<?= strtolower($txLinha->get("uf")) . "-" . strtolower($txLinha->get("uf"))?>" type="text" style="width:30px; border:none;" value="<?= $fieldsIcms[strtolower($tx->get("uf"))][strtolower($txLinha->get("uf"))] ?>"/></td>
          <?php endforeach; ?>
        </tr>  
       <?php endforeach; ?>
      </tr>
    </table>

    <label>
        <?= __("Origem  -  ") ?>
    </label>
    <label style="margin: 5px;display:inline;width:30px;float:left;height:10px;background-color:lightsteelblue"></label>
    <label>
        <?= __("Destino") ?>
    </label>
    <label style="margin: 5px;display:inline;width:30px;position:absolute;height:10px;background-color:antiquewhite"></label>
</div>
</div>
