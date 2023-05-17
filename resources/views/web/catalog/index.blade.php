@extends('layouts.default', [
    'title' => 'Item Shop'
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
<div class="row mb-3">
<div class="col-md-2">
<h3>Item Shop</h3>
</div>
<div class="col-md-10">
<div class="row">
<div class="col-md-9">
<form id="search">
<div class="input-group">
<input class="form-control" type="text" placeholder="Search for items...">
<div class="input-group-append">
<button class="btn btn-success" type="submit">
<i class="fas fa-search"></i>
<span class="hide-sm">Search</span>
</button>
</div>
</div>
<div class="mb-2 show-sm-only"></div>
</form>
</div>
<div class="col-md-3">
<select class="form-control" id="sort">
<option value="recent" selected>Recently Updated</option>
<option value="newest">Newest First</option>
<option value="oldest">Oldest First</option>
<option value="expensive">Most Expensive</option>
<option value="inexpensive">Least Expensive</option>
</select>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-2">
<h5>Category</h5>
<div class="category-link" data-category="crates">Crates</div>
<a class="category-link collapsed" data-toggle="collapse" data-target="#ClothingLinks">
<span>Clothing</span>
<span class="indicator float-right">+</span>
</a>
<div class="collapse" id="ClothingLinks" style="padding-left:10px;">
<a class="category-link" style="margin:0;" data-category="shirts">Shirts</a>
<a class="category-link" style="margin:0;" data-category="pants">Pants</a>
</div>
<a class="category-link collapsed" data-toggle="collapse" data-target="#ItemsLinks">
<span>Items</span>
<span class="indicator float-right">+</span>
</a>
<div class="collapse" id="ItemsLinks" style="padding-left:10px;">
<a class="category-link" style="margin:0;" data-category="hats">Hats</a>
<a class="category-link" style="margin:0;" data-category="faces">Faces</a>
<a class="category-link" style="margin:0;" data-category="gadgets">Gadgets</a>
</div>
<a class="category-link collapsed" data-toggle="collapse" data-target="#Body_PartsLinks">
<span>Body Parts</span>
<span class="indicator float-right">+</span>
</a>
<div class="collapse" id="Body_PartsLinks" style="padding-left:10px;">
<a class="category-link" style="margin:0;" data-category="bundles">Bundles</a>
<!--<a class="category-link" style="margin:0;" data-category="heads">Heads</a>!-->
</div>
<div class="mb-3 show-sm-only"></div>
</div>
<div class="col-md-10">
<div class="row" id="items"></div>
</div>
</div>
@endsection