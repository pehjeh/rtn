<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RealTimeNetworks</title>
    <link href="/assets/dist/css/bootstrap.css" rel="stylesheet">

    @livewireStyles
</head>
<body>

<div class="container">
    <header>
        <h1>RealTimeNetworks</h1>
    </header>
    <div class="">
        <livewire:stats/>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.3.slim.min.js"></script>
<script src="/assets/dist/js/bootstrap.js"></script>

@livewireScripts
</body>
</html>
