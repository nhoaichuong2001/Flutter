@extends('admin.app')
@section('title') Tạo khuyến mãi @endsection
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<div class="row">
  <form action="{{route('admin.vouchers.create.post')}}" method="POST" enctype="multipart/form-data">
  @csrf
    <div class="col">
      <div class="mb-3">
        <label for="name" class="form-label">Tên khuyến mãi :</label>
        <input type="text" class="form-control" id="name" placeholder="Nhập tên" name="name">
      </div>
      <div class="mb-3 mt-3">
        <label for="productID" class="form-label">Chọn sản phẩm:</label>
          <select class="form-select" id="productID" name="productID">
            @foreach($data as $item)
              <option>{{$item->id}}</option>
            @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label for="sale" class="form-label">Số tiền giảm:</label>
        <input type="number" class="form-control" id="sale" placeholder="Nhập số tiền giảm" name="sale">
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <label for="startDate" class="form-label">Ngày bắt đầu:</label>
        <input type="date" class="form-control" id="startDate" placeholder="Nhập ngày bắt đầu" name="startDate">
      </div>
      <div class="mb-3">
        <label for="endDate" class="form-label">Ngày kết thúc:</label>
        <input type="date" class="form-control" id="endDate" placeholder="Nhập ngày kết thúc" name="endDate">
      </div>
      <div class="mb-3">
        <label for="limit" class="form-label">Giới hạn:</label>
        <input type="number" class="form-control" id="limit" placeholder="Nhập giới hạn dùng" name="limit">
      </div>
      <button type="submit" class="btn btn-primary">Tạo mới</button>
    </div>
</form>
</div>


@endsection 