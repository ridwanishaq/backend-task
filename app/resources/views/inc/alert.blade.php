@if (Session::has('success'))
    <div id="alertBox">
        <div class="alert alert-success">
            <strong>Success! </strong>{{ Session::get('success') }}
            @php
                Session::forget('success');
            @endphp
        </div>
    </div>
@endif
@if (Session::has('error'))
    <div id="alertBox">
        <div class="alert alert-danger">
            {{ Session::get('error') }}
            @php
                Session::forget('error');
            @endphp
        </div>
    </div>
@endif
@if($errors->any())
    <div id="alertBox">
        <div class="alert alert-danger">
            <p><strong>Opps Something went wrong</strong></p>
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    </div>
@endif