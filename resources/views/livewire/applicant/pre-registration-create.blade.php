<div class="flex justify-center items-center h-screen">
    <div class="overflow-hidden bg-white shadow sm:rounded-lg border-gray-300 border-2 w-3/4 h-3/4">
        <div class="flex justify-between px-4 py-5 sm:p-6">
            <div class="flex items-center w-full">
                <img src="{{asset('images/sksu1.png')}}" class="ml-12 h-28 w-28" alt="">
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
                <div class="sm:mx-auto md:mx-48 p-2">
                    @if ($step === 1)
                        <!-- Step 1 -->
                        <div class="font-sans text-2xl font-semibold tracking-wider uppercase">
                            <div class="grid grid-cols-3 rounded-lg p-1">
                                @if($record->applicant_info === null)
                                <div class="col-span-1 p-4">
                                    <x-input label="First Name" wire:model="first_name"/>
                                </div>
                                <div class="col-span-1 p-4">
                                    <x-input label="Middle Name" wire:model="middle_name"/>
                                </div>
                                <div class="col-span-1 p-4">
                                    <x-input label="Last Name" wire:model="last_name"/>
                                </div>
                                <div class="col-span-1 p-4 ">
                                    <x-input label="Birthplace" wire:model="birthplace"/>
                                </div>
                                <div class="col-span-1 p-4 text-sm">
                                    <x-datetime-picker label="Birthday" wire:model="birthday" without-time timezone="Asia/Manila"/>
                                </div>
                                <div class="col-span-1 p-4">
                                    <x-input label="Age" disabled wire:model="age"/>
                                </div>
                                <div class="col-span-1 p-4">
                                    <x-input label="Present Address" wire:model="present_address"/>
                                </div>
                                <div class="col-span-1 p-4">
                                    <x-input label="Permanent Address" wire:model="permanent_address"/>
                                </div>
                                <div class="col-span-1 p-4">
                                    <x-input label="Contact Number" wire:model="contact_number"/>
                                </div>
                                <div class="col-span-1 p-4">
                                <x-select label="Gender" class="text-sm" wire:model="gender">
                                    <x-select.option label="Male" value="Male" />
                                    <x-select.option label="Female" value="Female" />
                                </x-select>
                                </div>
                                <div class="col-span-1 p-4">
                                    <x-input label="Religion" wire:model="religion"/>
                                </div>
                                <div class="col-span-1 p-4">
                                    <x-input label="Tribe" wire:model="tribe" />
                                </div>
                                <x-button class="mt-5 col-span-3" emerald label="Save" x-on:confirm="{
                                    title: 'Are you sure you want to save these information?',
                                    icon: 'warning',
                                    method: 'save_info',
                                    params: 1
                                }" spinner="save_info" />
                                @else
                                <span class="col-span-3 sm:text-sm md:text-3xl text-green-600 tracking-widest font-medium font-sans">You have already filled up your information</span>
                                <div class="col-span-3 grid grid-cols-2 mt-5 space-y-3">
                                    <div >
                                        <span class="sm:text-sm md:text-xl font-medium font-sans">Name :
                                            {{strtoupper($record->applicant_info->first_name.' '.$record->applicant_info->middle_name.' '.$record->applicant_info->last_name)}}
                                        </span>
                                    </div>
                                    <div >
                                        <span class="sm:text-sm md:text-xl font-medium font-sans">Birthplace : {{$record->applicant_info->birthplace}}</span>
                                    </div>
                                    <div>
                                        <span class="sm:text-sm md:text-xl font-medium font-sans">Birthdate :
                                            {{\Carbon\Carbon::parse($record->applicant_info->birthday)->format('F d, Y')}}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="sm:text-sm md:text-xl font-medium font-sans">Age :
                                            {{ \Carbon\Carbon::parse($record->applicant_info->birthday)->diffInYears() }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="sm:text-sm md:text-xl font-medium font-sans">Present Address : {{$record->applicant_info->present_address}}</span>
                                    </div>
                                    <div>
                                        <span class="sm:text-sm md:text-xl font-medium font-sans">Permanent Address : {{$record->applicant_info->permanent_address}}</span>
                                    </div>
                                    <div>
                                        <span class="sm:text-sm md:text-xl font-medium font-sans">Contact Number : {{$record->applicant_info->contact_number}}</span>
                                    </div>
                                    <div>
                                        <span class="sm:text-sm md:text-xl font-medium font-sans">Gender : {{$record->applicant_info->gender}}</span>
                                    </div>
                                    <div>
                                        <span class="sm:text-sm md:text-xl font-medium font-sans">Religion : {{$record->applicant_info->religion}}</span>
                                    </div>
                                    <div>
                                        <span class="sm:text-sm md:text-xl font-medium font-sans">Tribe : {{$record->applicant_info->tribe}}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    @elseif ($step === 2)
                        <!-- Step 2 -->
                        <div>
                            @if($record->program_id === null)
                           <span class="sm:text-sm md:text-2xl text-green-600 tracking-wide font-medium font-sans uppercase">Kindly tick the campus and course you are qualified to enroll</span>
                           @else
                           <span class="sm:text-sm md:text-3xl text-green-600 tracking-widest font-medium font-sans uppercase">You have already selected a course</span>
                           @endif
                           <div class="flex justify-around mt-10 space-x-4">
                            @if($record->program_id === null)
                            {{-- <x-select label="Select Campus" disabled placeholder="Select one" wire:model="campus_id" class="w-full">
                                @foreach ($campuses as $campus)
                                <x-select.option label="{{$campus->name}}" value="{{$campus->id}}" />
                                @endforeach
                                </x-select> --}}
                                <x-select searchable label="Select Course" placeholder="Select one" wire:model="course_id" class="w-full">
                                @foreach ($courses as $course)
                                <x-select.option label="{{$course->name}}" value="{{$course->id}}" />
                                @endforeach
                                </x-select>
                            @endif

                           </div>
                           @if ($record->program_id === null)
                           <div class="mt-16 space-y-3">
                            <div>
                                <span class="text-xl font-medium font-sans">Campus : {{$campus_name}}</span>
                               </div>
                               <div>
                                <span class="text-xl font-medium font-sans">Course : {{$course_name}}</span>
                               </div>
                           </div>
                           @else
                           <div class="mt-16 space-y-3">
                            <div>
                                <span class="text-xl font-medium font-sans">Campus : {{$record->program->campus->name}}</span>
                               </div>
                               <div>
                                <span class="text-xl font-medium font-sans">Course : {{$record->program->name}}</span>
                               </div>
                           </div>
                           @endif

                           @if($record->program_id === null)
                           <x-button class="mt-10 w-full" emerald label="Save" x-on:confirm="{
                            title: 'Are you sure you want to save these selections?',
                            icon: 'warning',
                            method: 'save_course',
                            params: 1
                        }" spinner="save_course" />
                        @endif
                        </div>
                    @elseif ($step === 3)
                        <!-- Step 3 -->
                        <div>
                            <span class="sm:text-sm md:text-3xl text-green-600 tracking-wide font-medium font-sans">Conformation of Enrollment Form (CEF)</span>
                            <div class="mt-10 space-x-8">
                                <span class="sm:text-sm md:text-3xl text-gray-700 tracking-wide font-medium font-sans ">Download the form</span>
                                <a href="#" wire:click="downloadCEF" class="sm:text-sm md:text-3xl text-green-600 tracking-wide font-medium font-sans underline cursor-pointer">Click to download</a>
                                <div class="mt-5  text-xl text-gray-500 tracking-wide font-medium font-sans">
                                    <span>Please confirm your intention to enroll as SKSU for this upcoming school year by completing<br> this form and uploading it through this platform</span>
                                </div>
                            </div>
                            @if ($record->attachments->count() === 0)
                            <div class="mt-10 space-x-8">
                                <span class="sm:text-sm md:text-3xl text-gray-700 tracking-wide font-medium font-sans ">Upload Document</span>
                                <div class="mt-5 bg-gray-100 p-4 rounded-lg">
                                        {{$this->form}}
                                </div>
                            </div>
                            @else
                            <div class="mt-10">
                                <span class="sm:text-sm md:text-xl text-green-600 tracking-widest font-medium font-sans uppercase">
                                    You have already uploaded your Conformation of Enrollment Form(CEF)
                                </span>
                            </div>

                            @endif

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
                        @if ($record->attachments->count() === 0)
                        <button wire:click="submitApplication" class="px-4 py-4 bg-green-400 text-white rounded-lg text-lg w-32 ml-10">Submit</button>
                        @else
                        <button wire:click="logOut" class="px-4 py-4 bg-red-600 text-white rounded-lg text-lg w-32 ml-10 tracking-wide">EXIT</button>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
