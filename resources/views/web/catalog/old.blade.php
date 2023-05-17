@extends('layouts.default', [
    'title' => 'Market'
])

@section('meta')
    <meta name="item-types-with-padding" content="{{ json_encode(config('site.item_thumbnails_with_padding')) }}">
    <meta name="item-type-padding-amount" content="{{ itemTypePadding('default') }}">
@endsection

@section('css')
<style>
        .category-link {
            color: inherit;
            opacity: .8;
            font-weight: 500;
            margin: 5px 0;
            cursor: pointer;
            width: 100%;
            display: block;
        }

        .category-link[data-toggle='collapse'] {
            color: inherit!important;
        }

        .category-link.active {
            color: var(--link_color);
            opacity: 1;
        }

        .category-link:hover {
            color: var(--link_color_hover);
            opacity: 1;
        }
    </style>
@endsection

@section('js')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/catalog.js?v=8') }}"></script>
    <script>
        const swiper = new Swiper('.swiper-container', {
            direction: 'horizontal',
            slidesPerView: 2,
            loop: false,
            pagination: { el: '.swiper-pagination' },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            breakpoints: { 640: { slidesPerView: 5 } }
        });
    </script>
@endsection

@section('content')
    <div class="row mb-2">
        <div class="col-auto">
            <h3>Market</h3>
        </div>
        @if (Auth::check())
            <div class="col text-right">
                <a href="{{ route('creator_area.index') }}" class="btn btn-success"><i class="fas fa-plus"></i> Create</a>
            </div>
        @endif
    </div>
    <div class="card text-center">
        <div class="card-body">
            <ul class="nav nav-pills nav-justified flex-column flex-sm-row" role="tablist">
                @foreach (config('site.catalog_item_types') as $type)
                    <li class="nav-item">
                        <span class="nav-link flex-sm-fill @if ($type == 'home') active @endif" data-category="{{ lcfirst(itemType($type, true)) }}">{{ itemType($type, true) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div id="homeTab">
        @forelse ($categories as $category)
            <div class="mb-5">
                <h3>{{ $category->title }}</h3>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @forelse ($category->items as $item)
                            <div class="swiper-slide" style="font-weight:600;padding: 0 15px;">
                                <div class="card mb-0">
                                    <div class="card-body" style="padding:10px;">
                                        <a href="{{ route('catalog.item', [$item->id, $item->slug()]) }}">
                                            @if ($item->limited)
                                                <div class="bg-primary text-white text-center" style="border-radius:50%;width:30px;height:30px;position:absolute;margin-left:5px;margin-top:5px;">
                                                    <span style="font-size:20px;font-weight:600;margin-top:7px;">C</span>
                                                </div>
                                            @elseif ($item->isTimed())
                                                <div class="bg-danger text-white text-center" style="border-radius:50%;width:30px;height:30px;position:absolute;margin-left:5px;margin-top:5px;">
                                                    <span style="font-size:17px;font-weight:600;"><i class="fas fa-clock" style="margin-top:6.5px;"></i></span>
                                                </div>
                                            @endif
                                            <img class="mb-1" style="background:var(--section_bg_inside);border-radius:6px;padding:{{ itemTypePadding($item->type) }};" src="{{ $item->thumbnail() }}">
                                        </a>
                                        <div class="hide-sm" style="width:37px;height:37px;margin-top:4px;float:left;position:relative;overflow:hidden;margin-right:10px;">
                                            <a href="{{ route('catalog.item', [$item->id, $item->slug()]) }}">
                                                <img style="background:var(--headshot_bg);border-radius:50%;" src="{{ $item->creatorImage() }}">
                                            </a>
                                        </div>
                                        <div class="text-truncate">
                                            <a href="{{ route('catalog.item', [$item->id, $item->slug()]) }}" style="color:inherit;">{{ $item->name }}</a>
                                            <div class="text-muted" style="margin-top:-5px;">By: <a href="{{ $item->creatorUrl() }}">{{ $item->creatorName() }}</a></div>
                                        </div>
                                        <div class="text-center">
                                            @if ($item->onsale() && $item->price == 0)
                                                <span class="text-success">Free</span>
                                            @elseif (!$item->onsale())
                                                <span class="text-muted">Off Sale</span>
                                            @else
                                                <span><i class="currency"></i> {{ number_format($item->price) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <style>#swiper_prev_{{ $category->id }}, #swiper_next_{{ $category->id }} { display: none; }</style>
                            <p>No items found.</p>
                        @endforelse
                    </div>
                    <div class="swiper-button-prev" id="swiper_prev_{{ $category->id }}" style="color:inherit;"></div>
                    <div class="swiper-button-next" id="swiper_next_{{ $category->id }}" style="color:inherit;"></div>
                </div>
            </div>
        @empty
            <p>There are currently no categories.</p>
        @endforelse
    </div>
    <div id="itemsTab" style="display:none;">
        <form id="search">
            <div class="input-group mb-3">
                <input class="form-control" type="text" placeholder="Search for items...">
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit">
                        <i class="fas fa-search"></i>
                        <span class="hide-sm">Search</span>
                    </button>
                </div>
            </div>
        </form>
        <div class="row" id="items"></div>
    </div>
@endsection
