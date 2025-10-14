<div class="w-[300px] h-[170px] p-6 bg-white hover:bg-gray-200 transition rounded-lg shadow-sm border-[1.5px] border-gray-300">
    <div class="w-full flex justify-between">
        <p class="font-bold text-lg line-clamp-1">{{ $name }}</p>
        <div class="flex items-center gap-2">
            <p>{{ $value }}</p>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#F5B947" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                </svg>
            </div>
        </div>
    </div>
    <p class="line-clamp-4">{{ $review }}</p>
</div>