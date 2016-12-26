var StatisticsManager = function()
{
  this.activate = function()
  {
    var started_time = Math.floor(Date.now() / 1000);
    $('body').attr('data-page-view-started-time', started_time);
  };

  this.send = function()
  {
    var started_time = parseInt($('body').attr('data-page-view-started-time'));
    var scroll_container = $(document);
    if($('#page-content-wrapper').length > 0)
    {
      var scroll_container = $('#page-content-wrapper');
    }

    var scroll = scroll_container.scrollTop();
    var scroll_max = scroll_container.height();
    var screen_size = window.screen.width + 'x' + window.screen.height;
    var spend_time = Math.floor(Date.now() / 1000) - started_time;

    var data = {
      Statistic: {
        page_title: document.title,
        page_url: window.location.href,
        ref_page_url: document.referrer,
        browser_data: window.navigator.userAgent,
        scroll: scroll,
        screen_size: screen_size,
        spend_time: spend_time
      }
    };

    $.ajax({
      url: '/api/statistics/create.json',
      method: 'POST',
      data: data
    });
  };

  this.bindEvents = function()
  {
    this.activate();

    var self = this;
    $(window).unload(function(e){
      self.send();
    });

/* Just for debug reason

    $(document).on('click touchstart', function(e){
      self.send();
    });
/**/

  };

  this.bindEvents();
};

$(document).ready(function(){
  if ($('[data-enable-statistic-log]').length == 0) return;
  new StatisticsManager();
});
