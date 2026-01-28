<div class="bg-indigo-50/50 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
	<div class="max-w-4xl mx-auto">
		{{-- Header --}}
		<div class="text-center mb-10">
			<h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Formulir Pendaftaran Online</h1>
			<p class="text-slate-500 text-lg">Lengkapi data diri Anda untuk bergabung dengan kami.</p>
		</div>

		<div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
			{{-- Stepper --}}
			<div class="bg-slate-50/50 border-b border-slate-100 px-6 py-6 sm:px-10">
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
							@foreach (['sd', 'smp', 'sma'] as $level)
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
													@if ($level == 'sd')
														Sekolah Dasar
													@elseif($level == 'smp')
														Sekolah Menengah Pertama
													@elseif($level == 'sma')
														Sekolah Menengah Atas
													@endif
												</div>

												<p class="text-sm text-slate-500">
													@if ($level == 'sd')
														Kelas 1 - 6
													@elseif($level == 'smp')
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
								<label for="full_name" class="block text-sm font-semibold text-slate-700 mb-2">Nama
									Lengkap</label>
								<input type="text" wire:model="full_name" id="full_name"
									class="w-full rounded-xl border-slate-300 border focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-slate-900"
									placeholder="Sesuai Akta Kelahiran">
								@error('full_name')
									<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
								@enderror
							</div>

							<div>
								<label for="nisn" class="block text-sm font-semibold text-slate-700 mb-2">NISN <span
										class="text-slate-400 font-normal">(Opsional)</span></label>
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
								<label for="place_of_birth" class="block text-sm font-semibold text-slate-700 mb-2">Tempat
									Lahir</label>
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
						<div class="p-6 rounded-2xl border border-slate-100">
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

						{{-- Mother --}}
						<div class="p-6 rounded-2xl border border-slate-100">
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
					<div class="animate-fade-in-up space-y-6">
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
							@foreach (['document_kartu_keluarga' => 'Kartu Keluarga', 'document_akte_kelahiran' => 'Akte Kelahiran', 'document_ijazah' => 'Ijazah / SKL'] as $field => $label)
								<div class="bg-white border border-slate-200 rounded-xl p-5 hover:border-indigo-300 transition-colors">
									<label for="{{ $field }}" class="flex items-center justify-between mb-2">
										<span class="block text-base font-semibold text-slate-900">{{ $label }}</span>
										@if ($field === 'document_ijazah')
											<span class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded">Opsional</span>
										@else
											<span class="text-xs text-red-500 font-medium">*Wajib</span>
										@endif
									</label>

									<input type="file" wire:model="{{ $field }}" id="{{ $field }}"
										class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 " />

									<div wire:loading wire:target="{{ $field }}"
										class="mt-2 text-sm text-indigo-600 italic flex items-center gap-1">
										<svg class="animate-spin h-4 w-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
											viewBox="0 0 24 24">
											<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
											</circle>
											<path class="opacity-75" fill="currentColor"
												d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
											</path>
										</svg>
										Uploading...
									</div>
									@error($field)
										<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
									@enderror
								</div>
							@endforeach
						</div>
					</div>
				@endif

				{{-- Step 5: Confirmation --}}
				@if ($currentStep == 5)
					<div class="animate-fade-in-up">
						<h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
							<span
								class="bg-indigo-100 text-indigo-700 w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold">5</span>
							Konfirmasi Data
						</h2>

						<div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 mb-8">
							<div class="flex items-start gap-4">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 mt-1" fill="none"
									viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
								</svg>
								<div>
									<h3 class="text-yellow-800 font-bold">Periksa Kembali Data Anda</h3>
									<p class="text-yellow-700 text-sm mt-1">Pastikan seluruh data yang Anda masukkan sudah
										benar. Data tidak dapat diubah setelah pendaftaran dikirim (kecuali diminta
										perbaikan).</p>
								</div>
							</div>
						</div>

						<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden mb-8">
							<dl class="divide-y divide-slate-100">
								<div class="px-6 py-4 grid grid-cols-3 gap-4 hover:bg-slate-50">
									<dt class="text-sm font-medium text-slate-500">Jenjang Pendaftaran</dt>
									<dd class="text-sm text-slate-900 font-bold col-span-2">{{ strtoupper($school_level) }}
									</dd>
								</div>
								<div class="px-6 py-4 grid grid-cols-3 gap-4 hover:bg-slate-50">
									<dt class="text-sm font-medium text-slate-500">Nama Lengkap</dt>
									<dd class="text-sm text-slate-900 col-span-2">{{ $full_name }}</dd>
								</div>
								<div class="px-6 py-4 grid grid-cols-3 gap-4 hover:bg-slate-50">
									<dt class="text-sm font-medium text-slate-500">Email</dt>
									<dd class="text-sm text-slate-900 col-span-2">{{ $email }}</dd>
								</div>
								<div class="px-6 py-4 grid grid-cols-3 gap-4 hover:bg-slate-50">
									<dt class="text-sm font-medium text-slate-500">No. HP</dt>
									<dd class="text-sm text-slate-900 col-span-2">{{ $phone_number }}</dd>
								</div>
								<div class="px-6 py-4 grid grid-cols-3 gap-4 hover:bg-slate-50">
									<dt class="text-sm font-medium text-slate-500">Orang Tua</dt>
									<dd class="text-sm text-slate-900 col-span-2">{{ $father_name }} & {{ $mother_name }}
									</dd>
								</div>
							</dl>
						</div>

						<div class="flex items-start gap-3 p-4 bg-slate-50 rounded-xl">
							<input id="confirm" type="checkbox" required
								class="mt-1 h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
							<label for="confirm" class="text-sm text-slate-600">
								Saya menyatakan bahwa seluruh data yang saya isikan adalah benar dan dapat
								dipertanggungjawabkan hukum. Saya bersedia menerima sanksi apabila ditemukan ketidaksesuaian
								data di kemudian hari.
							</label>
						</div>
					</div>
				@endif

				{{-- Navigation Buttons --}}
				<div class="mt-10 pt-6 border-t border-slate-100 flex justify-between items-center">
					@if ($currentStep > 1)
						<button type="button" wire:click="previousStep"
							class="px-6 py-3 border border-slate-300 shadow-sm text-sm font-bold rounded-full text-slate-700 bg-white hover:bg-slate-50 hover:border-slate-400 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
							&larr; Kembali
						</button>
					@else
						<div></div>
					@endif

					@if ($currentStep < $totalSteps)
						<button type="button" wire:click="nextStep" wire:loading.attr="disabled"
							class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-sm font-bold rounded-full shadow-lg text-white bg-indigo-600 hover:bg-indigo-700 hover:scale-105 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed min-w-40">

							<span wire:loading.remove wire:target="nextStep" class="flex items-center gap-2">
								Selanjutnya
								<span>&rarr;</span>
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
						<button type="submit" wire:loading.attr="disabled"
							class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-sm font-bold rounded-full shadow-lg text-white bg-green-600 hover:bg-green-700 hover:scale-105 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-70 disabled:cursor-not-allowed min-w-50">

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
	</div>
</div>
