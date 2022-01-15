<?php

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

function widthForStringUsingFontSize($string, $font, $fontSize)
{
    $drawingString = iconv('UTF-8', 'UTF-16BE//IGNORE', $string);
    $characters = array();
    for ($i = 0; $i < strlen($drawingString); $i++) {
        $characters[] = (ord($drawingString[$i++]) << 8 ) | ord($drawingString[$i]);
    }
    $glyphs = $font->glyphNumbersForCharacters($characters);
    $widths = $font->widthsForGlyphs($glyphs);
    $stringWidth = (array_sum($widths) / $font->getUnitsPerEm()) * $fontSize;
    return $stringWidth;
 }

function sendPDF($student, $folder, $baseFile, $type, $event_id, $webURL)
{
  // qr
  $data = '%sstuendt/check?event_id=%d&dni=%d&code=%s&grade=%d' ;
  $data = sprintf($data, $webURL, $event_id, $student->{'dni'}, $student->{'code'}, $student->{'grade'});
  $qr = (new QRCode)->render($data);
  $image = new Zend_Pdf_Resource_Image_Png($qr);
  // pdf
  $pdf = Zend_Pdf::load($folder . $baseFile);
  $customFont = Zend_Pdf_Font::fontWithPath(BASE_PATH . '/public/assets/fonts/Palatino Linotype.ttf');
  //var_dump($type);
  if($type == 'certified'){ // diplomado
    // qr
    $page = $pdf->pages[0];
    $page->drawImage($image, 325, 35, 500, 210); // source, x1, y1, x2, y2 || 150, 300, 350, 500
    $pdf->pages[0] = $page;
    $page->setFont($customFont, 22);
    // name
    $textWidth = widthForStringUsingFontSize(
      $student->{'last_names'} . ' ' . $student->{'first_names'}, $customFont, 22
    );
    $position = (800 - $textWidth)/2;
    $page->drawText(strtoupper($student->{'last_names'} . ' ' . $student->{'first_names'}), $position, 330);
    // code
    $page = $pdf->pages[1];
    $page->setFont($customFont, 26);
    $page->drawText($student->{'code'}, 625, 330);
    // grade
    $page->setFont($customFont, 36);
    $page->drawText($student->{'grade'}, 625, 180);
  }
  if($type == 'course'){ // curso
    // qr
    $page = $pdf->pages[0];
    $page->drawImage($image, 90, 35, 265, 210); // source, x1, y1, x2, y2 || 150, 300, 350, 500
    $pdf->pages[0] = $page;
    $page->setFont($customFont, 22);
    // name
    $textWidth = widthForStringUsingFontSize(
      $student->{'last_names'} . ' ' . $student->{'first_names'}, $customFont, 22
    );
    $position = (800 - $textWidth)/2;
    $page->drawText(strtoupper($student->{'last_names'} . ' ' . $student->{'first_names'}), $position, 330);
    // code
    $page = $pdf->pages[1];
    $page->setFont($customFont, 26);
    $page->drawText($student->{'code'}, 625, 330);
  }
  if($type == 'free-course'){ // curso libre
    // qr
    $page = $pdf->pages[0];
    $page->drawImage($image, 90, 35, 265, 210); // source, x1, y1, x2, y2 || 150, 300, 350, 500
    $pdf->pages[0] = $page;
    $page->setFont($customFont, 22);
    // name
    $textWidth = widthForStringUsingFontSize(
      $student->{'last_names'} . ' ' . $student->{'first_names'}, $customFont, 22
    );
    $position = (800 - $textWidth)/2;
    $page->drawText(strtoupper($student->{'last_names'} . ' ' . $student->{'first_names'}), $position, 330);
  }
  // save pdf
  $pdf->save($folder . $student->{'id'} . ' ' . $student->{'last_names'} . ' ' . $student->{'first_names'});
}

function sendEmail($email, $subject, $webURL, $pathPDF)
{

}

function deleleUpload($dir)
{
  $files = array_diff(scandir($dir), array('.','..'));
  foreach ($files as $file) {
    (is_dir("$dir/$file")) ? deleleUpload("$dir/$file") : unlink("$dir/$file");
  }
  return rmdir($dir);
}