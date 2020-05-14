<?php 
if (!defined('ABSPATH')) exit;

global $absdashboardtext;

?>

<div id="absd-popup" style="display:none" class="absd-popup">
  
  <div class="absd-popup-box">
    
    <!-- Loader : START !-->
    <div class="absd-loader absd-box">
      <h3 id="absd-message1">Loading...</h3>
      <div class="absd-load">
        <div class="absd-load-circle absd-on2"></div>
        <div class="absd-load-circle absd-left-less"></div>
        <div class="absd-load-circle absd-left-less"></div>
        <div class="absd-load-circle absd-left-less"></div>
        <div class="absd-load-circle absd-left-less"></div>
        <div class="absd-load-circle absd-left-less"></div>
        <div class="absd-load-circle absd-left-less"></div>
        <div class="absd-load-circle absd-left-less"></div>
      </div>
      <div class="absd-load-line">
        <div class="absd-load-line-on"></div>
      </div>
      <div id="absd-message2" class="absd-load-message">
        Please wait... will be finished soon...
      </div>
      <div id="absd-message3" class="absd-load-message"></div>
    </div>
    <!-- Loader : END !-->
    
    <!-- Info : START !-->
    <div class="absd-info absd-box absd-invisible">
      <div class="absd-info-close absd-close">X</div>
      <h3 id="absd-info1">Are you sure that you disconnect ?</h3>
      <div id="absd-info2" class="absd-info-text">
        You will not be able to use our dashboard...
      </div>
      <div id="absd-info-buttons" class="absd-info-buttons">
        <div class="absd-info-yes absd-button">
          Yes, I'm Agree
        </div>
        <div class="absd-info-no absd-button">
          No, Cancel...
        </div>
      </div>
    </div>
    <!-- Info : END !-->
    
    <!-- Warning : START !-->
    <div class="absd-warning absd-box absd-invisible">
      <div class="absd-time">10</div>
      <div class="absd-warning-close absd-close">X</div>
      <h3 id="absd-warning1">Warning</h3>
      <div class="absd-warning-icon">!</div>
      <div id="absd-warning2" class="absd-warning-message">
        Was an error at request... Please try again later or <a href="#">contact Book Everything Unlimited support</a>
      </div>
    </div>
    <!-- Warning : END !-->
    
    <!-- Clear-->
    <div class="absd-clear"></div>
    
  </div>
  
</div>