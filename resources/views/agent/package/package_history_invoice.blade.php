<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice | Agent Panel | Real Estate</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap-grid.min.css"
        integrity="sha512-ZuRTqfQ3jNAKvJskDAU/hxbX1w25g41bANOVd1Co6GahIe2XjM6uVZ9dh0Nt3KFCOA061amfF2VeL60aJXdwwQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray;
        }

        .font {
            font-size: 15px;
        }

        .authority {
            /*text-align: center;*/
            float: right;
        }

        .authority h5 {
            margin-top: -10px;
            color: green;
            /*text-align: center;*/
            margin-left: 35px;
        }

        .thanks p {
            color: green;
            font-size: 16px;
            font-weight: normal;
            font-family: serif;
            margin-top: 20px;
        }
    </style>

</head>

<body>

    <table width="100%" style="background: #F7F7F7; padding:0 20px 0 20px;">

        <tr>

            <td valign="top">
                <!-- {{-- <img src="" alt="" width="150"/> --}} -->
                <h2 style="color: green; font-size: 26px;"><strong>Real Estate</strong></h2>
            </td>

            <td align="right">
                <pre class="font">
                    Real Estate Head Office
                    Email: support@realestate.com
                    Mobile: 1245454545
                    Dhaka, Bangladesh
                </pre>
            </td>

        </tr>

    </table>


    <table width="100%" style="background:white; padding:2px;"></table>


    <table width="100%" style="background: #F7F7F7; padding:0 5px 20px 5px;" class="font">

        <tr>

            <td>
                <p class="font" style="margin-left: 20px;">
                    <strong>Name:</strong> {{ $package_history->user->name }} <br>
                    <strong>Email:</strong> {{ $package_history->user->email }} <br>
                    <strong>Phone:</strong> {{ $package_history->user->phone }} <br>
                    <strong>Address:</strong> {{ $package_history->user->address }}
                </p>
            </td>

            <td>
                <p class="font">
                <h3><span style="color: green;">Invoice:</span> #{{ $package_history->invoice }}</h3>
                <strong>Order Date:</strong> {{ $package_history->created_at }} <br>
                <strong>Payment Type:</strong> Cash on delivery (COD)
                </p>
            </td>

        </tr>

    </table>

    <br />


    <h3>Property Package</h3>

    <table width="100%">

        <thead style="background-color: green; color:#FFFFFF;">

            <tr class="font">
                <th>Package Name </th>
                <th class="text-end">Property Quantity</th>
                <th class="text-end">Unit cost</th>
                <th class="text-end">Total</th>
            </tr>

        </thead>

        <tbody>

            <tr class="font">
                <td align="center"> {{ $package_history->package_name }}</td>
                <td align="center">{{ $package_history->package_credits }}</td>
                <td align="center">$ {{ $package_history->package_amount }}</td>
                <td align="center">$ {{ $package_history->package_amount }}</td>
            </tr>

        </tbody>

    </table>


    <div class="row">

        <div class="col-6">
            <div class="thanks" style="margin-top: 2rem;">
                <p>Thanks For Buying Products..!!</p>
            </div>
        </div>

        <div class="col-6">
            <div class="authority float-right" style="margin-top: -3rem;">
                <p>-----------------------------------</p>
                <h5>Authority Signature:</h5>
            </div>
        </div>

    </div>


</body>

</html>
