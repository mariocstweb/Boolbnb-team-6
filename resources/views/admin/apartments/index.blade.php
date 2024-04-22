@extends('layouts.app')

@section('title', 'Appartamenti')

@section('content')
<h1 class="mt-4 mb-5">I tuoi appartamenti</h1>


<div class="d-flex justify-content-between align-items-center mb-5">
  {{-- Barra di ricerca --}}
  <form method="GET" action="{{ route('admin.apartments.index')}}">
    <div class="d-flex border p-2 rounded w-search">
        <input type="search" class="form-control border-0 me-2" placeholder="Cerca un appartamento" name="search"
        value="{{ $search }}">
        <button class="btn text-white bg-hover" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
  </form>

  <div>
    {{-- Aggiungi appartamento --}}
    <a href="{{route('admin.apartments.create')}}" class="btn bg-hover me-2 text-white p-2"><i class="fa-solid fa-house-medical ms-1"></i> Aggiungi appartamento</a>

    {{-- Cestino --}}
    <a class="btn c-main p-2 bg-hover-rev" href="{{route('admin.apartments.trash')}}"><i class="fa-regular fa-trash-can"></i> Cestino</a>  
    </div>
  </div>


@if($apartments->count() > 0)
  {{-- Tabella appartamenti --}}
  <table class="table table-hover">
    <thead class="border-top">
      <tr>
        <th scope="col">Anteprima</th>
        <th scope="col">ID</th>
        <th scope="col">Nome Appartamento</th>
        <th scope="col">Pubblicato</th>
        <th scope="col">Sponsorizzazione</th>
        <th scope="col">Azioni</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($apartments as $apartment)
        <tr>

          {{-- Cover --}}
          <td><img src="{{$apartment->cover}}" alt="{{$apartment->title}}" class="img-fluid table-img rounded-1"></td>

          {{-- ID --}}
          <td>{{$apartment->id}}</td>

          {{-- Titolo --}}
          <td>{{$apartment->title}}</td>

          {{-- Stato --}}
          <td class="text-start fs-4">{!!$apartment->is_visible ? '<i class="fa-solid fa-circle-check text-success"></i>' : '<i class="fa-solid fa-circle-xmark text-danger"></i>'!!}</td>

          {{-- Sponsorizzazione --}}
          <td>Sponsorizzazione</td>

          {{-- Cestino/Modifica/Dettaglio --}}
          <td>
            <div class="d-flex justify-content-between">
              <div class="d-flex align-items-center justify-content-center gap-2">
                {{-- Cestino --}}
                <form method="POST" action="{{route('admin.apartments.destroy', $apartment->id)}}">
                  @csrf
                  @method('DELETE')
                  <button class="btn bg-icon"><i class="fa-regular fa-trash-can"></i></button>
                </form>
                {{-- Modifica --}}
                <a href="{{route('admin.apartments.edit', $apartment->id)}}" class="btn bg-icon"><i class="fa-regular fa-pen-to-square"></i></a>
              </div>
              {{-- Dettaglio --}}
              <a href="{{route('admin.apartments.show', $apartment->id)}}" class="btn"><i class="fa-solid fa-chevron-right"></i></a>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div class="row">
   <div class="col-4"><p class="text-start">{{ $apartments->firstItem() }} - {{ $apartments->lastItem() }} di {{ $apartments->total() }} risultati</p></div>
    <div class="col-4 d-flex justify-content-center">
    {{ $apartments->links('pagination::bootstrap-4', ['prev_page_url' => 'Precedente', 'next_page_url' => 'Successivo']) }}
    </div>
  </div>
@else
  <h2 class=" text-center">Non ci sono appartamenti registrati</h2>
@endif
@endsection