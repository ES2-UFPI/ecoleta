@extends('dashboard.app')

@section('content')
    <h2>Cadastrar Ponto de coleta</h2>
    <hr>
    <form action="{{ route('dashboard.collectpoint.store') }}" method="POST">

        @csrf

        <div class="row">
            <div class="col-md-12 alert alert-warning d-none messageBox"></div>

            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Houve um erro no cadastro do ponto de coleta.
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="regiao">Região *</label>
                    <select required class="form-control" id="regiao" name="region_id">
                        <option value="">Selecione uma região</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}">
                                {{ $region->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome">Título</label>
                    <input required type="text" class="form-control" id="nome" name="title" placeholder="Ex: Mocambinho">
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
        </div>
    </form>
@endsection
