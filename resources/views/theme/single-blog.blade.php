@extends('theme.master')

@section('title', 'Single Blog')


@section('content')
    @include('theme.partials.hero', ['title' => $blog->name])

    <!--================ Start Blog Post Area =================-->
    <section class="blog-post-area section-margin">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="main_blog_details">
                        <img class="w-100 img-fluid" src="{{asset("storage/blogs/$blog->image")}}" alt="">
                        <a href="#">
                            <h4>{{ $blog->name }}</h4>
                        </a>
                        <div class="user_details">
                            <div class="float-right mt-sm-0 mt-3">
                                <div class="media">
                                    <div class="media-body">
                                        <h5>{{ $blog->user->name }}</h5>
                                        <p>{{ $blog->created_at->format('d M Y') }}</p>
                                    </div>
                                    <div class="d-flex">
                                        <img width="42" height="42" src="{{asset('assets')}}/img/avatar.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p>{{ $blog->description }}</p>
                    </div>

                    @if (count($blog->comments) > 0)
                    <div class="comments-area">
                        <h4>{{ count($blog->comments) }} Comments</h4>
                        @foreach ($blog->comments as $comment )
                        <div class="comment-list">
                            <div class="single-comment justify-content-between d-flex">
                                <div class="user justify-content-between d-flex">
                                    <div class="thumb">
                                        <img src="{{asset('assets')}}/img/avatar.png" width="50px">
                                    </div>
                                    <div class="desc">
                                        <h5><a href="#">{{ $comment->name }}</a></h5>
                                        <p class="date">{{ $comment->created_at->format('d M Y') }} </p>
                                        <p class="comment">
                                            {{ $comment->message }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Start Blog Post Siddebar -->
                @include('theme.partials.sidebar')
                <!-- End Blog Post Siddebar -->
            </div>
    </section>
    <!--================ End Blog Post Area =================-->

@endsection
