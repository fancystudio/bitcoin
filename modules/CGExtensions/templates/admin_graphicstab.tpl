<div class="pageoverflow">{$mod->Lang('info_graphicssettings')}</div>

<div class="pageoverflow">
  <p class="pagetext">{$prompt_imageextensions}:</p>
  <p class="pageinput">{$input_imageextensions}
  <br/>
  {$mod->Lang('info_imageextensions')}
  </p>
</div>

<fieldset>
  <legend>{$mod->Lang('resizing')}:</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_allow_resizing')}</p>
    <p class="pageinput">{$input_allow_resizing}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_delete_orig_image')}</p>
    <p class="pageinput">{$input_delete_orig_image}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('resize_image_to')}:</p>
    <p class="pageinput">{$input_resizeimage}</p>
  </div>
  
</fieldset>

<fieldset>
  <legend><strong>{$mod->Lang('watermarking')}:</strong></legend>
  <p class="pageoverflow">{$mod->Lang('info_watermarks')}</p>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_allow_watermarking')}</p>
    <p class="pageinput">{$input_allow_watermarking}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('watermark_alignment')}</p>
    <p class="pageinput">{$input_alignment}</p>
  </div> 
  <table class="pagetable">
    <tbody>
      <tr>
        <td valign="top">
          <fieldset>
          <legend>{$mod->Lang('text_watermarks')}:</legend>
          <div class="pageoverflow">
            <p class="pagetext">{$mod->Lang('watermark_text')}</p>
            <p class="pageinput">{$input_text}</p>
          </div>
          <div class="pageoverflow">
            <p class="pagetext">{$mod->Lang('text_color')}</p>
            <p class="pageinput">{$input_textcolor}</p>
          </div>
          <div class="pageoverflow">
            <p class="pagetext">{$mod->Lang('background_color')}</p>
            <p class="pageinput">{$input_bgcolor}</p>
          </div>
          <div class="pageoverflow">
            <p class="pagetext">{$mod->Lang('use_transparency')}</p>
            <p class="pageinput">{$input_transparent}</p>
          </div>
          <div class="pageoverflow">
            <p class="pagetext">{$mod->Lang('font')}</p>
            <p class="pageinput">{$input_font}</p>
          </div>
          <div class="pageoverflow">
            <p class="pagetext">{$mod->Lang('font_size')}</p>
            <p class="pageinput">{$input_textsize}</p>
          </div>
          <div class="pageoverflow">
            <p class="pagetext">{$mod->Lang('text_angle')}</p>
            <p class="pageinput">{$input_textangle}</p>
          </div>
          <div class="pageoverflow">
            <p class="pagetext">{$mod->Lang('translucency')}</p>
            <p class="pageinput">{$input_translucency}</p>
          </div> 
        </fieldset>
        </td>
        <td valign="top">
          <fieldset>
          <legend>{$mod->Lang('graphic_watermarks')}:</legend>
          <div class="pageoverflow">
            <p class="pagetext">{$mod->Lang('image')}</p>
            <p class="pageinput">{$input_image}</p>
          </div> 
          </fieldset>
        </td>
      </tr>
    </tbody>
  </table>
</fieldset>

<fieldset>
<legend>{$mod->Lang('thumbnailing')}:</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_allow_thumbnailing')}</p>
    <p class="pageinput">{$input_allow_thumbnailing}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('thumbnail_size')}:</p>
    <p class="pageinput">{$input_thumbnailsize}</p>
  </div>
</fieldset>

<div class="pageoverflow">
  <p class="pagetext">&nbsp;</p>
  <p class="pageinput">{$input_submit}</p>
</div> 
