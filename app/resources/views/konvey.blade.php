<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Font-Awesome Icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="/public/assets/css/styles.css">
        
        <title>Konvey - Take Home Assessment</title>
    </head>
    <body>

        <div class="container">

            <!-- Header -->
            <div class="logo-box">
                <img src="/public/assets/images/favicon.png" alt="" class="logo-icon">
                <h4 class="logo-title">Konvey Backend Take-Home Assessment!</h4>
            </div>

            @include('inc.alert')
            
            <!-- Prompt -->
            <form action="/" method="post">
                @csrf
                <div class="input-group mt-2">
                    <select class="form-select select-tone" name="tone" id="toneStyle" aria-label="Tone/Style" style="width: 20%">
                      <option selected value="">Choose a Tone/Style</option>
                      <option value="narrative">Narrative</option>
                      <option value="authoritative">Authoritative</option>
                      <option value="sad">Sad</option>
                      <option value="emotional">Emotional</option>
                      <option value="inspiring">Inspiring</option>
                      <option value="professional">Professional</option>
                      <option value="happy">Happy</option>
                    </select>
                    <input type="text" class="form-control prompt-box" name="prompt" placeholder="Enter a prompt..." style="width: 70%">
                    <button class="btn btn-outline-primary prompt-btn" type="submit" style="width: 10%"><i class="fa fa-location-arrow" aria-hidden="true"></i> Send</button>
                </div>
    
                <!-- Result -->
                <div class="row mt-5 result-container">
                    <hr>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                        @if (!empty($geminiData))
                            <h5><i class="fa fa-magic" aria-hidden="true"></i> Result:</h5>
                            <p>
                                {!! nl2br(preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $geminiData)) !!}
                            </p>
                        @endif
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        @if (!empty($diffusionImageOne))
                            <img src="data:image/png;base64,{{ $diffusionImageOne }}" alt="" class="generate-img">
                            <img src="data:image/png;base64,{{ $diffusionImageTwo }}" alt="" class="generate-img">
                        @endif
                    </div>
                </div>
            </form>

        </div>
        
        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </body>
</html>
        