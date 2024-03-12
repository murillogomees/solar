<div id="target-list-popup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="target-list-popup" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-hr">
                            <h2 class="modal-title section-title"><?= __("Insira os Ncm's do benefício") ?></h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span class="mdi mdi-close-circle"></span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="modal-content-body">
                                <div class="clearfix mb-10">
                                    <div class="pos-r">
                                        <textarea class="target-list caption-input input"
                                                  name="target-list"
                                                  id="target-list"
                                                  maxlength="5000"
                                                  spellcheck="true"
                                                  placeholder="<?= __("Digite aqui o NCM") ?>"></textarea>
                                    </div>
                                </div>

                                <ul class="field-tips">
                                    <li><?= __("O Ncm não aceita pontos, virgulas e traços use esse formato: 8500451") ?></li>
                                    <li><?= __("Utilze apenas um Ncm por linha") ?></li>
                                </ul>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="col s12 m6 l6 target-list-mb mr-0">
                              <a class="js-reactions-target-list tg-l-button fluid button"
                               href="javascript:void(0)">
                                   <?= __("Inserir") ?>
                               </a>
                            </div>
                        </div>

                    </div>
                </div>
</div>
