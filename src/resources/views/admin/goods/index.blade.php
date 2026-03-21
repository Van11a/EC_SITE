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
                        <h1 class="h3 mb-0 text-gray-800">商品管理</h1>
                    </div>
                    <div class="float-right pr-4">
                        <a href="{{ route('goods.create') }}">
                            <button type="button" class="btn btn-primary">新規登録</button>
                        </a>
                    </div>

                    <!-- Content Row -->
                    <div class="table-responsive pt-4">
                        @if (count($goods) > 0)
                            <table class="table table-hover bg-white">
                                <thead>
                                    <tr>
                                        <th>商品番号</th>
                                        <th>商品名</th>
                                        <th>画像</th>
                                        <th>在庫数</th>
                                        <th>商品金額</th>
                                        <th>表示</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($goods as $item)
                                    <tr>
                                        <td>{{ $item->part_number }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td><img style="max-height:80px;" src="{{ Storage::disk('public')->url($item->image1) }}"></td>
                                        <td>{{ $item->stock }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>                                   
                                            @if ($item->is_display == 1)
                                                表示
                                            @elseif ($item->is_display == 0)
                                                非表示
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#">
                                                <button type="button" class="btn btn-warning">編集</button>
                                            </a>
                                            {{--<a href="{{ route('goods.edit', $item->id) }}">
                                                <button type="button" class="btn btn-warning">編集</button>
                                            </a>--}}
                                            {{--<a href="{{ route('goods.destroy') }}">
                                                <button type="button" class="btn btn-danger">削除</button>
                                            </a>--}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $goods->links() }}
                        @endif
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>