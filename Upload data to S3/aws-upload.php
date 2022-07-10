<?php 

$command = escapeshellcmd('python aws-upload.py');
$output = shell_exec($command);
echo $output;

?>
