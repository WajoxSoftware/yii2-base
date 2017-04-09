<div id="subaccounts_link_generator_modal" class="modal  js-subaccounts-link-generator-modal">
    <div class="modal-content">
      <h4><?= \Yii::t('app/general', 'Generate link') ?></h4>
      <input type="text" class="form-control js-link" data-original-link=""/>
    </div>
    <div class="modal-footer">
        <a href="#" class="modal-action modal-close btn-flat"><?= \Yii::t('app/general', 'Close') ?></a>
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

  this.getSubaccountPartsSelector = function()
  {
    return '.js-subaccounts-link-generator-modal:first .js-subaccount-1, .js-subaccounts-link-generator-modal:first .js-subaccount-2, .js-subaccounts-link-generator-modal:first .js-subaccount-3, .js-subaccounts-link-generator-modal:first .js-subaccount-4';
  }

  this.getSubaccountPartsElements = function()
  {
    return this.getModal().find('.js-subaccount-1, .js-subaccount-2, .js-subaccount-3, .js-subaccount-4');
  };

  this.cleanPart = function(part)
  {
    if(part == undefined || part == null) {
      return '';
    }

    //return encodeURIComponent(part);
    return part;
  }

  this.getSubaccountFullTag = function()
  {
    var parts = [];

    var part1 = this.cleanPart(this.getModal().find('.js-subaccount-1').val());
    var part2 = this.cleanPart(this.getModal().find('.js-subaccount-2').val());
    var part3 = this.cleanPart(this.getModal().find('.js-subaccount-3').val());
    var part4 = this.cleanPart(this.getModal().find('.js-subaccount-4').val());

    if(part1 != '') {
      parts.push(part1);
      if(part2 != '') {
        parts.push(part2);
        if(part3 != '') {
          parts.push(part3);
          if(part3 != '') {
            parts.push(part4);
          }
        }
      }
    }

    return parts.join('/');
  };

  this.getSubaccount = function()
  {
    return this.getModal().find('.js-subaccount:first');
  };

  this.showModal = function()
  {
    this.getModal().modal('open');
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
    var tag = this.getSubaccountFullTag();
    link = link.replace(/\[subaccount_tag\]/, tag);
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
