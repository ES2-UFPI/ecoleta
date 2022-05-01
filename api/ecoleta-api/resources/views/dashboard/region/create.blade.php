@extends('dashboard.app')

@section('content')
    <h2>Cadastrar Região</h2>
    <hr>
    <form action="{{ route('dashboard.region.store') }}" method="POST">

        @csrf

        <div class="row">
            <div class="col-md-12 alert alert-warning d-none messageBox"></div>

            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Houve um erro no cadastro da região.
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="estado">Estado *</label>
                    <select required class="form-control" id="estado" name="state_id">
                        <option>Selecione um estado</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}"
                                data-route="{{ route('state.cities', ['state' => $state->id]) }}">
                                {{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cidade">Cidade *</label>
                    <select required class="form-control" id="cidade" name="city_id">
                        <option value="">Selecione uma cidade</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="nome">Título</label>
                    <input required type="text" class="form-control" id="nome" name="title" placeholder="Ex: Zona Norte">
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
        </div>
    </form>
@endsection
