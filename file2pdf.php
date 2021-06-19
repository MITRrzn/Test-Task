
<?php
// phpcs:disable
require("tcpdf/tcpdf.php");

error_reporting(E_ERROR  | E_PARSE);

$extensions = array('php', 'html', 'js');
$count = 0;
$user_path = readline("Inputh path to dir\n");
$path = new RecursiveDirectoryIterator($user_path);

foreach (new RecursiveIteratorIterator($path) as $file) {
    if (in_array(strtolower(array_pop(explode('.', $file))), $extensions)) {
        $count++;
        echo "\n" . $file . " \033[32m -> file for PDF conversion \033[0m\n";
        $file_info = dirname($file) . "\\" . basename($file); //Получение пути к файлу
        $content = file_get_contents($file); //Копирование содержимого файла

        $pdf = new TCPDF("P", "mm", "A4", true, 'UTF-8'); //Настройки отображения страницы pdf файла
        $pdf->SetFont('dejavusans', '', 14, '', true); //Настройки шрифта
        $PDF_HEADER_TITLE = $file_info . "\nPDF version of file"; //Шапка страницы
        $pdf->SetHeaderData(
            '',
            '',
            $PDF_HEADER_TITLE,
            ''
        );
        $pdf->AddPage();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Write(3, $content, '', false);
        $pdf->Output($file_info . '.pdf', 'F');
    }
}

echo "\n_______________________________________________\nTotal:" . $count . " files converted.";
