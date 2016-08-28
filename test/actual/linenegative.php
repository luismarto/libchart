<?php
    require_once '../common.php';

    header("Content-type: image/png");

    $chart = new \Libchart\View\Chart\LineChart();

    $dataSet = new \Libchart\Data\XYDataSet();
    $dataSet->addPoint(new \Libchart\Data\Point("2000", 780));
    $dataSet->addPoint(new \Libchart\Data\Point("2001", 200));
    $dataSet->addPoint(new \Libchart\Data\Point("2002", -100));
    $dataSet->addPoint(new \Libchart\Data\Point("2003", 0));
    $dataSet->addPoint(new \Libchart\Data\Point("2004", -550));
    $dataSet->addPoint(new \Libchart\Data\Point("2005", -300));
    $chart->setDataSet($dataSet);
    
    $chart->setTitle("Net migration");
    $chart->render();
?>