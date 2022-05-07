@extends('dashboard.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de itens de Pontos de Coleta Cadastradas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Houve um erro ao tentar excluir esse item do ponto de coleta. Se houver um descarte esse item não
                        pode mais ser excluído.
                    </div>
                @endif
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Ponto de Coleta</th>
                            <th>Título</th>
                            <th>Operações</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Ponto de Coleta</th>
                            <th>Título</th>
                            <th>Operações</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($collectionItems as $collectItem)
                            <tr>
                                <td>{{ $collectItem->collectPoint()->first()->title }}
                                </td>
                                <td>{{ $collectItem->title }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form
                                                action="{{ route('dashboard.collectitem.destroy', ['collectionItem' => $collectItem->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger"
                                                    onclick="confirm('Tem certeza que deseja excluir esse ponto de coleta?');">Remover</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('dashboard.collectitem.show', ['collectionItem' => $collectItem->id]) }}"
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
