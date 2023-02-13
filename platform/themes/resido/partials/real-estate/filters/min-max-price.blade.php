<div class="range-slider">
    <span class="rangeValues"></span>
    @php
        $maxPrice =\Botble\RealEstate\Models\Property::max('discount_rate');
        $minPrice =\Botble\RealEstate\Models\Property::min('discount_rate');
    @endphp
    
    <input value="{{intval($minPrice)}}" name="min_price" min="{{intval($minPrice)}}" max="{{intval($maxPrice)}}" type="range">
    <input value="{{intval($maxPrice)}}" name="max_price" min="{{intval($minPrice)}}" max="{{intval($maxPrice)}}" type="range">
</div>