@extends('home.layout')
@section('content')
<main>
    <section class="bg-[url('/public/images/gallery/logo.jpg')] mb-5 relative bg-cover bg-center h-[500px]">
        <div class="w-full h-full absolute inset-0 bg-blue-900 opacity-[0.50]"></div>
        <div class="w-full h-full flex justify-center items-center  bg-blend-multiply">
            <div class="flex flex-col text-center gap-2">
            <h1 style="text-shadow: 2px 4px 3px rgba(0,0,0,0.3);" class="text-white text-5xl font-bold uppercase drop-shadow-lg barril-private-text">Barril's Private <span class="text-sky-300 text-5xl"> Resort</span></h1>
            </div>
        </div>
    </section>
    <section class="flex flex-col flex-wrap  justify-start w-full" >
        @foreach ($announcements as $announcement)
        <section class="p-5 rounded-sm flex flex-row flex-wrap items-center justify-center w-full gap-5 xs:m-h-min">
            <section class="p-5 rounded-sm flex flex-row flex-wrap items-center justify-center w-full gap-5">
                <div class="bg-white border border-gray-200 drop-shadow-md w-full">
                    <div class="xl:h-[120px]  md:h-20">
                        <div class="xl:text-2xl xl:text-lg font-bold flex items-center drop-shadow-lg justify-start bg-sky-600 h-full backdrop-brightness-[0.85] w-full text-white uppercase" >
                            <img class="xl:w-64 md:w-32 xs:w-24 xxs:w-24" src="{{ asset('images/all/phone.png') }}" alt="">
                            <span class=" text-white recentannouncement-text">Latest Announcements</span>
                        </div>
                    </div>
                    <div class="p-4 flex items-start w-full rounded-xl xxs:flex-col lg:flex-row md:flex-row" >
                        <div class="mr-4 p-3 recentannouncement-text xxs:flex-row xxs:gap-2 xxs:my-2 lg:gap-0 xl:gap-0 md:gap-0  lg:my-0 xl:my-0 md:my-0  text-white flex md:flex-col xl:flex-col lg:flex-col items-center justify-center bg-yellow-500">
                        <span class="md:text-md xl:text-lg xs:text-md font-bold">{{ date('M',strtotime($announcement->due_at)) }}</span>
                        <h1 class="md:text-2xl xl:text-6xl xs:text-md font-bold">{{ date('d',strtotime($announcement->due_at)) }}</h1>
                        <span class="md:text-textmd xl:text-lg xs:text-md font-bold">{{ date('Y',strtotime($announcement->due_at)) }}</span>
                        </div>
                        <div>
                        <div href="#" class="flex gap-x-3">
                            <span class="  border-l-4 border-green-700"></span>
                            <div class="my-3text-slate-700  font-bold">
                                <h5 class=" xl:text-2xl xl:text-lg xs:text-md tracking-tight"> Pool Promos !</h5>
                                <small class="ml-2"><i>Date Posted : {{ date('M d, Y h:i: a',strtotime($announcement->due_at)) }}</i></small>
                            </div>
                        </div>
                        <div></div>
                        <div class="xl:my-4 md:my-1 font-norma px-7 text-start py-3 whitespace-pre-line dark:text-gray-400  text-slate-700 md:text-sm xl:text-xl xs:text-sm" style="font-weight: 500;">
                            <p class="font-bold uppercase">{{ $announcement->title }}</p>
                            <p class="indent-7">   {{ $announcement->description }}</p>
                        </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
        @endforeach
        {{ $announcements->links('pagination.flowbite-paginate') }}
    </section>
</main>
@endsection
