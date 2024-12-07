@extends('layouts.app')

@if (auth()->user()->department_id == 1 || auth()->user()->department_id == 2)
@endif
@section('charmatch', 'active')
@section('charmatch-0', 'show')
@section('charmatch-0-ajax', 'active')
@section('head')
<title>Department Hierarchy</title>
<style>
    ul {
        list-style-type: circle;
    }

    li {
        margin: 5px 0;
    }

    .department {
        font-weight: bold;
        color: var(--bs-blue);
    }

    .job-titles-user {
        margin-left: 20px;
        color: var(--bs-indigo);
    }

    .user-list {
        margin-left: 40px;
        color: var(--bs-dark);
    }



</style>
@endsection
@section('content')
<main>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-5">

        <div class="card mb-4 mt-5">
            <div class="card-body p-5">
                <div class="row align-items-center justify-content-center">
                    <h1 style="font-display: bold"> Department Hierarchy </h1>
                    <div class="row">

                        {{-- //CODE HERE --}}
                        <div class="tree">
                            <ul>
                                @foreach ($data as $department)
                                <li class="department">
                                    <h1 class="badge bg-primary">{{ $department['department_name'] }}</h1>
                                    <ul>
                                        @foreach ($department['job_Title'] as $job_Title_set_users)
                                        <li class="job-titles-user">
                                            <h4 class="badge bg-secondary position-relative">{{
                                                $job_Title_set_users['name'] }} <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    {{ $job_Title_set_users['user_count'] }}
                                                    <b class="visually-hidden">({{ $job_Title_set_users['user_count'] }}
                                                        )</b>
                                                </span></h4>


                                            <ul class="user-list">
                                                @foreach ($job_Title_set_users['users'] as $user)
                                                <li style="font-size: 11px">{{ $user }}</li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('script')

<script>

</script>
@endsection
