@extends('home.layout')
@section('content')
<main>

    <div class="hero-bg-picture md:h-[250px] xl:h-[700px] xs:h-[150px] xxs:h-[200px]">

    </div>
    <section  class="xl:mb-10 xl:relative xl:pt-[500px] md:pt-[180px] xs:pt-[120px] xxs:pt-[130px]" id="eventLists">
        <div class="shadow-owl">
            <div class="owl-carousel owl-theme">
                <a href="#" class="item">
                    <img class="carousel-img xxs:h-[180px] xs:h-[180px] md:w-[120px] md:h-[150px]  lg:h-[220px] xl:w-[300px] xl:h-[500px] " src="{{ asset('images/home/announcement/a.jpg') }}" alt="">
                </a>
                <a href="#" class="item">
                    <img class="carousel-img xxs:h-[180px] xs:h-[180px] md:w-[120px] md:h-[150px]  lg:h-[220px] xl:w-[300px] xl:h-[500px] " src="{{ asset('images/home/announcement/b.jpg') }}" alt="">
                </a>
                <a href="#" class="item">
                    <img class="carousel-img xxs:h-[180px] xs:h-[180px] md:w-[120px] md:h-[150px]  lg:h-[220px] xl:w-[300px] xl:h-[500px] " src="{{ asset('images/home/announcement/c.jpg') }}" alt="">
                </a>
                <a href="#" class="item">
                    <img class="carousel-img xxs:h-[180px] xs:h-[180px] md:w-[120px] md:h-[150px]  lg:h-[220px] xl:w-[300px] xl:h-[500px] " src="{{ asset('images/home/announcement/d.jpg') }}" alt="">
                </a>
                <a href="#" class="item">
                    <img class="carousel-img xxs:h-[180px] xs:h-[180px] md:w-[120px] md:h-[150px]  lg:h-[220px] xl:w-[300px] xl:h-[500px] " src="{{ asset('images/home/announcement/e.jpg') }}" alt="">
                </a>
                <a href="#" class="item">
                    <img class="carousel-img xxs:h-[180px] xs:h-[180px] md:w-[120px] md:h-[150px]  lg:h-[220px] xl:w-[300px] xl:h-[500px] " src="{{ asset('images/home/announcement/f.jpg') }}" alt="">
                </a>
                <a href="#" class="item">
                    <img class="carousel-img xxs:h-[180px] xs:h-[180px] md:w-[120px] md:h-[150px]  lg:h-[220px] xl:w-[300px] xl:h-[500px] " src="{{ asset('images/home/announcement/g.jpg') }}" alt="">
                </a>
                <a href="#" class="item">
                    <img class="carousel-img xxs:h-[180px] xs:h-[180px] md:w-[120px] md:h-[150px] lg:h-[220px] xl:w-[300px] xl:h-[500px] " src="{{ asset('images/home/announcement/h.jpg') }}" alt="">
                </a>
                <a href="#" class="item">
                    <img class="carousel-img xxs:h-[180px] xs:h-[180px] md:w-[120px] md:h-[150px] lg:h-[220px] xl:w-[300px] xl:h-[500px] " src="{{ asset('images/home/announcement/i.jpg') }}" alt="">
                </a>
                <a href="#" class="item">
                    <img class="carousel-img xxs:h-[180px] xs:h-[180px] md:w-[120px] md:h-[150px] lg:h-[220px] xl:w-[300px] xl:h-[500px] " src="{{ asset('images/home/announcement/j.jpg') }}" alt="">
                </a>
            </div>
        </div>
    </section>
    <section class="px-5 mt-5 pb-1 md:mt-3 md:pb-0 flex flex-row flex-wrap items-start justify-center gap-5 xs:gap-1">
        <h1 class="ribbon xl:text-3xl md:text-md font-bold uppercase drop-shadow-lg xs:text-sm"><span><p class="announcement-text">Welcome to Barril Private Resort</p></span></h1>
    </section>

    <section id="bookNowApp" class="p-5 xl:my-5 md:my-0 flex flex-row flex-wrap items-center justify-center w-full gap-5">
        <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row w-full  dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700  xs:flex-col">
            <img class="object-cover w-full rounded-t-lg xl:h-80 xl:w-80 md:h-40  md:w-50 md:rounded-none md:rounded-l-lg xs:w-50 xs:h-50" src="{{ asset('images/gallery/1.jpg') }}" alt="">
            <div class="flex flex-col justify-between p-4 gap-3 leading-normal">
                <p class="mb-3 font-normal xl:text-2xl  md:text-md xs:text-sm xs:font-bold">Reserve Your Spot</p>
                <a href="{{ route('home.bookings.index') }}" class="mb-2 xl:text-2xl md:text-lg xs:text-lg xxs:text-lg font-bold tracking-tight text-gray-900 dark:text-white xs:px-2 md:w-full"><span class="bg-blue-600 text-white xl:px-6 md:px-3  rounded-md xl:py-3 xl:my-3 md:py-1 md:my-2 shadow-md xs:px-2 hover:bg-blue-700 xs:py-2 xxs:py-2 xxs:px-2">Book your Visit Now <i class="fa fa-book-open"></i></span></a>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 md:text-md xl:text-xl">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Commodi officia officiis quae voluptate cum qui, voluptates blanditiis iste praesentium aspernatur exercitationem, fugiat numquam. Aperiam id adipisci error itaque iure ipsum.</p>
            </div>
        </div>
    </section>

   @if($announcement!==null)
    <a href="{{ route('home.announcement.index') }}">
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
                <span class="md:text-md xl:text-lg xs:text-md font-bold">{{ date('M',strtotime($announcement->due_at??'')) }}</span>
                <h1 class="md:text-2xl xl:text-6xl xs:text-md font-bold">{{ date('d',strtotime($announcement->due_at??'')) }}</h1>
                <span class="md:text-textmd xl:text-lg xs:text-md font-bold">{{ date('Y',strtotime($announcement->due_at??'')) }}</span>
                </div>
                <div>
                    <span class="  border-l-4 border-green-700"></span>
                    <div class="my-3text-slate-700  font-bold">
                        <h5 class=" xl:text-2xl xl:text-lg xs:text-md tracking-tight"> Pool Promos !</h5>
                        <small class="ml-2"><i>Date Posted : {{ date('M d, Y h:i: a',strtotime($announcement->due_at??'')) }}</i></small>
                    </div>
                <div class="xl:my-4 md:my-1 font-norma px-7 text-start py-3 whitespace-pre-line dark:text-gray-400 indent-7 text-slate-700 md:text-sm xl:text-xl xs:text-sm" style="font-weight: 500;">
                    <p class="font-bold uppercase">{{ $announcement->title }}</p>
                    <p class="indent-7">   {{ $announcement->description }}</p>
                </div>
                </div>
            </div>
        </div>
    </section>
