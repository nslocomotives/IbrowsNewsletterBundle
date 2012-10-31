var ns = ibrows_newsletter.namespace('ibrows_newsletter');

ns.statistic = function($options){

    var $self = this;
    var $options = $options;
    var $google = google;

    this.ready = function(){
        $google.load("visualization", "1", {packages:["corechart"]});
        $google.setOnLoadCallback(this.drawChart);
    }

    this.drawChart = function(){
        var $data = $google.visualization.arrayToDataTable($options.sentReadPieChart.data);

        var $chart = new $google.visualization.PieChart(document.getElementById($options.selectors.sentReadPieChart));
        $chart.draw($data, $options.sentReadPieChart.options);
    }

}