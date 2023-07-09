<div class="flex justify-center items-center h-screen">
    <div class="overflow-hidden bg-white shadow sm:rounded-lg border-gray-400 border-2 w-3/4 h-3/4">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center w-full">
                <img src="{{asset('images/sksu1.png')}}" class="ml-12 h-32 w-32" alt="">
                <div class="ml-4">
                    <span class="text-2xl font-bold text-gray-800 tracking-wide uppercase">SULTAN KUDARAT STATE UNIVERSITY</span>
                    <div>
                        <span class="text-2xl font-semibold text-gray-800 tracking-wide uppercase">Pre-Registration</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex h-3/4">
            <div class="col-span-1 w-full flex flex-col justify-between">
                <div class="flex-grow mx-auto p-5">
                    @if ($step === 1)
                        <!-- Step 1 -->
                        <div>
                            {{$record}}
                        </div>
                    @elseif ($step === 2)
                        <!-- Step 2 -->
                        <div>
                           <span class="sm:text-sm md:text-3xl text-green-600 tracking-widest font-medium font-sans">Kindly tick the campus and course you are qualified to enroll</span>
                           <div class="flex justify-around mt-10 space-x-4">
                            <x-select
                            searchable
                            label="Select Campus"
                            placeholder="Select one"
                            wire:model="campus_id"
                            class="w-full"
                        >
                            <x-select.option label="Pending" value="1" />
                            <x-select.option label="In Progress" value="2" />
                            <x-select.option label="Stuck" value="3" />
                            <x-select.option label="Done" value="4" />
                        </x-select>
                        <x-select
                            searchable
                            label="Select Course"
                            placeholder="Select one"
                            wire:model="course_id"
                            class="w-full"
                        >
                            <x-select.option label="Pending" value="1" />
                            <x-select.option label="In Progress" value="2" />
                            <x-select.option label="Stuck" value="3" />
                            <x-select.option label="Done" value="4" />
                        </x-select>
                           </div>
                           <div class="mt-16 space-y-3">
                            <div>
                                <span class="text-xl font-medium font-sans">Campus : {{$campus_id}}</span>
                               </div>
                               <div>
                                <span class="text-xl font-medium font-sans">Course : {{$course_id}}</span>
                               </div>
                           </div>
                           <x-button class="mt-10 w-full" emerald label="Save" />
                        </div>
                    @elseif ($step === 3)
                        <!-- Step 3 -->
                        <div>
                            <span class="sm:text-sm md:text-3xl text-green-600 tracking-widest font-medium font-sans">Conformation of Enrollment Form (CEF)</span>
                            <div class="mt-10 space-x-8">
                                <span class="sm:text-sm md:text-3xl text-gray-700 tracking-widest font-medium font-sans ">Download the form</span>
                                <a href="#" class="sm:text-sm md:text-3xl text-green-600 tracking-widest font-medium font-sans underline cursor-pointer">Click to download</a>
                                <div class="mt-5  text-xl text-gray-500 tracking-wide font-medium font-sans">
                                    <span>Please confirm your intent to enroll as SKSU for this upcoming school year by completing<br> this form and uploading it through this platform</span>
                                </div>
                            </div>
                            <div class="mt-10 space-x-8">
                                <span class="sm:text-sm md:text-3xl text-gray-700 tracking-widest font-medium font-sans ">Upload Document</span>
                                <div class="mt-5 bg-gray-100 p-4 rounded-lg">
                                        {{$this->form}}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Step navigation buttons -->
                <div class="p-5 flex justify-between">
                    @if ($step == 1)
                    <div class="">
                        <button wire:click="logOut" class="px-4 py-4 bg-gray-400 text-white rounded-lg text-lg w-32">Logout</button>
                    </div>
                    @endif
                    @if ($step > 1)
                    <div class="">
                        <button wire:click="prevStep" class="px-4 py-4 bg-gray-400 text-white rounded-lg text-lg w-32">Back</button>
                    </div>
                    @endif

                    @if ($step < 3)
                    <div class="flex items-center">
                        <span class="sm:text-sm md:text-2xl tracking-wide {{$step == 1 ? 'text-green-500' : 'text-gray-500'}} px-3">Step 1</span>
                        <span class="sm:text-sm md:text-2xl tracking-wide {{$step == 2 ? 'text-green-500' : 'text-gray-500'}} px-3">Step 2</span>
                        <span class="sm:text-sm md:text-2xl tracking-wide {{$step == 3 ? 'text-green-500' : 'text-gray-500'}} px-3">Step 3</span>
                        <button wire:click="nextStep" class="px-4 py-4 bg-green-400 text-white rounded-lg text-lg w-32 ml-10">Next</button>
                    </div>
                    @else
                    <div class="flex items-center">
                        <span class="sm:text-sm md:text-2xl tracking-wide {{$step == 1 ? 'text-green-500' : 'text-gray-500'}} px-3">Step 1</span>
                        <span class="sm:text-sm md:text-2xl tracking-wide {{$step == 2 ? 'text-green-500' : 'text-gray-500'}} px-3">Step 2</span>
                        <span class="sm:text-sm md:text-2xl tracking-wide {{$step == 3 ? 'text-green-500' : 'text-gray-500'}} px-3">Step 3</span>
                        <button wire:click="submitForm" class="px-4 py-4 bg-green-400 text-white rounded-lg text-lg w-32 ml-10">Submit</button>
                    </div>
                    @endif
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
