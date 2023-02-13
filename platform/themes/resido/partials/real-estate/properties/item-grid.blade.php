@php
    $img_slider = isset($img_slider) ? $img_slider : true;
    $is_lazyload = isset($lazyload) ? $lazyload : true;
@endphp

<div class="property-listing property-2 {{ $class_extend ?? '' }}"
     data-lat="{{ $property->latitude }}"
     data-long="{{ $property->longitude }}">
    <div class="listing-img-wrapper">
        <div class="list-img-slide">
            <div class="click @if(!$img_slider) not-slider @endif">
                @foreach ($property['images'] as $image)
                    <div>
                        <a href="{{ $property->url }}">
                            @if($is_lazyload)
                            <img src="{{ get_image_loading() }}"
                                data-src="{{ RvMedia::getImageUrl($image, 'medium', false, RvMedia::getDefaultImage()) }}"
                                class="img-fluid mx-auto lazy" alt="{{ $property->name }}"/>
                            @else
                            <img src="{{ RvMedia::getImageUrl($image, 'medium', false, RvMedia::getDefaultImage()) }}"
                                class="img-fluid mx-auto" alt="{{ $property->name }}"/>
                            @endif
                        </a>
                    </div>
                    @if(!$img_slider) @break @endif
                @endforeach
            </div>
        </div>
		<div class="icon-actions-wrapper">
                @if(auth('account')->check())
                <a href="JavaScript:Void(0);" data-id="{{ $property->id }}" class="add-to-wishlist" title="<?php echo e(__('Add to Wishlist')); ?>">
                <i class="far fa-heart"></i></a>
                @else
                <a href="{{url('/login')}}" class="btnX" title="<?php echo e(__('Add to Wishlist')); ?>">
                <i class="far fa-heart"></i>
                </a>
                @endif
        </div>
    </div>

    <div class="listing-detail-wrapper">
        <div class="listing-short-detail-wrap">
            <div class="listing-short-detail">
                <div class="list-price d-flex flex-column justify-content-between">
                    <div class="list-badge d-flex justify-content-start">
                        <span class="prt-types {{ $property->type->slug }}">{{ $property->type_name }}</span>
                        
                        @if($property->is_top_property == 1)
                        <span class="prt-types {{ $property->type->slug }}" style="background: #868ee7;margin-left: 5px;">{{ __('Top Property') }}</span>
                        @endif

                        @if($property->is_featured == 1)
                        <span class="prt-types {{ $property->type->slug }}" style="background: #868ee7;margin-left: 5px;">{{ __('Featured') }}</span>
                        @endif

                        @if($property->is_urgent == 1)
                        <div class="ribbon-wrapper urgent">
                            <div class="ribbon"><div class="ribbon-text">Urgent</div></div>
                        </div>
                        @endif

                        @if($property->is_sold == 1)
                        <div class="ribbon-wrapper sold">
                            <div class="ribbon"><div class="ribbon-text">Sold</div></div>
                        </div>
                        @endif
                        <span class="prt-types category" style="position: absolute;top: -58px; left: 0;">{{ $property->category()->first()->name }}</span>
                        <!-- <span class="corner-ribbon urgent">{{ __('Urgent') }}</span>
                        <span class="corner-ribbon sold">{{ __('SOLD') }}</span> -->
                    </div>
                    
                    <h6 class="listing-card-info-price">
                        @if($property->discount_rate == '')
                            <span>{{$property->currency->symbol}}{{number_format($property->price)}} @if($property->type->slug == 'rent') / {{$property->period}} @endif</span>
                        @else
                            <del>{{$property->currency->symbol}}{{ number_format($property->price) }}</del>@if($property->type->slug == 'rent') / {{$property->period}} @endif <br>
                            <span>{{$property->currency->symbol}}{{number_format($property->discount_rate)}} @if($property->type->slug == 'rent') / {{$property->period}} @endif</span>
                        @endif
                        <!-- <del>{{$property->currency->symbol}}{{ number_format($property->price) }}</del> @if($property->type->slug == 'rent') / {{$property->period}} @endif<br>
                        <span>{{$property->currency->symbol}}{{number_format($property->discount_rate)}} @if($property->type->slug == 'rent') / {{$property->period}} @endif</span> -->
                    </h6>
                </div>
                <h4 class="listing-name">
                    <a href="{{ $property->url }}" class="prt-link-detail"
                       title="{{ $property->name }}">{!! clean($property->name) !!}</a>
                </h4>
                @if (is_review_enabled() && $property->reviews_count > 0)
                    {!! Theme::partial('real-estate.elements.property-review', compact('property')) !!}
                @endif
            </div>
        </div>
    </div>

    <div class="price-features-wrapper">
        <div class="list-fx-features">
            <div class="listing-card-info-icon">
                <div class="inc-fleat-icon">
                    <img src="{{ Theme::asset()->url('img/bed.svg') }}" width="13" alt="" title="<?php echo e(__('Bedroom')); ?>" />
                </div>
                {!! clean($property->number_bedroom) !!} {!! __('Beds') !!}
            </div>
            <div class="listing-card-info-icon">
                <div class="inc-fleat-icon">
                    <img src="{{ Theme::asset()->url('img/bathtub.svg') }}" width="13" alt="" title="<?php echo e(__('Bathroom')); ?>" />
                </div>
                {!! clean($property->number_bathroom) !!} {!! __('Bath') !!}
            </div>
            <div class="listing-card-info-icon">
                <div class="inc-fleat-icon">
                    <img src="{{ Theme::asset()->url('img/move.svg') }}" width="13" alt="" title="<?php echo e(__('Bathroom')); ?>" />
                </div>
                {{ $property->square_text }}
            </div>
        </div>
    </div>

    <div class="listing-detail-footer">
        <div class="footer-first">
            <div class="foot-location d-flex">
                <img src="{{ Theme::asset()->url('img/pin.svg') }}" width="18"
                     alt="{!! clean($property->city_name ) !!}"/>
                {!! clean($property->city_name ) !!}
            </div>
        </div>
        <div class="footer-flex">
            <a href="{{ $property->url }}" class="prt-view">{{ __('View') }}</a>
        </div>
    </div>
</div>
