<div class="flex justify-center items-center h-screen">
    <div class="overflow-hidden bg-white shadow sm:rounded-lg border-gray-300 border-2 w-3/4 h-3/4">
        <div class="flex justify-between px-4 py-5 sm:p-6">
            <div class="flex items-center w-full">
                <img src="{{asset('images/sksu1.png')}}" class="ml-12 h-32 w-32" alt="">
                <div class="ml-4">
                    <span class="text-2xl font-bold text-gray-800 tracking-wide uppercase">SULTAN KUDARAT STATE UNIVERSITY</span>
                    <div>
                        <span class="text-2xl font-semibold text-gray-800 tracking-wide uppercase">Pre-Registration</span>
                    </div>
                </div>
            </div>
            <div class="">
                <span class="text-red-500">This examinee number belongs to: <br><span class="font-semibold">{{$record->name}}</span></span>
            </div>
        </div>
        <div class="flex h-3/4">
            <div class="col-span-1 w-full flex flex-col justify-between">
                <div class="flex-grow mx-auto p-5">

                        <!-- Step 3 -->
                        <div>
                            <div class="p-5 text-2xl font-semibold tracking-wide font-sans">
                                <span class="text-green-600">Congratulations</span><span> on successfully submitting your pre-registration form! Your submission has
                                    been received, and we appreciate your interest and participation.
                                </span>
                                <div class="mt-10">
                                    <span>Thank you again for choosing to pre-register with us. We look forward to the opportunity to serve you and provide a
                                        valuable experience.
                                    </span>
                                </div>

                            </div>
                        </div>
                </div>

                <!-- Step navigation buttons -->
                <div class="p-5 flex justify-end">
                    <button wire:click="logOut" class="px-4 py-4 bg-red-600 text-white rounded-lg text-lg w-32 ml-10 tracking-wide">EXIT</button>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
