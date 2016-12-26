<?php
use yii\helpers\Url;

ob_start();
?>
var TrafficStreamStatisticApi = function()
{
  this.getFilterValue = function(filterName)
  {
    var filterAttr= 'data-traffic-stream-' + filterName + '-filter';
    var filterSelector = '[' + filterAttr + ']:first';

    var item = $(filterSelector);

    if(item.length == 0)
    {
      return null;
    }

    return item.attr(filterAttr);
  };

  this.getInterval = function()
  {
    var val = this.getFilterValue('interval');

    if(val == null)
    {
      return 'all';
    }

    return val;
  };

  this.getStartDate = function()
  {
    return this.getFilterValue('startdate');
  };

  this.getFinishDate = function()
  {
    return this.getFilterValue('finishdate');
  };

  this.getUserSubaccountsIds = function()
  {
    return this.getFilterValue('user-subaccounts');
  };

  this.getIDS = function()
  {
    var ids = new Array();

    $('[data-TrafficStream-id]').each(function(){
      ids.push($(this).attr('data-TrafficStream-id'))
    });

    return ids;
  };

  this.load = function()
  {

    var data = {
      interval: this.getInterval(),
      custom_start_date: this.getStartDate(),
      custom_finish_date: this.getFinishDate(),
      user_subaccounts_ids: this.getUserSubaccountsIds(),
      id: this.getIDS()
    };

    $.ajax({
      url: '<?= Url::toRoute(['/api/traffic-stream-statistic']) ?>',
      method: 'POST',
      data: data,
      dataType: 'json',
      success: function(data)
      {
        for(var i in data)
        {
          var item = data[i];
          var ts = $('[data-TrafficStream-id="' + item.id + '"]:first');

          if(ts.length == 0)
          {
            continue;
          }

          ts.find('[data-role="stat"][data-target="clicks_count"]').html(item.stat.clicks_count);
          ts.find('[data-role="stat"][data-target="subscribes_count"]').html(item.stat.subscribes_count);
          ts.find('[data-role="stat"][data-target="bill_sum"]').html(item.stat.bill_sum);
          ts.find('[data-role="stat"][data-target="ecpc"]').html(item.stat.ecpc);
          ts.find('[data-role="stat"][data-target="cpc"]').html(item.stat.cpc);
          ts.find('[data-role="stat"][data-target="roi"]').html(item.stat.roi);
        }
      }
    });
  };

  this.bindEvents = function()
  {
    this.load();

    var self = this;
    setInterval(function(){
      self.load();
    }, 5000);
  };

  this.bindEvents();
};

$(document).ready(function(){
  new TrafficStreamStatisticApi();
});

<?php
$this->registerJs(ob_get_contents());
ob_end_clean();
?>
