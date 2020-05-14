
(function($){
  
  var abookingsystemdashboardNetwork = {
    save: function(){
        
        // Start Loader
        abookingsystemdashboardLoader.start(absdashboardtext['loading'],
                            absdashboardtext['wait']);
    }
  };
  
  window.abookingsystemdashboardNetwork = abookingsystemdashboardNetwork;
  
})(jQuery);