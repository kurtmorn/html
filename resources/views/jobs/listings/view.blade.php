@extends('layouts.jobs', [
    'title' => "Apply for {$listing->title}"
])

@section('meta')
    <meta name="routes" data-apply="{{ route('jobs.listings.apply') }}">
@endsection

@section('js')
    <script>
        var routes = {}
        var applying = false;

        $(() => {
            const meta = 'meta[name="routes"]';
            routes.apply = $(meta).attr('data-apply');

            $('[data-toggle="apply"]').click(function() {
                applying = !applying;

                if (applying) {
                    $('#view').hide();
                    $('#apply').show();
                } else {
                    $('#view').show();
                    $('#apply').hide();
                }
            });

            $('#apply form').submit(function(event) {
                event.preventDefault();

                const uid = $(this).find('input[name="uid"]').val();
                const name = $(this).find('input[name="name"]').val();
                const email = $(this).find('input[name="email"]').val();
                const why_work = $(this).find('textarea[name="why_work"]').val();
                const why_choose = $(this).find('textarea[name="why_choose"]').val();
                const how_find = $(this).find('textarea[name="how_find"]').val();

                $.post(routes.apply, { _token, uid, name, email, why_work, why_choose, how_find }).done((data) => {
                    $('.text-danger').html('');
                    $('.alert').html('');

                    if (typeof data.errors !== 'undefined')
                        for (const [name, messages] of Object.entries(data.errors)) {
                            var string = '';

                            messages.forEach((message) => string += `<div>${message}</div>`);

                            $(`#${name}`).html(string);
                        }
                    else
                        window.location = data.url;
                }).fail(() => {
                    $('.text-danger').html('');
                    $('.alert').html('Unable to submit application.').show()
                });
            });
        });
    </script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="view">
                <h3><i class="fas fa-list mr-1" style="font-size:25px;"></i> {{ $listing->title }}</h3>
                <div class="card">
                    <div class="card-body">
                        {!! nl2br($listing->body) !!}
                    </div>
                </div>
                <div class="text-center">
                    @if (Auth::check())
                        <button class="btn btn-outline-success" data-toggle="apply" @if (Auth::user()->isStaff()) disabled @endif>Apply For This Position</button>
                    @else
                        <a href="{{ route('jobs.login.index') }}" class="btn btn-outline-success">Apply For This Position</a>
                    @endif
                </div>
            </div>
            <div id="apply" style="display:none;">
                <h3>
                    <button class="btn btn-sm btn-outline-danger mr-2" data-toggle="apply"><i class="fas fa-arrow-left mr-1"></i> Cancel</button>
                    <i class="fas fa-briefcase mr-1" style="font-size:25px;"></i>
                    <span>Apply</span>
                </h3>
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="alert bg-danger text-white" id="error" style="display:none;"></div>
                        <form>
                            <input type="hidden" name="uid" value="{{ $listing->uid }}">
                            <label for="name">Your Name</label>
                            <input class="form-control " type="text" name="name" placeholder="Your Name" required>
                            <div class="text-danger mb-2" id="name"></div>
                            <label for="email">Your Email Address</label>
                            <input class="form-control" type="email" name="email" placeholder="Your Email Address" required>
                            <div class="text-danger mb-2" id="email"></div>
                            <label for="why_work">Why do you want to work at {{ config('site.name') }}?</label>
                            <textarea class="form-control" name="why_work" placeholder="Why do you want to work at {{ config('site.name') }}?" rows="5" required></textarea>
                            <div class="text-danger mb-2" id="why_work"></div>
                            <label for="why_choose">Why should we choose you?</label>
                            <textarea class="form-control" name="why_choose" placeholder="Why should we choose you?" rows="5" required></textarea>
                            <div class="text-danger mb-2" id="why_choose"></div>
                            <label for="how_find">How did you find {{ config('site.name') }}?</label>
                            <textarea class="form-control" name="how_find" placeholder="How did you find {{ config('site.name') }}?" rows="5" required></textarea>
                            <div class="text-danger mb-3" id="how_find"></div>
                            <button class="btn btn-block btn-outline-success" type="submit">Send Application</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
