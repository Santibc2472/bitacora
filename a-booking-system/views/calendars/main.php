<?php 
if (!defined('ABSPATH')) exit;

global $absdashboardclasses;
global $absdashboardtext;
global $ABookingSystem;


// No Access
if($ABookingSystem['role'] == 'customer'
  || $ABookingSystem['role'] == 'guest') {
    $absdashboardclasses->display->view('no-access'); 
    exit;
} else {
    $used_for = $absdashboardclasses->option->get('used_for',
                                        $ABookingSystem['user_id']);
}

?>

<div class="absd-left-column">
  
  <div class="absd-header">
  <?php $absdashboardclasses->display->view('calendars/'.$used_for); ?>
  </div>
  
  <div class="absd-left-content">
    <div class="absd-search">
      <input type="text" placeholder="<?php echo $absdashboardtext['search_for_'.$used_for] ?>">
    </div>
    
    <div class="absd-calendars">
      <div class="absd-calendars-holder"></div>
      
      <div class="absd-pagination">
        
      </div>
    </div>
  </div>
  
</div>

<div id="absd-calendars-content" class="absd-right-column"></div>

<script type="text/javascript">
    jQuery(document).ready(function(){
      
        function loadScript(url, callback){

            if(document.getElementById("google-map-library") === null
              || document.getElementById("google-map-library") === undefined) {
                var script = document.createElement("script")
                script.type = "text/javascript";
                script.id = "google-map-library";

                if (script.readyState){  //IE
                    script.onreadystatechange = function(){
                        if (script.readyState == "loaded" ||
                                script.readyState == "complete"){
                            script.onreadystatechange = null;
                            callback();
                        }
                    };
                } else {  //Others
                    script.onload = function(){
                        callback();
                    };
                }

                script.src = url;
                document.getElementsByTagName("head")[0].appendChild(script);
            }
        }
      
        loadScript("https://maps.googleapis.com/maps/api/js?key=<?php echo $ABookingSystem['google_map_api_key']; ?>&libraries=places&callback=window.abookingsystemdashboardForm.fields.field.map", window.abookingsystemdashboardCalendars.list);
    });
</script>