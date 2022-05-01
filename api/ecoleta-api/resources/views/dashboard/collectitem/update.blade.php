@extends('dashboard.app')

@section('content')
    <h2>Atualizar Item de um ponto de coleta: {{ $collectionItem->title }}</h2>
    <hr>
    <form action="{{ route('dashboard.collectitem.update', ['collectionItem' => $collectionItem->id]) }}" method="POST">

        @csrf
        @method('put')

        <div class="row">
            <div class="col-md-12 alert alert-warning d-none messageBox"></div>

            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Houve um erro na atualização de item do ponto de coleta.
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="pontoDeColeta">Ponto de Coleta *</label>
                    <select required class="form-control" id="pontoDeColeta" name="collect_point_id">
                        <option value="">Selecione uma região</option>
                        @foreach ($CollectPoints as $collectionPoint)
                            <option value="{{ $collectionPoint->id }}"
                                {{ $collectionItem->collect_point_id === $collectionPoint->id ? 'selected' : '' }}>
                                {{ $collectionPoint->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome">Título</label>
                    <input required type="text" class="form-control" id="nome" name="title"
                        placeholder="Ex: Lixo Eletrônico" value="{{ $collectionItem->title }}">
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </div>
    </form>
@endsection
