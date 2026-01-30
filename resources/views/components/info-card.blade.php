@props(['title', 'icon', 'class' => ''])

<div class="{{ $class }} bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
	<div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
		<h3 class="font-bold text-slate-900">{{ $icon }} {{ $title }}</h3>
	</div>
	<div class="p-6">
		{{ $slot }}
	</div>
</div>
