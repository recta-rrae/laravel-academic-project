@extends('layouts.main')

<style>
    /* .content-table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        min-width: 400px;
        border-radius: 5px 5px 0 0;
        overflow: hidden;
    }

    .content-table thead tr {
        background-color: rgb(77, 224, 205);
        color: #ffffff;
        text-align: left;
        font-weight: bold;
    }

    .content-table tbody tr{
        border-bottom: 1px solid #dddddd;
    } */

    .content-table tbody tr:nth-of-type(even) {
        background-color: #e7e7e7;
    }

    /* .content-table tbody tr:last-of-type {
        background-color: #f3f3f3;
        border-bottom: 2px solid rgb(51, 150, 137)
    } */
</style>

@section('content')

<div class="flex flex-col h-screen overflow-y-auto border-b-8 border-teal-500 rounded-b-md w-full">

  <div class="flex flex-row justify-between bg-white mx-2 my-2 rounded-md">
    
    <div class="flex"> 
      <h1 class="font-bold text-black text-xl mx-10 my-5">
        All Reports
      </h1>
      @if(session()->has('success'))
      <div id="alert-1" class="flex p-4 my-auto bg-green-300 rounded-lg dark:bg-green-300" role="alert">
        <svg class="flex-shrink-0 w-5 h-5 text-black my-auto" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
        <div class="ml-3 text-sm font-medium text-black my-auto">
          {{ session('success') }}
        </div>
        <button type="button" class="mx-1.5 my-auto bg-green-200 text-green-500 rounded-lg focus:ring-2 focus:ring-green-600 p-1.5 hover:bg-green-400 inline-flex h-8 w-8" data-collapse-toggle="alert-1" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
      </div>
      @endif  
    </div>

    <div class="flex flex-row">
    <form action="/reports/create" method="GET" class="my-auto mx-5">
      @csrf
      <button class="text-white font-bold px-5 bg-teal-400 py-2 transition ease-in rounded-md hover:shadow-sm hover:-translate-y-[2px] hover:bg-teal-500"><i class="fa fa-plus leading-none md:text-xs lg:text-xs text-white"></i> Add</button>
    </form>
    </div>

  </div>

  @if($reports->isEmpty())
  <center class="my-auto">
    <h1 class="text-xl">No Reports yet.</h1>
  </center>
  @else
  <div class="overflow-y-auto">
  <table class="content-table bg-gray-100 w-full h-min">
    <thead class="bg-teal-500" style="position: sticky; top: 0; z-index: 1;">  
      <tr class="text-white">
        <th class="text-center px-8 text-sm py-2">Id</th>
        <th class="text-center pr-5 text-sm py-2">Student ID</th>
        <th class="text-center pr-5 text-sm py-2">Subject ID</th>
        <th class="text-center px-5 text-sm py-2">Nama Siswa</th>
        <th class="text-center px-5 text-sm py-2">Semester</th>
        <th class="text-center px-5 text-sm py-2">Actions</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
        <tr>
          <td class="text-center px-8 py-2 text-xs md:text-sm font-bold md:font-semibold">{{ $report->id }}</td>
          <td class="text-center pr-5 py-2 text-xs md:text-sm font-bold md:font-semibold">{{ $report->student_id }}</td>
          <td class="text-center px-8 py-2 text-xs md:text-sm font-bold md:font-semibold">{{ $report->subject_id }}</td>
          <td class="text-center px-5 py-2 text-xs md:text-sm font-bold md:font-semibold">{{ $report->student->nama }}</td>
          <td class="text-center px-5 py-2 text-xs md:text-sm font-bold md:font-semibold">{{ $report->semester }}</td>
          <td class="text-center px-5 py-2 text-xs md:text-sm font-bold md:font-semibold">
            <div class="flex flex-row gap-1 justify-center">
              <a href="/reports/{{ $report->id }}" class="font-bold text-white hover:shadow-sm hover:-translate-y-1 hover:bg-teal-500 transition ease-in text-xs bg-teal-400 rounded-md my-3 px-3 py-1"><i class="fas fa-eye leading-none text-white text-[15px] md:text-lg lg:text-lg xl:text-lg"></i></a>
              <a href="/reports/{{ $report->id }}/edit" class="font-bold text-white hover:shadow-sm hover:-translate-y-1 hover:bg-orange-400 transition ease-in text-xs bg-orange-300 rounded-md my-3 px-3 py-1"><i class="fas fa-pencil leading-none text-white text-[15px] md:text-lg lg:text-lg xl:text-lg"></i></a>
              <form action="/reports/{{ $report->id }}" method="POST" class="my-3" onclick="return confirm('Delete report?')">
                @method('delete')
                @csrf
                <button type="submit" class="font-bold text-white hover:shadow-sm hover:-translate-y-1 hover:bg-red-500 transition ease-in text-xs bg-red-400 rounded-md px-3 py-1"><i class="fas fa-trash leading-none text-white text-[15px] md:text-lg lg:text-lg xl:text-lg"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div>
  @endif
</div>
@endsection