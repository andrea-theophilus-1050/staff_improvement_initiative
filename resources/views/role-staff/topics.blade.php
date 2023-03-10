@extends('layouts.main')
@section('content')
    <div class="row">
        @for ($i = 0; $i < 10; $i++)
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Topic name {{ $i }}</h4>
                        <p class="card-description font-weight-bold">Lorem ipsum dolor sit amet consectetur adipisicing
                            elit.
                            Repudiandae omnis nulla vitae voluptatum ab architecto quaerat impedit ullam dolor? Aliquid
                            dicta minima accusamus necessitatibus enim quis, culpa alias autem at?</p>
                        <div class="template-demo">
                            <div style="font-size: 13px">
                                <div class="d-flex justify-content-between">
                                    <li><b>Deadline for submit ideas:</b></li>
                                    <span>
                                        <i class="mdi mdi-calendar-clock"></i>
                                        March 20, 2023
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <li><b>Final deadline:</b></li>
                                    <span>
                                        <i class="mdi mdi-calendar-clock"></i>
                                        March 20, 2023
                                    </span>
                                </div>
                            </div>
                            {{--     <button type="button" class="btn btn-social-icon btn-outline-facebook"><i
                                    class="ti-facebook"></i></button>
                            <button type="button" class="btn btn-social-icon btn-outline-youtube"><i
                                    class="ti-youtube"></i></button>
                            <button type="button" class="btn btn-social-icon btn-outline-twitter"><i
                                    class="ti-twitter-alt"></i></button>
                            <button type="button" class="btn btn-social-icon btn-outline-dribbble"><i
                                    class="ti-dribbble"></i></button>
                            <button type="button" class="btn btn-social-icon btn-outline-linkedin"><i
                                    class="ti-linkedin"></i></button>
                            <button type="button" class="btn btn-social-icon btn-outline-google"><i
                                    class="ti-google"></i></button> --}}
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <script>
        const cards = document.querySelectorAll('.card');
        cards.forEach((card) => {
            card.addEventListener('mouseover', () => {
                card.style.cursor = 'pointer';
                card.classList.add('shadow-lg', 'bg-white');
            });
            card.addEventListener('mouseout', () => {
                card.classList.remove('shadow-lg', 'bg-white');
            });
        });

        cards.forEach((card) => {
            card.addEventListener('click', () => {
                alert(`Clicked ${card.querySelector('.card-title').innerText}`);
            });
        });
    </script>
@endsection
