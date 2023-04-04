@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card text-center h3 font-weight-bold">
                <div class="card shadow">
                    <div class="card-body">Latest topics</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($topics as $topic)
            @php
                $now = \Carbon\Carbon::now();
                $deadline2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($topic->topicDeadline->finalClosureDate)));
                $deadline1 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($topic->topicDeadline->firstClosureDate)));
            @endphp

            @if ($deadline1->isFuture() && $deadline2->isFuture())
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card" id="card">
                        <div class="card-body">
                            <h4 class="card-title" style="line-height: 1.5">{{ $topic->topic_name }} </h4>
                            <h4 class="card-title" id="topicID" hidden>{{ $topic->topic_id }}</h4>
                            <p class="card-description font-weight-bold">
                                {{ $topic->topic_description }}
                            </p>
                            <div class="template-demo">
                                <div style="font-size: 13px">
                                    <li>
                                        <b>Deadline for submit:</b>
                                        <span>
                                            <i class="mdi mdi-calendar-clock"></i>
                                            {{ date('M-d-Y - h:i:s a', strtotime($topic->topicDeadline->firstClosureDate)) }}
                                        </span>
                                    </li>
                                    <li>
                                        <b>Final deadline:</b>
                                        <span>
                                            <i class="mdi mdi-calendar-clock"></i>
                                            {{ date('M-d-Y - h:i:s a', strtotime($topic->topicDeadline->finalClosureDate)) }}
                                        </span>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>


    <div class="row mt-5">
        <div class="col-12 grid-margin stretch-card">
            <div class="card text-center h3 font-weight-bold">
                <div class="card shadow" style="background: #dee9f3">
                    <div class="card-body">Topic has closed submission</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($topics as $topic)
            @php
                $now = \Carbon\Carbon::now();
                $deadline2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($topic->topicDeadline->finalClosureDate)));
                $deadline1 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($topic->topicDeadline->firstClosureDate)));
            @endphp

            @if ($deadline1->isPast() && $deadline2->isFuture())
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card" id="card">
                        <div class="card-body">
                            <h4 class="card-title" style="line-height: 1.5">{{ $topic->topic_name }} </h4>
                            <h4 class="card-title" id="topicID" hidden>{{ $topic->topic_id }}</h4>
                            <p class="card-description font-weight-bold">
                                {{ $topic->topic_description }}
                            </p>
                            <div class="template-demo">
                                <div style="font-size: 13px">
                                    <li>
                                        <b>Deadline for submit:</b>
                                        <span>
                                            <i class="mdi mdi-calendar-clock"></i>
                                            {{ date('M-d-Y - h:i:s a', strtotime($topic->topicDeadline->firstClosureDate)) }}
                                        </span>
                                    </li>
                                    <li>
                                        <b>Final deadline:</b>
                                        <span>
                                            <i class="mdi mdi-calendar-clock"></i>
                                            {{ date('M-d-Y - h:i:s a', strtotime($topic->topicDeadline->finalClosureDate)) }}
                                        </span>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="row mt-5">
        <div class="col-12 grid-margin stretch-card">
            <div class="card text-center h3 font-weight-bold">
                <div class="card shadow" style="background: #e2e4e6">
                    <div class="card-body">Topic has completely closed</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($topics as $topic)
            @php
                $now = \Carbon\Carbon::now();
                $deadline2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($topic->topicDeadline->finalClosureDate)));
                $deadline1 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($topic->topicDeadline->firstClosureDate)));
            @endphp

            @if ($deadline1->isPast() && $deadline2->isPast())
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card" id="card">
                        <div class="card-body">
                            <h4 class="card-title" style="line-height: 1.5">{{ $topic->topic_name }} </h4>
                            <h4 class="card-title" id="topicID" hidden>{{ $topic->topic_id }}</h4>
                            <p class="card-description font-weight-bold">
                                {{ $topic->topic_description }}
                            </p>
                            <div class="template-demo">
                                <div style="font-size: 13px">
                                    <li>
                                        <b>Deadline for submit:</b>
                                        <span>
                                            <i class="mdi mdi-calendar-clock"></i>
                                            {{ date('M-d-Y - h:i:s a', strtotime($topic->topicDeadline->firstClosureDate)) }}
                                        </span>
                                    </li>
                                    <li>
                                        <b>Final deadline:</b>
                                        <span>
                                            <i class="mdi mdi-calendar-clock"></i>
                                            {{ date('M-d-Y - h:i:s a', strtotime($topic->topicDeadline->finalClosureDate)) }}
                                        </span>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <script>
        const cards = document.querySelectorAll('#card');
        cards.forEach((card) => {
            card.addEventListener('mouseover', () => {
                card.style.cursor = 'pointer';
                card.classList.add('shadow', 'bg-white');
            });
            card.addEventListener('mouseout', () => {
                card.classList.remove('shadow', 'bg-white');
            });
        });

        cards.forEach((card) => {
            card.addEventListener('click', () => {
                var topicID = card.querySelector('#topicID').innerHTML;

                window.location.href = "{{ route('staff.topics.idea.posts', ':id') }}".replace(':id',
                    topicID);
            });
        });
    </script>
@endsection
