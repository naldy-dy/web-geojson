<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload GeoJSON</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <h1>Upload File GeoJSON</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>

        <h2>Data GeoJSON yang Di-upload:</h2>
        <pre>{{ json_encode(session('geojson_data'), JSON_PRETTY_PRINT) }}</pre>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="geojson_file">Pilih file GeoJSON:</label>
        <input type="file" name="geojson_file" accept=".geojson" required>
        <button type="submit">Upload</button>
    </form>

    <div class="row">
        <div class="col-md-12">
            <div id="map" style="height: 50vh;"></div>
        </div>
    </div>

    <script>
        var peta1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

        var peta2 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'); // Example URL
        var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'); // Example URL
        var peta4 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'); // Example URL

        @foreach($list_desa as $data)
        var data{{$data->id}} = L.layerGroup();
        @endforeach

        var map = L.map('map', {
            center: [-1.8358712300287032, 109.97504462294081],
            zoom: 13,
            layers: [peta1, 
            @foreach($list_desa as $data)
            data{{$data->id}},
            @endforeach
            ]
        });

        var baseMaps = {
            "Grayscale": peta1,
            "Satellite": peta2,
            "Streets": peta3,
            "Dark": peta4,
        };

        var overLayer = {
            @foreach($list_desa as $data)
            "{{ ucwords($data->kecamatan) }}" : data{{$data->id}},
            @endforeach
        };

        L.control.layers(baseMaps, overLayer ).addTo(map);

        @foreach($list_desa as $data)
        L.geoJSON(@json($data->geojson), {
            style: {
                color: 'white',
                fillColor : '#c70039',
                fillOpacity: 0.5
            }
        }).addTo(data{{$data->id}});
        @endforeach
    </script>
</body>
</html>
