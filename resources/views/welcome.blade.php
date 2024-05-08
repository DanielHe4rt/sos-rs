<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<main class="container">
    <header>
        <h1>Ajuda os cara</h1>
    </header>

    <main>
        <div role="group">
            <button id="startCommunication" onclick="startCommunication()">
                Iniciar comunicação
            </button>
        </div>
    </main>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
</body>
</html>
