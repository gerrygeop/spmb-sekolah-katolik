<section class="relative pt-16 pb-24 lg:pt-32 lg:pb-40 overflow-hidden">
	<div
		class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,var(--tw-gradient-stops))] from-indigo-800 via-slate-500 to-slate-500">
	</div>
	<div class="absolute inset-0 -z-10 overflow-hidden">
		<svg aria-hidden="true"
			class="absolute top-0 left-[max(50%,25rem)] h-256 w-512 -translate-x-1/2 mask-[radial-gradient(64rem_64rem_at_top,white,transparent)] stroke-gray-200">
			<defs>
				<pattern id="e813992c-7d03-4cc4-a2bd-151760b470a0" width="200" height="200" x="50%" y="-1"
					patternUnits="userSpaceOnUse">
					<path d="M100 200V.5M.5 .5H200" fill="none" />
				</pattern>
			</defs>
			<svg x="50%" y="-1" class="overflow-visible fill-sky-100">
				<path d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M-300.5 600h201v201h-201Z"
					stroke-width="0" />
			</svg>
			<rect width="100%" height="100%" fill="url(#e813992c-7d03-4cc4-a2bd-151760b470a0)" stroke-width="0" />
		</svg>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
		<div
			class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm font-semibold mb-6 border border-yellow-200">
			<span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
			SPMB Online Dibuka
		</div>
		<h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 tracking-tight mb-6">
			Pendaftaran Peserta Didik Baru
		</h1>
		<p class="text-lg md:text-xl text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed">
			Isi formulir berikut dengan data yang benar dan lengkap. Pastikan semua dokumen persyaratan telah
			disiapkan untuk masa depan yang lebih cerah.
		</p>
		<div class="flex flex-col sm:flex-row gap-4 justify-center">
			<a href="{{ route('register') }}"
				class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 shadow-lg shadow-indigo-600/30 transition-all hover:scale-105">
				Daftar Sekarang
			</a>
			<a href="{{ route('status') }}"
				class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-slate-700 bg-white border border-slate-200 rounded-full hover:bg-slate-50 hover:border-slate-300 shadow-sm transition-all">
				Cek Status Pendaftaran
			</a>
		</div>
	</div>
</section>
