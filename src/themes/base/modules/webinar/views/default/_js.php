<?php
use yii\helpers\Url;

ob_start();
?>
var WebinarViewer = function() {
  this.namesDictionary = '<?= $model->names_dictionary ?>';
  this.namesList = this.namesDictionary.split(',');
  this.prevViewersCount = 0;
  this.advertEnabled = false;
  this.activeNames = [];

  var self = this;

  this.sync = function() {
      $.ajax({
          url: '<?= Url::to(['/webinar/api/default/view', 'id' => $model->id]) ?>',
          dataType: 'json',
          method: 'GET',
          success: function(data, textStatus, jqXHR) {
            self.render(data);
          }
      });
  };

  this.render = function(data) {
    var viewers = '';
    for (var i in data.viewers) {
      var viewer = data.viewers[i];
      viewers = viewers + '<li class="collection-item">' + viewer + '</li>';
    }

    $('#webinar-viewers-count').html(data.viewersCount);
    $('#webinar-viewers ul .a').html(viewers);

    if (data.enableAdvert) {
      $('#webinar-advert').removeClass('hide');
    }

    this.renderViewers(data.viewersCount);
  }

  this.renderViewers = function(viewersCount) {
    var diff = viewersCount - self.prevViewersCount;

    self.prevViewersCount = viewersCount;

    if (diff > 0) {
      return this.addViewers(diff);
    }

    if (diff < 0) {
      return this.dropViewers(Math.abs(diff));
    }
  };

  this.addViewers = function(vCount) {
    var items = '';
    for (var i = 0; i < vCount; i++) {
        items = items + '<li class="collection-item vg">' + this.getViewerName() + '</li>';
    }

    $('#webinar-viewers ul .g').append($(items));
  };

  this.dropViewers = function(vCount) {
    for (var i = 0; i < vCount; i++) {
      $('#webinar-viewers ul .g li.vg:last').hide(0).remove();
    }
  }

  this.getViewerName = function() {
    return 'Vasya Pupkin ' + Math.random() * (100 - 1) + 100;
  }

  this.start = function() {
      this.sync();
      setInterval(this.sync, 5000);
  }

  this.start();
}

$(document).ready(function(){
  new WebinarViewer();
});

<?php
$this->registerJs(ob_get_contents());
ob_end_clean();
?>
