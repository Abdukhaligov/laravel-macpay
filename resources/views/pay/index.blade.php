<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width"/>
  <title>GmodLA &#8250; Donate</title>
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/theme.css') }}" rel="stylesheet">

  <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/bb.min.js') }}"></script>
  <script type="text/javascript">
    function validate2(val) {
      v1 = document.getElementById("steamid");
      v2 = document.getElementById("server");
      v3 = document.getElementById("summ");
      v5 = document.getElementById("reminder");

      flag1 = true;
      flag2 = true;
      flag3 = true;

      if (val >= 1 || val == 0) {
        if (v1.value == "") {
          v1.style.borderColor = "red";
          flag1 = false;
        } else {
          v1.style.borderColor = "#252525";
          flag1 = true;
        }
      }

      if (val >= 2 || val == 0) {
        if (v2.value == "") {
          v2.style.borderColor = "red";
          flag2 = false;
        } else {
          v2.style.borderColor = "black";
          flag2 = true;
        }
      }

      if (val >= 3 || val == 0) {
        if (v3.value == "") {
          v3.style.borderColor = "red";
          flag3 = false;
        } else {
          v3.style.borderColor = "black";
          flag3 = true;
        }
      }

      flag = flag1 && flag2 && flag3;

      if (flag == false) {
        v5.style.display = "block";
      } else {
        v5.style.display = "none";
      }


      return flag;
    }
  </script>
</head>

<body>
<div class="footer__logoflex">
  <img src="{{ asset('img/logo_shadow.png') }}" alt="">
</div>

<form method="POST" action="{{route('pay.sendRequestToEnot')}}">
  @csrf
  <div class="container-fluid px-1 py-5 mx-auto">
    <div class="row d-flex justify-content-center">
      <div class="col-xl-5 col-lg-6 col-md-7">
        <div class="card b-0">
          <h3 class="heading">GmodLA Donate</h3>
          <p class="desc">Наш проект, как все, нуждается в материальной помощи.
            Благодаря вашей поддержке мы можем спокойно арендовать оборудование для игровых серверов и совершенствовать
            проект в целом.
            Именно по этим причинам мы предоставляем за ваши пожертвования особые донат баллы на игровом сервере для вас.
          </p>
          <fieldset class="show">
            <div class="form-card">
              <h5 class="sub-heading mb-4">Внимание</h5>
              <p class="desc">
                Деньги, потраченные на пожертвование сервера, <span class="yellow-text">не возвращаются ни при каких обстоятельствах.</span>
                Попытки любых махинаций или ввод Администрации в заблуждение наказываются без возмездной блокировкой на
                проекте.
                Переводы начисленных балов (например, с одного сервера на другой) или изменение суммы невозможны.
              </p>
              <label class="text-danger mb-3" id="reminder">Все поля должны быть заполнены</label>
              <div class="form-group"><label class="form-control-label">Ваш SteamID:</label>
                <input type="text" id="steamid"
                       name="steam_id"
                       required
                       value="{{$data["steam_id"]}}"
                       placeholder=""
                       class="form-control"
                       onblur="validate2(1)">
                @error('steam_id')
                  <div style="display: block;" class="col-form-label text-danger">{{$message}}</div>
                @enderror
              </div>
              <div class="form-group"><label class="form-control-label">Сервер:</label>
                <div class="select mb-3">
                  <select name="server_id" required class="form-control" onblur="validate2(2)">
                  @foreach($servers as $server)
                      <option {{($server->id == $data["server_id"]) ? 'selected' : ''}} value="{{$server->id}}">{{$server->name}}</option>
                    @endforeach
                  </select>
                  @error('server_id')
                    <div style="display: block;" class="col-form-label text-danger">{{$message}}</div>
                  @enderror
                </div>
                <div class="form-group"><label class="form-control-label">Сумма:</label>
                  <input type="text" id="summ"
                         required
                         name="amount" placeholder=""
                         value="{{$data["amount"]}}"
                         class="form-control"
                         onblur="validate2(3)">
                  @error('amount')
                    <div style="display: block;" class="col-form-label text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="form-check">
                <input required name="acceptPolicy" class="form-check-input" type="checkbox" id="gridCheck1">
                <label class="form-check-label" for="gridCheck1">
                  Я согласен со <a target="_blank" href="{{route('pay.policy')}}" class="yellow-text"> всеми условиями
                    пожертвования
                    проекту.</a>
                </label>
              </div>
              <button class="btn-block btn-primary" onclick="validate2(0)">Перейти к оплате</button>
            </div>
          </fieldset>
        </div>
      </div>
    </div>
  </div>
</form>

<footer>
  <div class="container">
    <div class="footer__copy">
      GMODLA - PROJECT © 2021. All rights reserved
    </div>
  </div>
</footer>

</body>
</html>
