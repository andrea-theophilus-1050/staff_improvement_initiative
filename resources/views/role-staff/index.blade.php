@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-body">
                            Idea Topics
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            @for ($i = 0; $i < 10; $i++)
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="media mb-5">
                            <img src="{{ asset('img/default-avt.jpg') }}" class="mr-3" alt="Profile Image"
                                style="height: 50px; width: 50px">
                            <div class="media-body">
                                <h5 class="card-title">Post Title</h5>
                                <div class="mb-2" style="font-size: 12px">
                                    <i class="mdi mdi-calendar-clock"></i>&nbsp;&nbsp;Created on March 11, 2023 at 12:00:00
                                </div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab,
                                    reiciendis
                                    facere inventore tenetur perspiciatis recusandae autem laudantium maxime id commodi
                                    omnis
                                    est laborum perferendis cum aut similique deserunt odio veritatis.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-9 d-flex">
                                <button
                                    class="btn btn-outline-primary btn-sm d-flex justify-content-center align-items-center">
                                    <i class="mdi mdi-thumb-up"></i>
                                    &nbsp;&nbsp;123 Like
                                </button>
                                <button
                                    class="btn btn-outline-danger btn-sm d-flex justify-content-center align-items-center ml-2">
                                    <i class="mdi mdi-thumb-down"></i>
                                    &nbsp;&nbsp;123 Dislike
                                </button>
                                <button
                                    class="btn btn-outline-success btn-sm d-flex justify-content-center align-items-center ml-2"
                                    data-toggle="collapse" data-target="#comment-section">
                                    <i class="mdi mdi-comment"></i>
                                    &nbsp;&nbsp;123 Comment
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-2">
                                <h6>Attachments:</h6>
                            </div>
                            <div class="col-sm-8">
                                <ul class="list-unstyled d-flex flex-row">
                                    <li class="mr-3">
                                        <a href="#">File 1</a>
                                        {{-- <button class="btn btn-sm btn-outline-primary ml-2 ">
                                        <i class="mdi mdi-download"></i>
                                        Download
                                    </button> --}}
                                    </li>
                                    <li class="mr-3">
                                        <a href="#">File 2</a>
                                        {{-- <button class="btn btn-sm btn-outline-primary ml-2 ">
                                        <i class="mdi mdi-download"></i>
                                        Download
                                    </button> --}}
                                    </li>
                                    <li><a href="#">File 3</a>
                                        {{-- <button class="btn btn-sm btn-outline-primary ml-2 ">
                                        <i class="mdi mdi-download"></i>
                                        Download
                                    </button> --}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div id="comment-section" class="collapse">
                            <h6>Comments:</h6>
                            <div class="card mb-2" style="background: #f5f7ff">
                                <div class="card-body">
                                    <div class="media">
                                        <img src="{{ asset('img/default-avt.jpg') }}" style="width: 30px; height: 30px"
                                            class="mr-3" alt="Profile Image">
                                        <div class="media-body">
                                            <p class="card-text">Comment 1</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2" style="background: #f5f7ff">
                                <div class="card-body">
                                    <div class="media">
                                        <img src="{{ asset('img/default-avt.jpg') }}" style="width: 30px; height: 30px"
                                            class="mr-3" alt="Profile Image">
                                        <div class="media-body">
                                            <p class="card-text">Comment 2</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form>
                                <div class="form-group">
                                    <label for="comment-text">Add a comment:</label>
                                    <textarea class="form-control" id="comment-text" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6>Related Posts:</h6>
                    <ul class="list-styled">
                        <li><a href="#">Related Post 1</a></li>
                        <li><a href="#">Related Post 2</a></li>
                        <li><a href="#">Related Post 3</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
