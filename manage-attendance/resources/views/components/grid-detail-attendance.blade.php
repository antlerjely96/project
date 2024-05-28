<x-card>
    <div class="grid grid-cols-3 gap-4" >
        @foreach($items as $item)
            <div class="bg-gray-100 p-4 rounded-2xl hover:bg-amber-100" @click="$wire.edit( {{$item->id}} )">
                <table class="table text-1xl border-0">
                    <tbody>
                    <tr>
                        <td class="text-black">
                            <span class="font-bold"> Attendance Date: </span>
                            <span class="text-red-400"> {{ $item->attendance_date }} </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-black">
                            <span class="font-bold"> Start at: </span>
                            <span class="text-red-400"> {{ $item->start_time }} </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-black">
                            <span class="font-bold"> End at: </span>
                            <span class="text-red-400"> {{ $item->end_time }} </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</x-card>
