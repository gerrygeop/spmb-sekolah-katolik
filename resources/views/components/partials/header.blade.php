<nav class="bg-white/70 border-b border-gray-100 fixed top-0 w-full z-50 shadow backdrop-blur-lg">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex justify-between h-20 items-center">
			<a href="/" class="flex items-center gap-3">
				<div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
						class="w-6 h-6">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
					</svg>
				</div>
				<div>
					<span class="text-xl font-bold text-slate-900 block leading-none">SPMB Sekolah</span>
					<span class="text-xs text-slate-500 font-medium">Penerimaan Peserta Didik Baru</span>
				</div>
			</a>
			<div class="hidden md:flex space-x-8 items-center">
				<a href="{{ url('/') }}"
					class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Beranda</a>
				<a href="/#jadwal" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Jadwal</a>
			</div>
			<div class="hidden md:flex md:items-center md:gap-3">
				<a href="{{ route('status') }}"
					class="hidden md:inline-flex px-5 py-2.5 text-sm font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-full transition-colors">
					Cek Status
				</a>
				<a href="{{ route('register') }}"
					class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-full shadow-lg shadow-indigo-600/20 transition-all hover:scale-105">
					Daftar
				</a>
			</div>
		</div>
	</div>
</nav>
