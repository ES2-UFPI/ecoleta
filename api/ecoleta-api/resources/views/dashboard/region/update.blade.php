@extends('dashboard.app')

@section('content')
    <h2>Atualizar Região: {{ $region->title }}</h2>
    <hr>
    <form action="{{ route('dashboard.region.update', ['region' => $region->id]) }}" method="POST">

        @csrf
        @method('put')

        <div class="row">
            <div class="col-md-12 alert alert-warning d-none messageBox"></div>

            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Houve um erro na edição da região.
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="estado">Estado *</label>
                    <select required class="form-control JAtualizarRegiao" id="estado" name="state_id">
                        <option>Selecione um estado</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}"
                                {{ $region->city()->first()->state()->first()->id === $state->id? 'selected': '' }}
                                data-route="{{ route('state.cities', ['state' => $state->id]) }}"
                                data-city="{{ $region->city_id }}">
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
                    <input required type="text" class="form-control" id="nome" name="title" placeholder="Ex: Zona Norte"
                        value="{{ $region->title }}">
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </div>
    </form>
@endsection
