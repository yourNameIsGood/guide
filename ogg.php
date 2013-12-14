<?php
// dl("libogg.dll"); // load a lib
$fp = fopen('s.spx', 'r');
$metadata = stream_get_meta_data($fp);
$songdata = $metadata['wrapper_data'][0];

while ($audio_data = fread($fp, 8192)) {
  /* Do something with the PCM audio we're extracting from the OGG.
     Copying to /dev/dsp is a good target on linux systems, 
     just remember to setup the device for your sampling mode first. */
}
fclose($fp);
?>
