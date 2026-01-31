@php
	$educationLevels = [
	    [
	        'abbreviation' => 'SMP',
	        'name' => 'Sekolah Menengah Pertama',
	        'classes' => 'Kelas 7, 8, dan 9',
	    ],
	    [
	        'abbreviation' => 'SMA',
	        'name' => 'Sekolah Menengah Atas',
	        'classes' => 'Kelas 10, 11, dan 12',
	    ],
	];
@endphp

<section class="py-20 bg-linear-to-br from-purple-100 via-white to-indigo-100">
	<div class="max-w-5xl mx-auto px-6 lg:px-8">

		{{-- Header Section --}}
		<div class="max-w-3xl mx-auto text-center mb-16">
			<h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">
				Jenjang Pendidikan
			</h2>
			<p class="text-lg text-slate-600 leading-relaxed">
				Kami berkomitmen memberikan pendidikan terbaik di setiap tahapan belajar.
				Temukan jenjang pendidikan yang tepat untuk pertumbuhan akademik dan karakter putra-putri Anda.
			</p>
		</div>

		{{-- Grid Section --}}
		<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
			@foreach ($educationLevels as $level)
				<div class="group bg-white p-6 rounded-2xl border border-indigo-100 cursor-default">
					<div class="flex items-center gap-5">
						<div
							class="shrink-0 w-16 h-16 rounded-xl flex items-center justify-center font-bold text-xl bg-indigo-600 text-white">
							{{ $level['abbreviation'] }}
						</div>
						<div>
							<h3 class="text-lg font-bold text-slate-900 transition-colors">
								{{ $level['name'] }}
							</h3>
							<p class="text-sm font-medium text-slate-500">
								<span class="text-indigo-500">●</span> {{ $level['classes'] }}
							</p>
						</div>
					</div>
				</div>
			@endforeach
		</div>

		{{-- Call to Action --}}
		<div class="mt-16 text-center">
			<p class="text-slate-500 mb-6 text-sm font-medium uppercase tracking-widest">Siap bergabung dengan kami?</p>
			<a href="{{ route('register') }}"
				class="inline-flex items-center px-10 py-4 text-base font-bold text-white bg-indigo-900 rounded-xl hover:bg-indigo-800 hover:-translate-y-1 transition-all shadow-xl shadow-indigo-200 group">
				Mulai Pendaftaran
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
					class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform">
					<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
				</svg>
			</a>
		</div>

	</div>
</section>
