@extends('dashboard.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Pontos de Coleta Cadastradas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Região</th>
                            <th>Título</th>
                            <th>Operações</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Região</th>
                            <th>Título</th>
                            <th>Operações</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($collectPoints as $collectPoint)
                            <tr>
                                <td>{{ $collectPoint->region()->first()->title }}
                                </td>
                                <td>{{ $collectPoint->title }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form
                                                action="{{ route('dashboard.collectpoint.destroy', ['collectPoint' => $collectPoint->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger"
                                                    onclick="confirm('Tem certeza que deseja excluir esse ponto de coleta?');">Remover</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('dashboard.collectpoint.show', ['collectPoint' => $collectPoint->id]) }}"
                                                class="btn btn-success">Editar</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
