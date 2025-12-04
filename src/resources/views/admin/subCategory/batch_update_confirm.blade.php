<!DOCTYPE html>
<html lang="ja">

<head>
    @include('admin/head')
    <title>ES SITE</title>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('admin/sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                @include('admin/topbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">カテゴリー登録確認</h1>
                    </div>

                    {{--<div class="form-wrap">
                        <form method="POST" action="{{ route('sub_category.batch_update', $category) }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">カテゴリー名</label>
                                <div class="col-sm-10">
                                    {{$input_data['name']}}
                                </div>
                                <input type="hidden" name="name" value="{{$input_data['name']}}">
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">表示順</label>
                                <div class="col-sm-10">
                                    {{$input_data['display_order']}}
                                </div>
                                <input type="hidden" name="display_order" value="{{$input_data['display_order']}}">
                            </div>
                            <button type="submit" class="btn btn-primary">入力確認へ</button>
                        </form>
                    </div>--}}

                    @php
                        $input_data = session('input_data');
                    @endphp
                    <!-- Content Row -->
                    <div class="table-responsive pt-4">
                        <form method="POST" action="{{ route('sub_category.batch_update', $category) }}">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $category->id }}">
                            @method('PATCH')

                            <table class="table table-hover bg-white">
                                <thead>
                                    <tr>
                                        {{--<th>表示順</th>--}}
                                        <th>カテゴリ名</th>
                                    </tr>
                                </thead>
                                <tbody id="inputForm">
                                    @foreach ($input_data as $index => $item)
                                        <tr>
                                           {{-- <td style="width:10rem;"><input type="number" name="sub_category[{{$index}}][display_order]" value="{{ $item['display_order'] }}" class="form-control" id="inputId"></td> --}}
                                            <td>{{ $item['name'] }}</td>
                                            <input type="hidden" name="sub_categories[{{$index}}][id]" value="{{ $item['id'] }}">
                                            <input type="hidden" name="sub_categories[{{$index}}][name]" value="{{ $item['name'] }}">
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{--<button type="button" id="addField" class="btn btn-primary">追加する</button>--}}
                            <button type="submit" class="btn btn-warning">一括更新</button>
                        </form>
                        {{-- <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#!" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#!">1</a></li>
                                <li class="page-item"><a class="page-link" href="#!">2</a></li>
                                <li class="page-item"><a class="page-link" href="#!">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#!" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav> --}}
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
</body>

</html>