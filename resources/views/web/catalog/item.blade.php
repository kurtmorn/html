@extends('layouts.default', [
    'title' => $item->name,
    'image' => $item->thumbnail()
])

@section('meta')
    <meta
        name="item-info"
        data-id="{{ $item->id }}"

        @if ($item->has3dView())
            data-model="{{ config('site.storage_url') }}/uploads/{{ $item->filename }}.obj"
            data-texture="{{ config('site.storage_url') }}/uploads/{{ $item->filename }}.png"
        @endif

        @if ($item->isTimed())
            data-onsale-until="{{ $item->onsale_until->format('Y-m-d H:i') }}"
        @endif
    >
@endsection

@section('css')
    <style>
        img.creator {
            background: var(--headshot_bg);
            border-radius: 50%;
            width: 80%;
        }

        .reseller:not(:first-child) {
            padding-top: 15px;
        }

        .reseller:not(:last-child) {
            padding-bottom: 15px;
            border-bottom: 1px solid var(--divider_color);
        }

        img.crate-contents-image {
            background: var(--section_bg_inside);
            border: 2px solid;
            border-radius: 50%;
            width: 75px;
        }

        .crate-item {
            background: var(--section_bg);
            width: 100px;
            height: 100px;
            margin: 0 25px;
            position: relative;
            display: inline-block;
        }

        @media only screen and (max-width: 768px) {
            .crate-item:first-child {
                margin-right: -52%;
            }
        }
    </style>
@endsection

@section('js')
    @if ($item->has3dView())
        <script src="{{ asset('js/vendor/three.min.js') }}"></script>
        <script src="{{ asset('js/vendor/three.orbitcontrols.min.js') }}"></script>
        <script src="{{ asset('js/vendor/three.obj_loader.min.js') }}"></script>
        <script src="{{ asset('js/3d_view.js') }}"></script>
    @endif

    @if ($item->isTimed())
        <script src="{{ asset('js/vendor/jquery.countdown.min.js') }}"></script>
        <script src="{{ asset('js/vendor/moment.min.js') }}"></script>
        <script src="{{ asset('js/vendor/moment.timezone.min.js') }}"></script>
        <script src="{{ asset('js/timed_item.js') }}"></script>
    @endif

    @if ($item->type == 'crate')
        <script src="{{ asset('js/vendor/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('js/crate.js?v=2') }}"></script>
    @endif
@endsection

