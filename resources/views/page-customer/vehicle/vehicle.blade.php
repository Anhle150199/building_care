@extends('page-customer.layout.app')
@section('title', 'Phương tiện')
@push('css')
@endpush
@section('content')

    <div class="page-content-wrapper">
        <div class="pt-4"></div>

        <div class="container">
            <a class="btn m-1 btn-round btn-danger  mb-4" href="{{ route('user.show-vehicle-register') }}">
                <i class="bi bi-plus-circle mx-1"></i>
                <span class="mx-1">Thêm phương tiện</span>
            </a>
        </div>
        <div class="container">
            <div class="card comparison-table-one">
                <div class="card-header">
                    <h6>Phương tiện đã đăng ký</h6>
                </div>
                <div class="card-body px-0">
                    <table class="table mb-0">
                        <thead class="thead-light">
                            <tr>
                                {{-- <th scope="col">#</th> --}}
                                <th scope="col" >Phương tiện</th>
                                <th scope="col" width="28%">Căn hộ</th>
                                <th width="28%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php //$step =1;?>
                            @foreach ($list as $item)
                                <tr id="{{$item->id}}" data-bs-target="#staticBackdrop" data-bs-toggle="modal" data-number="{{$item->license_plate_number}}" data-date="{{$item->updated_at->format("H:m d-m-Y")}}">
                                    {{-- <th scope="row">{{$step}}</th> --}}
                                    <td class="1" >
                                        <span class="d-block text-muted">
                                            @if ($item->category == 'car')
                                                Ô tô
                                            @elseif ($item->category == 'motorbike')
                                                Xe máy
                                            @else
                                                Xe điện
                                            @endif
                                        </span>
                                        <span>{{ $item->model }}</span>
                                    </td>
                                    <td class="2">
                                        {{ $item->name }}
                                        <span class="d-block text-muted">{{ $item->apartment_code }}</span>
                                    </td>
                                    <td class="3">
                                        @if ($item->status == 'accept')
                                            <span class="d-block text-success">Chấp nhận</span>
                                        @else
                                            <span class="d-block text-danger">Yêu cầu</span>
                                        @endif
                                        <div class="d-none">
                                            <?php echo $item->description; ?>
                                        </div>
                                    </td>

                                </tr>
                                <?php //$step++;?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal chi tiết --}}
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel" >Chi tiết phương tiện</h6>
                    <button class="btn btn-close p-1 ms-auto" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <p class="mb-0"><span class="fw-bold me-2">Phương tiện:</span><span id="vehicle" ></span></p>
                    <p class="mb-0"><span class="fw-bold me-2">Biển số:</span><span id="number"></span></p>
                    <p class="mb-0"><span class="fw-bold me-2">Căn hộ:</span><span id="apartment"></span></p>
                    <p class="mb-0"><span class="fw-bold me-2">Mô tả:</span></p><span id="description"></span>
                    <p class="mb-0"><span class="fw-bold me-2">Trạng thái:</span><span id="status" ></span></p>
                    <p class="mb-0"><span class="fw-bold me-2">Đăng ký ngày:</span><span id="date" ></span></p>
                </div>
                <div class="modal-footer">
                    @csrf
                    <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal">Đóng</button>
                    <button class="btn btn-sm btn-danger" id="btn-delete" data-delete="{{ route('user.delete-vehicle') }}" type="button">Xoá</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('p span').removeAttr("style");
        $('p').addClass("fz-14");
        $('#staticBackdrop').on('show.bs.modal', function(e){
            let btn = $(e.relatedTarget);
            let id = btn.attr('id');
            let number = btn.data('number');
            let date = btn.data('date');
            console.log(date);
            let vehicle = $('#'+id+" .1").text().trim();
            let apartment = $('#'+id+" .2").text().trim();
            let status = $('#'+id+" .3 span").text().trim();
            let description = $('#'+id+" .3 div").html();

            $('#vehicle').text(vehicle);
            $('#number').text(number);
            $('#apartment').text(apartment);
            $('#description').html(description);
            $('#status').text(status);
            $('#date').text(date);
            if(status == 'Yêu cầu'){
                $('#staticBackdropLabel').data('id', id);
                $("#btn-delete").show();
            } else $("#btn-delete").hide();
        })
        $('#btn-delete').click(function(){
            let id = $('#staticBackdropLabel').data('id');
            let vehicle = $('#vehicle').text();
            let token = $("input[name=_token]").val();

            Swal.fire({
                text: 'Bạn có chắc muốn xoá '+vehicle+' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tiếp tục',
                cancelButtonText: 'Huỷ',
                width: "80%"
            }).then((result) => {
                if (result.isConfirmed) {
                    let data = {
                        _token: token,
                        id: id
                    }

                    $.ajax({
                        url:$(this).data('delete'),
                        type: 'delete',
                        data: data,
                        typeData: 'json',
                        success: function(){
                            showToast('success', 'Phương tiện đã được xoá')
                            $('#staticBackdrop').modal('hide')
                            $('#'+id).remove();
                        },
                        error: function(){
                            showToast('danger', "")
                        }
                    })
                }
            })

        })
    </script>
@endpush
