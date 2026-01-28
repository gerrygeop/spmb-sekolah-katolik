@php
	$level = [
	    [
	        'abbreviation' => 'SD',
	        'name' => 'Sekolah Dasar',
	        'classes' => 'Kelas 1 - 6',
	    ],
	    [
	        'abbreviation' => 'SMP',
	        'name' => 'Sekolah Menengah Pertama',
	        'classes' => 'Kelas 7 - 9',
	    ],
	    [
	        'abbreviation' => 'SMA',
	        'name' => 'Sekolah Menengah Atas',
	        'classes' => 'Kelas 10 - 12',
	    ],
	];
@endphp

<section class="py-16 bg-linear-to-br from-purple-100 via-white to-indigo-200">
	<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="text-center mb-12">
			<h2 class="text-3xl font-bold text-slate-900 mb-4">Pilihan Jenjang Pendidikan</h2>
			<p class="text-slate-600">Silakan pilih jenjang pendidikan yang ingin didaftarkan.</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
			@foreach ($level as $item)
				<div class="group bg-white p-6 rounded-2xl border border-indigo-100 cursor-default">
					<div class="flex items-start gap-4">
						<div
							class="w-14 h-14 rounded-xl flex items-center justify-center font-bold text-xl bg-indigo-600 text-white transition-colors">
							{{ $item['abbreviation'] }}
						</div>
						<div>
							<h3 class="text-lg font-bold text-indigo-600">{{ $item['name'] }}</h3>
							<p class="text-sm text-slate-500">{{ $item['classes'] }}</p>
						</div>
					</div>
				</div>
			@endforeach
		</div>

		<div class="mt-12 text-center">
			<a href="{{ route('register') }}"
				class="inline-flex justify-center items-center px-8 py-3 text-sm font-bold text-white bg-indigo-900 rounded-lg hover:bg-yellow-500 hover:text-slate-900 transition-all">
				Mulai Pendaftaran
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
					class="w-4 h-4 ml-2">
					<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
				</svg>
			</a>
		</div>
	</div>
</section>
