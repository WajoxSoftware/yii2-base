<div id="subaccounts_link_generator_modal" class="js-subaccounts-link-generator-modal modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= \Yii::t('app/general', 'Generate link') ?></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <input type="text" class="form-control js-link" data-original-link=""/>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= \Yii::t('app/general', 'Close') ?></button>
      </div>
    </div>
  </div>
</div>

<?php
ob_start();
?>

var UserSubaccountsLinkGenerator = function(){
  this.getModal = function()
  {
    return $('.js-subaccounts-link-generator-modal:first');
  };

  this.getLink = function()
  {
    return this.getModal().find('.js-link:first');
  }

  this.cleanPart = function(part)
  {
    if(part == undefined || part == null) {
      return '';
    }

    return encodeURIComponent(part);
  }

  this.showModal = function()
  {
    this.getModal().modal('show');
  };

  this.setOriginalLink = function(link)
  {
    this.getLink().attr('data-original-link', link);
  };

  this.getOriginalLink = function()
  {
    return decodeURIComponent(this.getLink().attr('data-original-link'));
  };

  this.openModal = function(link)
  {
    this.setOriginalLink(link.attr('data-link-template'));
    this.showModal();
    this.updateLink();
  };

  this.updateLink = function()
  {
    var link = this.getOriginalLink();
    this.getLink().val(link);
  };

  this.bindEvents = function(){
    var self = this;

    $(document).on('click touchstart', 'a[data-subaccount-link-generator]', function(e){
      e.preventDefault();
      e.stopPropagation(); e.stopImmediatePropagation();

      self.openModal($(this));
    });

    $(document).on('change keypress keydown', this.getSubaccountPartsSelector(), function(e){
      self.updateLink();
    });
  };

  this.bindEvents();
};

$(document).ready(function(){
  new UserSubaccountsLinkGenerator();
});

<?php
$this->registerJs(ob_get_contents());
ob_end_clean();
?>
