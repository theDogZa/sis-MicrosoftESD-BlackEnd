@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="mb-50 text-center">
            <h2 class="font-w700 text-black mb-10">Dashboard</h2>
            <h3 class="h5 text-muted mb-0">Welcome to your app {{ Config::get('app.name') }}</h3>
        </div>
        {{-- <div class="row justify-content-center">
            <div class="col-md-6 col-xl-5">
                <div class="block">
                    <div class="block-content">
                        <p class="font-size-sm text-muted">
                            We’ve put everything together, so you can start working on your Laravel project as soon as possible! Codebase assets are integrated and work seamlessly with Laravel Mix, so you can use the npm scripts as you would in any other Laravel project.
                        </p>
                        <p class="font-size-sm text-muted">
                            Feel free to use any examples you like from the full versions to build your own pages. <strong>Wish you all the best and happy coding!</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
            <div class="col-md-6">
                @include('_dashboard._latest_order')
            </div>
            <div class="col-md-6">
                @include('_dashboard._path_top_sale')
            </div>
            <div class="col-md-6">
                @include('_dashboard._latest_inv')
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection

@section('js_after')
<script src="{{ asset('/js/plugins/chartjs/Chart.bundle.min.js') }}"></script>
<script>

    $('.icon-ats').on("click", function () {
        $('.ats-content').toggle('show');
        $('.icon-ats').toggle('show');
    });

var data_n = {!! json_encode($ChartPathTopSale['n']) !!}
var data_c = {!! json_encode($ChartPathTopSale['q']) !!}
var ctx = document.getElementById('ats-chart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: data_n,
        datasets: [{
            label: '# of Votes',
            data: data_c,
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(0, 255, 0, 0.7)',
                'rgba(0, 0, 128, 0.7)',
                'rgba(255, 255, 0, 0.7)',
                'rgba(128, 128, 0, 0.7)',
                'rgba(153, 120, 155, 0.7)'
            ],
            // borderColor: [
            //     'rgba(255, 99, 132, 1)',
            //     'rgba(54, 162, 235, 1)',
            //     'rgba(255, 206, 86, 1)',
            //     'rgba(75, 192, 192, 1)',
            //     'rgba(153, 102, 255, 1)',
            //     'rgba(255, 159, 64, 1)',
            //     'rgba(54, 162, 135, 1)',
            //     'rgba(255, 236, 86, 1)',
            //     'rgba(75, 19, 192, 1)',
            //     'rgba(153, 12, 255, 1)'
            // ],
            // borderWidth: 1
        }]
    },

    // options: {
    //     scales: {
    //         yAxes: [{
    //             ticks: {
    //                 beginAtZero: true
    //             }
    //         }]
    //     }
    // }
});
</script>
@endsection
