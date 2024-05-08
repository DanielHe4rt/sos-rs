@extends('components.app')


@section('content')
    <main>
        <div class="p-5 text-center bg-body-tertiary rounded-3" bis_skin_checked="1">
            <svg class="bi mt-4 mb-3" style="color: var(--bs-indigo);" width="100" height="100"><use xlink:href="#bootstrap"></use></svg>
            <h1 class="text-body-emphasis">
                {{ __('Ajuda os cara') }}
            </h1>
            <p class="col-lg-8 mx-auto fs-5 text-muted">
                {{ __('Centro de informações para reconhecimento de pessoas afetadas no Rio Grande do Sul.') }}
            </p>
            <div class="d-inline-flex gap-2 mb-5" bis_skin_checked="1">
                <button onclick="startCommunication()" class="d-inline-flex align-items-center btn btn-danger btn-lg px-4 rounded-pill" type="button">
                    <i class="fas fa-flag ms-2"></i>
                    <span class="px-2">Preciso de Ajuda</span>
                </button>
                <button class="d-inline-flex align-items-center btn btn-warning btn-lg px-4 rounded-pill" type="button">
                    <i class="fas fa-house ms-2"></i>
                    <span class="px-2">Estou em um abrigo</span>
                </button>
                <button class="d-inline-flex align-items-center btn btn-info btn-lg px-4 rounded-pill" type="button">
                    <i class="fas fa-house ms-2"></i>
                    <span class="px-2">Estou procurando alguém</span>
                </button>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <script type="text/javascript">

        const options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0,
        }

        function success(pos) {
            const crd = pos.coords
            console.log("Your current position is:")
            console.log(`Latitude : ${crd.latitude}`)
            console.log(`Longitude: ${crd.longitude}`)
            console.log(`More or less ${crd.accuracy} meters.`)
            console.log(crd)

            fetch('/start-communication',
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        latitude: crd.latitude,
                        longitude: crd.longitude,
                        accuracy: crd.accuracy,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data)
                })
                .catch((error) => {
                    console.error('Error:', error)
                })
        }

        function error(err) {
            console.warn(`ERROR(${err.code}): ${err.message}`)
        }

        function startCommunication() {
            navigator.geolocation.getCurrentPosition(success, error, options)
        }

    </script>
@endsection
