@extends('layouts.app')

@section('header')
    <div class="text-[13px] text-gray-500 font-medium">
        <span class="text-gray-400">{{ __('dashboard.header.breadcrumb_home') }} /</span>
        <span class="text-[#0ea5e9]">Kelola Akun</span>
    </div>
@endsection

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-[22px] font-bold text-[#1E293B]">Profil Pengguna</h1>
        </div>

        <div class="mb-4">
            <a href="{{ route('profile.show') }}"
                class="inline-flex items-center text-[13px] font-medium text-white bg-gray-500 hover:bg-gray-600 px-4 py-2 rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>


        <div class="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-full relative">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <!-- Avatar Section -->
                <div class="flex flex-col items-center justify-center pt-10 pb-6 border-b border-gray-100">
                    <div class="relative flex items-center justify-center w-24 h-24 p-[3px] bg-white border border-gray-200 rounded-full shadow-sm shrink-0">
                        <img id="profile-photo-preview" class="w-full h-full rounded-full object-cover block"
                            src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=E5E7EB&color=374151&bold=true&size=128' }}"
                            alt="Avatar">
                    </div>
                    <label for="photo-upload" class="mt-3 text-sm font-medium text-blue-500 hover:text-blue-600 cursor-pointer">
                        Edit Photo
                    </label>
                    <input id="photo-upload" type="file" name="photo" accept="image/*" class="hidden" onchange="previewPhoto(event)">
                    @error('photo')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <!-- Form Fields -->
                <div class="p-8 pb-24">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-[12px] font-medium text-gray-400 mb-1.5">{{ __('dashboard.profile.full_name') }}</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-[13px] rounded-lg p-2.5 outline-none focus:border-blue-500 focus:bg-white transition-colors">
                            @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <!-- NIP -->
                        <div>
                            <label class="block text-[12px] font-medium text-gray-400 mb-1.5">{{ __('dashboard.profile.nip') }}</label>
                            <input type="text" name="nip" value="{{ old('nip', '1234567890') }}"
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-[13px] rounded-lg p-2.5 outline-none focus:border-blue-500 focus:bg-white transition-colors">
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-[12px] font-medium text-gray-400 mb-1.5">{{ __('dashboard.profile.gender') }}</label>
                            <div class="relative">
                                <select name="gender" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-[13px] rounded-lg p-2.5 outline-none appearance-none focus:border-blue-500 focus:bg-white transition-colors cursor-pointer">
                                    <option value="L" selected>Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Agama -->
                        <div>
                            <label class="block text-[12px] font-medium text-gray-400 mb-1.5">{{ __('dashboard.profile.religion') }}</label>
                            <div class="relative">
                                <select name="religion" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-[13px] rounded-lg p-2.5 outline-none appearance-none focus:border-blue-500 focus:bg-white transition-colors cursor-pointer">
                                    <option value="Islam" selected>Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-[12px] font-medium text-gray-400 mb-1.5">{{ __('dashboard.profile.email') }}</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-[13px] rounded-lg p-2.5 outline-none focus:border-blue-500 focus:bg-white transition-colors">
                            @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div>
                            <label class="block text-[12px] font-medium text-gray-400 mb-1.5">{{ __('dashboard.profile.phone_number') }}</label>
                            <input type="text" name="phone" value="{{ old('phone', '081234567890') }}"
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-[13px] rounded-lg p-2.5 outline-none focus:border-blue-500 focus:bg-white transition-colors">
                        </div>

                        <!-- Jabatan -->
                        <div>
                            <label class="block text-[12px] font-medium text-gray-400 mb-1.5">{{ __('dashboard.profile.position') }}</label>
                            <div class="relative">
                                <select name="position" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-[13px] rounded-lg p-2.5 outline-none appearance-none focus:border-blue-500 focus:bg-white transition-colors cursor-pointer">
                                    <option value="Arsiparis Ahli Utama" selected>Arsiparis Ahli Utama</option>
                                    <option value="Arsiparis Ahli Madya">Arsiparis Ahli Madya</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Pangkat/Golongan -->
                        <div>
                            <label class="block text-[12px] font-medium text-gray-400 mb-1.5">{{ __('dashboard.profile.rank_class') }}</label>
                            <div class="relative">
                                <select name="rank" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-[13px] rounded-lg p-2.5 outline-none appearance-none focus:border-blue-500 focus:bg-white transition-colors cursor-pointer">
                                    <option value="Golongan IV" selected>Golongan IV</option>
                                    <option value="Golongan III">Golongan III</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Tempat, tanggal lahir -->
                        <div class="md:col-span-2">
                            <label class="block text-[12px] font-medium text-gray-400 mb-1.5">{{ __('dashboard.profile.birth_place_date') }}</label>
                            <input type="text" name="birth_place_date" value="{{ old('birth_place_date', 'Bandung, 10 Januari 1999') }}"
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-[13px] rounded-lg p-2.5 outline-none focus:border-blue-500 focus:bg-white transition-colors">
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label class="block text-[12px] font-medium text-gray-400 mb-1.5">{{ __('dashboard.profile.address') }}</label>
                            <textarea name="address" rows="3"
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-[13px] rounded-lg p-2.5 outline-none focus:border-blue-500 focus:bg-white transition-colors resize-none">Jl. Raya Derwati, Mekarjaya, Kec. Rancasari,&#10;Kota Bandung, Jawa Barat 40292</textarea>
                        </div>
                    </div>
                </div>

                <!-- Save Button positioned absolutely like in show view -->
                <div class="absolute bottom-6 right-6">
                    <button type="submit"
                        class="bg-[#3B82F6] hover:bg-blue-600 text-white text-[13px] font-medium py-2 px-5 rounded-lg border border-blue-500 shadow-sm flex items-center transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                            </path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function previewPhoto(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('profile-photo-preview').src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
