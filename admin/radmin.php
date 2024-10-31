<?php 
/**
 *
 * @package   RoVidX Free
 * @author    rob@smokingmanstudios.com
 * @license   GPL-2.0+
 * @link      http://smokingmanstudios.com/rovidx/
 * @copyright 2013 Smoking Man Studios
 *
 **/
 
function rovidx_menu() {
	 add_menu_page( 'RoVidX Options', 'RoVidX', 'manage_options', 'rovidx-options', 'rovidx_options_page', plugins_url( 'rovidx/images/smsico.png' ) );
	 add_submenu_page('rovidx-options', 'FAQ & Help', 'FAQ & Help', 'manage_options', 'rovidx-op-faq', 'rovidx_func_faq');
}
add_action( 'admin_menu', 'rovidx_menu' );

/* Administration Area Code */

function rovidx_func_faq()
			{
?><div align="center">Get the <a href="http://rovidx.com/downloads/rovidx-roku-edition/">Pro version</a> to access advanced features!</div>
<iframe src="http://rovidx.com/rovidx-free-support/" width="90%" height="800px" frameborder="0"></iframe>
<?php
			}
function rovidx_options_page()
{
    global $rovidx_options;
    wp_enqueue_style('RoVidXStylesheet');
    ob_start();
?>
<div class="wrap">
  <img src="<?php
    echo plugins_url('rovidx/images/rovidx.png');
?>" />
  <form id="rovidxform" method="post" action="options.php">
    <?php
    settings_fields('rovidx_settings_group');
?>
    <table width="90%" border="0" cellspacing="5" cellpadding="5">
      <tr>
        <td width="33%"><label class="description" for="rovidx_settings[catslug]">
            <?php
    _e('Enter the <strong>category slug</strong> for Roku content', 'rovidx_domain');
?>
          </label></td>
        <td width="33%"><input id="rovidx_settings[catslug]" size="75"  name="rovidx_settings[catslug]" type="text" value="<?php
    echo $rovidx_options['catslug'];
?>"/></td> <td rowspan="4"></td>
          </tr>
      <tr>
        <td><label class="title" for="rovidx_settings[ctitle]">
            <?php
    _e('Enter your show name', 'rovidx_domain');
?>
          </label></td>
        <td><input id="rovidx_settings[ctitle]" size="75" name="rovidx_settings[ctitle]" type="text" value="<?php
    echo $rovidx_options['ctitle'];
?>"/></td> 
      </tr>
    <tr>
      <td><label class="description" for="rovidx_settings[cdesc]">
            <?php
    _e('Enter your Channel description', 'rovidx_domain');
?>
          </label></td>
        <td>
          <textarea id="rovidx_settings[cdesc]" name="rovidx_settings[cdesc]" form="rovidxform" rows="10" cols="75"><?php
    echo $rovidx_options['cdesc'];
?></textarea>
        </td> 
      </tr>
      <tr>
        <td><label class="title" for="rovidx_settings[cthumbsd]">
            <?php
    _e('SD Thumbnail', 'rovidx_domain');
?>
          </label></td>
        <td><input id="rovidx_settings[cthumbsd]" size="75" name="rovidx_settings[cthumbsd]" type="text" value="<?php
    echo $rovidx_options['cthumbsd'];
?>"/></td>
      </tr>
      <tr>
        <td><label class="title" for="rovidx_settings[cthumbhd]">
            <?php
    _e('HD Thumbnail', 'rovidx_domain');
?>
          </label></td>
        <td><input id="rovidx_settings[cthumbhd]" size="75" name="rovidx_settings[cthumbhd]" type="text" value="<?php
    echo $rovidx_options['cthumbhd'];
?>"/></td>
        <td rowspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" class="button-primary" value="Save Options" /></td>
      </tr>
    </table>
  </form>
<div><h3>How to Build a Roku Channel (Works great for Private channels)</h3>
<ol>
  <li>Setup RoVidX and add some content.</li>
  <li>Download the <a href="https://owner.roku.com/Developer">Roku SDK</a></li>
  <li>Go to <strong>SDK\examples\source\videoplayer\source\</strong></li>
  <li>Edit categoryFeed.brs with a text editor (IE: NotePad)</li>
  <li>Change line #15 from <strong>&quot;http://rokudev.roku.com/rokudev/examples/videoplayer/xml&quot;</strong> to <strong>&quot;http://yoursite.url/feed/rmain&quot;</strong></li>
  <li>Change line #16 from<strong> &quot;/categories.xml&quot;</strong> to <strong>&quot;/&quot;</strong></li>
  <li>Save file.</li>
  <li>Zip the contents of the <strong>SDK\examples\source\videoplayer\source\</strong> directory (IE: myChannelName.zip)</li>
  <li>Upload the zip to your Roku</li>
  <li>Test for errors</li>
  <li>Use the Roku developer package feature to make a .pkg file</li>
  <li>Upload your .pkg file to Roku</li>
</ol>
<p>Need more instructions? <a href="http://rovidx.com/getrovidx/?affiliates=2">Get our Pro Edition</a> which includes full <strong>step-by-step video training, unlimited shows and more features.</strong></p></div><div class="goprorov"><h3>Get all the advanced features and more frequent updates!</h3>
 <a href="http://rovidx.com/downloads/rovidx-roku-edition/"><img src="<?php
    echo plugins_url('rovidx/images/gopro.png');
?>" /></a></div>
  </div>
<?php
    echo ob_get_clean();
}
function rovidx_register_settings()
{
    register_setting('rovidx_settings_group', 'rovidx_settings');
}
add_action('admin_init', 'rovidx_register_settings');