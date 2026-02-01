<div class="bg-indigo-50/50 min-h-screen py-12 px-0 sm:px-6 lg:px-8">
	<div class="max-w-4xl mx-auto">


		@if ($batch)
			<div class="text-center mb-10">
				<h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Formulir Pendaftaran Online</h1>
				<p class="text-slate-500 text-lg">Lengkapi data diri Anda untuk bergabung dengan kami.</p>
			</div>

			<div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
				{{-- Stepper --}}
				<div class="hidden sm:block bg-slate-50/50 border-b border-slate-100 px-6 py-6 sm:px-10">
					<nav aria-label="Progress">
						<ol role="list" class="flex items-center justify-between w-full max-w-2xl mx-auto">
							@foreach (range(1, $totalSteps) as $step)
								<li class="relative flex flex-col items-start group {{ $step < $totalSteps ? 'flex-1' : '' }}">
									<div class="flex items-center w-full">
										<div class="relative flex flex-col items-center justify-center sm:gap-y-2">
											<div
												class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all duration-300 {{ $step <= $currentStep ? 'bg-indigo-600 border-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'bg-white border-slate-300 text-slate-400 group-hover:border-indigo-400' }}">
												@if ($step < $currentStep)
													<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
														<path fill-rule="evenodd"
															d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
															clip-rule="evenodd" />
													</svg>
												@else
													{{ $step }}
												@endif
											</div>

											<span
												class="text-xs font-medium hidden sm:block {{ $step <= $currentStep ? 'text-indigo-700' : 'text-slate-400' }}">
												@if ($step == 1)
													Jenjang
												@elseif($step == 2)
													Siswa
												@elseif($step == 3)
													Orang Tua
												@elseif($step == 4)
													Berkas
												@elseif($step == 5)
													Konfirmasi
												@endif
											</span>
										</div>

										@if ($step < $totalSteps)
											<div class="flex-1 h-1 mx-4 rounded-full {{ $step < $currentStep ? 'bg-indigo-600' : 'bg-slate-200' }}">
											</div>
										@endif
									</div>

								</li>
							@endforeach
						</ol>
					</nav>
				</div>

				<form wire:submit.prevent="submit" class="p-6 sm:p-10">
					{{-- Step 1: School Level --}}
					@if ($currentStep == 1)
						<div class="animate-fade-in-up">
							<h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
								<span
									class="bg-indigo-100 text-indigo-700 w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold">1</span>
								Pilih Jenjang Sekolah
							</h2>

							<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
								@foreach (['smp', 'sma'] as $level)
									<label class="relative group cursor-pointer">
										<input type="radio" name="school_level" value="{{ $level }}" wire:model.live="school_level"
											class="peer sr-only">
										<div
											class="p-6 rounded-2xl border-2 transition-all duration-200 hover:shadow-md {{ $school_level == $level
											    ? 'border-indigo-600 bg-indigo-50/50 ring-1 ring-indigo-600 shadow-indigo-100'
											    : 'border-slate-200 bg-white hover:border-indigo-300' }}">

											<div class="flex items-start gap-4">
												<div
													class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-lg transition-colors {{ $school_level == $level
													    ? 'bg-indigo-600 text-white'
													    : 'bg-slate-100 text-slate-500 group-hover:bg-indigo-600 group-hover:text-white' }}">
													{{ strtoupper($level) }}
												</div>
												<div class="flex-1">
													<div
														class="font-bold text-md {{ $school_level == $level ? 'text-indigo-700' : 'text-slate-900 group-hover:text-indigo-700' }}">
														@if ($level == 'smp')
															Sekolah Menengah Pertama
														@elseif($level == 'sma')
															Sekolah Menengah Atas
														@endif
													</div>

													<p class="text-sm text-slate-500">
														@if ($level == 'smp')
															Kelas 7 - 9
														@elseif($level == 'sma')
															Kelas 10 - 12
														@endif
													</p>
												</div>
												@if ($school_level == $level)
													<div class="text-indigo-600">
														<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
															<path fill-rule="evenodd"
																d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
																clip-rule="evenodd" />
														</svg>
													</div>
												@endif
											</div>

										</div>
									</label>
								@endforeach
							</div>
						</div>

						@error('school_level')
							<p class="mt-4 text-center text-sm font-semibold text-red-600 bg-red-50 py-2 rounded-lg border border-red-200">
								{{ $message }}
							</p>
						@enderror
					@endif

					{{-- Step 2: Student Data --}}
					@if ($currentStep == 2)
						<div class="animate-fade-in-up space-y-6">
							<h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
								<span
									class="bg-indigo-100 text-indigo-700 w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold">2</span>
								Data Pribadi Calon Siswa
							</h2>

							<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
								<div class="col-span-full md:col-span-2">
									<label for="full_name" class="block text-sm font-semibold text-slate-700 mb-2">
										Nama Lengkap
									</label>
									<input type="text" wire:model="full_name" id="full_name"
										class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900"
										placeholder="Sesuai Akta Kelahiran">
									@error('full_name')
										<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
									@enderror
								</div>

								<div>
									<label for="nisn" class="block text-sm font-semibold text-slate-700 mb-2">
										NISN
									</label>
									<input type="text" wire:model="nisn" id="nisn"
										class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900"
										placeholder="Nomor Induk Siswa Nasional">
									@error('nisn')
										<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
									@enderror
								</div>

								<div>
									<label for="gender" class="block text-sm font-semibold text-slate-700 mb-2">Jenis
										Kelamin</label>
									<select id="gender" wire:model="gender"
										class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900">
										<option value="">Pilih Jenis Kelamin</option>
										<option value="Laki-laki">Laki-laki</option>
										<option value="Perempuan">Perempuan</option>
									</select>
									@error('gender')
										<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
									@enderror
								</div>

								<div>
									<label for="place_of_birth" class="block text-sm font-semibold text-slate-700 mb-2">
										Tempat Lahir
									</label>
									<input type="text" wire:model="place_of_birth" id="place_of_birth"
										class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900"
										placeholder="Kota Kelahiran">
									@error('place_of_birth')
										<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
									@enderror
								</div>

								<div>
									<label for="date_of_birth" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal
										Lahir</label>
									<input type="date" wire:model="date_of_birth" id="date_of_birth"
										class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900">
									@error('date_of_birth')
										<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
									@enderror
								</div>

								<div>
									<label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email
										Siswa</label>
									<input type="email" wire:model="email" id="email"
										class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900"
										placeholder="nama@email.com">
									@error('email')
										<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
									@enderror
								</div>

								<div>
									<label for="phone_number" class="block text-sm font-semibold text-slate-700 mb-2">No. HP /
										WhatsApp</label>
									<input type="text" wire:model="phone_number" id="phone_number"
										class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900"
										placeholder="08xxxxxxxxxx">
									@error('phone_number')
										<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
									@enderror
								</div>

								<div class="col-span-full">
									<label for="previous_school" class="block text-sm font-semibold text-slate-700 mb-2">Asal
										Sekolah</label>
									<input type="text" wire:model="previous_school" id="previous_school"
										class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900"
										placeholder="Nama Sekolah Sebelumnya">
									@error('previous_school')
										<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
									@enderror
								</div>

								<div class="col-span-full">
									<label for="address" class="block text-sm font-semibold text-slate-700 mb-2">Alamat
										Lengkap</label>
									<textarea id="address" wire:model="address" rows="3"
									 class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900"
									 placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota"></textarea>
									@error('address')
										<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
									@enderror
								</div>
							</div>
						</div>
					@endif

					{{-- Step 3: Parent Data --}}
					@if ($currentStep == 3)
						<div class="animate-fade-in-up space-y-8">
							<h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
								<span
									class="bg-indigo-100 text-indigo-700 w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold">3</span>
								Data Orang Tua / Wali
							</h2>

							{{-- Father --}}
							<div>
								<h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
									Data Ayah
								</h3>
								<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
									<div>
										<label class="block text-sm font-medium text-slate-700 mb-1">Nama Ayah</label>
										<input type="text" wire:model="father_name"
											class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900"
											placeholder="Sesuai Akta Kelahiran">
										@error('father_name')
											<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
										@enderror
									</div>
									<div>
										<label class="block text-sm font-medium text-slate-700 mb-1">No. HP Ayah</label>
										<input type="text" wire:model="father_phone"
											class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900"
											placeholder="08xxxxxxxxxx">
										@error('father_phone')
											<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
										@enderror
									</div>
									<div class="col-span-full">
										<label class="block text-sm font-medium text-slate-700 mb-1">Pekerjaan Ayah</label>
										<input type="text" wire:model="father_occupation"
											class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900"
											placeholder="Pekerjaan Sekarang">
										@error('father_occupation')
											<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
										@enderror
									</div>
								</div>
							</div>

							<div class="border-t border-gray-200"></div>

							{{-- Mother --}}
							<div>
								<h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
									Data Ibu
								</h3>
								<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
									<div>
										<label class="block text-sm font-medium text-slate-700 mb-1">Nama Ibu</label>
										<input type="text" wire:model="mother_name"
											class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900"
											placeholder="Sesuai Akta Kelahiran">
										@error('mother_name')
											<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
										@enderror
									</div>
									<div>
										<label class="block text-sm font-medium text-slate-700 mb-1">No. HP Ibu</label>
										<input type="text" wire:model="mother_phone"
											class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900"
											placeholder="08xxxxxxxxxx">
										@error('mother_phone')
											<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
										@enderror
									</div>
									<div class="col-span-full">
										<label class="block text-sm font-medium text-slate-700 mb-1">Pekerjaan Ibu</label>
										<input type="text" wire:model="mother_occupation"
											class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900"
											placeholder="Pekerjaan Sekarang">
										@error('mother_occupation')
											<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
										@enderror
									</div>
								</div>
							</div>
						</div>
					@endif

					{{-- Step 4: Documents --}}
					@if ($currentStep == 4)
						<div class="space-y-6">
							<h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
								<span
									class="bg-indigo-100 text-indigo-700 w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold">4</span>
								Upload Dokumen
							</h2>

							<div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
								<div class="flex">
									<div class="shrink-0">
										<svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
											<path fill-rule="evenodd"
												d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
												clip-rule="evenodd" />
										</svg>
									</div>
									<div class="ml-3">
										<p class="text-sm text-blue-700">
											Format file yang diterima: <strong>PDF, JPG, JPEG, PNG</strong>. Maksimal
											<strong>2MB</strong> per file.
										</p>
									</div>
								</div>
							</div>

							<div class="space-y-6">
								@foreach ($documents as $document)
									<div class="bg-white border border-slate-200 rounded-xl p-5 hover:border-indigo-300 transition-colors">
										<label class="flex items-center justify-between mb-2">
											<span class="block text-base font-semibold text-slate-900">
												{{ $document->name }}
											</span>

											@if ($document->is_required)
												<span class="text-xs text-red-500 font-medium">*Wajib</span>
											@endif
										</label>

										<input type="file" wire:model="uploadedDocuments.{{ $document->id }}" wire.loading.attr="disabled"
											class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />

										{{-- Preview file lama --}}
										@if (isset($existingDocuments[$document->id]) &&
												$existingDocuments[$document->id] &&
												empty($uploadedDocuments[$document->id]))
											<div class="mt-3 flex items-center gap-3 text-sm">
												<span class="text-green-600 font-medium flex items-center gap-1">
													✓ Dokumen sudah diupload
												</span>

												<a href="{{ Storage::url($existingDocuments[$document->id]) }}" target="_blank"
													class="text-indigo-600 hover:underline font-semibold">
													Lihat File
												</a>
											</div>
										@endif

										{{-- loading --}}
										<div class="flex items-center mt-2">
											<div wire:loading wire:loading.flex wire:target="uploadedDocuments.{{ $document->id }}"
												class="text-sm text-indigo-600 italic flex items-center gap-1">
												<svg class="animate-spin size-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
													viewBox="0 0 24 24">
													<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
														stroke-width="4">
													</circle>
													<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0 C5.373 0 0 5.373 0 12h4z"></path>
												</svg>
												<span>Uploading...</span>
											</div>

											@if ($this->hasUploadedFile($document->id))
												<div class="flex items-center justify-end gap-2 text-sm text-green-700">
													<svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
													</svg>

													<span class="font-medium">
														{{ $uploadedDocuments[$document->id]->getClientOriginalName() }}
													</span>
													<span class="text-slate-500">(file sudah dipilih)</span>
												</div>
											@endif
										</div>

										{{-- error --}}
										@error("uploadedDocuments.{$document->id}")
											<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
										@enderror
									</div>
								@endforeach

								@if ($isEdit)
									<div class="bg-white border border-slate-200 rounded-xl p-5 hover:border-indigo-300 transition-colors">
										<label class="flex items-center justify-between mb-2">
											<span class="block text-base font-semibold text-slate-900">
												Bukti Pembayaran
											</span>

											<span class="text-xs text-red-500 font-medium">*Wajib</span>
										</label>

										<input type="file" wire:model="payment_proof" wire.loading.attr="disabled"
											class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />

										{{-- Preview file lama --}}
										@if ($payment && $payment->proof_file)
											<div class="mt-3 flex items-center gap-3 text-sm">
												<span class="text-green-600 font-medium flex items-center gap-1">
													✓ Bukti Pembayaran Saat Ini:
												</span>
												<a href="{{ Storage::url($payment->proof_file) }}" target="_blank"
													class="text-indigo-600 hover:underline font-semibold flex items-center gap-1">
													Lihat File Lama
												</a>
											</div>
										@endif

										{{-- Loading Indicator --}}
										<div wire:loading wire:target="payment_proof" class="mt-2 text-sm text-indigo-600 italic">
											<span>Uploading new proof...</span>
										</div>

										{{-- Preview Nama File Baru setelah dipilih --}}
										@if ($payment_proof instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
											<div class="mt-2 flex items-center gap-2 text-sm text-green-700 font-medium">
												<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
												</svg>
												File siap diupload: {{ $payment_proof->getClientOriginalName() }}
											</div>
										@endif

										{{-- error --}}
										@error('payment_proof')
											<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
										@enderror
									</div>
								@endif
							</div>
						</div>
					@endif

					{{-- Step 5: Confirmation --}}
					@if ($currentStep == 5)
						<div class="max-w-3xl mx-auto space-y-8">
							{{-- Header --}}
							<div class="flex items-center gap-4">
								<div
									class="bg-green-600 text-white w-10 h-10 rounded-xl flex items-center justify-center text-lg font-bold shadow-lg shadow-green-100">
									5
								</div>
								<div>
									<h2 class="text-2xl font-bold text-slate-900">Konfirmasi Data</h2>
									<p class="text-sm text-slate-500">Pastikan data berikut sudah sesuai sebelum pendaftaran dikunci.</p>
								</div>
							</div>

							{{-- Alert Box --}}
							<div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
								<div class="flex items-start gap-4">
									<svg class="h-6 w-6 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
									</svg>
									<div>
										<h3 class="text-amber-800 font-bold text-sm">Peringatan Penting</h3>
										<p class="text-amber-700 text-xs md:text-sm mt-1 leading-relaxed">
											Setelah tombol pendaftaran dikirim, Anda <strong>tidak dapat mengubah data secara mandiri</strong> kecuali
											ada
											instruksi perbaikan dari panitia.
										</p>
									</div>
								</div>
							</div>

							{{-- Info Grid --}}
							<div class="grid grid-cols-1 gap-6">

								{{-- 1. Data Personal --}}
								<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
									<div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
										<h3 class="font-bold text-slate-900 flex items-center gap-2 text-sm">
											<span class="text-indigo-500">●</span> Identitas Calon Siswa
										</h3>
										<span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold uppercase tracking-wider">
											{{ $school_level }}
										</span>
									</div>
									<div class="divide-y divide-slate-100 px-6">
										<x-conf-row label="Nama Lengkap" :value="$full_name" />
										<x-conf-row label="NISN" :value="$nisn" />
										<x-conf-row label="Jenis Kelamin" :value="$gender" />
										<x-conf-row label="TTL" :value="$place_of_birth . ', ' . \Carbon\Carbon::parse($date_of_birth)->isoFormat('D MMMM Y')" />
										<x-conf-row label="Sekolah Asal" :value="$previous_school" />
									</div>
								</div>

								{{-- 2. Data Kontak & Keluarga --}}
								<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
									<div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
										<h3 class="font-bold text-slate-900 flex items-center gap-2 text-sm">
											<span class="text-indigo-500">●</span> Kontak & Orang Tua
										</h3>
									</div>
									<div class="divide-y divide-slate-100 px-6">
										<x-conf-row label="Email" :value="$email" />
										<x-conf-row label="No. WhatsApp" :value="$phone_number" />
										<x-conf-row label="Nama Ayah" :value="$father_name" />
										<x-conf-row label="Nama Ibu" :value="$mother_name" />
										@if ($guardian_name)
											<x-conf-row label="Nama Wali" :value="$guardian_name" />
										@endif
									</div>
								</div>
							</div>

							{{-- Agreement --}}
							<div class="p-5 bg-slate-100 border border-slate-200 rounded-2xl hover:bg-slate-200/50 transition-colors">
								<label class="flex items-start gap-4 cursor-pointer">
									<input type="checkbox" required
										class="mt-1 h-5 w-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
									<span class="text-sm text-slate-600 leading-relaxed">
										Saya menyatakan dengan sadar bahwa seluruh data yang diisikan adalah <strong>benar dan sesuai dengan
											aslinya</strong>. Jika di kemudian hari ditemukan ketidaksesuaian, saya bersedia menerima konsekuensi yang
										ditetapkan pihak sekolah.
									</span>
								</label>
							</div>
						</div>
					@endif

					@error('submit')
						<div class="mt-4 px-3 py-1.5 bg-red-100 border border-red-600 rounded-xl">
							<p class="text-red-600 text-center">
								{{ $message }}
							</p>
						</div>
					@enderror

					{{-- Navigation Buttons --}}
					<div class="mt-10 pt-6 border-t border-slate-100 flex justify-between items-center">
						@if ($currentStep > 1)
							<button type="button" wire:click="previousStep"
								class="px-4 sm:px-6 py-3 flex items-center gap-x-1 border border-slate-300 shadow-sm text-sm font-bold rounded-full text-slate-700 bg-white hover:bg-slate-50 hover:border-slate-400 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
									stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
									<path d="m15 18-6-6 6-6" />
								</svg>
								Kembali
							</button>
						@else
							<div></div>
						@endif

						@if ($currentStep < $totalSteps)
							<button type="button" wire:click="nextStep" wire:loading.attr="disabled"
								class="inline-flex items-center justify-center gap-x-1 px-6 py-3 border border-transparent text-sm font-bold rounded-full shadow-lg text-white bg-indigo-600 hover:bg-indigo-700 hover:scale-105 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">

								<span wire:loading.remove wire:target="nextStep" class="flex items-center gap-1">
									Selanjutnya
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
										stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
										<path d="m9 18 6-6-6-6" />
									</svg>
								</span>

								<span wire:loading.flex wire:target="nextStep" class="flex items-center justify-center">
									<svg class="animate-spin h-5 w-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
										viewBox="0 0 24 24">
										<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
										</circle>
										<path class="opacity-75" fill="currentColor"
											d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
										</path>
									</svg>
									<span>Memproses...</span>
								</span>
							</button>
						@else
							<button type="submit" wire:loading.attr="disabled" wire:target="submit"
								class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-full text-white bg-green-600 hover:bg-green-700 hover:scale-105 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-70 disabled:cursor-not-allowed">

								<span wire:loading.remove wire:target="submit" class="flex items-center justify-center gap-2">
									Kirim Pendaftaran
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
										<path fill-rule="evenodd"
											d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
											clip-rule="evenodd" />
									</svg>
								</span>

								<span wire:loading.flex wire:target="submit" class="items-center justify-center gap-2">
									<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
										viewBox="0 0 24 24">
										<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
										</circle>
										<path class="opacity-75" fill="currentColor"
											d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
										</path>
									</svg>
									<span class="whitespace-nowrap">Mengirim...</span>
								</span>
							</button>
						@endif
					</div>
				</form>
			</div>
		@else
			{{-- Tampilan Jika Pendaftaran TUTUP (Empty State) --}}
			<div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 p-12 text-center">
				<div class="inline-flex items-center justify-center w-20 h-20 bg-amber-50 rounded-full mb-6">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
						stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
						class="w-10 h-10 text-amber-500">
						<path d="M8 2v4" />
						<path d="M16 2v4" />
						<path d="M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
						<path d="M3 10h18" />
						<path d="m17 22 5-5" />
						<path d="m17 17 5 5" />
					</svg>
				</div>

				<h2 class="text-2xl font-bold text-slate-900 mb-3">Pendaftaran Belum Dibuka</h2>
				<p class="text-slate-500 max-w-md mx-auto mb-8 leading-relaxed">
					Mohon maaf, saat ini pendaftaran murid baru belum dibuka. Silakan pantau terus halaman ini atau ikuti media
					sosial kami untuk informasi pendaftaran selanjutnya.
				</p>

				<div class="flex flex-col sm:flex-row items-center justify-center gap-4">
					<a href="{{ route('welcome') }}"
						class="w-full sm:w-auto px-6 py-3 bg-slate-800 text-white rounded-xl font-semibold hover:bg-slate-700 transition-colors">
						Kembali ke Beranda
					</a>
				</div>
			</div>
		@endif
	</div>
</div>
