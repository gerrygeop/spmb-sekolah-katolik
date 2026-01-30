<x-layouts.landing>
	<div class="bg-slate-50 min-h-screen py-12 px-2 sm:px-6 lg:px-8">
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
			<x-registration-status-card :registration="$registration" />

			{{-- Student & Parent Data --}}
			<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
				<x-info-card title="Data Calon Siswa" icon="👤" class="lg:col-span-2">
					<dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
						<x-info-item label="Nama Lengkap" :value="$registration->student->full_name" />
						<x-info-item label="Jenjang" :value="strtoupper($registration->school_level->value)" />
						<x-info-item label="NISN" :value="$registration->student->nisn" />
						<x-info-item label="Jenis Kelamin" :value="$registration->student->gender" />
						<x-info-item label="Tempat, Tanggal Lahir" :value="$registration->student->ttl" />
						<x-info-item label="Email" :value="$registration->student->email" />
						<x-info-item label="No. Telepon" :value="$registration->student->phone_number" />
						<x-info-item label="Asal Sekolah" :value="$registration->student->previous_school" />
						<div class="sm:col-span-2">
							<x-info-item label="Alamat" :value="$registration->student->address" />
						</div>
					</dl>
				</x-info-card>

				<x-info-card title="Data Orang Tua" icon="👨‍👩‍👧">
					<div class="space-y-4 text-sm">
						<div class="grid grid-cols-2 gap-y-3">
							<x-info-item label="Nama Ayah" :value="$registration->parent->father_name" />
							<x-info-item label="Pekerjaan Ayah" :value="$registration->parent->father_occupation" />
							<x-info-item label="No. Telepon Ayah" :value="$registration->parent->father_phone" />
						</div>
						<div class="grid grid-cols-2 gap-y-3 border-t border-slate-100 pt-4">
							<x-info-item label="Nama Ibu" :value="$registration->parent->mother_name" />
							<x-info-item label="Pekerjaan Ibu" :value="$registration->parent->mother_occupation" />
							<x-info-item label="No. Telepon Ibu" :value="$registration->parent->mother_phone" />
						</div>
					</div>
				</x-info-card>
			</div>

			{{-- Documents --}}
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
				<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
					<div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
						<h3 class="font-bold text-slate-900 flex items-center gap-2">
							📄 Dokumen Pendaftaran
						</h3>
					</div>

					<div class="p-6 space-y-3">
						@forelse ($registration->documents as $doc)
							<div class="flex items-center justify-between py-2 border-b border-slate-100 last:border-0">
								<div>
									<p class="text-sm font-medium text-slate-800">
										{{ $doc->document->name }}
									</p>

									@if ($doc->document->description)
										<p class="text-xs text-slate-500">
											{{ $doc->document->description }}
										</p>
									@endif
								</div>

								<a href="{{ Storage::url($doc->file_path) }}" target="_blank"
									class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 text-sm font-semibold">
									Lihat
									<svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7M21 12H3" />
									</svg>
								</a>
							</div>
						@empty
							<p class="text-sm text-slate-500 italic">
								Belum ada dokumen yang diunggah.
							</p>
						@endforelse
					</div>
				</div>
			</div>
		</div>
	</div>

	@push('scripts')
		<script>
			function copyToClipboard(text) {
				navigator.clipboard.writeText(text).then(() => {
					alert('Nomor rekening berhasil disalin!');
				});
			}
		</script>
	@endpush
</x-layouts.landing>
