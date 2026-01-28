<x-layouts.landing>
	<div class="bg-slate-50 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
		<div class="max-w-7xl mx-auto space-y-6">

			{{-- Flash Messages --}}
			@if (session('success'))
				<div class="bg-green-50 border-l-4 border border-green-500 p-4 rounded-r-xl" role="alert">
					<div class="flex">
						<svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
						<div class="ml-3">
							<p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
						</div>
					</div>
				</div>
			@endif

			{{-- Header Card --}}
			<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
				<div class="bg-linear-to-r from-slate-900 to-slate-800 px-6 py-8 md:px-10 text-white">
					<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
						<div>
							<h1 class="text-2xl font-semibold">
								{{ $registration->student->full_name ?? 'Calon Siswa' }}
							</h1>
							<h5 class="text-slate-400 mt-1">
								NISN {{ $registration->student->nisn ?? '-' }}
							</h5>
						</div>
						<div class="text-left md:text-right">
							<div class="text-xs text-slate-400 uppercase tracking-wider">Kode Pendaftaran</div>
							<div class="text-2xl font-mono font-bold text-yellow-400">
								{{ $registration->registration_code }}</div>
						</div>
					</div>
				</div>

				{{-- Status Section --}}
				<div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
					<div class="flex items-center gap-3">
						<span class="text-2xl">{{ $registration->status->statusIcon() }}</span>
						<div>
							<span class="text-xs text-slate-500 uppercase tracking-wider">Status</span>
							<div
								class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $registration->status->statusColor() }} border">
								{{ $registration->status->getLabel() }}
							</div>
						</div>
					</div>
				</div>

				{{-- Payment Section --}}
				@if ($registration->status === \App\Enums\RegistrationStatus::PEMBAYARAN_TERTUNDA)
					<div class="px-6 py-6 bg-yellow-50 border-t border-yellow-500">
						<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
							<div>
								<h3 class="font-bold text-yellow-900">Tagihan Pembayaran Pendaftaran</h3>
								<p class="text-3xl font-bold text-yellow-800 mt-1">Rp
									{{ number_format($registration->total_amount, 0, ',', '.') }}</p>
								<p class="text-sm text-yellow-700 mt-2">Selesaikan pembayaran untuk melanjutkan proses
									pendaftaran.</p>
							</div>

							<button id="pay-button"
								class="w-full md:w-auto px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
								<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
								</svg>
								Bayar Sekarang
							</button>
						</div>
					</div>
				@endif

				{{-- Payment Verified - Next Steps --}}
				@if ($registration->status === \App\Enums\RegistrationStatus::PEMBAYARAN_TERVERIFIKASI)
					<div class="px-6 py-6 bg-blue-50 border-b border-blue-100">
						<h3 class="font-bold text-blue-900 mb-3">✅ Pembayaran Berhasil!</h3>
						<p class="text-sm text-blue-800 mb-4">Data Anda sedang dalam proses verifikasi oleh Admin.</p>
						<div class="bg-white rounded-xl p-4 border border-blue-200">
							<h4 class="font-semibold text-slate-900 mb-2">📅 Jadwal Tes Seleksi</h4>
							<div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
								<div><span class="text-slate-500">Tanggal:</span> <strong>20 Januari 2026</strong></div>
								<div><span class="text-slate-500">Waktu:</span> <strong>08:00 - 12:00 WIB</strong></div>
								<div><span class="text-slate-500">Lokasi:</span> <strong>Gedung Aula Utama</strong></div>
								<div><span class="text-slate-500">Bawa:</span> <strong>Kartu Identitas, Alat Tulis</strong>
								</div>
							</div>
						</div>
					</div>
				@endif

				{{-- Need Revision --}}
				@if ($registration->status->value === \App\Enums\RegistrationStatus::PERBAIKAN->value)
					<div class="px-6 py-6 bg-orange-50 border-b border-orange-100">
						<h3 class="font-bold text-orange-900 mb-2">⚠️ Perlu Perbaikan Data</h3>
						<p class="text-sm text-orange-800 mb-3">{{ $registration->notes }}</p>
						<a href="{{ route('registration.edit', ['code' => $registration->registration_code]) }}"
							class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors">
							Edit Formulir →
						</a>
					</div>
				@endif

				{{-- Approved --}}
				@if ($registration->status === \App\Enums\RegistrationStatus::DITERIMA)
					<div class="px-6 py-6 bg-green-50 border-b border-green-100">
						<h3 class="font-bold text-green-900 mb-2">🎉 Selamat! Anda Diterima</h3>
						<p class="text-sm text-green-800">Silakan datang ke sekolah untuk proses daftar ulang dengan membawa
							dokumen asli.</p>
					</div>
				@endif
			</div>

			{{-- Data Grid --}}
			<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
				{{-- Student Info --}}
				<div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
					<div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
						<h3 class="font-bold text-slate-900">👤 Data Calon Siswa</h3>
					</div>
					<div class="p-6">
						<dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
							<div>
								<dt class="text-slate-500">Nama Lengkap</dt>
								<dd class="font-semibold text-slate-900">
									{{ $registration->student->full_name ?? '-' }}</dd>
							</div>
							<div>
								<dt class="text-slate-500">Jenjang</dt>
								<dd class="font-semibold text-slate-900">{{ strtoupper($registration->school_level) }}
								</dd>
							</div>
							<div>
								<dt class="text-slate-500">NISN</dt>
								<dd class="font-semibold text-slate-900">
									{{ $registration->student->nisn ?? '-' }}</dd>
							</div>
							<div>
								<dt class="text-slate-500">Jenis Kelamin</dt>
								<dd class="font-semibold text-slate-900">
									{{ $registration->student->gender ?? '-' }}</dd>
							</div>
							<div>
								<dt class="text-slate-500">Tempat, Tanggal Lahir</dt>
								<dd class="font-semibold text-slate-900">
									{{ $registration->student->place_of_birth ?? '-' }},
									{{ $registration->student->date_of_birth ? \Carbon\Carbon::parse($registration->student->date_of_birth)->isoFormat('D MMMM Y') : '-' }}
								</dd>
							</div>
							<div>
								<dt class="text-slate-500">Email</dt>
								<dd class="font-semibold text-slate-900">
									{{ $registration->student->email ?? '-' }}</dd>
							</div>
							<div>
								<dt class="text-slate-500">No. Telepon</dt>
								<dd class="font-semibold text-slate-900">
									{{ $registration->student->phone_number ?? '-' }}</dd>
							</div>
							<div>
								<dt class="text-slate-500">Asal Sekolah</dt>
								<dd class="font-semibold text-slate-900">
									{{ $registration->student->previous_school ?? '-' }}</dd>
							</div>
							<div class="sm:col-span-2">
								<dt class="text-slate-500">Alamat</dt>
								<dd class="font-semibold text-slate-900">
									{{ $registration->student->address ?? '-' }}</dd>
							</div>
						</dl>
					</div>
				</div>

				{{-- Parent Info --}}
				<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
					<div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
						<h3 class="font-bold text-slate-900">👨‍👩‍👧 Data Orang Tua</h3>
					</div>
					<div class="p-6 space-y-4 text-sm">
						<div class="grid grid-cols-2 gap-y-3">
							<div>
								<span class="text-slate-500 mb-1">Nama Ayah</span>
								<p class=" text-slate-900 font-semibold">{{ $registration->parentProfile->father_name ?? '-' }}</p>
							</div>
							<div>
								<span class="text-slate-500 mb-1">Pekerjaan Ayah</span>
								<p class="text-slate-900 font-semibold">
									{{ $registration->parentProfile->father_occupation ?? '-' }}
								</p>
							</div>
							<div>
								<span class="text-slate-500 mb-1">No. Telepon Ayah</span>
								<p class="text-slate-900 font-semibold">
									{{ $registration->parentProfile->father_phone ?? '-' }}
								</p>
							</div>
						</div>

						<div class="grid grid-cols-2 gap-y-3">
							<div>
								<span class="text-slate-500 mb-1">Nama Ibu</span>
								<p class=" text-slate-900 font-semibold">{{ $registration->parentProfile->mother_name ?? '-' }}</p>
							</div>
							<div>
								<span class="text-slate-500 mb-1">Pekerjaan Ibu</span>
								<p class="text-slate-900 font-semibold">
									{{ $registration->parentProfile->mother_occupation ?? '-' }}
								</p>
							</div>
							<div>
								<span class="text-slate-500 mb-1">No. Telepon Ibu</span>
								<p class="text-slate-900 font-semibold">
									{{ $registration->parentProfile->mother_phone ?? '-' }}
								</p>
							</div>
						</div>
						@if ($registration->parentProfile->guardian_name)
							<div>
								<h4 class="font-semibold text-slate-700 mb-1">Wali</h4>
								<p class="text-slate-900">{{ $registration->parentProfile->guardian_name }}</p>
								<p class="text-slate-500">{{ $registration->parentProfile->guardian_occupation ?? '-' }} •
									{{ $registration->parentProfile->guardian_phone ?? '-' }}</p>
							</div>
						@endif
					</div>
				</div>
			</div>

			{{-- Documents & Payment --}}
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
				{{-- Documents --}}
				<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
					<div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
						<h3 class="font-bold text-slate-900">📄 Dokumen</h3>
					</div>
					<div class="p-6">
						@forelse($registration->documents as $doc)
							<div class="flex items-center justify-between py-2 border-b border-slate-100 last:border-0">
								<span class="text-sm text-slate-700 capitalize">{{ str_replace('_', ' ', $doc->type) }}</span>
								<a href="{{ Storage::url($doc->file_path) }}" target="_blank"
									class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Lihat →</a>
							</div>
						@empty
							<p class="text-sm text-slate-500">Belum ada dokumen yang diunggah.</p>
						@endforelse
					</div>
				</div>

				{{-- Payment Info --}}
				<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
					<div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
						<h3 class="font-bold text-slate-900">💰 Informasi Pembayaran</h3>
					</div>
					<div class="p-6 text-sm">
						@if ($registration->payment)
							<dl class="space-y-2">
								<div class="flex justify-between">
									<dt class="text-slate-500">Order ID</dt>
									<dd class="font-mono text-slate-900">{{ $registration->payment->order_id ?? '-' }}</dd>
								</div>
								<div class="flex justify-between">
									<dt class="text-slate-500">Jumlah</dt>
									<dd class="font-semibold text-slate-900">Rp
										{{ number_format($registration->payment->amount, 0, ',', '.') }}</dd>
								</div>
								<div class="flex justify-between">
									<dt class="text-slate-500">Status</dt>
									<dd
										class="font-semibold capitalize {{ $registration->payment->status === 'success' ? 'text-green-600' : 'text-yellow-600' }}">
										{{ $registration->payment->status }}</dd>
								</div>
							</dl>
						@else
							<p class="text-slate-500">Belum ada data pembayaran.</p>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	@push('scripts')
		<script
			src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
			data-client-key="{{ config('services.midtrans.client_key') }}"></script>
		<script>
			const payButton = document.getElementById('pay-button');
			if (payButton) {
				payButton.onclick = function() {
					payButton.disabled = true;
					payButton.innerHTML =
						'<svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Memproses...';

					fetch('{{ route('payment.snap-token') }}', {
							method: 'POST',
							headers: {
								'Content-Type': 'application/json',
								'X-CSRF-TOKEN': '{{ csrf_token() }}'
							},
							body: JSON.stringify({
								registration_code: '{{ $registration->registration_code }}'
							})
						})
						.then(res => res.json())
						.then(data => {
							payButton.disabled = false;
							payButton.innerHTML =
								'<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg> Bayar Sekarang';
							if (data.snap_token) {
								snap.pay(data.snap_token, {
									onSuccess: (result) => {
										updateStatus(result.transaction_status || 'settlement');
									},
									onPending: (result) => {
										updateStatus('pending');
									},
									onError: (result) => {
										showNotification('error', 'Pembayaran gagal. Silakan coba lagi.');
									},
									onClose: () => {
										console.log('Popup closed');
									}
								});
							} else {
								showNotification('error', data.error || 'Gagal mendapatkan token pembayaran.');
							}
						}).catch(err => {
							payButton.disabled = false;
							payButton.innerHTML = 'Bayar Sekarang';
							showNotification('error', 'Terjadi kesalahan sistem.');
						});
				};
			}

			function updateStatus(transactionStatus) {
				fetch('{{ route('payment.callback') }}', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json',
							'X-CSRF-TOKEN': '{{ csrf_token() }}'
						},
						body: JSON.stringify({
							registration_code: '{{ $registration->registration_code }}',
							transaction_status: transactionStatus
						})
					})
					.then(() => location.reload())
					.catch(() => location.reload());
			}

			function showNotification(type, message) {
				const div = document.createElement('div');
				div.className =
					`fixed top-4 right-4 p-4 rounded-xl shadow-lg z-50 ${type === 'error' ? 'bg-red-500' : 'bg-green-500'} text-white font-medium max-w-md`;
				div.textContent = message;
				document.body.appendChild(div);
				setTimeout(() => div.remove(), 5000);
			}
		</script>
	@endpush
</x-layouts.landing>
