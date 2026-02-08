@props(['galleries' => collect()])

<div class="relative overflow-hidden py-16 bg-linear-to-br from-purple-100 via-white to-indigo-300">
	<h1 class="text-3xl font-bold text-center mx-auto">Galeri Sekolah</h1>
	<p class="text-slate-700 text-center mt-2 max-w-lg mx-auto">
		Dokumentasi berbagai aktivitas pembelajaran, kegiatan siswa, dan momen berharga di lingkungan sekolah kami.
	</p>

	@if ($galleries->isEmpty())
		<p class="text-sm text-slate-600 text-center mt-10">
			Galeri belum tersedia.
		</p>
	@else
		<div class="flex flex-wrap items-center justify-center mt-12 gap-4 max-w-5xl mx-auto">
			@foreach ($galleries as $gallery)
				<figure class="relative group rounded-lg overflow-hidden bg-white/70 shadow-sm">
					<img
						src="{{ Storage::url($gallery->image_url) }}"
						alt="{{ $gallery->title }}"
						class="size-56 object-cover object-top transition-transform duration-300 group-hover:scale-105" />
					@if ($gallery->caption)
						<figcaption class="absolute inset-x-0 bottom-0 bg-black/60 text-white text-xs px-3 py-2">
							{{ $gallery->caption }}
						</figcaption>
					@endif
				</figure>
			@endforeach
		</div>
	@endif
</div>
