<!DOCTYPE html>
<html>
    <head>
        <title>{{ Config::get('site.title') }} - Huoltotauko</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:700" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #1C99E0;
                display: table;
                font-weight: 700;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
                text-shadow: 0 3px 0px #1B6C9A;
            }

            .title p {
                font-size: 32px;
                margin-bottom: 40px;
                text-shadow: none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">
                    Sivustoa huolletaan
                    <p>
                        Ole hyvä ja odota hetki...
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
