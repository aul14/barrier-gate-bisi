<div class="container">
    <footer class="footer pt-0">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-end">
                <div class="col-lg-12">
                    <div class="copyright text-center text-xs text-muted fixed-bottom">
                        ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>, PT Charoen Pokphand Indonesia Tbk
                        @if (Request::is('full_table*') || Request::is('full_page*') || Request::is('/'))
                            <a href="javascript:void(0)" class="btn btn-xs btn-primary btn-pause" style="display: none;"><i
                                    class="fa fa-volume-high"></i></a>
                            <a href="javascript:void(0)" class="btn btn-xs btn-primary btn-play"><i
                                    class="fa fa-volume-xmark"></i></a>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </footer>
</div>
