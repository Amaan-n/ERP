@foreach($workers['result'] as $worker)
    @php 
    $worker_name = ($local_value == 'ar') ? ($worker->a_name == null) ? (strlen($worker->name) > 30) ? substr(strtoupper($worker->name), 0, 30). '...' : strtoupper($worker->name) : $worker->a_name : ((strlen($worker->name) > 30) ? substr(strtoupper($worker->name), 0, 30). '...' : strtoupper($worker->name)); 
    @endphp

    <a href="javascript:void(0);"
       class="btn text-uppercase cursor-pointer worker_selection bg-light-primary font-weight-bold font-size-lg m-1 border-0"
       style="background: linear-gradient(to right, #c2e59c, #64b3f4); border-radius: 5px;"
       data-toggle="popover"
       data-placement="top"
       data-content="{{ $worker_name }}"
       data-id="{{$worker->id}}">
        {{ $worker_name }}
    </a>
@endforeach
