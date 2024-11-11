@props(['disabled' => false, 'rows' => 3, 'cols' => 50])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control']) !!} rows="{{ $rows }}" cols="{{ $cols }}"></textarea>
