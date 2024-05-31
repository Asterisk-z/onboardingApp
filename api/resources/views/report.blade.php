<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Certificate</title>
    <!-- Include the Google Font -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap"> --}}
    <style>
        @page {
            margin: 0px;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0px;
            padding: 0;
            background-color: #f0f0f0;
        }


        table {
            padding: 3px;
        }

        table>tbody>tr>td,
        table>tbody>tr>th {
            padding: 5px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

    </style>
</head>

<body>

    <?php
    $logo = false ? public_path('assets/img/logo.png') : asset('assets/img/logo.png');
    ?>

    <div>
        {{-- <img src="{{ $logo }}" alt="Event Logo"> --}}
        {{-- <div class="event-name secondary-color">Certificate of Participation</div>  --}}

        {!! $dataTable !!}

    </div>


</body>

</html>
