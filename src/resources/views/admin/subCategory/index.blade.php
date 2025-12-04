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
                        <h1 class="h3 mb-0 text-gray-800">{{$category->name}}：サブカテゴリー管理</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="table-responsive pt-4">
                        <form method="POST" action="{{ route('sub_category.batch_update_confirm', $category) }}">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $category->id }}">
                            <table class="table table-hover bg-white">
                                <thead>
                                    <tr>
                                        {{--<th>表示順</th>--}}
                                        <th>カテゴリ名</th>
                                    </tr>
                                </thead>
                                <tbody id="inputForm">
                                    @foreach ($form_items as $index => $item)
                                        <tr>
                                           {{-- <td style="width:10rem;"><input type="number" name="sub_categories[{{$index}}][display_order]" value="{{ $item->display_order }}" class="form-control" id="inputId"></td> --}}
                                            <td><input type="text" name="sub_categories[{{$index}}][name]" value="{{ $item->name }}" class="form-control"></td>
                                            <input type="hidden" name="sub_categories[{{$index}}][id]" value="{{ $item->id }}" class="form-control">
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