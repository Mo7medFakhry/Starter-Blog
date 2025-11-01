@php
$Categories = \App\Models\Category::get();
$recentBlogs = \App\Models\Blog::latest()->take(3)->get();
@endphp

<!-- Start Blog Post Siddebar -->
<div class="col-lg-4 sidebar-widgets">
    <div class="widget-wrap">
        <div class="single-sidebar-widget newsletter-widget">
            <h4 class="single-sidebar-widget__title">Newsletter</h4>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ route('subscribe.store') }}" method="post">
                @csrf
                <div class="form-group mt-30">
                    <div class="col-autos">
                        <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Enter email"
                            onfocus="this.placeholder = ''" value="{{ old('email') }}"
                            onblur="this.placeholder = 'Enter email'" name="email">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="bbtns d-block mt-20 w-100">Subcriber</button>
            </form>
        </div>

        <div class="single-sidebar-widget post-category-widget">
            <h4 class="single-sidebar-widget__title">Catgory</h4>
            @if (count($Categories) > 0)
                <ul class="cat-list mt-20">
                    @foreach ($Categories as $category)
                        <li>
                            <a href="{{ route('theme.category', ['id' => $category->id]) }}"
                                class="d-flex justify-content-between">
                                <p>{{ $category->name }}</p>
                                <p>{{ count($category->blogs) }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        @if (count($recentBlogs) > 0)
            <div class="single-sidebar-widget popular-post-widget">
                <h4 class="single-sidebar-widget__title">Recent Blogs </h4>
                <div class="popular-post-list">
                    @foreach ($recentBlogs as $blog)
                        <div class="single-post-list">
                            <div class="thumb">
                                <img class="card-img rounded-0" src="{{asset("storage/blogs/$blog->image")}}" alt="">
                                <ul class="thumb-info">
                                    <li><a href="#">{{ $blog->user->name }}</a></li>
                                    <li><a href="#">{{ $blog->created_at->format('d M Y') }}</a></li>
                                </ul>
                            </div>
                            <div class="details mt-20">
                                <a href="{{ route('blogs.show', ['blog' => $blog]) }}') }}">
                                    <h6>{{ $blog->name }}</h6>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
<!-- End Blog Post Siddebar -->
