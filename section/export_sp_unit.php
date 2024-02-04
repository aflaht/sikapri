<?php
    require_once "../import/vendor/phpoffice/phpexcel/Classes/PHPExcel.php";
    include_once "../koneksi.php";
    $periode = $_POST["pil2"];
    //Buat file excel
    $excel = new PHPExcel();

    //Pilih sheet
    $excel->setActiveSheetIndex(0);

    //Data dari db
    $query = mysqli_query($koneksi, "SELECT u.kdpr,nama_unit,SUM(total) as total,SUM(sp_pokok) as pokok,SUM(sp_wajib) as wajib,SUM(sp_lain) as lain FROM unit t INNER JOIN user u ON t.kdpr=u.kdpr INNER JOIN simpanan p ON p.no_anggota=u.no_anggota WHERE p.periode=$periode GROUP BY nama_unit");
    $row = 7;
    $no = 1;
    while($data = mysqli_fetch_object($query)){
        $excel->getActiveSheet()
            ->setCellValue('B'.$row , $no)
            ->setCellValue('C'.$row , $data->kdpr)
            ->setCellValue('D'.$row , $data->nama_unit)
            ->setCellValue('E'.$row , $data->pokok)
            ->setCellValue('F'.$row , $data->wajib)
            ->setCellValue('G'.$row , $data->lain)
            ->setCellValue('H'.$row , $data->total);
        $no++;
        $row++;
    }

    //format panjang kolom
    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(1);
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
    $excel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
    $excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
    $excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);

    //buat header tabel
    $month = date('F Y');
    $excel->getActiveSheet()
        ->setCellValue('A2' , 'LAPORAN SIMPANAN PER-UNIT')
        ->setCellValue('A3' , 'PERIODE '.$month)
        ->setCellValue('B6' , 'NO')
        ->setCellValue('C6' , 'KDPR')
        ->setCellValue('D6' , 'UNIT')
        ->setCellValue('E6' , 'pokok')
        ->setCellValue('F6' , 'wajib')
        ->setCellValue('G6' , 'lain')
        ->setCellValue('H6' , 'TOTAL');

    //merge cell
    $excel->getActiveSheet()->mergeCells('A2:H2');
    $excel->getActiveSheet()->mergeCells('A3:H3');

    //Align
    $excel->getActiveSheet()->getStyle('A2:A3')->getAlignment()->setHorizontal('center');

    //styling
    $excel->getActiveSheet()->getStyle('A2')->applyFromArray(
        array(
            'font'=>array(
                'size'=> 14,
                'bold'=> true,
            )
        )
    );
    $excel->getActiveSheet()->getStyle('B6:H6')->applyFromArray(
        array(
            'font'=>array(
                'bold'=> true,
            ),
            'borders'=>array(
                'allborders'=>array(
                    'style'=>PHPExcel_Style_Border::BORDER_THIN
                )
            )
        )
    );

    //border data
    $excel->getActiveSheet()->getStyle('B7:H'.($row-1))->applyFromArray(
        array(
            'borders'=>array(
                'outline'=>array(
                    'style'=>PHPExcel_Style_Border::BORDER_THIN
                ),
                'vertical'=>array(
                    'style'=>PHPExcel_Style_Border::BORDER_THIN
                )
            )
        )
    );

    //redirect
    header('Content-Type: application/vdn.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="laporan_simpanan.xlsx"');
    header('cache-Control: max-age=0');

    //download
    $file = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    //outputfile
    $file->save('php://output');
?>
