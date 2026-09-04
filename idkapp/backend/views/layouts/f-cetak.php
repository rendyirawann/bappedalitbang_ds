<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;
use backend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
AppAsset::register($this);
?>

<!-- <script type="text/javascript">
        window.print();
    </script> -->

    <script>
        $('#print-button').click(function() {
    var data = [];
    $('#basic-1 tbody tr').each(function() {
        var rowData = [];
        $(this).find('td').each(function() {
            rowData.push($(this).text());
        });
        data.push(rowData);
    });
    $.post('print', {data: data}, function(response) {
        // Handle response jika diperlukan
    });
});

    </script>