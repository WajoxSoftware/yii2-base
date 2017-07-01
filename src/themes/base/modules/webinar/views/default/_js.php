<?php
use yii\helpers\Url;

ob_start();
?>
var WebinarViewer = function() {
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
      viewers = viewers + '<li class="webinar-viewers-item">' + viewer + '</li>';
    }

    $('#webinar-viewers-count').html(data.viewersCount);
    $('#webinar-viewers ul .a').html(viewers);

    if (data.enableAdvert) {
      $('#webinar-advert').removeClass('hidden');
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
    for (var i = 0; i < vCount; i++) {
        var item = $('#webinar-viewers ul .g li.hidden:first');
        if (item.length == 0) {
          return;
        }
        item.removeClass('hidden').addClass('visible');
    }
  };

  this.dropViewers = function(vCount) {
    for (var i = 0; i < vCount; i++) {
        var item = $('#webinar-viewers ul .g li.visible:first');
        if (item.length == 0) {
          return;
        }
        item.removeClass('visible').addClass('hidden');
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
