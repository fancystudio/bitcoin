{* reset session template *}
{* NOTE: this template requires jquery be available in any page that it is used on *}

<p><a href="javascript:;" name="feu_manual_reset">Click Here To Confirm Login Status</a></p>{* safe to remove this *}

{* style information for the modal window and the mask... these can be removed and placed in a CMSMS stylesheet *}
{literal}
<style type="text/css">
#feu_modal {
  background-color: #fff;
  border: 1px solid #00f;
  padding: 2px;
  margin:  2px;
}
#feu_mask {
  background-color: #000;
}
#feu_modal .title {
  background-color: #00f;
  color:  #fff;
  padding: 0px;
}
</style>
{/literal}

{capture assign='feu_theform'}{strip}
{* the reset-session form, a simple form to display a message with a title to the user with two options... okay, and cancel... the name of these buttons is important, as well the strip tag is important *}
<form action="javascript:;">
<p class="title">{$mod->Lang('title_reset_session')}</p>
<p class="row">{$mod->Lang('msg_reset_session')}</p>
<p class="row">
  <input type="submit" name="feu_ok" value="{$mod->Lang('ok')}"/>
  <input type="submit" name="feu_cancel" value="{$mod->Lang('cancel')}"/>
</p>
</form>
{/strip}{/capture}

{literal}
<script type="text/javascript">
//<![CDATA[
// the timer interval (how often you want to display the dialog to your users
var timer_interval = {/literal}{$session_timeout}{literal} - 30;

// a function to hide the modal dialog -- you can modify this function
function feu_close_modal()
{
   jQuery('#feu_modal').fadeOut(2000);
   jQuery('#feu_mask').fadeOut(1000);
}

// a function to display the modal dialog... you can modify this function
function feu_open_modal()
{
  var maskHeight = jQuery(document).height();
  var maskWidth = jQuery(document).width();

  // set the mask size to fill up the whole screen
  jQuery('#feu_mask').css({'width':maskWidth,'height':maskHeight});

  // transition effect
  jQuery('#feu_mask').fadeIn(1000);
  jQuery('#feu_mask').fadeTo("slow",0.8);

  // get the top left corner of the popup
  var winHeight = jQuery(window).height();
  var winWidth = jQuery(window).width();

  var popupHeight = jQuery('#feu_modal').height();
  var popupWidth  = jQuery('#feu_modal').width();

  var top = winHeight/2 - popupHeight/2;
  var left = winWidth/2 - popupWidth/2;
  // set the popup window to center
  jQuery('#feu_modal').css({'top':top,'left':left});

  // transition effect
  jQuery('#feu_modal').fadeIn(2000);
}

function feu_user_cancelled()
{
  // a callback function that may be customized to allow displaying a message to the user
  // to indicate that they may be logged out at any time.
  alert('You have chosen to disregard the session warning, you may continue to browse this site however some functionality may be unavailable to you until you login again');
}

// *
// * do not modify below here unless you are an experienced jquery programmer *
// *

if( timer_interval <= 0 )
  {
     timer_interval = 0;
  }
var dialogcontents = '{/literal}{$feu_theform}{literal}';


// we have jQuery
jQuery(document).ready(function(){
  // create a new id for our stuff
  jQuery('body').append('<div id="feu_body"></div>');
  
  // create the mask and append it to the dom
  jQuery('#feu_body').append('<div id="feu_mask"></div>');

  // create the modal dialog and append it to the DOM
  jQuery('#feu_body').append('<div id="feu_modal">'+dialogcontents+'</div>');
  
  // and a junk div
  jQuery('#feu_body').append('<div id="feu_junk" style="display: none;"></div>');

  // handle click events
  jQuery('#feu_modal input[name=feu_ok]').click(function(e){
    e.preventDefault();

    // do the ajax request
    var url = '{/literal}{$reset_url}{literal}';
    var url = url.replace(/amp;/g,'');
    jQuery('#feu_junk').load(url);

    // and done.
    feu_close_modal();
   });
  jQuery('#feu_modal input[name=feu_cancel]').click(function(e){
    e.preventDefault();
    feu_close_modal();
    feu_user_cancelled();
  });
  jQuery('a[name=feu_manual_reset]').click(function(e){
    e.preventDefault();
    feu_open_modal();
  });

  // create our timer
  if( timer_interval > 0 )
     {
        setTimeout(feu_open_modal,timer_interval * 1000);
     }

});
//]]>
</script>
{/literal}

{* required css *}
{literal}
<style type="text/css">
#feu_modal {
  position: absolute;
  z-index: 9999;
  display: none;
}
#feu_mask {
  top: 0;
  left: 0;
  position: absolute;
  z-index: 9000;
  display: none;
}
</style>
{/literal}