{{-- resources/views/info-city.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Información</h1>
    <form method="POST" action="{{ route('get-city-info') }}">
        @csrf
        <select name="country" id="country-select" onchange="updateStates()">
            <option value="">Seleccione un país</option>
            @foreach($countries as $country)
                <option value="{{ $country['iso2'] }}">{{ $country['name'] }}</option>
            @endforeach
        </select>

        <select name="state" id="state-select" onchange="updateCities()">
            <!-- Las opciones de estados se llenarán dinámicamente -->
            <option value="state">Seleccione un estado</option>
        </select>

        <select name="city" id="city-select">
            <!-- Las opciones de ciudades se llenarán dinámicamente -->
            <option value="city">Seleccione una ciudad</option>
        </select>

        <button type="submit">Buscar Información de la Ciudad</button>
    </form>

    @if(isset($weatherInfo))
    <div>
        <p>Temperatura: {{ $weatherInfo['main']['temp'] }}°C</p>
        <p>Sensación térmica: {{ $weatherInfo['main']['feels_like'] }}°C</p>
        <p>Humedad: {{ $weatherInfo['main']['humidity'] }}%</p>
        <p>Descripción: {{ $weatherInfo['weather'][0]['description'] }}</p>
    </div>
    @endif
</div>

<script>
function updateStates() {
    var countryIso = document.getElementById('country-select').value;
    fetch(`/states/${countryIso}`)
    .then(response => response.json())
    .then(data => {
        var stateSelect = document.getElementById('state-select');
        stateSelect.innerHTML = '<option value="">Seleccione un estado</option>'; // Limpiar opciones existentes
        data.forEach(function(state) {
            var option = new Option(state.name, state.iso2);
            stateSelect.appendChild(option);
        });
    })
    .catch(error => console.error('Error:', error));
}

function updateCities() {
    var countryIso = document.getElementById('country-select').value;
    var stateIso = document.getElementById('state-select').value;
    fetch(`/cities/${countryIso}/${stateIso}`)
    .then(response => response.json())
    .then(data => {
        var citySelect = document.getElementById('city-select');
        citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>'; // Limpiar opciones existentes
        data.forEach(function(city) {
            var option = new Option(city.name, city.id);
            citySelect.appendChild(option);
        });
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection
