@if($errors->any())
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <ul>
                    {!! implode('', $errors->all('
                    <li class="error">:message</li>
                    ')) !!}
                </ul>
            </div>
        </div>
    </div>
    {{--  <div class="alert alert-danger">
          <ul>
              {!! implode('', $errors->all('
              <li class="error">:message</li>
              ')) !!}
          </ul>
      </div>--}}
@endif
@if(\Illuminate\Support\Facades\Session::has('error'))
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {!! session('error') !!}
            </div>
        </div>
    </div>
@endif
@if(\Illuminate\Support\Facades\Session::has('success'))
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {!! session('success') !!}
            </div>
        </div>
    </div>
@endif
