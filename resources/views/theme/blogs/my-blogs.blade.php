@extends('theme.master')

@section('title', ' My Blogs')

@section('content')

    @include('theme.partials.hero', ['title' => 'My Blogs'])

    <!-- ================ contact section start ================= -->
    <section class="section-margin--small section-margin">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped table-dark">
                        <thead>
                            <tr>
                                <th scope="col" >#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if (count($blogs) > 0)
                                @foreach ($blogs as $key => $blog)
                                    <tr>
                                        <th scope="row">{{ ++$key}}</th>
                                        <td>
                                            <a href="{{ route('blogs.show', ['blog' => $blog]) }}" target="_blank">{{ $blog->name }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('blogs.edit', ['blog' => $blog]) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
                                            <a href="{{ route('blogs.destroy', ['blog' => $blog]) }}" class="btn btn-sm btn-danger mr-2">Delete</a>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                    @if (count($blogs) > 0)
                        {{ $blogs->render("pagination::bootstrap-4") }}
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- ================ contact section end ================= -->
@endsection
