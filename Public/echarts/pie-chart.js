// 首页饼状图表

// 基于准备好的dom，初始化echarts实例
var myChart = echarts.init(document.getElementById('myChartMain'));
// 指定图表的配置项和数据
// var option = {
//     title: {
//         text: 'ECharts 入门示例'
//     },
//     tooltip: {},
//     legend: {
//         data:['销量']
//     },
//     xAxis: {
//         data: ["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"]
//     },
//     yAxis: {},
//     series: [{
//         name: '销量',
//         type: 'bar',
//         data: [5, 20, 36, 10, 10, 20]
//     }]
// };


// app.title = '环形图';

var option = {
    tooltip: {
        trigger: 'item',
        formatter: "{a} <br/>{b}: {c} ({d}%)"
    },
    legend: {
        orient: 'right',
        x: 'right',
        data:['investors','Team','bounty','Advisors']
    },
    series: [
        {
            name:'访问来源',
            type:'pie',
            radius: ['40%', '70%'],
            avoidLabelOverlap: false,
            label: {
                normal: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    show: true,
                    textStyle: {
                        fontSize: '30',
                        fontWeight: 'bold'
                    }
                }
            },
            labelLine: {
                normal: {
                    show: false
                }
            },
            data:[
                {
                    value:100,
                    name:'investors',
                    itemStyle: {
                        normal: {
                            color: '#3ab775'
                        }
                    }
                },
                {
                    value:200,
                    name:'Team',
                    itemStyle: {
                        normal: {
                            color: '#f3e48a'
                        }
                    }
                },
                {
                    value:300,
                    name:'bounty',
                    itemStyle: {
                        normal: {
                            color: '#6fb5e9'
                        }
                    }
                },
                {
                    value:400,
                    name:'Advisors',
                    itemStyle: {
                        normal: {
                            color: '#ef725e'
                        }
                    }
                },
            ]
        }
    ]
};

// 使用刚指定的配置项和数据显示图表。
myChart.setOption(option);



