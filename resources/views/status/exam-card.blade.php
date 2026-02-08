<x-layouts.print :title="'Kartu Ujian - ' . $registration->registration_code">
	<div class="min-h-screen py-10 px-4">
		<div class="max-w-3xl mx-auto space-y-4">
			<div class="no-print flex items-center justify-end gap-3">
				<a href="{{ route('status.show', ['code' => $registration->registration_code]) }}"
					class="px-4 py-2 text-xs font-black uppercase tracking-widest rounded-xl border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
					Kembali
				</a>
				<button onclick="window.print()"
					class="px-5 py-2 text-xs font-black uppercase tracking-widest rounded-xl bg-slate-900 text-white hover:bg-slate-800 transition-colors shadow">
					Cetak
				</button>
			</div>

			<div class="bg-white border border-slate-800 overflow-hidden shadow-sm">
				<div class="border-b px-6 py-6 text-slate-900">
					<div class="flex flex-col items-center gap-4">
						<div class="text-center">
							<p class="text-xs uppercase tracking-[0.25em] text-slate-800">Kartu Ujian Seleksi</p>
							<h1 class="text-xl font-black tracking-tight mt-1">
								{{ $registration->batch->name ?? 'Penerimaan Peserta Didik Baru' }}
							</h1>
							<p class="text-sm text-slate-800 mt-1">
								Jenjang: {{ $registration->school_level?->getLabel() ?? '-' }}
							</p>
						</div>
					</div>
				</div>

				<div class="p-6 space-y-6">
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
							<p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Nomor Pendaftaran</p>
							<p class="text-base font-bold text-slate-900">
								{{ $registration->registration_code }}
							</p>
						</div>
						<div>
							<p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Nama Peserta</p>
							<p class="text-base font-bold text-slate-900">
								{{ $registration->student->full_name ?? '-' }}
							</p>
						</div>
						<div>
							<p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">NISN</p>
							<p class="text-base font-bold text-slate-900">
								{{ $registration->student->nisn ?? '-' }}
							</p>
						</div>
						<div>
							<p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Asal Sekolah</p>
							<p class="text-base font-bold text-slate-900">
								{{ $registration->student->previous_school ?? '-' }}
							</p>
						</div>
						<div>
							<p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">No. Telepon</p>
							<p class="text-base font-bold text-slate-900">
								{{ $registration->student->phone_number ?? '-' }}
							</p>
						</div>
					</div>

					<div class="border-t border-slate-800 pt-5">
						<h2 class="text-sm font-black text-slate-900 uppercase tracking-widest my-3">Jadwal Tes Seleksi</h2>

						@if ($schedule)
							<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
								<div>
									<p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Tanggal</p>
									<p class="text-base font-bold text-slate-900">
										{{ \Carbon\Carbon::parse($schedule->scheduled_at)->translatedFormat('d F Y') }}
									</p>
								</div>
								<div>
									<p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Waktu</p>
									<p class="text-base font-bold text-slate-900">{{ $schedule->waktu }}</p>
								</div>
								<div>
									<p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Lokasi</p>
									<p class="text-base font-bold text-slate-900">{{ $schedule->location }}</p>
								</div>
								<div>
									<p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Wajib Dibawa</p>
									<p class="text-base font-bold text-slate-900">
										{{ $schedule->requirements ?? '-' }}
									</p>
								</div>
							</div>
						@else
							<div class="bg-slate-50 rounded-xl p-4 border border-dashed border-slate-300">
								<p class="text-sm text-slate-600">
									Jadwal seleksi belum tersedia. Silakan cek kembali di halaman status pendaftaran.
								</p>
							</div>
						@endif
					</div>

					<div class="pt-5">
						<ul class="text-xs text-slate-700 space-y-1">
							<li>Hadir 15 menit sebelum tes dimulai.</li>
							<li>Bawa kartu ujian ini dan identitas diri yang sah.</li>
							<li>Gunakan pakaian rapi dan sopan sesuai ketentuan sekolah.</li>
						</ul>
					</div>

					<div class="flex items-center justify-between border-t border-slate-200 pt-4">
						<div class="text-[10px] text-slate-600 uppercase tracking-widest">
							Dicetak: {{ now()->translatedFormat('d F Y H:i') }} WIB
						</div>
						<div class="text-[10px] text-slate-600 uppercase tracking-widest">
							Status: {{ $registration->status->getLabel() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-layouts.print>
