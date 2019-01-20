@component('mail::message')
# Wedding Fair Promotion 2019
## Survey Response
@foreach($form as $key => $value)
@if( $key === 'interest' )
@foreach( $value as $interest_key => $interest_value )
**Interested In {{ title_case($interest_key) }}** : {{ $interest_value ? 'Yes' : 'No' }}


@endforeach
@else
**{{ title_case($key) }}** : {{ $value ?? 'N/A' }}


@endif
@endforeach
@endcomponent
