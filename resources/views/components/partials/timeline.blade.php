@props(['timeline', 'batch'])

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

	{{-- Gradient Fade Mask --}}
	<div class="absolute inset-0 pointer-events-none bg-linear-to-b from-blue-900 via-transparent to-blue-900"></div>

	<section class="py-16 relative z-10">
		<div class="container mx-auto px-4">
			{{-- Header Section --}}
			<div class="max-w-4xl mx-auto mb-12 text-center">
				<div class="mb-4">
					<span
						class="text-sm text-blue-900 bg-yellow-400 px-4 py-1.5 rounded-full font-bold uppercase tracking-widest">Jadwal</span>
				</div>

				@if ($batch)
					<h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
						{{ $batch->name }}
					</h2>
					<p class="text-gray-300 leading-relaxed max-w-2xl mx-auto">
						Harap perhatikan setiap tahapan pendaftaran di bawah ini. Pastikan Anda melakukan registrasi dan verifikasi berkas
						tepat waktu.
					</p>
				@else
					<h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
						Penerimaan Siswa Baru
					</h2>
				@endif
			</div>

			<div class="max-w-4xl mx-auto relative px-4 py-5">
				@if ($batch && count($timeline) > 0)
					{{-- Garis Tengah --}}
					<div
						class="absolute left-8 md:left-1/2 top-0 bottom-0 w-0.5 bg-linear-to-b from-yellow-400 via-yellow-500 to-yellow-600 md:-translate-x-1/2">
					</div>

					<div class="space-y-12">
						@foreach ($timeline as $index => $item)
							<div class="relative flex items-center justify-between md:justify-normal group">
								{{-- Konten Kiri --}}
								<div class="hidden md:block w-1/2 {{ $index % 2 === 0 ? 'pr-12 text-right' : '' }}">
									@if ($index % 2 === 0)
										<div class="transition-all duration-300 group-hover:-translate-y-1">
											<span class="text-yellow-400 font-bold text-lg tracking-wider">{{ $item['date'] }}</span>
											<h3 class="text-xl font-bold text-white mt-1">{{ $item['title'] }}</h3>
										</div>
									@endif
								</div>

								{{-- Dot --}}
								<div
									class="absolute left-4.5 md:left-1/2 size-4 bg-yellow-400 border-2 border-slate-700 rounded-full -translate-x-1/2 z-10 shadow-[0_0_10px_rgba(250,204,21,0.5)]">
								</div>

								{{-- Konten Kanan --}}
								<div class="w-full md:w-1/2 pl-16 md:pl-12 {{ $index % 2 === 0 ? 'md:invisible' : '' }}">
									<div class="transition-all duration-300 group-hover:-translate-y-1">
										<span class="text-yellow-400 font-bold text-lg tracking-wider">{{ $item['date'] }}</span>
										<h3 class="text-xl font-bold text-white mt-1">{{ $item['title'] }}</h3>
										@if (isset($item['description']))
											<p class="text-slate-400 text-sm mt-2 leading-relaxed">{{ $item['description'] }}</p>
										@endif
									</div>
								</div>
							</div>
						@endforeach
					</div>
				@else
					{{-- Empty State - Tampilan Jika Tidak Ada Batch --}}
					<div
						class="flex flex-col items-center text-center py-20 bg-blue-800/20 rounded-3xl border border-white/10 backdrop-blur-sm">
						<div class="bg-yellow-400/10 p-6 rounded-full mb-6">
							<svg class="w-16 h-16 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
									d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
							</svg>
						</div>
						<h3 class="text-2xl font-bold text-white mb-3">Pendaftaran Belum Dibuka</h3>
						<p class="text-gray-300 max-w-md px-6 leading-relaxed">
							Mohon maaf, saat ini pendaftaran murid baru belum dibuka. Silakan pantau terus halaman ini atau ikuti media
							sosial kami untuk informasi pendaftaran selanjutnya.
						</p>
					</div>
				@endif
			</div>
		</div>
	</section>
</div>
