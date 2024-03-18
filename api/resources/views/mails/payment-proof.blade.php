<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .logo {
            text-align: center;
        }
        .logo img {
            max-width: 100px;
            height: auto;
        }
        .payment-details {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{asset('assets/img/logo.png')}}" alt="Company Logo">
        </div>
        <h2>Payment Confirmation</h2>
        
        <div class="payment-details">
            <table>
                <tr>
                    <th>Amount Paid</th>
                    <td>NGN {{ $data['amount'] }}</td>
                </tr>
                <tr>
                    <th>Payment By</th>
                    <td>{{ $data['payee'] }}</td>
                </tr>
                <tr>
                    <th>Date of Payment</th>
                    <td>{{ $data['date'] }}</td>
                </tr>
                <tr>
                    <th>Payment Reference</th>
                    <td>{{ $data['reference'] }}</td>
                </tr>
                {{-- <tr>
                    <th>Download Receipt</th>
                    <td>
                        <a href="{{ $data['download_link'] }}" download="{{ $data['name'] }}">
                            <button style="padding: 8px 12px; background-color: #23346A; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                Download
                            </button>
                        </a>
                    </td>
                </tr> --}}
                <!-- Add more payment details as needed -->
            </table>
        </div>
    </div>
</body>
</html>
