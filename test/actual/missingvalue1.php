<?php
    require_once '../common.php';

    header("Content-type: image/png");
    
    $chart = new \Libchart\View\Chart\PieChart(500, 250);
    
    $dataSet = new \Libchart\Data\XYDataSet();
    $dataSet->addPoint(new \Libchart\Data\Point("One (80)", 80));
    $dataSet->addPoint(new \Libchart\Data\Point("Null", 0));
    $dataSet->addPoint(new \Libchart\Data\Point("Two (50)", 50));
    $dataSet->addPoint(new \Libchart\Data\Point("Three (70)", 70));
    $chart->setDataSet($dataSet);
    
    $chart->setTitle("User agents for www.example.com");
    $chart->render();
?>