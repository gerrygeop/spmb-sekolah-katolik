@props(['registration'])

@php
	$statusEnum = \App\Enums\RegistrationStatus::class;
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
	<div class="bg-linear-to-r from-slate-900 to-slate-800 px-6 py-8 md:px-10 text-white">
		<div class="flex flex-col md:flex-row justify-between items-start gap-6 relative z-10">
			<div>
				<h1 class="text-xl md:text-2xl font-semibold leading-tight">
					{{ $registration->student->full_name ?? 'Calon Siswa' }}
				</h1>
				<h5 class="text-slate-400 text-sm md:text-base mt-1">
					NISN <span class="font-mono text-slate-300">{{ $registration->student->nisn ?? '-' }}</span>
				</h5>
			</div>

			<div class="w-full md:w-auto flex flex-col md:items-end gap-4">
				@php
					$steps = $registration->batch->timeline ?? [];
					$currentStatus = $registration->status;
					$currentStepIndex = 0;

					if ($currentStatus === $statusEnum::PEMBAYARAN_TERTUNDA) {
					    $currentStepIndex = 0;
					} elseif ($currentStatus === $statusEnum::VERIFIKASI || $currentStatus === $statusEnum::PERBAIKAN) {
					    $currentStepIndex = 1;
					} elseif ($currentStatus === $statusEnum::TERVERIFIKASI) {
					    $currentStepIndex = 2;
					} elseif ($currentStatus === $statusEnum::TIDAK_LULUS) {
					    $currentStepIndex = 3;
					} elseif ($currentStatus === $statusEnum::LULUS || $currentStatus === $statusEnum::CADANGAN) {
					    $currentStepIndex = 4;
					}
				@endphp

				<div class="flex flex-col gap-4 relative">
					{{-- Registration Code --}}
					<div class="flex flex-col md:items-end">
						<div class="text-xs text-slate-400 uppercase tracking-wider mb-1">Kode Pendaftaran</div>
						<div class="text-2xl md:text-2xl text-yellow-400 font-mono font-bold flex items-center gap-3">
							<span>{{ $registration->registration_code }}</span>
							<button onclick="copyToClipboard('{{ $registration->registration_code }}')" title="Salin"
								class="transition-colors text-yellow-500 cursor-pointer active:bg-indigo-700 hover:text-yellow-400 p-1 hover:bg-slate-600 rounded-lg">
								<svg xmlns="http://www.w3.org/2000/svg" class="size-5 md:size-6" fill="none" viewBox="0 0 24 24"
									stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
								</svg>
							</button>
						</div>

						<p class="text-sm text-slate-400 mt-2 italic">
							*Simpan Kode Pendaftaran ini untuk pengecekan status selanjutnya.
						</p>
					</div>
				</div>

				<div id="copy-toast"
					class="absolute top-0 right-8 bg-yellow-500/80 text-slate-800 px-6 py-3 rounded-xl shadow-2xl translate-y-20 opacity-0 transform transition-all duration-300 z-50 flex items-center gap-2">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24"
						stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
					</svg>
					<span class="text-sm font-medium">Nomor pendaftaran berhasil disalin</span>
				</div>
			</div>
		</div>

		{{-- Timeline Stepper --}}
		@if (count($steps) > 0)
			<div class="mt-12 mb-4 relative z-10">
				<div class="text-xs text-slate-400 mb-2">Update terakhir:
					{{ $registration->updated_at->translatedFormat('d F Y H:i') }} WIB
				</div>

				{{-- Mobile Scroll Wrapper --}}
				<div class="overflow-x-auto pt-2 pb-8 -mx-6 px-6 md:overflow-visible md:pb-0 md:mx-0 md:px-0 scrollbar-hide">
					<div class="relative flex justify-between min-w-150 md:min-w-0 md:w-full">
						{{-- Connecting Line Background --}}
						<div class="absolute top-3.75 left-0 w-full h-1 bg-slate-700/50 rounded-full -z-10"></div>

						{{-- Connecting Line Progress --}}
						@php
							$lineProgress = 0;
							if (count($steps) > 1) {
							    $lineProgress = ($currentStepIndex / (count($steps) - 1)) * 100;
							}
						@endphp
						<div class="absolute top-3.75 left-0 h-1 bg-yellow-400 rounded-full -z-10 transition-all duration-1000 ease-out"
							style="width: {{ $lineProgress }}%"></div>

						@foreach ($steps as $index => $step)
							@php
								$isActive = $index === $currentStepIndex;
								$isCompleted = $index < $currentStepIndex;
								$isFuture = $index > $currentStepIndex;
							@endphp
							<div class="flex flex-col items-center group cursor-default w-32 relative">
								{{-- Step Circle --}}
								<div
									class="w-8 h-8 rounded-full flex items-center justify-center border-2 z-10 transition-all duration-300 {{ $isCompleted ? 'bg-yellow-400 border-yellow-400 text-slate-900' : '' }} {{ $isActive ? 'bg-slate-800 border-yellow-400 text-yellow-400 scale-110' : '' }} {{ $isFuture ? 'bg-slate-800 border-slate-600 text-slate-500' : '' }} ">
									@if ($isCompleted)
										<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
											<path fill-rule="evenodd"
												d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
												clip-rule="evenodd" />
										</svg>
									@else
										<span class="text-xs font-bold">{{ $index + 1 }}</span>
									@endif
								</div>

								{{-- Step Title --}}
								<div
									class="mt-3 text-center transition-colors duration-300 {{ $isActive || $isCompleted ? 'text-white' : 'text-slate-500' }}">
									<p class="text-[10px] uppercase font-bold tracking-wider mb-0.5">{{ $step['title'] }}</p>

									{{-- Date --}}
									@if (isset($step['start_date']))
										<p class="text-[9px] font-medium opacity-70">
											{{ \Carbon\Carbon::parse($step['start_date'])->translatedFormat('d F Y') }}
										</p>
									@endif
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		@endif

	</div>

	{{-- Status Section --}}
	<div class="px-6 py-4 bg-slate-50/50">
		<div class="flex items-center gap-3">
			<span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</span>
			<div
				class="inline-flex items-center px-3 py-1 rounded-full text-sm uppercase font-semibold {{ $registration->status->statusColor() }} border">
				{{ $registration->status->getLabel() }}
			</div>
		</div>
	</div>

	{{-- Pembayaran Tertunda --}}
	@if ($registration->status === $statusEnum::PEMBAYARAN_TERTUNDA)
		<div class="bg-amber-50 rounded-t-3xl border-t border-amber-200 overflow-hidden shadow-sm">
			<div class="p-8 md:p-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
				<div class="space-y-4 max-w-lg">
					<div>
						<h3 class="text-amber-900 font-black text-xl flex items-center gap-2 uppercase tracking-tight">
							Tagihan Pendaftaran
						</h3>
						<p class="text-amber-700/80 text-sm leading-relaxed mt-1">
							Mohon selesaikan pembayaran untuk melanjutkan ke tahap verifikasi berkas.
						</p>
					</div>
					<div class="flex flex-col">
						<span class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-1">
							Total Biaya
						</span>
						<span class="text-4xl font-black text-amber-800 tracking-tighter leading-none">
							Rp {{ number_format($registration->total_amount, 0, ',', '.') }}
						</span>
					</div>
				</div>

				<div class="space-y-4 w-full md:w-auto border-t md:border-t-0 md:border-l border-amber-200 pt-6 md:pt-0 md:pl-10">
					<div class="flex items-center gap-4">
						<span class="text-xs font-black text-amber-900 uppercase">Bank BNI</span>
					</div>
					<div>
						<p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-1">Nomor Rekening</p>
						<div class="flex items-center gap-3">
							<span class="text-2xl font-mono font-black text-amber-900">123123123</span>
							<button onclick="copyToClipboard('123123123')" title="Salin"
								class="p-2 hover:bg-amber-200 rounded-lg transition-colors text-amber-700 active:scale-90">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
									stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
								</svg>
							</button>
						</div>
						<p class="text-xs font-bold text-amber-800/70 mt-1 uppercase">A/n Yayasan Pendidikan Katolik</p>
					</div>
				</div>
			</div>

			{{-- Upload bukti pembayaran --}}
			<div class="bg-white px-8 pb-6 pt-8 border-t border-slate-200">
				<form action="{{ route('payments.upload', $registration->id) }}" method="POST" enctype="multipart/form-data"
					class="flex flex-col md:flex-row items-center gap-4">
					@csrf
					<div class="grow w-full">
						<label class="block text-xs font-black text-slate-700 uppercase tracking-widest mb-2">
							Unggah Bukti Transfer
						</label>
						<input type="file" name="proof_file" required
							class="block w-full text-xs text-slate-900 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-black file:bg-slate-600 file:text-white hover:file:bg-slate-700 transition-all cursor-pointer bg-white/50 rounded-xl border border-slate-300 p-2">

						<span class="text-xs capitalize font-normal">
							(Format file yang diterima: <strong>PDF, JPG, JPEG, PNG</strong>.
							Maksimal <strong>2MB</strong>)
						</span>

						@error('proof_file')
							<p class="text-sm text-red-500 mt-2">
								{{ $message }}
							</p>
						@enderror
					</div>
					<button type="submit"
						class="w-full md:w-auto px-10 py-3 bg-slate-800 text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-slate-900 shadow-lg shadow-slate-900/20 transition-all active:scale-95">
						Konfirmasi
					</button>
				</form>
			</div>
		</div>
	@endif

	{{-- Sedang Diverifikasi --}}
	@if ($registration->status === $statusEnum::VERIFIKASI)
		<div class="bg-blue-50 border-t border-blue-200 rounded-t-3xl overflow-hidden shadow-sm animate-fade-in">
			<div class="p-8 md:p-10">
				<div class="flex flex-col md:flex-row items-center gap-8">
					<div class="relative shrink-0">
						<div class="bg-blue-600 text-white p-5 rounded-2xl shadow-xl shadow-blue-200 relative z-10">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
								stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-10">
								<path
									d="M16 22h2a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v2.85" />
								<path d="M14 2v5a1 1 0 0 0 1 1h5" />
								<path d="M8 14v2.2l1.6 1" />
								<circle cx="8" cy="16" r="6" />
							</svg>
						</div>
					</div>

					<div class="grow space-y-3 text-center md:text-left">
						<div class="flex flex-col md:flex-row md:items-center gap-3">
							<h3 class="text-xl md:text-2xl font-black text-blue-900 uppercase tracking-tight">
								Sedang Diverifikasi
							</h3>
						</div>
						<p class="text-sm font-bold text-blue-800/80 leading-relaxed max-w-2xl">
							Kami sedang memverifikasi dokumen dan bukti pembayaran Anda.
							Proses ini biasanya memakan waktu 1-2 hari kerja. Mohon cek halaman ini secara berkala.
						</p>
					</div>

					{{-- Badge Status --}}
					<div class="w-full md:w-auto flex flex-col items-center gap-2">
						<div class="px-6 py-4 bg-white/60 rounded-2xl border border-blue-100 flex items-center gap-3 shadow-sm">
							<div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
							<span class="text-xs font-black text-blue-900 uppercase tracking-widest">Dalam peninjauan</span>
						</div>
						<p class="text-[10px] font-bold text-blue-400 italic">Terima kasih atas kesabaran Anda.</p>
					</div>
				</div>
			</div>
		</div>
	@endif

	{{-- Terverifikasi --}}
	@if ($registration->status === $statusEnum::TERVERIFIKASI)
		<div class="bg-indigo-50 border-t border-indigo-100 rounded-t-3xl overflow-hidden shadow-sm animate-fade-in">
			<div class="p-8">
				<div class="flex items-center gap-4 mb-6">
					<div class="bg-emerald-500 text-white p-2 rounded-full shadow-lg shadow-emerald-200">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
						</svg>
					</div>
					<div>
						<h3 class="text-xl font-black text-indigo-950 tracking-tight leading-none">Data Terverifikasi</h3>
						<p class="text-sm text-indigo-700/80 mt-1 font-medium">
							Selamat! Berkas Anda telah terverifikasi. Anda berhak mengikuti Tes Seleksi sesuai jadwal
							berikut:
						</p>
					</div>
				</div>

				@if ($registration->selection_schedule)
					@php $schedule = $registration->selection_schedule; @endphp
					<div class="bg-white rounded-2xl p-6 border border-indigo-200 shadow-sm relative overflow-hidden">
						<h4 class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
							<span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
							Jadwal Tes Seleksi
						</h4>

						<div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8 relative z-10">
							{{-- Tanggal --}}
							<div class="flex items-start gap-3">
								<div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
									</svg>
								</div>
								<div>
									<p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</p>
									<p class="font-black text-slate-800">
										{{ \Carbon\Carbon::parse($schedule->scheduled_at)->translatedFormat('d F Y') }}
									</p>
								</div>
							</div>

							{{-- Waktu --}}
							<div class="flex items-start gap-3">
								<div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
								</div>
								<div>
									<p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Waktu</p>
									<p class="font-black text-slate-800">
										{{ $schedule->waktu }}
									</p>
								</div>
							</div>

							{{-- Lokasi --}}
							<div class="flex items-start gap-3">
								<div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
									</svg>
								</div>
								<div>
									<p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Lokasi</p>
									<p class="font-black text-slate-800 uppercase tracking-tight">
										{{ $schedule->location }}
									</p>
								</div>
							</div>

							<div class="flex items-start gap-3">
								<div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
									</svg>
								</div>
								<div>
									<p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Wajib Bawa</p>
									<p class="font-black text-slate-800">
										{{ $schedule->requirements }}
									</p>
								</div>
							</div>
						</div>
					</div>

					<div class="mt-6 flex items-center justify-between">
						<p class="text-[11px] text-indigo-500 font-bold italic">*Harap datang 15 menit sebelum tes dimulai.</p>
					</div>
				@else
					<div
						class="bg-slate-50 rounded-2xl p-8 border border-dashed border-slate-300 flex flex-col items-center text-center">
						<div class="p-3 bg-white rounded-full shadow-sm mb-4">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24"
								stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
							</svg>
						</div>
						<h4 class="text-slate-800 font-bold text-base">Jadwal Belum Tersedia</h4>
						<p class="text-slate-500 text-sm max-w-lg mt-1">
							Jadwal seleksi Anda akan segera diinformasikan. Harap cek kembali halaman ini secara berkala.
						</p>
					</div>
				@endif

			</div>
		</div>
	@endif

	{{-- Perlu Perbaikan --}}
	@if ($registration->status === $statusEnum::PERBAIKAN)
		<div class="bg-red-50 border-t border-red-200 rounded-t-3xl overflow-hidden shadow-sm animate-pulse-subtle">
			<div class="p-8 flex flex-col md:flex-row items-start md:items-center gap-6">
				<div class="bg-red-100 text-red-600 p-4 rounded-2xl shadow-inner">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
						stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
					</svg>
				</div>

				<div class="grow space-y-2">
					<h3 class="text-lg font-black text-red-900 uppercase tracking-tight">Perlu Perbaikan Data</h3>
					<div class="bg-white/60 rounded-xl p-4 border border-red-100">
						<p class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-1">Catatan Verifikator:
						</p>
						<p class="font-semibold text-red-800 leading-relaxed">
							"{{ $registration->notes ?? 'Terdapat data yang belum lengkap atau tidak sesuai. Silakan perbaiki segera.' }}"
						</p>
					</div>
				</div>

				<div class="w-full md:w-auto">
					<a href="{{ route('registration.edit', ['code' => $registration->registration_code]) }}"
						class="group flex items-center justify-center gap-3 px-8 py-4 bg-red-600 hover:bg-red-700 text-white font-black text-xs uppercase tracking-[0.15em] rounded-2xl transition-all shadow-lg shadow-red-600/20 active:scale-95">
						Perbarui Data
						<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform"
							fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7M21 12H3" />
						</svg>
					</a>
				</div>
			</div>
		</div>
	@endif

	{{-- Lulus --}}
	@if ($registration->status === $statusEnum::LULUS)
		<div
			class="bg-emerald-50 border-t border-emerald-200 rounded-t-3xl overflow-hidden shadow-sm relative animate-fade-in">
			<div class="p-8 md:p-10 text-center md:text-left flex flex-col md:flex-row items-center gap-8">
				<div class="relative">
					<div
						class="w-20 h-20 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-emerald-200 transform -rotate-3">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
								d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
						</svg>
					</div>
					<div class="absolute -top-2 -right-2 text-2xl animate-bounce">🎉</div>
				</div>

				<div class="grow space-y-3">
					<h3 class="text-2xl md:text-3xl font-black text-emerald-900 tracking-tighter uppercase">
						Selamat, Anda Lulus!
					</h3>
					<p class="text-sm text-emerald-800/80 leading-relaxed max-w-xl">
						Selamat bergabung! Anda dinyatakan <span class="font-bold">DITERIMA</span> di
						{{ $registration->school_level->getLabel() }} Sekolah Katolik.
						Silakan selesaikan proses Daftar Ulang untuk meresmikan status siswa Anda.
					</p>
				</div>

				<div
					class="relative shrink-0 w-full md:w-auto border-t md:border-t-0 md:border-l border-emerald-200 pt-6 md:pt-0 md:pl-10">
					<button
						class="w-full md:w-auto px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-lg shadow-emerald-600/20 transition-all active:scale-95 flex items-center justify-center gap-3">
						Daftar Ulang
					</button>
				</div>
			</div>
		</div>
	@endif

	{{-- Tidak Lulus --}}
	@if ($registration->status === $statusEnum::TIDAK_LULUS)
		<div class="bg-red-50 border-t border-red-200 rounded-t-3xl overflow-hidden shadow-sm animate-fade-in">
			<div class="p-8 md:p-10 text-center md:text-left">
				<div class="flex flex-col md:flex-row items-center gap-8">
					<div class="bg-red-200 text-red-500 p-5 rounded-2xl shrink-0 shadow-inner">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</div>

					<div class="grow space-y-3">
						<h3 class="text-xl md:text-2xl font-black text-slate-800 uppercase tracking-tight">
							Informasi Hasil Seleksi
						</h3>
						<p class="text-sm font-bold text-slate-600 leading-relaxed max-w-2xl">
							Terima kasih telah mengikuti seluruh rangkaian seleksi.
							Mohon maaf, berdasarkan hasil tes dan kuota yang tersedia, saat ini Anda
							<span class="text-slate-900 underline decoration-slate-300 decoration-2 underline-offset-4">belum
								dapat diterima</span>.
						</p>
						<p class="text-sm font-black text-slate-500 uppercase tracking-widest">
							Jangan berkecil hati. Tetap semangat dan sukses untuk pendidikan Anda selanjutnya.
						</p>
					</div>
				</div>
			</div>
		</div>
	@endif

	{{-- Cadangan --}}
	@if ($registration->status === $statusEnum::CADANGAN)
		<div class="bg-amber-50 border-t border-amber-200 rounded-t-3xl overflow-hidden shadow-sm animate-fade-in">
			<div class="p-8 md:p-10">
				<div class="flex flex-col md:flex-row items-start md:items-center gap-6">
					<div class="bg-amber-100 text-amber-600 p-4 rounded-2xl shadow-inner shrink-0">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</div>

					<div class="grow space-y-2">
						<h3 class="text-xl font-black text-amber-900 uppercase tracking-tight flex items-center gap-3">
							Anda Masuk Daftar Cadangan
						</h3>
						<p class="text-sm font-bold text-amber-800/80 leading-relaxed max-w-2xl">
							Hasil seleksi Anda memenuhi kriteria namun kuota saat ini telah penuh.
							Kami akan segera menghubungi Anda apabila terdapat kursi yang tersedia.
						</p>
					</div>
				</div>

				<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-amber-200/50 pt-6">
					<div class="flex items-center gap-3">
						<div class="w-1.5 h-1.5 bg-amber-400 rounded-full"></div>
						<p class="text-[11px] font-bold text-amber-700 uppercase tracking-wider">
							Update Terakhir: {{ now()->format('d M Y') }}
						</p>
					</div>
					<div class="flex items-center gap-3">
						<div class="w-1.5 h-1.5 bg-amber-400 rounded-full"></div>
						<p class="text-[11px] font-bold text-amber-700 uppercase tracking-wider">
							Periode Tunggu: 7 Hari Kerja
						</p>
					</div>
				</div>
			</div>
		</div>
	@endif
</div>
