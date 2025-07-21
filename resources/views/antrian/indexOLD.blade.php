@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Antrian Barrier Gate'])
    <style>
        .pagination-container {
            position: fixed;
            bottom: 10px;
            right: 10px;
        }
    </style>
    <div class="row mt-1 px-1">
        <div class="card">
            <div class="card-body p-1">
                <div class="row justify-content-center row-antrian">

                </div>
                <div class="pagination-container">
                    <!-- Pagination buttons will be appended here -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let ws_url = $("input[name=ws_url]").val(),
            currentPage = 1,
            totalPages = 1,
            isLoading = false,
            isAutoScrollEnabled = true;
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            getQueue();

            wsRealTime();

            // Infinite scroll
            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                    const nextPage = (currentPage % totalPages) + 1;
                    getQueue(nextPage); // Pass isAutoScrollEnabled to scrollToTop
                }
            });

            // // Disable auto-scroll when a pagination link is clicked
            // $('.pagination-container').on('click', 'a', function(e) {
            //     e.preventDefault();
            //     isAutoScrollEnabled = false;
            //     let page = $(this).attr('href').split('page=')[1];
            //     getQueue(page, false); // Pass false to not scroll to top
            // });
        });

        function wsRealTime() {
            let ws = new WebSocket(`${ws_url}/real-time`);

            ws.onopen = function(event) {
                console.log('Connection Dashboard Real Time Established');
            };

            ws.onmessage = function(e) {
                let data = JSON.parse(e.data),
                    antrian = data.antrian,
                    data_antrian = data.data_antrian;

                getQueue();
            }

            ws.onclose = function(event) {
                // connection closed, discard old websocket and create a new one in 5s
                ws = null
                // Attempt to reconnect after a delay (e.g., 5 seconds)
                setTimeout(() => {
                    console.log('Attempting to reconnect...');
                    wsRealTime();
                }, 5000);
                // setTimeout(wsBarrierGate, 5000, WB)
            }

            ws.error = function(err) {
                console.log(err); // Write errors to console
            }
        }

        function getQueue(page = 1) {
            if (isLoading) {
                return;
            }

            isLoading = true;

            $.ajax({
                type: "post",
                url: '{{ route('get.queue') }}',
                data: {
                    page: page
                },
                dataType: "json",
                success: function(response) {
                    let res = response.data;
                    let queue_html = ""
                    if (res.length > 0) {
                        res.forEach((val, key) => {
                            const dateObject = new Date(val.created_at);
                            const options = {
                                timeZone: 'Asia/Jakarta',
                                hour12: false,
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit'
                            };
                            const formattedDateTime = dateObject.toLocaleString('en-US', options),
                                typeScenario = val.type_scenario.split(" ");
                            let bg_card;

                            if (typeScenario[0] == 'inbound') {
                                bg_card = 'bg-success';
                            } else if (typeScenario[0] == 'outbound') {
                                bg_card = 'bg-primary';
                            } else {
                                bg_card = 'bg-info';
                            }
                            queue_html += `
                            <div class="col-md-3 my-3 queue-${val.plant}|${val.sequence}|${val.arrival_date}" data-plant="${val.plant}" data-sequence="${val.sequence}" data-arrival_date="${val.arrival_date}">
                                <div class="cardqueue cardqueue-1 ${bg_card}">
                                    <div class="row">
                                        <div class="col-6">
                                            <h6 class="m-0">${val.jenis_kendaraan == null ? '-' : val.jenis_kendaraan}</h6>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="m-0 text-end">${val.next_status}</h6>
                                        </div>
                                    </div>
                                    <hr class="my-0">
                                    <h2 class="text-center my-0">
                                        ${val.truck_no}
                                        </h2>
                                    <h6 class="text-center">${val.type_scenario}</h6>
                                    <hr class="my-0">
                                    <p class="text-center my-0">${formattedDateTime}</p>
                                </div>
                            </div>                        
                            `;
                        });

                        currentPage = page;
                        totalPages = response.total_pages;
                    }
                    // let pagination_html = response.pagination_links;
                    // $(`.pagination-container`).html(pagination_html);

                    $(`.row-antrian`).append(queue_html);

                    isLoading = false;
                },
                error: function(xhr, status, error) {
                    isLoading = false;

                    if (xhr.status == 422) {
                        console.log('Request failed with validation errors:', xhr.responseJSON.errors);
                    } else {
                        console.log('Request failed with status:', status);
                    }
                }
            });
        }
        // setInterval(function() {
        //     const nextPage = (currentPage % totalPages) + 1;
        //     getQueue(nextPage);
        //     $('html, body').animate({
        //         scrollTop: 0
        //     }, 'slow');
        // }, 5000);
    </script>
@endsection
