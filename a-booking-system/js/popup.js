
(function($){
  
  /* type watch */
  var abookingsystemdashboardDelay = function(){
      var timer = 0;
      return function(callback, ms){
          clearTimeout (timer);
          timer = setTimeout(callback, ms);
      }  
  }();
  
  window.abookingsystemdashboardDelay = abookingsystemdashboardDelay;
  
  /*
   * Loader
   */
  var abookingsystemdashboardLoaderBullets = {
      start: function(){
          var currentCircle = 0;
          
          setInterval(function(){
              
              if($('.absd-load-circle').eq(currentCircle).hasClass("absd-on1")) {
                  $('.absd-load-circle').eq(currentCircle).removeClass("absd-on1");
                  $('.absd-load-circle').eq(currentCircle).addClass("absd-on2");
                  currentCircle++; 
              } else {
                  $('.absd-load-circle').eq(currentCircle).addClass("absd-on1");
                  
                  if(currentCircle == 7) {
                      currentCircle = 0;
                  }
              }
          }, 30);
      },
      stop: function(){
          $('.absd-load-circle').removeClass('absd-on1');
          $('.absd-load-circle').removeClass('absd-on2');
      } 
  };
  
  window.abookingsystemdashboardLoaderBullets = abookingsystemdashboardLoaderBullets;
  
  var abookingsystemdashboardPopupLoader = {
      start: function(){
          $('#absd-popup').addClass('absd-loader-custom');
          $('#absd-popup').addClass('absd-open');
          $('#absd-popup').css('left', 0);
        
          $('.absd-box').addClass('absd-invisible');
          $('.absd-loader').removeClass('absd-invisible');
          
          abookingsystemdashboardDelay(function(){
              $('#absd-popup .absd-popup-box').addClass('absd-open');
              $('#absd-popup').css('left', 0);
              
              abookingsystemdashboardDelay(function(){
                  abookingsystemdashboardLoaderBullets.start();
              }, 300);
          }, 300);
      },
      
      stop: function(){
          
          abookingsystemdashboardDelay(function(){
              $('#absd-popup .absd-popup-box').removeClass('absd-open');
          
              abookingsystemdashboardDelay(function(){
                  $('#absd-popup').removeClass('absd-loader-custom');
                  $('#absd-popup').removeClass('absd-open');
                  abookingsystemdashboardLoaderBullets.stop();
              }, 300);
          }, 700);
      } 
  };
  
  window.abookingsystemdashboardPopupLoader = abookingsystemdashboardPopupLoader;
  
  var abookingsystemdashboardLoader = {
      start: function(message1,
                      message2){
          
          $('.absd-load').removeClass('absd-hidden');
          $('.absd-load-line').addClass('absd-hidden');
          $('#absd-message2').removeClass('absd-load-message-left');
          $('#absd-message3').removeClass('absd-load-message-right');
          
          $('#absd-message1').html(message1);
          $('#absd-message2').html(message2);
          $('#absd-message3').html('');
          abookingsystemdashboardPopupLoader.start();
      },
      stop: function(message1,
                     message2,
                     close){
          $('#absd-message1').html(message1);
          $('#absd-message2').html(message2);
        
          if(close !== undefined) {
              abookingsystemdashboardPopupLoader.stop();
          }
      } 
  };
  
  window.abookingsystemdashboardLoader = abookingsystemdashboardLoader;
  
  /*
   * Percentage Loader
   */
  var abookingsystemdashboardLoaderLine = {
      currentLine: 1,
      time_per_percent: 700,
      load_function: '',
      start: function(){
          
           window.abookingsystemdashboardLoaderLine.load_function = setInterval(function(){

            if(window.abookingsystemdashboardLoaderLine.currentLine <= 99
               && !window.abookingsystemdashboardPercentageLoader.is_stop) {
                $('.absd-load-line-on').css('width', window.abookingsystemdashboardLoaderLine.currentLine+'%');
                $('#absd-message3').html(window.abookingsystemdashboardLoaderLine.currentLine+'%');
                window.abookingsystemdashboardLoaderLine.currentLine++; 
            }
          }, window.abookingsystemdashboardLoaderLine.time_per_percent);
      },
      stop: function(){
          $('.absd-load-line-on').css('width', '100%');
          $('#absd-message3').html('100%');
          clearInterval(window.abookingsystemdashboardLoaderLine.load_function);
      } 
  };
  
  window.abookingsystemdashboardLoaderLine = abookingsystemdashboardLoaderLine;
  
  var abookingsystemdashboardPopupPercentageLoader = {
      start: function(){
          $('#absd-popup').addClass('absd-loader-custom');
          $('#absd-popup').addClass('absd-open');
          $('#absd-popup').css('left', 0);
        
          $('.absd-box').addClass('absd-invisible');
          $('.absd-loader').removeClass('absd-invisible');
          
          abookingsystemdashboardDelay(function(){
              $('#absd-popup .absd-popup-box').addClass('absd-open');
              $('#absd-popup').css('left', 0);
              
              abookingsystemdashboardDelay(function(){
                  abookingsystemdashboardLoaderLine.start();
              }, 300);
          }, 300);
      },
      
      stop: function(){
          
          abookingsystemdashboardDelay(function(){
              $('#absd-popup .absd-popup-box').removeClass('absd-open');
          
              abookingsystemdashboardDelay(function(){
                  $('#absd-popup').removeClass('absd-loader-custom');
                  $('#absd-popup').removeClass('absd-open');
                  abookingsystemdashboardLoaderLine.stop();
              }, 300);
          }, 700);
      } 
  };
  
  window.abookingsystemdashboardPopupPercentageLoader = abookingsystemdashboardPopupPercentageLoader;
  
  var abookingsystemdashboardPercentageLoader = {
      is_stop: false,
      start: function(message1,
                      message2){
          
          $('.absd-load').addClass('absd-hidden');
          $('.absd-load-line-on').css('width', '1%');
          $('.absd-load-line').removeClass('absd-hidden');
          $('#absd-message2').addClass('absd-load-message-left');
          $('#absd-message3').addClass('absd-load-message-right');
          window.abookingsystemdashboardPercentageLoader.is_stop = false;
          
          $('#absd-message1').html(message1);
          $('#absd-message2').html(message2);
          $('#absd-message3').html('1%');
          window.abookingsystemdashboardLoaderLine.currentLine = 1;
          abookingsystemdashboardPopupPercentageLoader.start();
      },
      stop: function(message1,
                     message2,
                     close){
          $('#absd-message1').html(message1);
          $('#absd-message2').html(message2);
          $('#absd-message3').html('100%');
            $('.absd-load-line-on').css('width', '100%');
          window.abookingsystemdashboardPercentageLoader.is_stop = true;
        
          if(close !== undefined) {
              abookingsystemdashboardPopupPercentageLoader.stop();
          }
      } 
  };
  
  window.abookingsystemdashboardPercentageLoader = abookingsystemdashboardPercentageLoader;
  
  /*
   * Info Box
   */
  
  var abookingsystemdashboardInfo = {
      start: function(message1,
                      message2,
                      yesText,
                      noText,
                      yesFunction,
                      noFunction,
                      yesClass = ''){
        
          $('#absd-info1').html(message1);
        
          if(noFunction === undefined){
              noFunction = abookingsystemdashboardInfo.stop;
          }
        
          if(yesFunction !== undefined) {
              $('#absd-popup').removeClass('absd-loader-custom');
          }
        
          if(typeof message2 === 'object') {
              // Start Form
              abookingsystemdashboardForm.start($('#absd-info2'), message2);
          } else {
              $('#absd-info2').html(message2);         
          }
          
          $('.absd-info-yes').html(yesText);
          $('.absd-info-no').html(noText);
          
          $('#absd-popup').addClass('absd-open');
          $('#absd-popup').css('left', 0);
        
          $('.absd-box').addClass('absd-invisible');
          $('.absd-info').removeClass('absd-invisible');
        
          abookingsystemdashboardInfo.events(yesFunction,
                            noFunction);
        
          abookingsystemdashboardDelay(function(){
              $('#absd-popup .absd-popup-box').addClass('absd-open');
              $('#absd-popup').css('left', 0);
              
              if(yesClass != '') {
                  $('.absd-info-yes').addClass(yesClass);
              }
          }, 300);
      },
      stop: function(){
          $('#absd-popup .absd-popup-box').removeClass('absd-open');

          abookingsystemdashboardDelay(function(){
              $('#absd-popup').removeClass('absd-open');
              $('.absd-info-yes').removeClass('absd-selected');
              $('#absd-info-buttons').removeClass('absd-invisible');
          }, 300);
      },
      events: function(yesFunction,
                       noFunction){
        
//           $(document).keyup(function(event) {
//               var keycode = event.keyCode || event.which;
              
//               // Enter
//               if(keycode == '13') {
//                   yesFunction(); 
//               }
              
//               // Backspace
//               if(keycode == '27') {
//                   noFunction();
//               }
//           });
          
          $('.absd-info-yes').unbind('click');
          $('.absd-info-yes').bind('click', function(){
              yesFunction();
          });
        
          $('.absd-info-no, .absd-info-close').unbind('click');
          $('.absd-info-no, .absd-info-close').bind('click', function(){
              noFunction();
          });
      }
  };
  
  window.abookingsystemdashboardInfo = abookingsystemdashboardInfo;
  
  /*
   * Warning Box
   */
  
  var abookingsystemdashboardWarning = {
      time: 10,
      start: function(message1,
                      message2,
                      messagetime){
          $('#absd-warning1').html(message1);
          $('#absd-warning2').html(message2);
          
          $('#absd-popup').addClass('absd-open');
          $('#absd-popup').addClass('absd-loader-custom');
          $('#absd-popup').css('left', 0);
        
          $('.absd-box').addClass('absd-invisible');
          $('.absd-warning').removeClass('absd-invisible');
        
          abookingsystemdashboardWarning.events();
        
          abookingsystemdashboardDelay(function(){
              $('#absd-popup .absd-popup-box').addClass('absd-open');
              $('#absd-popup').css('left', 0);
          }, 300);
          
          
          abookingsystemdashboardWarning.timer.start(messagetime);
      },
      timer: 
      {
          start: function(messagetime){
              abookingsystemdashboardWarning.time = messagetime;
              abookingsystemdashboardWarning.timer.reload();
          },
          reload: function(){
              $('.absd-time').html(abookingsystemdashboardWarning.time);
              
              if(abookingsystemdashboardWarning.time > 0) {
                  setTimeout(abookingsystemdashboardWarning.timer.reload, 1000);
                  abookingsystemdashboardWarning.time--;
              } else {
                  abookingsystemdashboardWarning.stop();
              }
          }
      },
      stop: function(){
          $('#absd-popup .absd-popup-box').removeClass('absd-open');

          abookingsystemdashboardDelay(function(){
              $('#absd-popup').removeClass('absd-open');
              $('#absd-popup').removeClass('absd-loader-custom');
          }, 300);
      },
      events: function(){
        
          $('.absd-warning-close').unbind('click');
          $('.absd-warning-close').bind('click', function(){
              abookingsystemdashboardWarning.stop();
          });
      }
  };
  
  window.abookingsystemdashboardWarning = abookingsystemdashboardWarning;
  
})(jQuery);