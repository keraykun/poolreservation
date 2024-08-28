@extends('home.layout')
@section('content')
<main>
<style>
.rate1,.rate2,.rate3,.rate4 {
    float: left;
    height: 46px;
    padding: 0 10px;
}
.rate1:not(:checked) > input,
.rate2:not(:checked) > input,
.rate3:not(:checked) > input,
.rate4:not(:checked) > input {
    position:absolute;
    top:-9999px;
}
.rate1:not(:checked) > label,
.rate2:not(:checked) > label,
.rate3:not(:checked) > label,
.rate4:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate1:not(:checked) > label:before,
.rate2:not(:checked) > label:before,
.rate3:not(:checked) > label:before,
.rate4:not(:checked) > label:before {
    content: '★ ';
}
.rate1 > input:checked ~ label,
.rate2 > input:checked ~ label,
.rate3 > input:checked ~ label,
.rate4 > input:checked ~ label  {
    color: #ffc700;
}
.rate1:not(:checked) > label:hover,
.rate1:not(:checked) > label:hover ~ label {
    color: #deb217;
}
.rate2:not(:checked) > label:hover,
.rate2:not(:checked) > label:hover ~ label {
    color: #deb217;
}
.rate3:not(:checked) > label:hover,
.rate3:not(:checked) > label:hover ~ label {
    color: #deb217;
}
.rate4:not(:checked) > label:hover,
.rate4:not(:checked) > label:hover ~ label {
    color: #deb217;
}
.rate1 > input:checked + label:hover,
.rate1 > input:checked + label:hover ~ label,
.rate1 > input:checked ~ label:hover,
.rate1 > input:checked ~ label:hover ~ label,
.rate1 > label:hover ~ input:checked ~ label {
    color: #c59b08;
}

