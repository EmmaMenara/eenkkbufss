@if(Session::has('status'))
    <div class="col-md-12" id="successMessage">
        <div class="alert alert-{{Session::get('status_type')}}">
            {{Session::get('status')}}
        </div>
    </div>
@endif