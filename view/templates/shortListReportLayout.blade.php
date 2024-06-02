<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$appNameFull}}</title>
    <style>
        body {
            background-color: #fdfdfd;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            background-color: #020f1b;
            color: #ffffff;
            page-break-inside: avoid;
            padding: 10px;
        }

        .logo {
            max-width: 80px;
            display: block;
            margin: 0 auto 10px auto;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            margin: 5px 0;
            color: #020f1b;
        }

        .document-header {
            text-decoration: underline;
            font-size: 20px;
            color: #075E54;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            page-break-inside: avoid;
            /* Prevent table from breaking across pages */
        }

        tr th {
            background-color: #020f1b;
            color: #ffffff;
            height: 30px;
            vertical-align: middle;
            padding-top: 5px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .contact-info {
            text-align: center;
        }


        @media print {
            .container {
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="contact-info" style="width: 50%; vertical-align: top;">
            <img src="/{{$appName}}/assets/img/logo2.png" width="200px" alt="logo" class="logo">
            <h1>Uganda Police Force, Recruitment System</h1>

            <br><br><br><br>
            <h2>Shortlist Report</h2>
            <span>Created On {{$currentDate}}</span><br><br><br>

        </div>
        <div class="card">
            <div class="card-body">

                <!-- Table with stripped rows -->
                <table class="table table-striped datatable" id="shortlist-table">
                    <thead>
                        <tr>
                            <th scope="col">SNo</th>
                            <th scope="col">Name</th>
                            <th scope="col">District</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Job Title</th>
                            <th scope="col">Status</th>
                            <th scope="col">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shortlist as $item)
                        <tr>
                            <td scope="row">{{$loop->iteration}}</td>
                            <td>{{$item['name']}}</td>                        
                            <td>{{$item['district']}}</td>
                            <td>{{$item['phone']}}</td>
                            <td>{{$item['title']}}</td>
                            <td>
                                @if($item['status'] == 'shortlisted')
                                <span class="badge bg-success">Shortlisted on {{$item['created_at']}}</span>

                                @endif
                            </td>
                            <td>{{$item['notes']}}</td>

                        </tr>
                        @endforeach


                    </tbody>
                </table>

            </div>
        </div>

    </div>
</body>

</html>