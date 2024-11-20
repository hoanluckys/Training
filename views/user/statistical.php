<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
?>


<?php
$this->title = 'Thống kê dự án';
$this->params['breadcrumbs'][] = $this->title;

$data = [
    ['name' => 'User A', 'data' => [10, 15, 20, 3, 3, 3,3,3,3,3,33,3,3,3,3,3,3,3,3,3,3,3,33,3,3,3,3,3,3,3,33]],
    ['name' => 'User B', 'data' => [5, 25, 30, 3, 3, 3,3,3,3,3,33,3,3,3,3,3,3,3,3,3,3,3,33,3,3,3,3,3,3,3,33]],
    ['name' => 'User C', 'data' => [34, 34, 86, 3, 3, 3,3,3,3,3,33,3,3,3,3,3,3,3,3,3,3,3,33,3,3,3,3,3,3,3,33]],
];
//?>


<div class="card" style="border: 0px; margin-top: 13px;">
    <div class="card-body">
        <?php
            echo Highcharts::widget([
                'id' => 'project-chart',
                'options' => [
                    'chart' => [
                        'type' => 'column',
                    ],
                    'title' => [
                        'text' => 'Biểu đồ thống kê số lượng project theo user và ngày tháng',
                    ],
                    'xAxis' => [
                        'categories' => ['Ngày 1', 'Ngày 2', 'Ngày 3'], // Danh sách ngày
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'Số lượng project',
                        ],
                    ],
                    'series' => $data,
                ],
            ]);
        ?>
        <button onclick="getChartSeries()">test</button>
    </div>
</div>
<script>
    function getChartSeries() {
        var chartId = 'project-chart';
        var chart = Highcharts.chart(chartId);
        var seriesData = chart.series.map(function(series) {
            return {
                name: series.name,
                data: series.data.map(function(point) {
                    return point.y;
                })
            };
        });
        console.log(seriesData);
        return seriesData;
    }
</script>