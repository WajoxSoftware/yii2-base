<?php
use yii\helpers\Url;

ob_start();
?>
var WebinarViewer = function() {
  this.advertEnabled = false;

  this.sync = function() {
      $.ajax({
          url: '<?= Url::to(['/webinar/api/default/view', 'id' => $model->id]) ?>',
          dataType: 'json',
          method: 'GET',
          success: function(data, textStatus, jqXHR) {
            var viewers = '';
            for (var i in data.viewers) {
              var viewer = data.viewers[i];
              viewers = viewers + '<li class="collection-item">' + viewer + '</li>';
            }

            $('#webinar-viewers-count').html(data.viewersCount);
            $('#webinar-viewers ul').html(viewers);

            if (data.enableAdvert) {
              $('#webinar-advert').removeClass('hide');
            }
          }
      });
  };

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