.rate2 > input:checked + label:hover,
.rate2 > input:checked + label:hover ~ label,
.rate2 > input:checked ~ label:hover,
.rate2 > input:checked ~ label:hover ~ label,
.rate2 > label:hover ~ input:checked ~ label {
    color: #c59b08;
}
.rate3 > input:checked + label:hover,
.rate3 > input:checked + label:hover ~ label,
.rate3 > input:checked ~ label:hover,
.rate3 > input:checked ~ label:hover ~ label,
.rate3 > label:hover ~ input:checked ~ label {
    color: #c59b08;
}
.rate4 > input:checked + label:hover,
.rate4 > input:checked + label:hover ~ label,
.rate4 > input:checked ~ label:hover,
.rate4 > input:checked ~ label:hover ~ label,
.rate4 > label:hover ~ input:checked ~ label {
    color: #c59b08;
}
textarea{
    border: none;
    outline: none;
    resize: none;
}
textarea:hover,
textarea:focus {
    border: none !important;
    outline: none !important;
    overflow: auto;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;

}
</style>
    @if (Auth::check())
    <div class="flex flex-col justify-center items-center w-full">
        <section  class="index-1 max-w-3xl text-slate-800 py-5 px-8 border border-sky-700 drop-shadow-md bg-white flex flex-col flex-wrap items-start justify-start w-full gap-5"  style="border-radius:10px; box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
        -webkit-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
        -moz-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);">
            <div class="flex flex-col items-start justify-start px-6 py-8 mx-auto lg:py-0 mt-5 text-3xl font-bold" >
                Rate our services
            </div>
                <div class="flex flex-col items-start justify-start px-3 py-8 mx-auto lg:py-0 mt-5" >
                    <form method="POST" action="{{ route('home.rating.store') }}">
                    <ul class="list-none bg-white w-full text-xl">
                        <li class="border-b-2 border-slate-300 py-2 px-3 flex justify-start">
                            <span class="font-bold mr-[60px]">Room</span>
                            <span class="mr-5"> : </span>
                            <span>
                                <div class="rate1">
                                    <input type="radio" id="room_star5" name="room" value="5" />
                                    <label for="room_star5" title="text">5 stars</label>
                                    <input type="radio" id="room_star4" name="room" value="4" />
                                    <label for="room_star4" title="text">4 stars</label>
                                    <input type="radio" id="room_star3" name="room" value="3" />
                                    <label for="room_star3" title="text">3 stars</label>
                                    <input type="radio" id="room_star2" name="room" value="2" />
                                    <label for="room_star2" title="text">2 stars</label>
                                    <input type="radio" id="room_star1" name="room" value="1" />
                                    <label for="room_star1" title="text">1 star</label>
                                </div>
                                @error('room')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </span>
                        </li>
                        <li class="border-b-2 border-slate-300 py-2 px-3 flex justify-start">
                            <span class="font-bold mr-[65px]">Food</span>
                            <span class="mr-5"> : </span>
                            <span>
                                <div class="rate2">
                                    <input type="radio" id="food_star5" name="food" value="5" />
                                    <label for="food_star5" title="text">5 stars</label>
                                    <input type="radio" id="food_star4" name="food" value="4" />
                                    <label for="food_star4" title="text">4 stars</label>
                                    <input type="radio" id="food_star3" name="food" value="3" />
                                    <label for="food_star3" title="text">3 stars</label>
                                    <input type="radio" id="food_star2" name="food" value="2" />
                                    <label for="food_star2" title="text">2 stars</label>
                                    <input type="radio" id="food_star1" name="food" value="1" />
                                    <label for="food_star1" title="text">1 star</label>
                                </div>
                            </span>
                            @error('food')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                        </li>
                        <li class="border-b-2 border-slate-300 py-2 px-3 flex justify-start">
                            <span class="font-bold mr-[70px]">Pool</span>
                            <span class="mr-5"> : </span>
                            <span>
                                <div class="rate3">
                                    <input type="radio" id="pool_star5" name="pool" value="5" />
                                    <label for="pool_star5" title="text">5 stars</label>
                                    <input type="radio" id="pool_star4" name="pool" value="4" />
                                    <label for="pool_star4" title="text">4 stars</label>
                                    <input type="radio" id="pool_star3" name="pool" value="3" />
                                    <label for="pool_star3" title="text">3 stars</label>
                                    <input type="radio" id="pool_star2" name="pool" value="2" />
                                    <label for="pool_star2" title="text">2 stars</label>
                                    <input type="radio" id="pool_star1" name="pool" value="1" />
                                    <label for="pool_star1" title="text">1 star</label>
                                </div>
                            </span>
                            @error('pool')
                            <span class="text-red-600">{{ $message }}</span>
                             @enderror
                        </li>
                        <li class="border-b-2 border-slate-300 py-2 px-3 flex justify-start">
                            <span class="font-bold mr-[70px]">Staff</span>
                            <span class="mr-5"> : </span>
                            <span>
                                <div class="rate4">
                                    <input type="radio" id="staff_5" name="staff" value="5" />
                                    <label for="staff_5" title="text">5 stars</label>
                                    <input type="radio" id="staff_4" name="staff" value="4" />
                                    <label for="staff_4" title="text">4 stars</label>
                                    <input type="radio" id="staff_3" name="staff" value="3" />
                                    <label for="staff_3" title="text">3 stars</label>
                                    <input type="radio" id="staff_2" name="staff" value="2" />
                                    <label for="staff_2" title="text">2 stars</label>
                                    <input type="radio" id="staff_1" name="staff" value="1" />
                                    <label for="staff_1" title="text">1 star</label>
                                </div>
                            </span>
                            @error('staff')
                            <span class="text-red-600">{{ $message }}</span>
                             @enderror
                        </li>
                        <li class="py-2 px-3 flex justify-start">
                            <span class="font-bold mr-[20px]">Comment</span>
                            <span class="mr-5"> : </span>
                            <span>
                                <textarea placeholder="( Optional )" name="comment" id="" cols="50" rows="8"></textarea>
                            </span>
                        </li>
                        <li class="py-2 px-3 flex justify-start">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                            <input type="hidden" name="barcode" value="{{ $booking->barcode }}">
                            <input type="hidden" name="start_time" value="{{ $booking->start_time }}">
                            <button class="px-4 py-2 bg-sky-700 hover:bg-sky-600 text-white rounded-md" type="submit">Submit</button>
                        </li>
                    </ul>
                </form>
                </div>
        </section>
        @else
        <section class="p-5 rounded-sm flex flex-row flex-wrap items-start justify-start w-full gap-5 ">
            <div class="flex flex-col items-start justify-start px-6 py-8 mx-auto sm:h-screen lg:py-0 mt-5">
                <div class="w-full  rounded-lg  dark:border md:mt-0  xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                    <p class="text-3xl drop-shadow-sm text-slate-600">You need to login first to see your schedule. Click to <a href="{{ route('guest.index') }}" class="text-sky-700 font-bold">Login</a></p>
                </div>
            </div>
        </section>
        @endif


    </div>
</main>

@endsection
