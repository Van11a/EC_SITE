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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>
                    <div class="float-right pr-4">
                        <a href="{{ route('user.create') }}">
                            <button type="button" class="btn btn-primary">新規登録</button>
                        </a>
                    </div>

                    <!-- Content Row -->
                    <div class="table-responsive pt-4">
                        @if (count($users) > 0)
                            <table class="table table-hover bg-white">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ログインID</th>
                                        <th>管理者名</th>
                                        <th>登録日</th>
                                        <th>更新日</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->login_id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{ date('Y年n月j日'), $user->ins_date}}</td>
                                        <td>{{ date('Y年n月j日'), $user->up_date}}</td>
                                        <td>
                                            <a href="{{ route('user.edit', $user->id) }}">
                                                <button type="button" class="btn btn-warning">編集</button>
                                            </a>
                                            {{--<a href="{{ route('user.destroy') }}">
                                                <button type="button" class="btn btn-danger">削除</button>
                                            </a>--}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $users->links() }}
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