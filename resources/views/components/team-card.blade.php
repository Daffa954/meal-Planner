<div class="md:w-[380px] w-full bg-white rounded-lg shadow-sm border-[1.5px] border-gray-300">
    <a href="#">
        <img class="rounded-t-lg h-[270px] w-full object-cover" src="{{ $image ?? asset('assets/images/placeholder.jpg') }}" alt="{{ $title }}">
    </a>
    <div class="p-5 border-t-2 border-gray-200">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $title }}</h5>
        </a>
        <p class="mb-3 font-normal text-gray-700">{{ $description }}</p>
    </div>
</div>