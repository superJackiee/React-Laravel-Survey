@extends('main')

@section('title', '/ Home')

@section('content')
  @if(Helper::hasPendingDotEnvFileConfigs())
    <h1 class="text-center">Some configurations are missing!</h1>

    <div class="row">
      <div class="col-md-10 col-md-offset-1">
      {!! Helper::openForm('setup-update-missing-configs') !!}

        @foreach(Helper::getPendingDotEnvFileConfigs() as $group => $fields)
          <fieldset class="form-group">
            <legend><h2>{{ $group }}</h2></legend>

            @foreach($fields as $category => $field)
              @if($field['type'] === 'text')
                <div class="form-group">
                  {{ Form::label($field['name'], $category) }}:
                  {{ Form::text($field['name'], $field['value'], ['class' => 'form-control']) }}
                </div>
                @if(strlen($field['description']) > 0)
                  <blockquote><p>{!! $field['description'] !!}</p></blockquote>
                @endif

              @elseif($field['type'] === 'div')
                <div class="form-group">
                  {{ Form::label($field['name'], $category) }}
                  <div class="{{ $field['name'] }}"></div>
                </div>
                @if(strlen($field['description']) > 0)
                  <blockquote><p>{!! $field['description'] !!}</p></blockquote>
                @endif

              @elseif($field['type'] === 'checkbox')
                <div class="form-group">
                  {{ Form::label($field['name'], $category) }}
                  {{ Form::checkbox($field['name'], $field['value'], ['class' => 'form-control']) }}
                </div>
                @if(strlen($field['description']) > 0)
                  <blockquote><p>{!! $field['description'] !!}</p></blockquote>
                @endif

              @endif

            @endforeach

          </fieldset>
        @endforeach

        <div class="form-group">
          {{ Form::submit('Save', ['class' => 'btn btn-success btn-block setup-save']) }}
        </div>

      {!! Helper::closeForm() !!}
      </div>
    </div>

    <pre class="hide" style="white-space:pre-wrap">
    <?php print_r(Helper::getPendingDotEnvFileConfigs()); ?>
    </pre>

    {!! Helper::getGoogleReCaptchaApiAsset() !!}
    <script src="{{ asset('js/setup.js') }}"></script>

  @else
    <h1 class="text-center">Create your own surveys with Laravel!</h1>

    @if(count($available_surveys) > 0)
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Author</th>
          </tr>
        </thead>
        <tbody>
          @foreach($available_surveys as $available_survey)
            <tr>
              <td>
                <span>{{ $available_survey->name }}</span>
                <span class="mdash"> &mdash; </span>
                <span class="italics">published {{ Helper::createCarbonDiffForHumans($available_survey->created_at) }}</span>
              </td>
              <td>
                <span>{{ $available_survey->author_name }}</span>
                <span class="pull-right">
                  {{ Helper::linkRoute('public_survey.show', 'Start', [$available_survey->uuid], ['class' => 'btn btn-xs btn-primary']) }}
                </span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif

    @if(Helper::isMaxMindGeoIpEnabled())
    <h6 class="text-center">Uses <a href="https://dev.maxmind.com/geoip/geoip2/downloadable/" target="_blank">GeoIP2</a> from <a href="https://www.maxmind.com" target="_blank">MaxMind</a>.</h6>
    @endif
  @endif
@endsection

