@props(['label', 'value'])

<div class="flex flex-col sm:flex-row sm:justify-between py-3.5 gap-1 transition-colors">
	<dt class="text-[13px] font-medium text-slate-500">{{ $label }}</dt>
	<dd class="text-sm text-slate-900 font-semibold sm:text-right uppercase">{{ $value ?? '-' }}</dd>
</div>
