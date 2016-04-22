<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href='https://fonts.googleapis.com/css?family=Ubuntu&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Ubuntu';
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
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">

            <div class="content">
                <form onsubmit="return false;">
                  <div class="form-group">
                    <input type="email" class="form-control" id="login" placeholder="Почта">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control" id="pass" placeholder="Пароль">
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-default form-control">Вход</button>
                  </div>
                </form>


                <div><a href="#">Забыли пароль?</a></div>
                <div>Не зарегистрированы? <a href="/register">Регистрация</a></div>

                <div class="form-group" id="errorPlace" style="top: 10px;right: 10px; position: absolute;"></div>

            </div>

        </div>



    <script type="text/javascript">

    $("form").submit(function() {
        var login = $("#login").val();
        var pass = $("#pass").val();
        var jsonData = {};
        jsonData.login = login;
        jsonData.pass = pass;
        jsonData._token  = "{{ csrf_token() }}";
        $.ajax({
            url:"/login",
            method:"POST",
            data:jsonData,
            success:function(data) {
                console.log( data );
                switch(+data) {
                    case 200: {
                        // $("#errorPlace").append('<div class="alert alert-success" role="alert">Успешная авторизация</div>');
                        window.location.reload();
                        setTimeout(function() {
                            $(".alert").remove();
                        },3000);

                        break;
                    }

                    case 400: {
                        console.log( 'err');
                        $("#errorPlace").append('<div class="alert alert-danger" role="alert">Ошибка в параметрах</div>');
                        setTimeout(function() {
                            $(".alert").remove();
                        },3000);
                        break;
                    }

                    case 403: {
                        console.log( 'err');
                        $("#errorPlace").append('<div class="alert alert-danger" role="alert">Не верный пароль</div>');
                        setTimeout(function() {
                            $(".alert").remove();
                        },3000);
                        break;
                    }

                    case 404: {
                        console.log( 'err');
                        $("#errorPlace").append('<div class="alert alert-danger" role="alert">Пользователь не найден</div>');
                        setTimeout(function() {
                            $(".alert").remove();
                        },3000);
                        break;
                    }


                    case 500: {
                        console.log( 'err');
                        $("#errorPlace").append('<div class="alert alert-danger" role="alert">Ошибка сервера</div>');
                        setTimeout(function() {
                            $(".alert").remove();
                        },3000);
                        break;
                    }                    

                }
            }
        })
    });

    </script>


    </body>
</html>
