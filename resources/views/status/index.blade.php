<x-layouts.landing>
	<div class="bg-slate-50 min-h-[calc(100vh-80px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
		<div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl border border-slate-100">
			<div class="text-center">
				<div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 mb-4">
					<svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
						xmlns="http://www.w3.org/2000/svg">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
					</svg>
				</div>
				<h2 class="text-3xl font-extrabold text-slate-900">Cek Status Pendaftaran</h2>
				<p class="mt-2 text-sm text-slate-600">
					Masukkan kode pendaftaran yang Anda dapatkan saat mendaftar.
				</p>
			</div>

			<form class="mt-8 space-y-6" action="{{ route('status.check') }}" method="POST">
				@csrf
				<div class="rounded-md shadow-sm -space-y-px">
					<div>
						<label for="registration_code" class="sr-only">Kode Pendaftaran</label>
						<input id="registration_code" name="registration_code" type="text" required
							class="appearance-none rounded-lg relative block w-full px-4 py-3 border border-slate-300 placeholder-slate-500 text-slate-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
							placeholder="Contoh: REG-2024-XXXX">
					</div>
				</div>
				@error('registration_code')
					<div class="text-red-500 text-sm mt-2 flex items-center gap-2">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
							<path fill-rule="evenodd"
								d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
								clip-rule="evenodd" />
						</svg>
						{{ $message }}
					</div>
				@enderror

				<div>
					<button type="submit"
						class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-full text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg shadow-indigo-600/30 hover:scale-[1.02] transition-all">
						<span class="absolute left-0 inset-y-0 flex items-center pl-3">
							<svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg"
								viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
								<path fill-rule="evenodd"
									d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
									clip-rule="evenodd" />
							</svg>
						</span>
						Cek Status Sekarang
					</button>
				</div>
			</form>

			<div class="text-center mt-4">
				<a href="{{ url('/') }}"
					class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center justify-center gap-2">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
					</svg>
					Kembali ke Beranda
				</a>
			</div>
		</div>
	</div>
</x-layouts.landing>
