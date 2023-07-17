

<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password - OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .otp-container {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        .otp-code {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }

        .otp-copy {
            text-align: center;
            margin-bottom: 20px;
        }

        .otp-copy input {
            width: 300px;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .otp-copy button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .otp-copy button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th>From</th>
            <td>sipaias.official@gmail.com</td>
        </tr>
        <tr>
            <th>To</th>
            <td>{{ $to }}</td>
        </tr>
        <tr>
            <th>Subject</th>
            <td>Forgot Password - OTP Verification</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ date('d F Y', strtotime(now())) }}</td>
        </tr>
    </table>

    <div class="otp-container">
        <h2>Forgot Password - OTP Verification</h2>
        <p>Please copy the OTP code below and use it for password reset:</p>
        <div class="otp-code">{{ $data['token'] }}</div>
    </div>
</body>

</html>
