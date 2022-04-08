<?php

$contestName = "PSTU Mujib Borsho IT Carnival Programming Contest - 2022 | CoderOJ";
$pdfName = "test.pdf";

$data = [
    '--page-offset' => "0",
    '--footer-font-size' => "10",
    '--footer-right' => "'[page] of [topage]'",
    '--footer-left' => "'{$contestName}'",
];


$parameter = "";

foreach ($data as $key => $value) {
    $parameter .= $key . " " . $value . " ";
}

echo $parameter;

exec("wkhtmltopdf  {$parameter} test.html pdf/{$pdfName}");

//echo " <a href='pdf/{$pdfName}' target='_blank'>pdf success</a>";


echo '<embed src="http://localhost:82/pdf/test.pdf" width="90%" height="100%" type="application/pdf" frameborder="0" allowfullscreen>';