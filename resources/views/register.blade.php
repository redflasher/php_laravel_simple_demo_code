<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href='https://fonts.googleapis.com/css?family=Ubuntu&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet"> -->

        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

        <!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> -->
        <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>

    <style type="text/css">

        body{ 
            margin-top:40px; 
        }

        .stepwizard-step p {
            margin-top: 10px;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 100%;
            position: relative;
        }

        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }

        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-order: 0;

        }

        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }

        .btn-circle {
          width: 30px;
          height: 30px;
          text-align: center;
          padding: 6px 0;
          font-size: 12px;
          line-height: 1.428571429;
          border-radius: 15px;
        }
    </style>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>


    </head>
    <body>
        <div class="container">

            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step">
                        <a href="#step-1" id="prevBtn" type="button" class="btn btn-primary btn-circle">1</a>
                        <p>Шаг 1</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                        <p>Шаг 2</p>
                    </div>
                </div>
            </div>


<form role="form" onsubmit="return false;">
    <div class="row setup-content" id="step-1">
        <div class="col-xs-12">
            <div class="col-md-12">
                <h3> Регистрация -  Шаг 1</h3>

                <div class="form-group">
                    <input type="text" class="form-control" required="required" name="sponsor" placeholder="Введите логин спонсора или его номер счета">
                </div>

          <div class="form-group pull-right">
            <button class="btn btn-primary nextBtn" type="button" >Дальше</button>
          </div>


            </div>
        </div>
    </div>

    <div class="row setup-content" id="step-2">

            <div class="col-xs-12">
                <div class="col-md-12">
                    <h3> Регистрация -  Шаг 2</h3>

              <div class="form-group">
                <input type="text" class="form-control" required="required" name="fname" placeholder="Имя">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" required="required" name="sname" placeholder="Фамилия">
              </div>

              <div class="form-group">
                  <input type="email" class="form-control" required="required" name="email" placeholder="Почта">
              </div>

              <div class="form-group">
                <input type="text" class="form-control" required="required" name="username" placeholder="Логин">
              </div>

              <div class="form-group">
                <input type="text" class="form-control" required="required" name="phone" placeholder="Номер телефона">
              </div>

              <div class="form-group">
                <input type="text" class="form-control" name="skype" placeholder="Skype">
              </div>

              <div class="form-group">
                  <select class="form-control" name="country" value="RU">
                      <option>RU</option>
                      <option>EN</option>
                      <option>IT</option>
                      <option>DE</option>
                      <option>UA</option>
                  </select>
              </div>


              <div class="form-group">
                <input type="password" class="form-control" required="required"/ name="password" placeholder="Пароль">
              </div>


              <div class="form-group">
                <input type="password" class="form-control" required="required" name="finPassword" placeholder="Финансовый пароль">
              </div>

                <div class="form-group text-center">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" required="required" style="float:none"> Я согласен с условиями <a href="/agreements">соглашения</a>
                      </label>
                    </div>
                </div>

                <div class="pull-right">
                    <a href="#step-1" id="prevBtn" type="button" class="btn btn-default prevRectBtn">Назад</a>
                    <button type="submit" class="btn btn-primary">Регистрация</button>
                </div>


            </div>
        </div>

    </div>

</form>

<div class="form-group" id="errorPlace" style="top: 10px;right: 10px; position: fixed;"></div>


    <script type="text/javascript">
    $(document).ready(function () {

        var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allNextBtn = $('.nextBtn');

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                    $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-primary').addClass('btn-default');
                $item.addClass('btn-primary');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });

        allNextBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url']"),
                isValid = true;

            $(".form-group").removeClass("has-error");
            for(var i=0; i<curInputs.length; i++){
                if (!curInputs[i].validity.valid){
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }

            if (isValid)
                nextStepWizard.removeAttr('disabled').trigger('click');
        });

        $('div.setup-panel div a.btn-primary').trigger('click');

        $(".prevRectBtn").click(function() {
            $("#prevBtn").trigger("click");
        });
    });


      //register
      $("form").submit(function() {

      var sponsor = $("[name=sponsor]").val();
      var fname = $("[name=fname]").val();
      var sname = $("[name=sname]").val();
      var email = $("[name=email]").val();
      var username = $("[name=username]").val();
      var phone = $("[name=phone]").val();
      var skype = $("[name=skype]").val();
      var country = $("[name=country]").val();
      var password = $("[name=password]").val();
      var finPassword = $("[name=finPassword]").val();

      var jsonData = {};

      jsonData.sponsor = sponsor;
      jsonData.fname = fname;
      jsonData.sname = sname;
      jsonData.email = email;
      jsonData.username = username;
      jsonData.phone = phone;
      jsonData.skype = skype;
      jsonData.country = country;
      jsonData.password = password;
      jsonData.finPassword = finPassword;


        jsonData._token  = "{{ csrf_token() }}";
        $.ajax({
            url:"/register",
            method:"POST",
            data:jsonData,
            success:function(data) {
                console.log( data );
                switch(+data) {
                    case 200: {
                        console.log( "ok" );
                        window.location.href= "/";
/*                        $("#errorPlace").append('<div class="alert alert-success" role="alert">Успешная регистрация</div>');
                        setTimeout(function() {
                            $(".alert").remove();
                        },3000);*/
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
                        $("#errorPlace").append('<div class="alert alert-danger" role="alert">Спонсор не найден</div>');
                        setTimeout(function() {
                            $(".alert").remove();
                        },3000);
                        break;
                    }

                    case 409: {
                        console.log( 'err');
                        $("#errorPlace").append('<div class="alert alert-danger" role="alert">Пользователь уже существует</div>');
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
        });
    });

    </script>

    </body>
</html>
