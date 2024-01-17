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

        .certificate {
            width: 800px;
            max-width: 100%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            border: 10px solid #273466;
            /* Organization's primary color */
        }

        .donload-container {

            text-align: center;
        }

        .certificate img {
            max-width: 150px;
            height: auto;
        }

        .event-name {
            font-size: 28px;
            font-weight: bold;
            margin: 20px 0;
            color: #C49B47;
            /* Organization's secondary color */
        }

        .participant-name {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .date {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .signature {
            margin-top: 40px;
        }

        .organizer-signature {
            max-width: 100px;
            margin-top: 10px;
        }

        .signature-text {
            margin: 20px 0;
            font-family: 'Pacifico', cursive;
        }

        /* Styling for organization's secondary color */
        .secondary-color {
            color: #C49B47;
        }

        /* Styling for organization's tertiary color */
        .tertiary-color {
            color: #969698;
        }
    </style>
</head>

<body>

    <?php
    $organizerName = env('EVENT_ORGANIZER_NAME', null);
    
    if (!$organizerName) {
        $organizerName = env('APP_NAME', 'MROIS');
    }
    
    $signature = env('EVENT_ORGANIZER_SIGNATURE', null);
    if (!$organizerName) {
        $signature = $organizerName;
    }
    
    $logo = $isDownload ? public_path('assets/img/logo.png') : asset('assets/img/logo.png');
    $signature = $isDownload ? public_path('assets/img/signature.png') : asset('assets/img/signature.png');
    ?>
    <div class="certificate">
        <img src="{{ $logo }}" alt="Event Logo">
        <div class="event-name secondary-color">Certificate of Participation</div>
        <div class="event-name secondary-color"><strong class="tertiary-color">{{ $event->name }} </strong></div>
        <div class="participant-name secondary-color">This is to certify that</div>
        <div class="participant-name secondary-color"><strong class="tertiary-color">{{ $name }}</strong></div>
        <div class="date tertiary-color">has successfully participated in the event on
            {{ date('M d, Y', strtotime($event->date)) }}.</div>
        <div class="signature">
            <img src="{{ $signature }}" alt="Organizer Signature" class="organizer-signature">
            <p class="secondary-color">{{ $organizerName }}</p>
        </div>
    </div>

    @if (!$isDownload)
        <div class="donload-container">
            <a href="{{ route('certificateSampleDownload', $event->id) }}">Download</a>
        </div>
    @endif

</body>

</html>
