@props(['label', 'value'])

<div>
	<dt class="text-slate-500">{{ $label }}</dt>
	<dd class="font-semibold text-slate-900">{{ $value ?? '-' }}</dd>
</div>
