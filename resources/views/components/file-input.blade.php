@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['type' => 'file', 'id'=>'input-file', 'class' => 'd-none']) !!}>
