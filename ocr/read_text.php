<?php
use thiagoalessio\TesseractOCR\TesseractOCR;
echo (new TesseractOCR('text.png'))
    ->run();
?>
