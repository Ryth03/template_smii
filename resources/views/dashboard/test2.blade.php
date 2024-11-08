<x-guest-layout>
    @section('title')
Register
    @endsection
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <style>
        [type="checkbox"]+label {
            color: unset;
            background-color: unset;
        }
    </style>

    <div class="col-12 p-0">
        <div class="login-card login-dark">
            <div class="w-full" style="max-width:450px;">
                <div class="login-main" style="background: rgba(255, 255, 255, 0.527); backdrop-filter: blur(10px); border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-width: 450px; width:100%;">
                    <form class="theme-form" method="POST" action="" >
                        @csrf
                        <h3 class="font-bold text-4xl text-center" style="color:#c0a01f">Intra SMII</h3>
                        <p class="mt-10 text-center" style="color: #141412">Register to continue to Intra SMII.</p>
                        <div class="relative w-full mt-4">
                            <label for="input-label" class="block text-sm font-medium mb-2 text-gray-700">Nama</label>
                            <input type="text" name="nama" id="input-label"
                                class="border-1 py-2 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:focus:ring-gray-600"
                                placeholder="Masukan Nama">
                        </div>

                        <div class="relative w-full mt-4">
                            <label for="compDept" class="block text-sm font-medium mb-2 text-gray-700">Perusahaan / Departemen</label>
                            <input type="text" name="company/department" id="compDept"
                                class="border-1 py-2 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:focus:ring-gray-600"
                                placeholder="Masukan Perusahaan / Departemen">
                        </div>

                        <label class="font-medium block mb-1 mt-4 text-gray-700" for="password">
                            Password
                        </label>
                        <div class="relative w-full">
                            <input
                                class="border-1 rounded w-full py-2 px-3 leading-tight border-gray-300 bg-gray-100 focus:outline-none focus:border-indigo-700 focus:bg-white text-gray-700 pr-10 font-mono js-password"
                                id="password" type="password" name="password" autocomplete="off"
                                placeholder="*********" required>
                            <span onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 flex items-center px-3 cursor-pointer text-gray-700">
                                <i class="fa fa-eye" id="toggleEye"></i>
                            </span>
                        </div>

                        <label class="font-medium block mb-1 mt-4 text-gray-700" for="Confirm Password">
                            Confirm Password
                        </label>
                        <div class="relative w-full">
                            <input
                                class="border-1 rounded w-full py-2 px-3 leading-tight border-gray-300 bg-gray-100 focus:outline-none focus:border-indigo-700 focus:bg-white text-gray-700 pr-10 font-mono js-password"
                                id="confirmPassword" type="password" name="confirmPassword" autocomplete="off"
                                placeholder="*********" required>
                            <span onclick="toggleConfirmPasswordVisibility()" class="absolute inset-y-0 right-0 flex items-center px-3 cursor-pointer text-gray-700">
                                <i class="fa fa-eye" id="toggleEyeConfirm"></i>
                            </span>
                        </div>
                        

                        
                        <!-- Modal -->
                        <div>
                            <button type="button" class="mt-7 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-base px-3 py-3 text-center"

                            data-modal-target="createDepartmentModal" data-modal-toggle="createDepartmentModal">
                            Perjanjian Kerja Kontraktor
                            </button>
                        </div>

                        <div class="mt-10">
                            <input type="checkbox" id="termsAgreement" name="termsAgreement" required>
                            <label for="termsAgreement" class="text-gray-900 dark:text-white">Saya setuju dengan Perjanjian Kerja Kontraktor</label>
                        </div>

                        <div class="form-group mt-5">
                            <div class="text-end mt-6" >
                                <button class="btn btn-primary btn-block rounded-md text-white w-full"
                                    type="submit" onclick="validateForm(event)">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Terms --}}
    <div id="createDepartmentModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                 <div class="flex flex-col p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Perjanjian Kerja Kontraktor
                        </h3>
                        <button type="button"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="createDepartmentModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewbox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <label class="text-justify block mt-4 text-gray-900 dark:text-white">
                        Dalam hal ini menerangkan bahwa kedua belah pihak sepakat mengadakan sebuah perjanjian kerja dengan keetentuan dan syarat-syarat sebagai berikut :
                    </label>
                 </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <div class="text-justify  text-gray-900 dark:text-white">
                        <label for="department_name" class="block mb-2 font-medium">
                            PIHAK KEDUA berkewajiban :
                        </label>
                        <ol class="p-2.5 space-y-4 list-decimal">
                            <li>Melaporkan dan menyerahkan fotocopy KTP / Identitas Diri yang berlaku kepada PIHAK PERTAMA</li>
                            <li>Selama melakukan pekerjaan di area PT SMII wajib memakai APD Standar seperti :
                                <br>
                                <ol class="list-inside" style="list-style-type: lower-alpha;">
                                    <li>Helm</li>
                                    <li>Rompi</li>
                                    <li>Sepatu</li>
                                    <li>Celana panjang</li>
                                    <li>Baju berlengan</li>
                                </ol>
                            </li>
                            <li>Mentaati semua persyaratan yang tertuang dalam surat ijin kerja dan yang di persyaratkan oleh pihak pertama</li>
                            <li>Mentaati semua peraturan umum yang berlaku di PT SMII</li>
                            <li>Memperhatikan dan mematuhi setiap rambu yang dipasang di area PT SMII</li>
                            <li>Pengawasan proyek wajib berada di area proyek selama aktivitas berlangsung</li>
                            <li>Menyiapkan alat proteksi kebakaran khusus pekerjaan hot work dan listrik</li>
                            <li>Melaporkan kepada pihak PT SMII jika terjadi kecelakaan kerja</li>
                            <li>Dilarang meninggalkan area kerja dalam kondisi kotor dan berantakan</li>
                            <li>Menjaga kebersihan di lingkungan PT SMII, dengan membuang sampah di tempat sampah yang telah disediakan </li>
                        </ol>

                        <label for="department_name" class="block mt-3 mb-2 font-medium ">
                            PIHAK Pertama berkewajiban :
                        </label>
                        <ol class="p-2.5 space-y-4 list-decimal">
                            <li>Memberikan safety induction diawal proyek sebelum pekerjaan dimulai kepada pihak kedua</li>
                            <li>Melakukan pengawasan dilapangan secara berkala di area proyek</li>
                            <li>Apabila dalam melakukan aktivitas pekerjaan di area PT SMII dengan sengaja tidak mematuhi peraturan / tata-tertib point 1-10 
                                maka pihak pertama berhak memberikan sanksi kepada pihak kontraktor atau karyawannya yang melanggar.
                                <br>
                                adapun sanksi yang berlaku sebagai berikut :
                                <br>
                                <ol class="list-inside" style="list-style-type: lower-alpha;">
                                    <li>Teguran lisan (dari HSE dan Security)</li>
                                    <li>Denda paling tinggi sebesar 1.000.000 (dari finance)</li>
                                    <li>Kontraktor dan atau karyawan diblacklist / dikeluarkan saat itu juga</li>
                                </ol>
                            </li>
                        </ol>
                        <div class="block mt-3 mb-2 font-medium">
                            Demikian perjanjian ini dibuat serta disetujui masing - masing pihak yang bersangkutan, 
                            dan guna dipatuhi sepenuhnya dengan itikad serta jiwa kerjasama sebaik-baiknya.
                        </div>
                         <div class="flex items-center justify-center">
                            <button type="button" data-modal-hide="createDepartmentModal" class="bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 transition duration-200">
                                <span>Close</span>
                            </button>
                         </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var toggleIcon = document.getElementById('toggleEye');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        function toggleConfirmPasswordVisibility() {
            var passwordInput = document.getElementById('confirmPassword');
            var toggleIcon = document.getElementById('toggleEyeConfirm');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        function validateForm(event) {
            const checkbox = document.getElementById('termsAgreement');
            if (!checkbox.checked) {
                event.preventDefault(); // Mencegah form dikirim
                alert('Anda harus menyetujui syarat dan ketentuan.');
            }
        }
    </script>
</x-guest-layout>
