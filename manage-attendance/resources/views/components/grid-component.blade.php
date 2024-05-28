<x-card>
    <div class="grid grid-cols-3 gap-4" >
        @foreach($items as $item)
            <div class="bg-gray-100 p-4 rounded-2xl hover:bg-amber-100" @click="$wire.getDetail({{$item->classStudent->id }}, {{$item->subject->id}}, {{$item->instructor->id}})">
                <table class="table text-1xl border-0">
                    <tbody>
                        <tr>
                           <td class="text-black">
                               <span class="font-bold"> Class: </span>
                               <span class="text-red-400"> {{ $item->classStudent->name }} </span>
                           </td>
                        </tr>
                        <tr>
                            <td class="text-black">
                                <span class="font-bold"> Subject: </span>
                                <span class="text-red-400"> {{ $item->subject->name }} </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-black">
                                <span class="font-bold"> Instructor: </span>
                                <span class="text-red-400"> {{ $item->instructor->name }} </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-black">
                                <span class="font-bold"> Duration: </span>
                                <span class="text-green-500"> {{ $item->subject->duration }} h </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-black">
                                <span class="font-bold"> Remaining duration: </span>
                                <span class="text-green-500"> {{ $item->subject->duration }} h </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-black">
                                <span class="font-bold"> Status: </span>
                                <span class="text-green-500"> {{ $item->status }} </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</x-card>
