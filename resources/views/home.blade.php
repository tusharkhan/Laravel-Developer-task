@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-5 mb-5">
                <div class="card">
                    <div class="card-header">{{ __('Make your URL short') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('url_short') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Your URL</label>
                                <input type="text" class="form-control" name="original_url" id="exampleInputEmail1"
                                       placeholder="https://example.com">

                                @error('original_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-7 col-lg-7">
                <table class="table table-bordered">
                    <thead class="thead-light ">
                        <tr>
                            <th scope="col">Original URL</th>
                            <th scope="col">Short URL</th>
                            <th scope="col">Total Click</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($urls as $url)
                            <tr>
                                <td>
                                    <a href="{{ $url->original_url }}" target="_blank">{{ $url->original_url }}</a>
                                </td>
                                <td>
                                    <a onclick="count('{{ $url->url_code }}')" href="{{ $url->short_url  }}" target="_blank">{{ $url->short_url  }}</a>
                                </td>
                                <td id="{{ $url->url_code }}">{{ $url->click_count }} time(s)</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $urls->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>
@endsection

@push('scropts')
<script>
    function count(id){
        let count = document.getElementById(id);
        let text = count.innerText;
        let number = parseInt(text.match(/\d+/)[0], 10);
        
        count.innerText = (++number) + " time(s)";
    }
</script>
@endpush