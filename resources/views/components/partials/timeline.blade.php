@php
	$timeline = [
	    [
	        'date' => '1 Januari - 28 Februari 2026',
	        'title' => 'Pendaftaran Online',
	    ],
	    [
	        'date' => '1 Maret - 10 Maret 2026',
	        'title' => 'Verifikasi Berkas',
	    ],
	    [
	        'date' => '20 Maret - 25 Maret 2026',
	        'title' => 'Tes Masuk',
	    ],
	    [
	        'date' => '1 April 2026',
	        'title' => 'Pengumuman Hasil',
	    ],
	    [
	        'date' => '2 April - 15 April 2026',
	        'title' => 'Daftar Ulang',
	    ],
	];
@endphp

<div id="jadwal" class="relative bg-blue-900 py-16">
	{{-- Pattern Layer --}}
	<div class="absolute inset-0 opacity-30 text-slate-900 pointer-events-none">
		<svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
			<defs>
				<pattern id="dot-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
					<circle cx="2" cy="2" r="2" fill="currentColor" />
				</pattern>
			</defs>
			<rect width="100%" height="100%" fill="url(#dot-pattern)" />
		</svg>
	</div>

	{{-- Gradient Fade Mask (Top & Bottom) --}}
	<div
		class="absolute inset-0 pointer-events-none
               bg-linear-to-b
               from-blue-900
               via-transparent
               to-blue-900">
	</div>

	<section class="py-16">
		<div class="container mx-auto px-4">
			<div class="max-w-4xl mx-auto mb-6 text-center relative">
				<div class="mb-4">
					<span class="text-sm text-gray-900 bg-yellow-400 px-4 py-1.5 rounded-3xl">Jadwal</span>
				</div>
				<h2 class="text-3xl font-bold text-white mb-8 text-center">
					Jadwal Penting SMPB
				</h2>
				<p class="text-gray-100 leading-relaxed">
					Ikuti jadwal penting pendaftaran agar tidak ketinggalan
				</p>
			</div>

			<div class="max-w-152 mx-auto relative">
				<div class="absolute left-8 md:left-1/2 top-0 bottom-0 w-0.5 bg-yellow-500 md:-translate-x-1/2"></div>

				@foreach ($timeline as $index => $item)
					<div class="relative flex items-center mb-8 {{ $index % 2 === 0 ? 'md:flex-row-reverse' : 'md:flex-row' }}">
						<div class="w-full md:w-72 pl-20 md:pl-0 {{ $index % 2 === 0 ? 'md:pl-2' : 'md:pr-2 md:text-right' }}">
							<div class="rounded-xl p-6">
								<p class="inline-block bg-golden text-lg text-yellow-400 py-1 rounded-full font-semibold">
									{{ $item['date'] }}
								</p>
								<h3 class="text-2xl font-bold text-white">
									{{ $item['title'] }}
								</h3>
							</div>
						</div>

						<div
							class="absolute left-8 md:left-1/2 w-4 h-4 bg-yellow-400 border-4 border-golden rounded-full -translate-x-1/2">
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>
</div>
