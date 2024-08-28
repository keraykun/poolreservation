@extends('home.layout')
@section('content')

<main>
    <section class="bg-[url('/public/images/events/camp_event.jpg')] relative bg-cover bg-center h-[500px]">
        <div class="w-full h-full absolute inset-0 bg-green-700 opacity-[0.30]"></div>
        <div class="w-full h-full flex justify-center items-center  bg-blend-multiply">
            <div class="flex flex-col text-center gap-2">
            <h1 style="text-shadow: 2px 4px 3px rgba(0,0,0,0.3);" class="text-white text-5xl font-bold uppercase drop-shadow-lg">Barangay Camp 1<span class="text-green-500"> Events</span></h1>
            </div>
        </div>
    </section>
    <section class="p-5 cursor-grab flex flex-col flex-wrap items-start  justify-start w-full gap-5" >

        <article class="w-full border border-gray-200 drop-shadow-md rounded-lg  bg-[url('/public/images/issuance/eventchild.png')] bg-[length:300px_300px]  bg-center flex-col"  style="background-repeat: repeat-x; background-blend-mode: soft-light; background-color: rgb(124, 182, 124);">
           <section class="hover-event-image flex gap-x-[45px] p-[10px]">
                <div class="w-[700px] h-[700px] p-1 rounded-lg" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                    <img class="w-full rounded-md h-full" src="{{ asset('images/home/announcement/aaa.jpg') }}" alt="">
                </div>
               <article class="flex-stretch w-full">
                    <article class="flex items-center justify-between">
                        <h1 class="text-3xl mt-3 pt-20 text-shadow-black-white font-bold text-white">Inter-Purok Basketball Tournament</h1>
                        <p class="date-ribbon">December 26, 2023 - December 10, 2023</p>
                    </article>
                    <p class="mt-2 text-lg text-shadow-black-white text-white  whitespace-pre-line font-bold">
                        Qualification
                        - must be 15 years old                            - must be 15 years old
                        - must be resident of the barangay          - must be resident of the barangay
                        - must besss                                           - must besss
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dignissimos magnam fugit nisi facilis magni? Dolore nihil delectus, doloremque harum magnam exercitationem non, dolores quas vitae sunt, tempora voluptatibus id nobis.
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius nemo officia obcaecati autem nihil? Facilis similique aspernatur a iusto iure adipisci qui soluta necessitatibus, maiores hic praesentium minima quaerat veniam.
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius nemo officia obcaecati autem nihil? Facilis similique aspernatur a iusto iure adipisci qui soluta necessitatibus, maiores hic praesentium minima quaerat veniam.
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius nemo officia obcaecati autem nihil? Facilis similique aspernatur a iusto iure adipisci qui soluta necessitatibus, maiores hic praesentium minima quaerat veniam.
                    </p>
                </article>
           </section>
        </article>
        <a href="{{ route('home.events.index') }}" style="background: #162641;" class="px-5 py-3 rounded-md text-white drop-shadow-md  ">Back</a>
    </section>
</main>
@endsection
