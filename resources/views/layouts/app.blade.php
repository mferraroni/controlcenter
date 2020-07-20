
<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.header')
    </head>

    <body id="page-top">
    <div id='app'></div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        @auth
            @include('layouts.sidebar')
        @endauth

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            @auth
                @include('layouts.topbar')
            @endauth

            @yield('content-master') <!-- For special things to be done outside the container -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <h1 class="h3 mb-4 text-gray-800">
                    @yield('title', 'Page Title')
                    @yield('title-extension')
                </h1>

                <!-- Success or failure messages (if any) START -->
                @if(Session::has('success') OR isset($success))
                    <div class="alert alert-success" role="alert">
                        {!! Session::pull("success") !!}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @if(count($errors) > 1)
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @else
                            {{ $errors->first() }}
                        @endif
                    </div>
                @endif
                <!-- Success or failure messages END -->

                @yield('content')
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

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // Search bar
        $(document).ready(function(){

            function fetch_users(query = '')
            {
                $.ajax({
                    url:"{{ route('user.search') }}",
                    method:'GET',
                    data:{query:query},
                    dataType:'json',
                    success:function(data)
                    {
                        if(data.length > 0){

                            var html = '';
                            var baseUrl = '{{ URL::to('/user') }}\/'

                            for(var i=0; i < data.length; i++){
                                html +='<a href="'+ baseUrl + data[i]['id'] +'">'+ data[i]['id'] + ": "+ data[i]['name'] +'</a>'
                            }

                            $('.search-results').html(html);
                        } else {
                            $('.search-results').html("No results");
                        }

                        $('.search-results').slideDown("fast");
                    }
                })
            }
    
            var timer = null
            $(document).on('keyup', '#search', function(){
                var query = $(this).val();
                clearTimeout(timer);
                timer = setTimeout(fetch_users, 500, query)
            });

            $('#user-search-form').on('submit', function(e){
                
                var query = $('#search').val();
                clearTimeout(timer);
                timer = setTimeout(fetch_users, 500, query)

                e.preventDefault();
            });

            $(document).on('focusout', '#search', function(){
                $('.search-results').slideUp("fast");
            });
        });
    </script>
    @yield('js')
    </body>
</html>
