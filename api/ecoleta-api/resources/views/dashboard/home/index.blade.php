@extends('dashboard.app')

@section('content')
    <div class="d-none" id="home">oi</div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">

        <!-- Quantidade de regioes -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Regiões cadastradas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countRegions }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- pontos de coleta -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pontos de coleta cadastrados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countCollectPoints }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- itens diferentes -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Itens de pontos cadastrados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countCollectionItems }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- grafico de pizza dos itens com mais descarte (maximo 3 itens) -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Itens mais descartados</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart" data-array="{{ json_encode($mostCollecionItems) }}"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach ($mostCollecionItems as $key => $item)
                            <span class="mr-2">
                                <i class="fas fa-circle {{ $item['color'] }}"></i> {{ $item['collectionItem']->title }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- grafico de quantidade de pontos de coleta por região (ate 12 regiões) -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pontos de coleta por região</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart" data-array="{{ json_encode($lastTwelveRegions) }}"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