</section>
</a>
   @endif

    <section class="p-5 rounded-sm flex flex-col flex-wrap items-center justify-center w-full gap-5">
        <article class="flex flex-col items-center">
            <p class="xl:text-3xl md:text-lg text-slate-600 font-bold">Reviews</p>
            <a href="{{ route('home.rating.index') }}" class="xl:text-md sm:text-sm  text-blue-500"><span class="underline">Show all reviews</span> ( {{ number_format($count) }} )</a>
        </article>
        <article class="flex gap-4 xl:flex-row lg:flex-row md:flex-col xs:flex-col xxs:flex-col">
          @foreach ($ratings as $rating)
            <div class="xl:max-w-sm md:max-w-xs xs:p-5 xxs:p-5 xl:p-6 md:p-3 border  border-slate-300 dark:bg-gray-800 dark:border-gray-700 rounded-xl" style="box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;">
                <div class="xl:text-lg md:text-md flex justify-end items-center gap-2">
                    <div class="img-star italic text-slate-600 fonmt-bold">{{ $rating->booking->user->name }}</div>
                    <img class="object-fit w-10" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSIn-gE6j6sjvg0ekFgFBIzVP5VdN3aBu9dLg&usqp=CAU" alt="">
                </div>
                <p class="mb-3 font-normal xl:text-lg md:text-sm text-gray-500 dark:text-gray-400">{{ $rating->comment->comments }}</p>
                <ul class="list-none bg-white w-full text-xl">
                    <li class="px-3 flex justify-start">
                        <span class="font-bold mr-[20px] md:mt-1 xl:text-xl md:text-sm xs:text-sm xs:mt-1 xxs:text-sm xxs:mt-1">Room</span>
                        <span class="mr-2"> : </span>
                        <span>
                          @switch($rating->room->star)
                               @case(5)
                                    <div class="rate1">
                                        <label class="checked">5 stars</label>
                                        <label class="checked">4 stars</label>
                                        <label class="checked">3 stars</label>
                                        <label class="checked">2 stars</label>
                                        <label class="checked">1 star</label>
                                    </div>
                                @break
                                @case(4)
                                    <div class="rate1">
                                        <label  class="notchecked">5 stars</label>
                                        <label  class="checked">4 stars</label>
                                        <label  class="checked">3 stars</label>
                                        <label class="checked">2 stars</label>
                                        <label class="checked">1 star</label>
                                    </div>
                                @break
                                @case(3)
                                    <div class="rate1">
                                        <label  class="notchecked">5 stars</label>
                                        <label  class="notchecked">4 stars</label>
                                        <label  class="checked">3 stars</label>
                                        <label class="checked">2 stars</label>
                                        <label class="checked">1 star</label>
                                    </div>
                                @break
                                @case(2)
                                    <div class="rate1">
                                        <label  class="notchecked">5 stars</label>
                                        <label  class="notchecked">4 stars</label>
                                        <label  class="notchecked">3 stars</label>
                                        <label class="checked">2 stars</label>
                                        <label class="checked">1 star</label>
                                    </div>
                                @break
                                @case(1)
                                    <div class="rate1">
                                        <label  class="notchecked">5 stars</label>
                                        <label  class="notchecked">4 stars</label>
                                        <label  class="notchecked">3 stars</label>
                                        <label class="notchecked">2 stars</label>
                                        <label class="checked">1 star</label>
                                    </div>
                                @break
                              @default
                                <span>error</span>
                          @endswitch
                        </span>
                    </li>
                    <li class="px-3 flex justify-start">
                        <span class="font-bold mr-[28px] md:mt-1 xl:text-xl md:text-sm xs:text-sm xs:mt-1 xxs:text-sm xxs:mt-1">Food</span>
                        <span class="mr-2"> : </span>
                        <span>
                            @switch($rating->food->star)
                                 @case(5)
                                      <div class="rate2">
                                          <label class="checked">5 stars</label>
                                          <label class="checked">4 stars</label>
                                          <label class="checked">3 stars</label>
                                          <label class="checked">2 stars</label>
                                          <label class="checked">1 star</label>
                                      </div>
                                  @break
                                  @case(4)
                                      <div class="rate1">
                                          <label  class="notchecked">5 stars</label>
                                          <label  class="checked">4 stars</label>
                                          <label  class="checked">3 stars</label>
                                          <label class="checked">2 stars</label>
                                          <label class="checked">1 star</label>
                                      </div>
                                  @break
                                  @case(3)
                                      <div class="rate1">
                                          <label  class="notchecked">5 stars</label>
                                          <label  class="notchecked">4 stars</label>
                                          <label  class="checked">3 stars</label>
                                          <label class="checked">2 stars</label>
                                          <label class="checked">1 star</label>
                                      </div>
                                  @break
                                  @case(2)
                                      <div class="rate1">
                                          <label  class="notchecked">5 stars</label>
                                          <label  class="notchecked">4 stars</label>
                                          <label  class="notchecked">3 stars</label>
                                          <label class="checked">2 stars</label>
                                          <label class="checked">1 star</label>
                                      </div>
                                  @break
                                  @case(1)
                                      <div class="rate1">
                                          <label  class="notchecked">5 stars</label>
                                          <label  class="notchecked">4 stars</label>
                                          <label  class="notchecked">3 stars</label>
                                          <label class="notchecked">2 stars</label>
                                          <label class="checked">1 star</label>
                                      </div>
                                  @break
                                @default
                                  <span>error</span>
                            @endswitch
                          </span>
                    </li>
                    <li class="px-3 flex justify-start">
                        <span class="font-bold mr-[35px] md:mt-1 xl:text-xl md:text-sm xs:text-sm xs:mt-1 xxs:text-sm xxs:mt-1">Pool</span>
                        <span class="mr-2"> : </span>
                        <span>
                            @switch($rating->pool->star)
                                 @case(5)
                                      <div class="rate3">
                                          <label class="checked">5 stars</label>
                                          <label class="checked">4 stars</label>
                                          <label class="checked">3 stars</label>
                                          <label class="checked">2 stars</label>
                                          <label class="checked">1 star</label>
                                      </div>
                                  @break
                                  @case(4)
                                      <div class="rate1">
                                          <label  class="notchecked">5 stars</label>
                                          <label  class="checked">4 stars</label>
                                          <label  class="checked">3 stars</label>
                                          <label class="checked">2 stars</label>
                                          <label class="checked">1 star</label>
                                      </div>
                                  @break
                                  @case(3)
                                      <div class="rate1">
                                          <label  class="notchecked">5 stars</label>
                                          <label  class="notchecked">4 stars</label>
                                          <label  class="checked">3 stars</label>
                                          <label class="checked">2 stars</label>
                                          <label class="checked">1 star</label>
                                      </div>
                                  @break
                                  @case(2)
                                      <div class="rate1">
                                          <label  class="notchecked">5 stars</label>
                                          <label  class="notchecked">4 stars</label>
                                          <label  class="notchecked">3 stars</label>
                                          <label class="checked">2 stars</label>
                                          <label class="checked">1 star</label>
                                      </div>
                                  @break
                                  @case(1)
                                      <div class="rate1">
                                          <label  class="notchecked">5 stars</label>
                                          <label  class="notchecked">4 stars</label>
                                          <label  class="notchecked">3 stars</label>
                                          <label class="notchecked">2 stars</label>
                                          <label class="checked">1 star</label>
                                      </div>
                                  @break
                                @default
                                  <span>error</span>
                            @endswitch
                          </span>
                    </li>
                    <li class="px-3 flex justify-start">
                        <span class="font-bold mr-[30px] md:mt-1 xl:text-xl md:text-sm xs:text-sm xs:mt-1 xxs:text-sm xxs:mt-1">Staff</span>
                        <span class="mr-2"> : </span>
                        <span>
                            @switch($rating->staff->star)
                                 @case(5)
                                      <div class="rate4">
                                          <label class="checked">5 stars</label>
                                          <label class="checked">4 stars</label>
                                          <label class="checked">3 stars</label>
                                          <label class="checked">2 stars</label>
                                          <label class="checked">1 star</label>
                                      </div>
                                  @break
                                  @case(4)
                                      <div class="rate1">
                                          <label  class="notchecked">5 stars</label>
                                          <label  class="checked">4 stars</label>
                                          <label  class="checked">3 stars</label>
                                          <label class="checked">2 stars</label>
                                          <label class="checked">1 star</label>
                                      </div>
                                  @break
                                  @case(3)
                                      <div class="rate1">
                                          <label  class="notchecked">5 stars</label>
                                          <label  class="notchecked">4 stars</label>
                                          <label  class="checked">3 stars</label>
                                          <label class="checked">2 stars</label>
                                          <label class="checked">1 star</label>
                                      </div>
                                  @break
                                  @case(2)
                                      <div class="rate1">
                                          <label  class="notchecked">5 stars</label>
                                          <label  class="notchecked">4 stars</label>
                                          <label  class="notchecked">3 stars</label>
                                          <label class="checked">2 stars</label>
                                          <label class="checked">1 star</label>
                                      </div>
                                  @break
                                  @case(1)
                                      <div class="rate1">
                                          <label  class="notchecked">5 stars</label>
                                          <label  class="notchecked">4 stars</label>
                                          <label  class="notchecked">3 stars</label>
                                          <label class="notchecked">2 stars</label>
                                          <label class="checked">1 star</label>
                                      </div>
                                  @break
                                @default
                                  <span>error</span>
                            @endswitch
                          </span>
                    </li>
                    <li class="px-1 text-slate-600 flex justify-start">
                      <small class="xl:text-md md:text-sm"><i>Date booked at</i>  <span class="font-medium">{{ date('M d, Y  H:i:a',strtotime($rating->booked_at)) }}</span></small>
                    </li>
                </ul>
            </div>
          @endforeach
        </article>
    </section>


    {{-- <section class="flex flex-row gap-5 mt-20" id="eventGallery">
        <article class="relative">
            <div class="ribbon">
                <span class="ribbon2">G<br>A<br>L<br>L<br>E<br>R<br>I<br>E<br>S</span>
            </div>
        </article>
        <article  class="wrapper-gallery">
            <img class="our-gallery w-[300px] h-[300px]" src="{{ asset('images/gallery/1.jpg') }}" alt="Bolinao 10/7/2023">
            <img class="our-gallery w-[300px] h-[300px]" src="{{ asset('images/gallery/2.jpg') }}" alt="Bolinao 10/7/2023">
            <img class="our-gallery w-[300px] h-[300px]" src="{{ asset('images/gallery/3.jpg') }}" alt="Bolinao 10/7/2023">
            <img class="our-gallery w-[300px] h-[300px]" src="{{ asset('images/gallery/4.jpg') }}" alt="Bolinao 10/7/2023">
            <img class="our-gallery w-[300px] h-[300px]" src="{{ asset('images/gallery/5.jpg') }}" alt="Bolinao 10/7/2023">
            <img class="our-gallery w-[300px] h-[300px]" src="{{ asset('images/gallery/6.jpg') }}" alt="Bolinao 10/7/2023">
            <img class="our-gallery w-[300px] h-[300px]" src="{{ asset('images/gallery/7.jpg') }}" alt="Bolinao 10/7/2023">
            <img class="our-gallery w-[300px] h-[300px]" src="{{ asset('images/gallery/8.jpg') }}" alt="Bolinao 10/7/2023">
            <img class="our-gallery w-[300px] h-[300px]" src="{{ asset('images/gallery/9.jpg') }}" alt="Bolinao 10/7/2023">
            <img class="our-gallery w-[300px] h-[300px]" src="{{ asset('images/gallery/10.jpg') }}" alt="Bolinao 10/7/2023">
        </article>
        <article class="relative">
            <div class="ribbon">
                <a href="#" class="ribbon3"><span class="bg-green-600 py-1 px-2 rounded-lg shadow-md hover:bg-green-700">View All Gallery</span></a>
            </div>
            <div class="ribbon">
                <a href="#" class="ribbon4"><span class="bg-green-600 py-1 px-2 rounded-lg shadow-md hover:bg-green-700">Recent Album</span></a>
            </div>
        </article>
    </section> --}}
</main>
@endsection
