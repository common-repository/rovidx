<?php 
/**
 *
 * @package   rovidx Basic
 * @author    rob@smokingmanstudios.com
 * @license   GPL-2.0+
 * @link      http://smokingmanstudios.com/rovidx/
 * @copyright 2013 Smoking Man Studios
 *
 *
 **/

/*Custom RSS Initator */
function customXML(){
        add_feed('rposts', 'rovidxml');
		add_feed('rmain', 'rovidxml1');
}
add_action('init', 'customXML');

$categories = get_option( 'rovidx_settings' , 'catslug' );	

/* get featured image url function */
function rovidx_featured_img_url( $rovidx_featured_img_size ) {
	$rovidx_image_id = get_post_thumbnail_id();
	$rovidx_image_url = wp_get_attachment_image_src( $rovidx_image_id, $rovidx_featured_img_size );
	$rovidx_image_url = $rovidx_image_url[0];
	return $rovidx_image_url;
}

function rovidxml1() {
echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>"; 

$podShow = get_option( 'rovidx_settings' , 'ctitle' );	
$podDesc = get_option( 'rovidx_settings' , 'cdesc' );
$podThumbSD = get_option( 'rovidx_settings' , 'cthumbsd' );
$podThumbHD = get_option( 'rovidx_settings' , 'cthumbhd' );

?>
<categories>
  <category title="<?php echo $podShow['ctitle'] ?>" description="<?php echo $podDesc['cdesc'] ?>" sd_img="<?php echo $podThumbSD['cthumbsd'] ?>" hd_img="<?php echo $podThumbHD['cthumbhd'] ?>">
    <categoryLeaf title="" description="" feed="<?php echo get_site_url(); ?>/feed/rposts/"/>
  </category>
</categories>
<?php
}
	
function rovidxml(){
echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>";

$rcat = get_option( 'rovidx_settings' , 'catslug' );	
$qry = new WP_Query( 'category_name=' . $rcat['catslug'] );  
$image_attributes = wp_get_attachment_image_src( $attachment_id );
$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
 ?><feed>
<resultLength>5</resultLength>
<endIndex>20</endIndex>
<?php 
/* RUN THE LOOP */
global $ctr;
if($qry->have_posts()){
    while($ctr > 0) {
        $qry->the_post();
		$ctr = $ctr - 1;
		
?>
<item sdImg="<?php echo rovidx_featured_img_url( 'thumbnail');?>" hdImg="<?php echo rovidx_featured_img_url( 'thumbnail');?>">
<title><?php 
	  $mykey_values = get_post_custom_values('rovidx_vtitle');
  foreach ( $mykey_values as $key => $value ) {
    echo "$value"; 
  }
?></title>
<contentId><?php echo get_the_ID(); ?></contentId>
<contentType>Podcast</contentType>
<contentQuality>HD</contentQuality>
<media>
<streamFormat>mp4</streamFormat>
<streamQuality>HD</streamQuality>
<streamBitrate><?php 
	  $mykey_values = get_post_custom_values('rovidx_vbitrate');
  foreach ( $mykey_values as $key => $value ) {
    echo "$value";
	}
	   ?></streamBitrate>
<streamUrl><?php 
	  $mykey_values = get_post_custom_values('rovidx_vurl');
  foreach ( $mykey_values as $key => $value ) {
    echo "$value"; 
  }?></streamUrl>
</media>
<synopsis><?php 
	  $mykey_values = get_post_custom_values('rovidx_vdesc');
  foreach ( $mykey_values as $key => $value ) {
    echo "$value"; 
  }
?></synopsis>
<genres><?php echo "RoVidX Free Edition"; ?></genres>
<runtime><?php 
	  $mykey_values = get_post_custom_values('rovidx_vlength');
  foreach ( $mykey_values as $key => $value ) {
	  $value = $value * 60;
    echo "$value"; 
  }
?></runtime>
</item>
<?php
}
header('Content-type:text/xml');
echo "</feed>";
}}?>