function BarTypeCharts(seriesName, elementId, xValue, yValue, colorCode) {
    let myChart = echarts.init(elementId);

    let option;
    option = {
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow',
            },
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        color: colorCode,
        xAxis: [{
            type: 'category',
            data: xValue,
            axisTick: {
                alignWithLabel: true
            },
            axisLabel: {
                show: true,
                showMaxLabel: true,
            }
        }],
        yAxis: [{
            type: 'value',
            axisLabel: {
                formatter: '{value} KG'
            },
        }],
        series: [{
            name: seriesName,
            type: 'bar',
            barWidth: '60%',
            data: yValue,
        }]
    };

    option && myChart.setOption(option);
    $(window).on('resize', function(){
        location.reload();
        if(myChart != null && myChart != undefined){
            myChart.resize();
        }
    });
}
