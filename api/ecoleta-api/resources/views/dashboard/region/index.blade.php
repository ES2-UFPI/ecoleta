@extends('dashboard.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Regiões cadastradas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Houve um erro ao tentar excluir essa região. Verifique se há dados vinculados a ela, pois você só poderá excluir caso a região não esteja vinculado a nenhuma entidade.
                    </div>
                @endif
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Cidade</th>
                            <th>Título</th>
                            <th>Operações</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Cidade</th>
                            <th>Título</th>
                            <th>Operações</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($regions as $region)
                            <tr>
                                <td>{{ $region->city()->first()->name .'/' .$region->city()->first()->state()->first()->code }}
                                </td>
                                <td>{{ $region->title }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form
                                                action="{{ route('dashboard.region.destroy', ['region' => $region->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger"
                                                    onclick="confirm('Tem certeza que deseja excluir essa região?');">Remover</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('dashboard.region.show', ['region' => $region->id]) }}"
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
