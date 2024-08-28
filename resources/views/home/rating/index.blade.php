@extends('home.layout')
@section('content')
<main>
    <section class="px-5 mt-5 pb-1 flex flex-row flex-wrap items-start justify-center gap-5">
        <h1 class="ribbon text-3xl font-bold uppercase drop-shadow-lg"><span><p class="announcement-text">Welcome to Barril Private Resort</p></span></h1>
    </section>



    <section class="p-5 rounded-sm flex flex-col flex-wrap items-center justify-center w-full gap-5">
        <article>
            <a  class="py-2 px-3 hover:bg-sky-600 bg-sky-700 text-white rounded-md shadow-md" href="{{ route('home') }}">Back</a>
        </article>
        <article>
            <p  class="text-3xl text-slate-600 font-bold">Our reviews from client ( {{ number_format($count) }} )</p>
        </article>
        <article class="flex p-5 gap-4 flex-wrap items-center justify-center h-[900px]  flex-row" id="olFoodList" style="overflow-y: scroll;">
         @foreach ($ratings as $rating)
            <div class="w-full p-6 border  border-slate-300 dark:bg-gray-800 dark:border-gray-700 rounded-xl" style="box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;">
                <div class="text-lg flex justify-end items-center gap-2">
                    <div class="img-star italic text-slate-600 fonmt-bold">{{ $rating->booking->user->name }}</div>
                    <img class="object-fit w-10" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSIn-gE6j6sjvg0ekFgFBIzVP5VdN3aBu9dLg&usqp=CAU" alt="">
                </div>
                <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">{{ $rating->comment->comments }}</p>
                <ul class="list-none bg-white w-full text-xl">
                    <li class="px-3 flex justify-start">
                        <span class="font-bold mr-[20px]">Room</span>
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
                        <span class="font-bold mr-[28px]">Food</span>
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
                        <span class="font-bold mr-[35px]">Pool</span>
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
                        <span class="font-bold mr-[30px]">Staff</span>
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
                        <small> <i class="font-bold">Date booked at</i><small> <span class="font-medium">{{ date('M d, Y  h:i:s a',strtotime($rating->booked_at)) }}</span> (  </small>   <span class="font-medium">{{ \Carbon\Carbon::parse($rating->booked_at)->diffForHumans() }}</span> ) </small>
                      {{-- <small> <i>Date booked at</i>  <span class="font-medium">{{ date('M d, Y  H:i:a',strtotime($rating->booked_at)) }}</span></small> --}}
                    </li>
                </ul>
            </div>
         @endforeach
        </article>
    </section>

</main>
@endsection
