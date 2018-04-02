@extends ('backend.login.master') @section ('content')
  <script type="text/javascript">
    function date_time(id) {
        date = new Date;
        h = date.getHours();
        if(h<10)
        {
                h = "0"+h;
        }
        m = date.getMinutes();
        if(m<10)
        {
                m = "0"+m;
        }
        s = date.getSeconds();
        if(s<10)
        {
                s = "0"+s;
        }
        result = ''+h+':'+m+':'+s;
        document.getElementById(id).innerHTML = result;
        setTimeout('date_time("'+id+'");','1000');
        return true;
        }

        function date(id) {
        date = new Date;
        year = date.getFullYear();
        month = date.getMonth();
        months = new Array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        d = date.getDate();
        day = date.getDay();
        days = new Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
        result = ''+days[day]+', '+d+' '+months[month]+' '+year+'';
        document.getElementById(id).innerHTML = result;
        setTimeout('date("'+id+'");','1000');
        return true;
        }
  </script>

  @if(session()->has('presence_success_on'))
  <div class="alert alert-success" role="alert">
    @lang('alert.presence_success_on',['name'=>session()->get('presence_success_on')])
  </div>
  @endif

   @if(session()->has('return_presence_success_on'))
  <div class="alert alert-success" role="alert">
    @lang('alert.return_presence_success_on',['name'=>session()->get('return_presence_success_on')])
  </div>
  @endif

   @if(session()->has('presence_success_late'))
  <div class="alert alert-success" role="alert">
    @lang('alert.presence_success_late',['name'=>session()->get('presence_success_late')])
  </div>
  @endif

  @if(session()->has('presence_failed'))
  <div class="alert alert-danger" role="alert">
    @lang('alert.presence_failed')
  </div>
  @endif

  <div class="lockscreen-logo">
    <a href="#"><span id="date_time" style="font-size: 80px; font-weight: bold"></span></a>
    <a href="#"><span id="date" style="font-size: 20px"></span></a>
    <script type="text/javascript">window.onload = date('date');</script>
    <script type="text/javascript">window.onload = date_time('date_time');</script>
  </div>
  <!-- User name -->
  <!-- <div class="lockscreen-name">John Doe</div> -->

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="{{ URL::asset('admin/dist/img/user.png')}}" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form method="POST" action="{{url('/presence')}}" class="lockscreen-credentials">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <div class="input-group">
        <input type="password" class="form-control" placeholder="Tap ID Card" name="id_card">

        <div class="input-group-btn">
          <button type="button" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Harap Tap ID anda ke RFID Reader
  </div>
<!--   <div class="text-center">
    <a href="login.html">Or sign in as a different user</a>
  </div> -->
  <div class="lockscreen-footer text-center">
    Copyright &copy; 2014-2016 <b><a href="https://adminlte.io" class="text-black">Almsaeed Studio</a></b><br>
    All rights reserved
  </div>

@endsection
