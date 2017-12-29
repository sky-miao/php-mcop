// mcop
// banner部分tab切换

$('.language-box .hd').click(function(event) {
   
    if ($('.select').hasClass('show')) {
        $('.select').removeClass('show')
    }else{
        $('.select').addClass('show');
    }
    //$('.select').addClass('show');  
});

// 创建图表
if(document.getElementById("myChart")){
    var ctx = document.getElementById("myChart").getContext("2d");
    var data = {
        datasets: [{
            data: [10, 20, 30,40],
            backgroundColor: ['#56B6EE','#F6E47B','#FF6956','#00BA6E'],
            borderWidth:0
        }],
        labels: [
            'investors',
            'Team',
            'bounty',
            'Advisors'
        ]
    };
    var options = {

    };
    var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: options
    });
}

//手机设备的简单适配
var treeMobile = $('.site-tree-mobile')
,shadeMobile = $('.site-mobile-shade')

treeMobile.on('click', function(){
    $('body').addClass('site-mobile');
});

shadeMobile.on('click', function(){
    $('body').removeClass('site-mobile');
});
