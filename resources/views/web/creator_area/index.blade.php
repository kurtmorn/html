@extends('layouts.default', [
    'title' => $title
])

@section('js')
    @if (!$isGroup)
        <script src="{{ asset('js/creator_area.js') }}"></script>
    @endif
@endsection

@section('content')
    @if (!$isGroup)
        <div class="alert bg-warning">There currently is a small issue with UV mapping on the side of arms. Do not worry as this will be fixed in the future and all your shirts will be re-rendered.</div>
    @else
        @if (Auth::user()->reachedGroupLimit())
            <div class="alert bg-danger text-white">You have reached the limit of groups you can be apart of.</div>
        @endif
    @endif
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3>{{ $title }}</h3>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('creator_area.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if ($isGroup)
                            <input type="hidden" name="is_group" value="true">
                            <label for="name">Name</label>
                            <input class="form-control mb-2" type="text" name="name" placeholder="Space Name" required>
                            <label for="description">Description</label>
                            <textarea class="form-control mb-2" name="description" placeholder="Space Description" rows="5"></textarea>
                            <label for="template">Logo</label><br>
                            <input class="mb-3" name="template" type="file">
                        @else
                            @if ($groupId)
                                <input type="hidden" name="group_id" value="{{ $groupId }}">
                            @endif

                            <label for="name">Name</label>
                            <input class="form-control mb-2" type="text" name="name" placeholder="Item Name" required>
                            <label for="description">Description</label>
                            <textarea class="form-control mb-2" name="description" placeholder="Item Description" rows="5"></textarea>
                            <label for="type">Type</label>
                            <select class="form-control mb-2" name="type">
                                <option value="shirt">Shirt</option>
                                <option value="pants">Pants</option>
                            </select>
                            <label for="price">Price</label>
                            <input class="form-control mb-2" type="number" name="price" placeholder="Item Price" min="0" max="1000000">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="onsale">
                                <label class="form-check-label" for="onsale">For Sale</label>
                            </div>
                            <label for="template">Template (<a href="{{ asset('img/template.png') }}" target="_blank">Download</a>)</label><br>
                            <input class="mb-3" name="template" type="file">
                        @endif

                        <button class="btn btn-block btn-success" type="submit">{!! (!$isGroup) ? 'Create' : "Create for <i class=\"currency\"></i> {$price}" !!}</button>
                    </form>
                </div>
            </div>
        </div>
        @if (!$isGroup && config('site.renderer.previews_enabled'))
            <div class="col-md-6">
                <h3>Preview</h3>
                <div class="card text-center">
                    <div class="card-body">
                        <img id="preview" src="{{ config('site.storage_url') }}/{{ config('site.renderer.default_filename') }}.png">
                        <div class="text-danger mt-2" id="error" style="display:none;"></div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
