<div>
    <div class="flex space-x-1">
      <div class="grid place-content-center">
        <img src="{{ asset('images/sksu1.png') }}" class="h-10" alt="">
      </div>
      <div>
        <h1 class="text-xl font-bold text-gray-700"> SULTAN KUDARAT STATE UNIVERISTY</h1>
        <h1>PRE-REGISTRATION</h1>
      </div>
    </div>
    <div class="mt-10 flex justify-end">
        <span class="text-lg mt-5 text-center font-bold text-gray-700 underline">Total Students : {{$applied_students->count()}}</span>
    </div>

    <h1 class="text-xl mt-5 text-center font-bold text-gray-700">APPLIED STUDENTS</h1>
    @if ($campus_name)
    <h1 class="text-lg mt-3 text-center font-bold text-gray-500">{{$campus_name}}</h1>
    @else
    <h1 class="text-lg mt-3 text-center font-bold text-gray-500">All Campuses</h1>
    @endif
    @if ($course_name)
    <h1 class="text-lg text-center font-bold text-gray-500">{{$course_name}}</h1>
    @else
    <h1 class="text-lg text-center font-bold text-gray-500">All Courses</h1>
    @endif
    <div class="mt-5 overflow-x-auto">
      <table id="example" class="table-auto mt-5" style="width:100%">
        <thead class="font-normal">
          <tr>
            <th class="border text-left whitespace-nowrap px-2 text-sm font-medium text-gray-500 py-2">EXAMINEE NUMBER</th>
            <th class="border text-left whitespace-nowrap px-2 text-sm font-medium text-gray-500 py-2">FULL NAME</th>
            <th class="border text-left whitespace-nowrap px-2 text-sm font-medium text-gray-500 py-2">CAMPUS</th>
            <th class="border text-left whitespace-nowrap px-2 text-sm font-medium text-gray-500 py-2">COURSE</th>
          </tr>
        </thead>
        <tbody class="">
          @foreach ($applied_students as $item)
            <tr>
              <td class="border text-gray-600 whitespace-nowrap  px-3  py-1">{{$item->examinee_number}}</td>
              <td class="border text-gray-600 whitespace-nowrap  px-3  py-1">{{strtoupper($item->name)}}</td>
              <td class="border text-gray-600  px-3  py-1">{{ $item->campus->name }}</td>
              <td class="border text-gray-600  px-3  py-1">{{ $item->program?->name }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
