<div class="h-screen flex justify-center items-center">
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="md:h-full order-2 md:order-none mx-auto mt-5">
            <img src="{{ asset('images/sksu1.png') }}" class="w-32 h-32 mx-auto" alt="">
            <div class="mt-4 ml-24">
                <a href="https://sksu.edu.ph/"
                    class="inline-flex space-x-4">
                    <span
                        class="rounded bg-green-600 px-3 py-1 text-md font-semibold text-white tracking-wide uppercase">
                        What's new </span>
                    <span class="inline-flex items-center space-x-1 text-lg font-medium text-green-600">
                        <span>
                            Visit our official website
                        </span>
                        <!-- Heroicon name: solid/chevron-right -->
                        <svg class="w-5 h-5"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </a>
            </div>
            <div class="mt-10">
                <span
                class="text-3xl font-bold text-gray-700 tracking-wide uppercase">
               SKSU - TERTIARY </span>
            </div>
            <span
            class="text-5xl font-bold text-green-800 tracking-wide uppercase">
           PRE-REGISTRATION </span>
           <div class="mt-4">
            <span
            class="text-xl font-bold text-green-800 tracking-wide uppercase">
           SULTAN KUDARAT STATE UNIVERSITY </span>
           </div>
           <div class="mt-2">
            <span
            class="text-lg font-semibold text-gray-700 tracking-wide">
           EJC Montilla, 9800 City of Tacurong Province of Sultan Kudarat </span>
           <div class="mt-14 border-b-2 border-gray-300 w-full"></div>
           </div>
           <div class="mt-5 space-y-3">
            <h3 class="text-lg font-semibold text-gray-700 tracking-wide">Examinee Number:</h3>
            <input wire:model="examinee_number" type="number" class="rounded-lg w-full text-lg py-3 focus:outline-none focus:border-green-800" placeholder="ex: 203665">
            <button wire:click="checkExamineeNumber" class="rounded-lg w-full py-3 bg-green-500 text-white font-semibold text-lg hover:bg-green-800">Log in</button>
            <div class="">
                {{-- <a class="ml-2 text-lg text-green-600 underline" target="_blank" href="https://mail.google.com/mail/u/0/?fs=1&tf=cm&to=tpt@sksu.edu.ph&su=TPT+PRE-REGISTRATION+HELPDESK&body=Full+Name%3A%0D%0AExaminee+Number%3A%0D%0A%0D%0AConcern%3A">Need Help? Send us an email here.<img src="gmail.svg" alt="Gmail" class="ml-1 h-4 w-4 inline-block align-middle"></a> --}}
                <a class="ml-2 text-lg text-green-600 underline" target="_blank" href="https://mail.google.com/mail/u/0/?fs=1&tf=cm&to=tpt@sksu.edu.ph&su=TPT+PRE-REGISTRATION+HELPDESK&body=Full+Name%3A%0D%0AExaminee+Number%3A%0D%0A%0D%0AConcern%3A">Need Help? Send us an email here.
                    <svg class="ml-1 h-4 w-4 inline-block align-middle" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                      </svg>

                </a>

            </div>
        </div>
        </div>
        <div class="relative">
            <img src="{{ asset('images/sksu_university.jpg') }}" class="rounded-2xl md:h-full object-cover shadow-xl mb-19" alt="">
        </div>
    </div>
</div>
