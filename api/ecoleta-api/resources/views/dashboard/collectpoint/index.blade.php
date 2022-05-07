@extends('dashboard.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Pontos de Coleta Cadastradas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Houve um erro ao tentar excluir esse ponto de coleta. Verifique se há dados vinculados a ela.
                    </div>
                @endif
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
                                        <div class="col-md-4">
                                            <form
                                                action="{{ route('dashboard.collectpoint.destroy', ['collectPoint' => $collectPoint->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger"
                                                    onclick="confirm('Tem certeza que deseja excluir esse ponto de coleta?');">Remover</button>
                                            </form>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="{{ route('dashboard.collectpoint.show', ['collectPoint' => $collectPoint->id]) }}"
                                                class="btn btn-success">Editar</a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="{{ route('dashboard.collectpoint.items', ['collectPoint' => $collectPoint->id]) }}"
                                                class="btn btn-primary">Visualizar Itens</a>
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
