<?php

require('tfpdf/tfpdf.php');

// pdfライブラリを使用するためにインスタンス化
$pdf = new tFPDF;
$pdf->AddFont('ShipporiMincho', '', 'ShipporiMincho-TTF-Regular.ttf', true);

// 生徒名、教科を受け取って文字コードを設定、改行を受け付ける
$names = htmlentities($_GET['names'], ENT_QUOTES, "utf-8");
$names = explode("\r\n", $names);
$department = $_GET['department'];

// 生徒名、教科名のループ
foreach($names as $name) {
    $pdf->SetFont('ShipporiMincho', '', 20);
    $pdf->AddPage();
    $pdf->Cell(0, 10, $department.'プリント');
    $pdf->Ln(5);
    $pdf->Cell(100);
    $pdf->Cell(90, 10, "名前：$name", 'B');
    $pdf->Ln(40);
    make_contents();
}

// pdf出力
$pdf->Output();

// 問題のループ
function make_contents() {

    global $pdf;

    // 問題を受け取って文字コード設定、改行受け付ける
    $contents = htmlspecialchars($_GET['contents'], ENT_QUOTES, "utf-8");
    $contents = explode("\r\n", $contents);

    // 一行あたり10問でカウントする用の変数用意
    $count = 0;
    $Y = $pdf->getY();

    // レイアウトのループ、10問以上で横並びにする
    foreach($contents as $content) {
        $count++;
        if($count == 10){
            $pdf->setY($Y);
        }

        if($count >= 10) {
            $pdf->setX(110);
        }
        $pdf->SetFont('ShipporiMincho', '', 25);
        $pdf->Cell(20, 10, '('.$count.')');
        $pdf->SetFont('ShipporiMincho', '', 30);
        $pdf->Cell(80, 10, $content);
        $pdf->Ln(25);
    }
}