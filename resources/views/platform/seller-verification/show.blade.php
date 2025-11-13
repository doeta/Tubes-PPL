<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pendaftaran Penjual') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Review Pendaftaran Penjual</h3>
                        <a href="{{ route('platform.seller-verification.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            &larr; Kembali ke Daftar
                        </a>
                    </div>

                    <!-- Informasi Toko -->
                    <div class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <h4 class="text-md font-semibold mb-3 text-gray-800 dark:text-gray-200">Informasi Toko</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Nama Toko</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $seller->nama_toko }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Tanggal Pendaftaran</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $seller->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Deskripsi Toko</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $seller->deskripsi_singkat ?: '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi PIC -->
                    <div class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <h4 class="text-md font-semibold mb-3 text-gray-800 dark:text-gray-200">Informasi Penanggung Jawab (PIC)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Nama PIC</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $seller->nama_pic }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Email PIC</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $seller->email_pic }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">No. KTP</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $seller->no_ktp_pic }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Alamat sesuai KTP</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $seller->alamat_ktp_pic }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat Toko -->
                    <div class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <h4 class="text-md font-semibold mb-3 text-gray-800 dark:text-gray-200">Alamat Toko</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Alamat Lengkap</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $seller->alamat }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Kelurahan</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $seller->nama_kelurahan }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Kecamatan</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $seller->kecamatan }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Kabupaten/Kota</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $seller->kabupaten_kota }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Provinsi</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $seller->provinsi }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- File KTP -->
                    <div class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <h4 class="text-md font-semibold mb-3 text-gray-800 dark:text-gray-200">Dokumen KTP</h4>
                        @if($seller->file_ktp_pic)
                            <div class="mb-2">
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">File KTP PIC</label>
                                <div class="mt-2">
                                    @if(Str::endsWith($seller->file_ktp_pic, '.pdf'))
                                        <a href="{{ Storage::url($seller->file_ktp_pic) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                            Lihat PDF
                                        </a>
                                    @else
                                        <img src="{{ Storage::url($seller->file_ktp_pic) }}" alt="KTP" class="max-w-md rounded-lg shadow-lg">
                                    @endif
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">Tidak ada file KTP</p>
                        @endif
                    </div>

                    <!-- Informasi Akun -->
                    <div class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <h4 class="text-md font-semibold mb-3 text-gray-800 dark:text-gray-200">Informasi Akun</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Nama Pengguna</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $seller->user->name }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Email Login</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $seller->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    @if($seller->isPending())
                        <div class="flex space-x-4">
                            <!-- Approve Form -->
                            <form method="POST" action="{{ route('platform.seller-verification.approve', $seller) }}" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pendaftaran ini?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Setujui
                                </button>
                            </form>

                            <!-- Reject Button (opens modal) -->
                            <button onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Tolak
                            </button>
                        </div>

                        <!-- Reject Modal -->
                        <div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                                <div class="mt-3">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100 mb-4">
                                        Alasan Penolakan
                                    </h3>
                                    <form method="POST" action="{{ route('platform.seller-verification.reject', $seller) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-4">
                                            <label for="rejection_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Masukkan alasan penolakan:
                                            </label>
                                            <textarea id="rejection_reason" name="rejection_reason" rows="4" required class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Jelaskan alasan penolakan..."></textarea>
                                        </div>
                                        <div class="flex justify-end space-x-3">
                                            <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                                Batal
                                            </button>
                                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                                Tolak Pendaftaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-gray-700 dark:text-gray-300">
                                Status: <span class="font-semibold">{{ ucfirst($seller->verification_status) }}</span>
                            </p>
                            @if($seller->verified_at)
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Diverifikasi pada: {{ $seller->verified_at->format('d F Y, H:i') }}
                                </p>
                            @endif
                            @if($seller->rejection_reason)
                                <p class="text-sm text-red-600 dark:text-red-400 mt-2">
                                    Alasan penolakan: {{ $seller->rejection_reason }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
