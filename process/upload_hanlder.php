<?php

require_once '../include/customfunctions.php';
$filename = $_FILES['files']['name'][0];
$tmp_name = $_FILES['files']['tmp_name'][0];
$path = projectroot . '/uploads/audio/'.$filename;
move_uploaded_file($tmp_name, $path);