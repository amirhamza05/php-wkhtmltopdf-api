<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

date_default_timezone_set("Asia/Dhaka");

if (empty($_POST)) {
    $response = [
        "error" => true,
        "message" => "Invalid Request",
    ];
    echo json_encode($response);
    exit();
}

$request = (object)$_POST;

$pdfPath = "temp/pdf/";
$htmlPath = "temp/html/";
$randHash = rand();

$pdfFile = $pdfPath . "pdf_" . $randHash . ".pdf";
$htmlFile = $htmlPath . "pdf_" . $randHash . ".html";

$buttonLeftTitle = isset($request->button_left_title) ? $request->button_left_title :  "";
$html = isset($request->html) ? base64_decode($request->html) : "";

//create html file
$htmlFileOb = fopen($htmlFile, "w") or die("Unable to open file!");
fwrite($htmlFileOb, $html);
fclose($htmlFileOb);

$data = [
    '--page-offset' => "0",
    '--footer-font-size' => "10",
    '--footer-right' => "'[page] of [topage]'",
    '--footer-left' => "'{$buttonLeftTitle}'",
];

$parameter = "";

foreach ($data as $key => $value) {
    $parameter .= $key . " " . $value . " ";
}

exec("wkhtmltopdf {$parameter} {$htmlFile} {$pdfFile}");

$response = [
    "error" => false,
    "message" => "Successfully Generated Pdf",
    "pdf_url" => "{$pdfFile}"
];

echo json_encode($response);
