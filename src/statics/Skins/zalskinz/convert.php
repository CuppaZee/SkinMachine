<?php
  require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/SimpleImage.php';

function makestuff($skinname)
{
  $new_image = imagecreatetruecolor(1050, 900);
  $white = imagecolorallocate($new_image, 255, 255, 255);
  imagefill($new_image, 0, 0, $white);
  $output = new SimpleImage();
  $output->image = $new_image;
  $output->image_type == IMAGETYPE_PNG;
  $skin = new SimpleImage();
  $skin->load($skinname.".png");
  $skin->resize(1050, 900);
  $output->merge(0, 0, $skin);
  $output->save($skinname."_ex.png", IMAGETYPE_PNG, 90);
  $output->resize(117, 100);
  $output->save($skinname."_tn.png", IMAGETYPE_PNG, 90);
}

makestuff("Australia");
makestuff("France");

?>
