@extends('layouts.dashboard')

@section('content')
    <canvas id="myChart"></canvas>
    <input type="hidden" value="{{$labels}}" id="chart_label">
    <input type="hidden" value="{{$position}}" id="chart_data">

@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var data = $('#chart_data').val();
        var labels = $('#chart_label').val();
        var jData = JSON.parse(data);
        var jLabels = JSON.parse(labels);
        console.log(jData);
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar',

            // The data for our dataset
            data: {
                labels : jLabels,
                datasets: [{
                    label: "Users With Highest Votes",
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: jData,
                }]
            },

            // Configuration options go here
            options: {}
        });
    </script>
@stop