@section('content')
    @if (!$item->public_view)
        <div class="alert bg-warning"><i class="fas fa-exclamation-triangle"></i> This item is not public.</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    @if (Auth::check() && Auth::user()->ownsItem($item->id))
                        <div class="bg-success text-white text-center" id="ownershipCheck" style="border-radius:50%;width:30px;height:30px;position:absolute;cursor:pointer;margin-left:5px;margin-top:5px;" title="You own this item" data-toggle="tooltip">
                            <i class="fas fa-check" style="font-size:18px;margin-top:7px;"></i>
                        </div>
                    @endif

                    <img class="thumbnail" id="thumbnail" style="background:var(--section_bg_inside);border-radius:6px;padding:{{ itemTypePadding($item->type) }};" src="{{ $item->thumbnail() }}">

                    @if ($item->has3dView())
                        <div class="show-sm-only" style="margin-top:-15px;"></div>
                        <button class="btn btn-primary" id="3dButton" style="margin-top:-75px;margin-left:5px;">Toggle 3D</button>
                        <div id="canvas" style="display:none;width:100%;height:100%;background:var(--section_bg_inside);border-radius:6px;"></div>
                    @endif

                    @if (Auth::check() && ($item->creator_type == 'group' || ($item->creator_type == 'user' && $item->creator->id != Auth::user()->id && !$item->creator->isStaff())))
                        <div class="text-center mt-2 hide-sm">
                            <a href="{{ route('report.index', ['item', $item->id]) }}" class="text-danger">
                                <i class="fas fa-flag"></i>
                                <span>Report</span>
                            </a>
                        </div>
                    @endif

                    @if ($item->type == 'crate')
                        <button class="btn btn-block btn-sm btn-success mt-3" data-toggle="modal" data-target="#crate">View Contents</button>

                        @if (Auth::check() && Auth::user()->ownsItem($item->id))
                            <button class="btn btn-block btn-sm btn-primary mt-3" id="openCrateButton" @if ($copiesOwned == 0) style="display:none;" @endif>Open a Crate</button>
                            <div class="text-danger text-center" id="copiesOwned" @if ($copiesOwned == 0) style="display:none;" @endif>{{ $copiesOwned }} owned</div>
                        @endif
                    @endif
                </div>
                <div class="col-md-6">
                    <h4 style="font-weight:600;">{{ $item->name }}</h4>
                    <div class="text-truncate show-sm-only" style="margin-top:-5px;margin-bottom:5px;">
                        <span>Created by</span>
                        <a href="{{ $item->creatorUrl() }}">{{ $item->creatorName() }}</a>
                        @if ($item->creator_type == 'user' && $item->creator->is_verified)
                            <i class="fas fa-shield-check text-success ml-1" style="font-size:13px;" title="This user is verified." data-toggle="tooltip"></i>
                        @endif
                    </div>
                    <div style="max-height:175px;overflow-y:auto;">
                        @if ($item->type != 'crate')
                            {!! (!empty($item->description)) ? nl2br(e($item->description)) : '<div class="text-muted">This item does not have a description.</div>' !!}
                        @else
                            @if (!empty($item->description))
                                {!! nl2br(e($item->description)) !!}
                                <br>
                                <br>
                            @endif

                            This crate contains {{ count($item->crateItems()) }} items that each consist of different rarities. Opening this crate will give you a guaranteed item from the crate.

                            @if ($item->isTimed())
                                This crate will go off sale on {{ $item->onsale_until->format('F jS') }} at {{ $item->onsale_until->format('g:i A') }} so be sure to get it while you can!
                            @endif
                        @endif
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <a href="{{ $item->creatorUrl() }}" class="hide-sm">
                        <img class="creator" src="{{ $item->creatorImage() }}">
                        <div class="text-truncate mt-1">
                            <span>{{ $item->creatorName() }}</span>
                            @if ($item->creator_type == 'user' && $item->creator->is_verified)
                                <i class="fas fa-shield-check text-success ml-1" style="font-size:13px;" title="This user is verified." data-toggle="tooltip"></i>
                            @endif
                        </div>
                    </a>

                    @if ($item->isTimed())
                        <div class="text-danger mt-2" id="timer"></div>
                    @endif

                    @if ($item->limited)
                        <div class="text-danger mt-2">{{ ($item->stock > 0) ? "{$item->stock} LEFT" : 'SOLD OUT' }}</div>
                    @endif

                    @auth
                        @if (site_setting('catalog_purchases_enabled') && $item->status == 'approved' && $item->onsale())
                            @if (!Auth::user()->ownsItem($item->id) || $item->type == 'crate')
                                <button class="btn btn-block btn-sm btn-success mt-3" data-toggle="modal" data-target="#purchaseConfirmation">{!! ($item->price == 0) ? 'Take for Free' : 'Buy for &nbsp;<i class="currency text-white"></i> ' . number_format($item->price) !!}</button>
                            @else
                                <button class="btn btn-block btn-sm btn-success mt-3" disabled>{!! ($item->price == 0) ? 'Take for Free' : 'Buy for &nbsp;<i class="currency text-white"></i> ' . number_format($item->price) !!}</button>
                            @endif
                        @endif

                        @if (Auth::user()->canEditItem($item->id))
                            <a href="{{ route('catalog.edit', [$item->id, $item->slug()]) }}" class="btn btn-block btn-sm btn-primary mt-3"><i class="fas fa-edit"></i> Edit</a>
                        @endif

                        @if (Auth::user()->isStaff() && Auth::user()->staff('can_view_item_info'))
                            <a href="{{ route('admin.items.view', $item->id) }}" class="btn btn-block btn-sm btn-danger mt-3" target="_blank"><i class="fas fa-gavel"></i> View in Panel</a>
                        @endif

                        @if (Auth::user()->isStaff() && Auth::user()->staff('can_edit_item_info') && !in_array($item->type, ['tshirt', 'shirt', 'pants']))
                            <a href="{{ route('admin.edit_item.index', $item->id) }}" class="btn btn-block btn-sm btn-danger mt-3" target="_blank"><i class="fas fa-gavel"></i> Edit in Panel</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="row text-center">
                <div class="col-6 col-md">
                    <h5>{{ $item->created_at->format('M d, Y') }}</h5>
                    <h6 class="text-muted" style="margin-top:-10px;">TIME CREATED</h6>
                </div>
                <div class="col-6 col-md">
                    <h5>{{ $item->updated_at->format('M d, Y') }}</h5>
                    <h6 class="text-muted" style="margin-top:-10px;">LAST UPDATED</h6>
                </div>
                <div class="col-6 col-md">
                    <h5>{{ ($item->type != 'crate') ? number_format($item->owners()->count()) : number_format($item->sold()->count()) }}</h5>
                    <h6 class="text-muted" style="margin-top:-10px;">{{ ($item->type != 'crate') ? 'OWNERS' : 'SOLD' }}</h6>
                </div>
                <div class="col-6 col-md">
                    <h5>{{ itemType($item->type) }}</h5>
                    <h6 class="text-muted" style="margin-top:-10px;">TYPE</h6>
                </div>
            </div>
            @if (Auth::check() && ($item->creator_type == 'group' || ($item->creator_type == 'user' && $item->creator->id != Auth::user()->id && !$item->creator->isStaff())))
                <div class="text-center mt-2 mt-2 show-sm-only">
                    <a href="{{ route('report.index', ['item', $item->id]) }}" class="text-danger">
                        <i class="fas fa-flag"></i>
                        <span>Report</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
    @if ($item->type == 'bundle')
        <h3>Items in this Bundle</h3>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @forelse ($item->bundleItems() as $bundleItem)
                        <div class="col-6 col-md-2 text-center">
                            <div class="card mb-sm-only" style="border:none;">
                                <div class="card-body" style="padding:0;">
                                    <a href="{{ route('catalog.item', [$bundleItem->id, $bundleItem->slug()]) }}" style="color:inherit;font-weight:600;">
                                        <img style="background:var(--section_bg_inside);border-radius:6px;padding:{{ itemTypePadding($bundleItem->type) }};" src="{{ $bundleItem->thumbnail() }}">
                                        <div class="text-truncate mt-1">{{ $bundleItem->name }}</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col">No items found.</div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
    <h3>Suggested Items</h3>
    <div class="card">
        <div class="card-body">
            <div class="row">
                @forelse ($suggestions as $suggestion)
                    <div class="col-6 col-md-2">
                        <div class="card mb-sm-only" style="border:none;">
                            <div class="card-body" style="padding:0;">
                                <a href="{{ route('catalog.item', [$suggestion->id, $suggestion->slug()]) }}" style="color:inherit;font-weight:600;">
                                    @if ($suggestion->limited)
                                        <div class="bg-primary text-white text-center" style="border-radius:50%;width:30px;height:30px;position:absolute;margin-left:5px;margin-top:5px;">
                                            <span style="font-size:20px;font-weight:600;margin-top:7px;">C</span>
                                        </div>
                                    @endif
                                    <img style="background:var(--section_bg_inside);border-radius:6px;padding:{{ itemTypePadding($suggestion->type) }};" src="{{ $suggestion->thumbnail() }}">
                                    <div class="text-truncate mt-1">{{ $suggestion->name }}</div>
                                </a>

                                @if ($suggestion->onsale() && $suggestion->price == 0)
                                    <span class="text-success">Free</span>
                                @elseif (!$suggestion->onsale())
                                    <span class="text-muted">Off Sale</span>
                                @else
                                    <span><i class="currency"></i> {{ number_format($suggestion->price) }}</span>
                                @endif

                                @if ($suggestion->limited)
                                    <div class="float-right text-danger">{{ ($suggestion->stock > 0) ? "{$suggestion->stock} LEFT" : 'SOLD OUT' }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col">No items found.</div>
                @endforelse
            </div>
        </div>
    </div>
    @if ($item->limited && $item->stock <= 0)
        <div class="row">
            <div class="col">
                <h3>Resellers</h3>
            </div>
            @if (Auth::check() && Auth::user()->ownsItem($item->id) && !empty(Auth::user()->resellableCopiesOfItem($item->id)))
                <div class="col text-right">
                    <button class="btn btn-success" data-toggle="modal" data-target="#resell">Sell</button>
                </div>
            @endif
        </div>
        <div class="card">
            <div class="card-body">
                @forelse ($item->resellers() as $listing)
                    <div class="row reseller">
                        <div class="col-5 col-md-2 text-center">
                            <a href="{{ route('users.profile', $listing->seller->username) }}">
                                <img class="creator" src="{{ $listing->seller->headshot() }}">
                            </a>
                        </div>
                        <div class="col-7 col-md-10 align-self-center">
                            <p class="text-truncate">
                                <a href="{{ route('users.profile', $listing->seller->username) }}" style="font-size:23px;">{{ $listing->seller->username }}</a>
                                @if ($listing->seller->is_verified)
                                    <i class="fas fa-shield-check text-success ml-1" style="font-size:16px;" title="This user is verified." data-toggle="tooltip"></i>
                                @endif
                            </p>

                            @if (!Auth::check() || Auth::user()->id != $listing->seller->id)
                                <button class="btn btn-success" data-toggle="modal" data-target="#resellPurchaseConfirmation_{{ $listing->id }}" @if (!Auth::check()) disabled @endif>Buy for <i class="currency"></i> {{ number_format($listing->price) }}</button>
                            @else
                                <form action="{{ route('catalog.take_off_sale') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $listing->id }}">
                                    <button class="btn btn-danger" type="submit">Selling for <i class="currency"></i> {{ number_format($listing->price) }}</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p>No one is currently reselling this item.</p>
                @endforelse
            </div>
        </div>
        {{ $item->resellers()->onEachSide(1) }}
    @endif

    @if (Auth::check())
        @if ($item->onsale() && $item->status == 'approved' && (!Auth::user()->ownsItem($item->id) || $item->type == 'crate'))
            <div class="modal fade" id="purchaseConfirmation" tabindex="-1" role="dialog">
                <form action="{{ route('catalog.purchase') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Purchase Item</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure that you want to {{ ($item->price == 0) ? 'take' : 'purchase' }} this {{ strtolower(itemType($item->type)) }} for {!! ($item->price == 0) ? '<span class="text-primary">Free</span>' : '<i class="currency"></i> ' . number_format($item->price) !!}?</p>
                                @if ($item->type == 'crate')
                                    <label for="amount">Amount</label>
                                    <input class="form-control" type="number" name="amount" placeholder="Amount" min="1">
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" type="submit">Yes</button>
                                <button class="btn btn-danger" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        @if ($item->limited && $item->stock <= 0)
            @if (Auth::user()->ownsItem($item->id) && !empty(Auth::user()->resellableCopiesOfItem($item->id)))
                <div class="modal fade" id="resell" tabindex="-1" role="dialog">
                    <form action="{{ route('catalog.resell') }}" method="POST">
                        @csrf
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Sell Item</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>Please select the copy you wish to sell.</p>
                                    <select class="form-control mb-2" name="id">
                                        @foreach (Auth::user()->resellableCopiesOfItem($item->id) as $copy)
                                            <option value="{{ $copy->id }}">Copy #{{ $copy->number }}</option>
                                        @endforeach
                                    </select>
                                    <input class="form-control" type="number" name="price" placeholder="Price" min="1" max="1000000">
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success" type="submit">Sell</button>
                                    <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif

            @foreach ($item->resellers() as $listing)
                <div class="modal fade" id="resellPurchaseConfirmation_{{ $listing->id }}" tabindex="-1" role="dialog">
                    <form action="{{ route('catalog.purchase') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <input type="hidden" name="reseller_id" value="{{ $listing->id }}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Purchase Item</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure that you want to purchase this {{ strtolower(itemType($item->type)) }} for <i class="currency"></i> {{ number_format($listing->price) }}?</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success" type="submit">Yes</button>
                                    <button class="btn btn-danger" data-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        @endif
    @endif

    @if ($item->type == 'crate')
        <div class="modal fade" id="crate" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Contents</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        @forelse ($item->crateItems() as $crateItem)
                            <div class="row mb-4">
                                <div class="col-auto text-center">
                                    <img class="crate-contents-image" style="border-color:{{ crateRarity('color', $crateItem['rarity']) }};" src="{{ $crateItem['thumbnail'] }}">
                                </div>
                                <div class="col-7 align-self-center">
                                    <h5 class="text-truncate mb-0" style="font-weight:600;">{{ $crateItem['name'] }}</h5>
                                    <div><strong>{{ crateRarity('name', $crateItem['rarity']) }}</strong></div>
                                    <div>{{ number_format($crateItem['owner_count']) }} {{ ($crateItem['owner_count'] == 1) ? 'Owner' : 'Owners' }}</div>
                                </div>
                                <div class="col-2 align-self-center pl-0 text-right">
                                    <a href="{{ route('catalog.item', [$crateItem['id'], $crateItem['slug']]) }}" class="btn btn-sm btn-success" target="_blank">View</a>
                                </div>
                            </div>
                        @empty
                            <p>This crate is empty.</p>
                        @endforelse
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="prize" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Prize</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <img style="background:var(--section_bg_inside);border-radius:6px;width:50%;" id="prizeImage">
                        <h3 style="font-weight:600;">Congratulations!</h3>
                        <h5>You won <strong id="prizeName"></strong>!</h5>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('account.character.index') }}" class="btn btn-success">Customize Character</a>
                        <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="unbox" tabindex="-1" role="dialog">
            <div class="modal-dialog" style="max-width:800px;" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div style="background:var(--section_bg_inside);padding:15px 0;border-radius:6px;white-space:nowrap;overflow:hidden;">
                            <div class="mb-3" id="unboxItems"></div>
                            <div class="section-div"><i class="fas fa-arrow-up"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
